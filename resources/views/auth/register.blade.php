<x-layout>
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-cover">
                    <div class="auth-inner row m-0">
                        <!-- Left Text-->
                        <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                            <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                                <img class="img-fluid" src="{{ asset('app-assets/images/pages/register-v2.svg') }}" alt="Register V2" />
                            </div>
                        </div>
                        <!-- /Left Text-->
                        <!-- Register-->
                        <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                            <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                                <h2 class="card-title fw-bold mb-1">Sign Up here 🚀</h2>
                                <p class="card-text mb-2">Manage school assets inventory easily and efficiently!</p>
                                <form class="auth-register-form mt-2" action="{{ route('register') }}" method="POST" id="register-form">
                                    @csrf
                                    <div class="mb-1">
                                        <label class="form-label" for="name">Full Name</label>
                                        <input class="form-control @error('name') is-invalid @enderror" id="name" type="text" name="name" placeholder="Full Name" aria-describedby="name" autofocus="" tabindex="1" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="email">Email</label>
                                        <input class="form-control @error('email') is-invalid @enderror" id="email" type="text" name="email" placeholder="Email Address" aria-describedby="email" tabindex="2" />
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="mb-1">
                                        <label class="form-label" for="password">Password</label>
                                        <div class="input-group input-group-merge form-password-toggle">
                                            <input class="form-control form-control-merge" id="password" type="password" name="password" placeholder="············" aria-describedby="password" tabindex="3" />
                                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="form-check">
                                            <input class="form-check-input" id="register-privacy-policy" type="checkbox" tabindex="4" />
                                            <label class="form-check-label" for="register-privacy-policy">I agree to<a href="#">&nbsp;privacy policy & terms</a></label>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100" tabindex="5">Sign up</button>
                                </form>
                                <p class="text-center mt-2"><span>Already have an account?</span><a href="{{ route('login') }}"><span>&nbsp;Sign in instead</span></a></p>
                            </div>
                        </div>
                        <!-- /Register-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <script>
        document.getElementById('register-form').addEventListener('submit', function(event) {
            var checkbox = document.getElementById('register-privacy-policy');
            if (!checkbox.checked) {
                event.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Agreement Required',
                    text: 'You must agree to the privacy policy & terms.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            event.preventDefault();

            const formData = new FormData(this);
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful',
                        text: 'Welcome, ' + data.user + '!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/home';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: 'Registration unsuccessful. Please try again.',
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
