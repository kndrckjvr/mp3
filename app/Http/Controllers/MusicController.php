<?php

namespace App\Http\Controllers;

use App\Mail\EmailPinMail;
use App\Music;
use App\Purchase;
use App\PurchaseToken;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MusicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['musics'] = Music::paginate(20);

        return view('pages.store', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Music  $music
     * @return \Illuminate\Http\Response
     */
    public function show(Music $music)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Music  $music
     * @return \Illuminate\Http\Response
     */
    public function edit(Music $music)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Music  $music
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Music $music)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Music  $music
     * @return \Illuminate\Http\Response
     */
    public function destroy(Music $music)
    {
        //
    }

    public function cart(Request $request)
    {
        // find music data
        $data = Music::find($request->get('id'));
        $cart = session('cart') ?? [];

        // check if music is already in the cart if not add to cart
        if (array_search($request->get('id'), array_column($cart, 'id')) === false) {
            array_push($cart, $data);
        }

        // save data to session
        session(['cart' => $cart]);

        return response()->json($cart);
    }

    public function remove_cart(Request $request)
    {
        $cart = session('cart') ?? [];

        // find index from array data remove by index
        if ($index = array_search($request->get('id'), array_column($cart, 'id')) !== false) {
            array_splice($cart, $index - 1, 1);
        }

        // save new data
        session(['cart' => $cart]);

        return response()->json($cart);
    }

    public function checkout()
    {
        // get data from session
        $data['cart_items'] = session('cart') ?? [];

        return view('pages.checkout', $data);
    }

    public function process_checkout(Request $request)
    {
        if (empty(session('cart')) || session('cart') == null) {
            return ('/');
        }

        // get email
        $data = $request->only(['email']);
        $user_data = [];
        $music_data = session('cart');

        // check if user does not exist
        if (!Auth::check()) {
            // if the user does not exist create new user
            $new_user = new User();

            // get name from username of email
            $new_user->name = substr($data['email'], 0, strrpos($data['email'], '@'));
            $new_user->email = $data['email'];
            $new_user->password = password_hash('123Qwe!', PASSWORD_DEFAULT);
            $new_user->role = 'user';

            // save
            $new_user->save();

            $user_data['id'] = $new_user->id;
        } else {
            $user_data['id'] = Auth::user()->id;
            $data['email'] = Auth::user()->email;
        }

        $purchase_data = $this->save_purchased_data($user_data, $music_data);


        // send email with the generated token and pin and clear cart data
        Mail::to($data['email'])->send(new EmailPinMail($purchase_data));
        session(['cart' => []]);

        return redirect('/');
    }

    public function download(Request $request)
    {
        $data = $request->only(['token', 'pin', 'id']);

        $music = Purchase::whereHas('purchase_token', function ($query) use ($data) {
            return $query->where('token', $data['token']);
        })->whereHas('music', function ($query) use ($data) {
            return $query->where('id', $data['id']);
        })->first();

        if (!password_verify($data['pin'], $music->purchase_token->pin)) {
            $data['redirect_link'] = url('download') . "?" . http_build_query(['token' => $data['token'], 'id' => $data['id']]);
            return view('pages.wrong_pin', $data);
        }

        $path = storage_path() . '\\app\\music\\';

        if (file_exists($path . $music->music->download_link)) {
            return response()->download($path . $music->music->download_link);
        } else {
            return response()->download($path . 'default.mp3');
        }
    }

    public function save_purchased_data($user_data, $music_data)
    {
        $pin = sprintf("%06d", mt_rand(1, 999999));
        // create pruchase token
        do {
            $token_key = md5(rand(1, 10) . microtime());
        } while (PurchaseToken::where("token", "=", $token_key)->first() instanceof PurchaseToken);

        // save token
        $purchase_token = new PurchaseToken();
        $purchase_token->token = $token_key;
        $purchase_token->pin = password_hash($pin, PASSWORD_DEFAULT);
        $purchase_token->save();

        // save purchase data
        foreach ($music_data as $music) {
            $purchase_data = new Purchase();

            $purchase_data->user_id = $user_data['id'];
            $purchase_data->music_id = $music->id;
            $purchase_data->token_id = $purchase_token->id;

            $purchase_data->save();
        }

        return [
            'pin' => $pin,
            'token' => $token_key,
        ];
    }
}
