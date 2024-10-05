<x-layout>
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Logo -->
                    <a class="brand-logo" href="/">
                        <img src="{{ asset('app-assets/images/logo/logo.png') }}" alt="logo" height="32">
                        <h2 class="brand-text text-primary ms-1">Sewa Mobil PT Jasamedika</h2>
                    </a>
                    <!-- Logo End-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="{{ asset('app-assets/images/pages/login-v2.svg')}}" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1">Welcome to the Sewa Mobil Apps 👋</h2>
                            <p class="card-text mb-2">Please sign-in to your account to manage and track Sewa Mobil.</p>
                            <form class="auth-login-form mt-2" action="{{ route('login.post') }}" method="POST"  id="login-form">
                                @csrf
                                <div class="mb-1">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" id="email" type="email" name="email" placeholder="Email Address" aria-describedby="email" autofocus="" tabindex="1" />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Password</label><a href="{{ route('forgot-password') }}"><small>Forgot Password?</small></a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="form-check">
                                        <input class="form-check-input" id="remember-me" type="checkbox" tabindex="3" />
                                        <label class="form-check-label" for="remember-me"> Remember Me</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
                            </form>
                            <p class="text-center mt-2"><span>New on our platform?</span><a href="{{ route('register') }}"><span>&nbsp;Create an account</span></a></p>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->

<script>
    document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    fetch(this.getAttribute('action'), {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // If login successful, show success message using SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Login Successful',
                text: 'Welcome, ' + data.user + '!', // Menampilkan nama pengguna
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '/home';
            });
        } else {
            // If login failed, show error message using SweetAlert2
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Invalid email or password. Please try again.',
                confirmButtonText: 'Retry'
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});

</script>
</x-layout>
