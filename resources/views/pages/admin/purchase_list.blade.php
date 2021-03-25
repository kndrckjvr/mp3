@extends('base')


@section('content')
<div class="container">
    <h1>Purchases</h1>
    <div class="w-50 m-auto">
        @if(empty($purchases) || $purchases == null || count($purchases) == 0)
        <h6 class="text-center">There are no purchases made.</h6>
        @endif
        @foreach ($purchases as $purchase)
        <div class="border border-dark p-2 mb-1">
            <div class="d-flex flex-row">
                <div class="w-50">
                    Purchased By: {{ $purchase[0]->user->name }}
                </div>
                <div class="w-50">
                    Token: {{ $purchase[0]->purchase_token->token }}
                </div>
            </div>
            <div class="d-flex flex-row">
                <div class="w-50">
                    Purchased at: {{ $purchase[0]->created_at }}
                </div>
                <div class="w-50">
                    Quanity: {{ count($purchase) }}
                </div>
            </div>
            <div class="d-flex flex-row justify-content-center">
                <h5>Musics</h5>
            </div>
            @foreach ($purchase as $music)
            <div class="d-flex flex-row align-items-center justify-content-between border border-dark p-2 mb-2">
                <div>{{ $music->music->name }} - {{ $music->music->artist }}</div>
                <a href="{{ route('user.download', ['token' => $music->purchase_token->token, 'id' => $music->music->id]) }}"
                    type="button" class="btn btn-primary">Download</a>
            </div>
            @endforeach
        </div>
        @endforeach
    </div>
</div>
@endsection