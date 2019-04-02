@extends("master")

@section("content")
    <!-- Login Begins -->
    <div class="container-fluid" style="margin-top: 12rem;">
        <div class="row justify-content-center">
            <form method="POST" action="/login">
                {{ csrf_field() }}
                <img class="col-6 offset-3 mb-2 right" src="/images/santa.png"/>
                <h2 class="text-center">Log In</h2>
                <div id="login_email_wrapper">
                    <div class="form-group mt-4">
                        <input type="email" class="form-control" placeholder="Email Address" name="username"
                               value="{{ old('username', '') }}" required>
                    </div>
                    <button type="button" class="btn bg-primary-color float-right px-3" onclick="onNextClick()">Next
                    </button>
                </div>
                <div id="login_password_wrapper" class="invisible mt-4">
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label mb-3 ml-1">
                            <input type="checkbox" class="form-check-input">Remember Me
                        </label>
                    </div>
                    <button type="submit" class="btn bg-primary-color float-right">Sign In</button>
                </div>
            </form>
        </div>
    </div>

    <script src="/js/login.js"></script>
    <!-- Login Ends -->
@endsection()