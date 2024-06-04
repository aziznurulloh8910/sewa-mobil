<x-layout-dashboard>
    <!-- BEGIN: Header-->
    <x-navbar></x-navbar>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <x-sidebar></x-sidebar>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>

        <div class="content-body">
            <!-- profile -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Profile Details</h4>
                </div>
                <div class="card-body py-2 my-25">
                    <div class="alert alert-primary">
                        <h4 class="alert-heading">
                            Your account is assigned the role of an @if (auth()->user()->role == 1) Super Admin @else Admin @endif</h4>
                        <div class="alert-body fw-normal">
                            @if (auth()->user()->role == 1)
                            Role modifications for any account in the <a href="{{ route('users') }}">users data table</a> can only be performed by a super admin.
                            @else
                                Role modifications for any account in the users data table can only be performed by a super admin.
                            @endif
                        </div>
                    </div>
                    <!-- form -->
                    <form class="validate-form pt-50" action="{{ route('users.update', auth()->user()->id) }}" method="POST" id="update-user-profile">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountFullName">Full Name</label>
                                <input type="text" class="form-control" id="accountFullName" name="name" placeholder="Full Name" value="{{ old('name', auth()->user()->name) }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountEmail">Email Address</label>
                                <input type="email" class="form-control" id="accountEmail" name="email" placeholder="Email Address" value="{{ old('emai', auth()->user()->email) }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountPassword">Current Password</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" class="form-control" id="account-old-password" name="current-password" placeholder="Enter current password" />
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountNewPassword">New Password</label>
                                <div class="input-group form-password-toggle input-group-merge">
                                    <input type="password" id="account-new-password" name="new-password" class="form-control" placeholder="Enter new password" />
                                    <div class="input-group-text cursor-pointer">
                                        <i data-feather="eye"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary mt-1 me-1">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary mt-1">Discard</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>
        </div>

        <!-- deactivate account  -->
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Delete Account</h4>
            </div>
            <div class="card-body py-2 my-25">
                <div class="alert alert-warning">
                    <h4 class="alert-heading">Are you sure you want to delete your account?</h4>
                    <div class="alert-body fw-normal">
                        Once you delete your account, there is no going back. Please be certain.
                    </div>
                </div>

                <form id="formAccountDeactivation" class="validate-form" onsubmit="return false">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="accountActivation" id="accountActivation" data-msg="Please confirm you want to delete account" />
                        <label class="form-check-label font-small-3" for="accountActivation">
                            I confirm my account deactivation
                        </label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-danger deactivate-account mt-1">Deactivate Account</button>
                    </div>
                </form>
            </div>
        </div>
        <!--/ profile -->
    </div>
    <!-- END: Content-->



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <x-footer></x-footer>

    @push('script')
        <script>
            document.getElementById('update-user-profile').addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    icon: 'success',
                    title: 'Are you sure?',
                    text: "Do you want to save the changes?",
                    confirmButtonText: 'Yes, save it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update User Failed',
                            text: 'Invalid email or password. Please try again.',
                            confirmButtonText: 'Retry'
                        });
                    }
                });
            });
        </script>
    @endpush

</x-layout-dashboard>
