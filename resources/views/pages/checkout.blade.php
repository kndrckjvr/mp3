@extends('base')

@section('content')
<div class="container mt-4">
    <h1>Checkout: </h1>
    <div id="checkout-body-list">
        @foreach ($cart_items as $item)
        <div class="d-flex flex-row w-100 border border-dark justify-content-between mb-1 p-3">
            <div class="d-flex flex-row w-75">
                <img src="/images/{{ $item->album_image }}" alt="default" style="width: 10%;">
                <div class="d-flex flex-column p-2 justify-content-between">
                    <span>{{ $item->name }} - {{ $item->artist }}</span>
                    <span>Price: $5.00</span>
                </div>
            </div>
            <div class="d-flex flex-row justify-content-around align-items-center w-25">
                <button type="button" class="btn btn-danger remove-cart-data" data-id="{{ $item->id }}">Remove</button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="d-flex flex-row w-100 border border-dark justify-content-between mb-1 p-3">
        <h4 class="fw-bold">Total:</h4>
        <h4 id="checkout-total">$ 0.00</h4>
    </div>
    <div>
        <form action="/process-checkout" method="post" class="d-flex flex-row w-100 border border-dark justify-content-between mb-1 p-3">
            @csrf
            <div class="d-flex flex-row w-50">
                <input type="email" value="{{ Auth::user()->email ?? '' }}" class="form-control" name="email"
                    placeholder="name@example.com" {{ Auth::check() ? 'readonly' : '' }}>
            </div>
            <button type="submit" class="btn btn-success">Checkout</button>
        </form>
    </div>
</div>
@endsection