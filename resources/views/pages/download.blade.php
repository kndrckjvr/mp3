@extends('base')

@section('content')
<div class="container mt-4">
    <h1>Music</h1>

    <form action="/download-music" method="post">
        @csrf
        <div class="mb-3">
            <label for="musicTitle" class="form-label">Music Title</label>
            <input type="text" class="form-control" id="musicTitle" value="{{ $music->music->name }} - {{ $music->music->artist }}" readonly>
        </div>
        <div class="mb-3">
            <label for="tokenInput" class="form-label">Token</label>
            <input type="text" class="form-control" id="tokenInput" name="token" value="{{ $token }}" readonly>
        </div>
        <div class="mb-3">
            <label for="pin_code" class="form-label">Pin</label>
            <input type="password" class="form-control" id="pin_code" name="pin" placeholder="Please Enter Pin Code">
        </div>
        <input type="hidden" value="{{ $music->music->id }}" name="id">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection