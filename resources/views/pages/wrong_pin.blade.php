@extends('base')

@section('content')
    <div class="container">
        <h1>Entered Pin is wrong</h1>
        <a href="{{ $redirect_link }}">Go Back</a>
    </div>
@endsection