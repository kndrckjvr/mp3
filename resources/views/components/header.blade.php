<div class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
                </div>
                <div class="navbar-nav">
                    <a class="nav-link {{ Route::is('music.index') ? 'active' : '' }}" aria-current="page"
                        href="/music">Store</a>
                </div>
                @if(!Auth::check())
                <div class="navbar-nav">
                    <a class="nav-link {{ Route::is('check-my-downloads') ? 'active' : '' }}" aria-current="page"
                        href="/check-my-downloads">Check My Downloads</a>
                </div>
                @else
                    @if(strpos(Auth::user()->role, 'admin') !== -1)
                    <div class="navbar-nav">
                        <a class="nav-link {{ Route::is('user.list') ? 'active' : '' }}" aria-current="page"
                            href="/user/show">Users</a>
                    </div>
                    <div class="navbar-nav">
                        <a class="nav-link {{ Route::is('purchase.list') ? 'active' : '' }}" aria-current="page"
                            href="/user/show">Purchases</a>
                    </div>
                    @endif
                @endif
            </div>
            <div class="d-none d-lg-flex">
                @if(!Auth::check())
                <div class="navbar-nav">
                    <a class="nav-link {{ Route::is('user.login') ? 'active' : '' }}" aria-current="page"
                        href="/login">Login</a>
                </div>
                @else
                <div class="navbar-nav">
                    <a class="nav-link {{ Route::is('user.profile') ? 'active' : '' }}" aria-current="page"
                        href="/profile">{{ auth()->user()->name }}</a>
                </div>
                <div>
                    <button type="button" class="btn btn-danger" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</button>
                    <form id="logout-form" action="/logout" method="POST" style="display: none">
                        @csrf
                    </form>
                </div>
                @endif
                <div class="navbar-nav">
                    <a class="nav-link" id="cart-modal-count" aria-current="page" href="javascript:void(0)"
                        data-bs-toggle="modal" data-bs-target="#cart-modal">Cart
                        ({{ count(session('cart') ?? []) }})</a>
                </div>
            </div>
        </div>
    </nav>
</div>