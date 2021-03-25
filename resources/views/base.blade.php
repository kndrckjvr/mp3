<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    @component('components.header')

    @endcomponent
    @yield('content')
    <div class="modal fade" id="cart-modal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cart-body-list">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary"
                        onclick="window.location = '/checkout'">Checkout</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>



    <script>
        let cart = '@json(session("cart") ?? [])';

        function updateCart(e) {
            let data = JSON.parse(e);
            let len = data.length;
            $('#cart-body-list').html("");
            $('#checkout-body-list').html("");
            $('#cart-modal-count').html(`Cart (${len})`);

            if (len == 0) {
                $('#cart-body-list').html('<p class="m-0 text-center">There are no items in this cart.</p>');
            }


            for(let i = 0; i < len; i++) {
                let rowData = data[i];
                let html =  `<div class="d-flex flex-row w-100 border border-dark justify-content-between mb-1 p-3">` +
                                `<div class="d-flex flex-row w-75">` +
                                    `<img src="/images/${rowData.album_image}" alt="default" class="w-25">` +
                                    `<div class="d-flex flex-column p-2 justify-content-between">` +
                                        `<span>${rowData.name} - ${rowData.artist}</span>` +
                                        `<span>Price: $5.00</span>` +
                                    `</div>` +
                                `</div>` +
                                `<div class="d-flex flex-row justify-content-around align-items-center w-25">` +
                                    `<button type="button" class="btn btn-danger remove-cart-data" data-id="${rowData.id}">Remove</button>` +
                                `</div>` +
                            `</div>`;
                let checkoutHtml =  `<div class="d-flex flex-row w-100 border border-dark justify-content-between mb-1 p-3">` +
                                `<div class="d-flex flex-row w-75">` +
                                    `<img src="/images/${rowData.album_image}" alt="default" style="width: 10%;">` +
                                    `<div class="d-flex flex-column p-2 justify-content-between">` +
                                        `<span>${rowData.name} - ${rowData.artist}</span>` +
                                        `<span>Price: $5.00</span>` +
                                    `</div>` +
                                `</div>` +
                                `<div class="d-flex flex-row justify-content-around align-items-center w-25">` +
                                    `<button type="button" class="btn btn-danger remove-cart-data" data-id="${rowData.id}">Remove</button>` +
                                `</div>` +
                            `</div>`;

                $('#cart-body-list').append(html);
                $('#checkout-body-list').append(checkoutHtml);
                $('#checkout-total').html(`$ ${(len * 5).toFixed(2)}`)
            }
        }

        updateCart(cart);

        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#cart-modal').on('shown.bs.modal', function() {
                updateCart(cart);
            })

            $('body').on('click', 'button.remove-cart-data', function(e) {
                let music_id = $(e.currentTarget).data('id');
                $.ajax({
                    url: "{{ route('music.cart.remove') }}",
                    data: { id: music_id },
                    type: 'DELETE',
                    success: function (result) {
                        cart = JSON.stringify(result);
                        updateCart(cart);
                    }
                })
            });
        });
    </script>

    @yield('script')
</body>

</html>