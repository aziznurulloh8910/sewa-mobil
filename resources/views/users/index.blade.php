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
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
                <div class="content-header-left col-md-9 col-12 mb-2">
                    <h2>Data Users</h2>
                </div>
            </div>
        </div>


        <div class="content-body">
            <!-- Basic Tables start -->
            <div class="row" id="basic-table">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Table Basic</h4>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#AddUserForm">
                                Add New User
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role == 1)
                                                <span class="badge rounded-pill badge-light-primary me-1">Super Admin</span>
                                            @else
                                                <span class="badge rounded-pill badge-light-success me-1">Admin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart d-inline-flex">
                                                <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0" data-bs-toggle="dropdown">
                                                    <i data-feather="more-vertical"></i>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('users.detail', ['id' => $user->id]) }}" data-bs-toggle="modal" data-bs-target="#DetailUser-{{ $user->id }}" >
                                                        <i data-feather="user" class="me-50"></i>
                                                        <span>Detail</span>
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('users.delete', ['id' => $user->id]) }}" id="delete-user-button" data-name="{{ $user->name }}" data-id="{{ $user->id }}">
                                                        <i data-feather="trash" class="me-50"></i>
                                                        <span>Delete</span>
                                                    </a>
                                                    <form id="delete-user-form-{{ $user->id }}" action="{{ route('users.delete', ['id' => $user->id]) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>

                                            <!-- Buttom Trigger Edit Modal Form -->
                                            <a class="item-edit" id="update-user-form" href="{{ route('users.update', ['id' => $user->id]) }}" data-bs-toggle="modal" data-bs-target="#editModal-{{$user->id}}">
                                                <i data-feather="edit" class="me-50"></i>
                                            </a>

                                            <!-- Edit Modal Form -->
                                            <div class="modal fade text-start" id="editModal-{{$user->id}}" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Update User Form</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <label>Name: </label>
                                                                <div class="mb-1">
                                                                    <input type="text" name="name" placeholder="Full Name" class="form-control" value="{{ old('name', $user->name) }}" />
                                                                </div>
                                                                <label>Email: </label>
                                                                <div class="mb-1">
                                                                    <input type="text" name="email" placeholder="Email Address" class="form-control" value="{{ old('email', $user->email) }}" />
                                                                </div>

                                                                <label>Password: </label>
                                                                <div class="mb-1">
                                                                    <input type="password" name="password" placeholder="Password" class="form-control" />
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- Detail Modal -->
                                            <div class="modal fade text-start" id="DetailUser-{{ $user->id }}" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myModalLabel33">Detail User</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="col">
                                                                <div class="row">
                                                                    <label>Name: {{ $user->name }}</label>
                                                                </div>
                                                                <div class="row">
                                                                    <label>Email: {{ $user->email }}</label>
                                                                </div>
                                                                <div class="row">
                                                                    <label>Role:
                                                                        @if ($user->role == 1)
                                                                            Super Admin
                                                                        @else
                                                                            Admin
                                                                        @endif
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Basic Tables end -->

            <!-- Create Modal -->
            <div class="modal fade text-start" id="AddUserForm" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">Add User Form</h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('users.create') }}" method="POST" id="add-user-form">
                            @csrf
                            <div class="modal-body">
                                <label>Name: </label>
                                <div class="mb-1">
                                    <input type="text" name="name" placeholder="Full Name" class="form-control" />
                                </div>
                                <label>Email: </label>
                                <div class="mb-1">
                                    <input type="text" name="email" placeholder="Email Address" class="form-control" />
                                </div>

                                <label>Password: </label>
                                <div class="mb-1">
                                    <input type="password" name="password" placeholder="Password" class="form-control" />
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @push('script')
    <script>
        document.getElementById('delete-user-button').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default action

            var user_id = this.getAttribute('data-id')
            var user_name = this.getAttribute('data-name')

            Swal.fire({
                title: 'Are you sure?',
                text: `You will delete the user : ${user_name}.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete!',
                cancelButtonText: 'Cancel',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-danger'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-user-form-${user_id}`).submit();

                    setTimeout(function() {
                        Swal.fire({
                            title: 'Deleted!',
                            text: `User has been deleted.`,
                            icon: 'success',
                            confirmButtonText: 'OK',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            }
                        });
                    }, 500);
                }
            });
        });


        document.getElementById('add-user-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Successful',
                        text: 'New user has been successfully added!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = '/users';
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Add User Failed',
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
    @endpush

    <x-footer></x-footer>

</x-layout-dashboard>
