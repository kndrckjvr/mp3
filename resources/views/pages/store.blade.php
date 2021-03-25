@extends('base')

@section('content')
<div class="container mt-4" style="min-height; 94vh">
    <div class="row">
        <div>
            <p class="fw-bold m-0">Music: <span class="text-primary">({{ $musics->total() }})</span></p>
        </div>
    </div>
    <div class="row mt-2">
        @foreach ($musics->items() as $item)
        <div class="col col-md-3 col-lg-3 mb-2">
            <div class="card">
                <img src="/images/default-album.png" class="card-img-top" alt="default">
                <div class="card-body">
                    <h5 class="card-title">{{ $item->name }} - {{ $item->artist }}</h5>
                    <p class="card-text">Purchased {{ $item->downloads }} times.</p>
                    <a href="javascript:void(0)" class="music-add-cart btn btn-primary" data-id="{{ $item->id }}">
                        Add to Cart
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    {{ $musics->links() }}
</div>
@endsection

@section('script')
<script>
    $('.music-add-cart').on('click', function(e) {
        let music_id = $(e.currentTarget).data('id');
        $.ajax({
            url: "{{ route('music.cart') }}",
            data: { id: music_id },
            type: 'POST',
            success: function (result) {
                cart = JSON.stringify(result);
                updateCart(cart);
            }
        })
    });
</script>
@endsection