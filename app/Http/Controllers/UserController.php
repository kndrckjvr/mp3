<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'profile', 'downloads']);
    }

    public function index()
    {
        if (!Auth::check()) {
            return view('pages.login');
        } else {
            return redirect('/');
        }
    }

    public function login(Request $request)
    {
        $data = $request->only(['email', 'password']);

        if (Auth::attempt($data)) {
            return response()->json([
                'message' => Auth::user(),
                'status' => 1
            ]);
        } else {
            return response()->json([
                'message' => 'The username and password you entered did not match our records. Please double-check and try again.',
                'status' => 2
            ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function check_my_downloads(Request $request)
    {
        $data['request'] = $request->only(['email']);
        $data['purchases'] = [];
        if (!(empty($data['request']) || $data['request'] == null)) {
            $user = User::where('email', $data['request']['email'])->first();
            if ($user != null) {
                $data['purchases'] = User::find($user->id)->purchase->groupBy('token_id');
            }
        }

        return view('pages.check_my_download', $data);
    }

    public function downloads(Request $request)
    {
        $data = $request->only(['token', 'pin', 'id']);

        $data['music'] = Purchase::whereHas('purchase_token', function ($query) use ($data) {
            return $query->where('token', $data['token']);
        })->whereHas('music', function ($query) use ($data) {
            return $query->where('id', $data['id']);
        })->first();

        if ($data['music'] == null || empty($data['music'])) {
            return redirect('/profile');
        }

        return view('pages.download', $data);
    }

    public function profile()
    {
        $data['user'] = Auth::user();
        $data['purchases'] = User::find(Auth::user()->id)->purchase->groupBy('token_id');

        return view('pages.profile', $data);
    }
}
