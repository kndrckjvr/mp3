@extends('base')

@section('content')
<div class="container mt-4" style="min-height; 94vh">
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <form action="#" id="login-form">
                        @csrf
                        <div class="mb-3">
                            <label for="email_address" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email_address" id="email_address"
                                placeholder="name@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary ml-auto" id="login-submit">Login</button>
                            <button type="button" class="btn btn-primary ml-auto">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-3"></div>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        let data ={ 
            email: $('#email_address').val(),
            password: $('#password').val(),
        };
        
        $.ajax({
            url: "{{ route('login') }}",
            data: data,
            type: 'POST',
            success: function (result) {
                if (result.status == 1) {
                    window.location = "/"
                }
            }
        })
    });
</script>
@endsection