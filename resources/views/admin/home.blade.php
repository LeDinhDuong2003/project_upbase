@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div style="display: flex; justify-content: space-between;margin: 0px;">
                        <div>
                            <h4>{{ __('User Management') }}</h4>
                        </div>
                        <div>
                            <form method="GET" action="/export-users">
                                <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Export Users') }}</button>
                            </form>
                            <form method="GET" action="/export-posts">
                                <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Export Posts') }}</button>
                            </form>
                        </div>

                    </div>

                    <div class="alert alert-error" role="alert">
                        @if ($errors->any())
                        <div>
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-success" role="alert">{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    <label for="search">{{ __('Search Users') }}</label>
                    <form action="/users/search" id="search-form" method="GET" style="display:flex;align-items:center;">
                        <div class="form-group">
                            <input style="width:600px" type="text" class="form-control" id="search" name="search" placeholder="Search by email or name">
                        </div>
                        <div>
                            <button style="float: right;" type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                        </div>
                    </form>

                    <form method="GET" action="/home">
                        <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Show All Users') }}</button>
                    </form>

                    <form method="GET" action="/users/trash">
                        <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Show Users In Trash') }}</button>
                    </form>

                    <button style="margin: 5px;" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
                        {{ __('Create New User') }}
                    </button>

                    @if($users->count() >0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Email</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="users-table-body">
                            @foreach ($users as $user)
                            <tr>
                                <!-- Bao bọc cả hàng trong thẻ <a> -->

                                <td><a href="{{ url('/users/details/' . $user->id) }}" style="color: inherit; display: block; text-decoration: none;"> {{ $user->email }}</a></td>
                                <td><a href="{{ url('/users/details/' . $user->id) }}" style="color: inherit; display: block; text-decoration: none;"> {{ $user->name }}</a></td>
                                <td><a href="{{ url('/users/details/' . $user->id) }}" style="color: inherit; display: block; text-decoration: none;">
                                        <img src="{{ asset('storage/' . $user->img) }}" alt="" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;">
                                    </a>
                                </td>
                                <td><a href="{{ url('/users/details/' . $user->id) }}" style="color: inherit; display: block; text-decoration: none;"> {{ $user->role }}</a></td>
                                <td>
                                    <!-- Các nút "Edit" và "Delete" vẫn giữ nguyên -->
                                    <div style="display: flex; gap: 10px;">
                                        <form action="{{ url('/admin/edit/' . $user->id) }}" method="get">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                        <form action="{{ url('/users/destroy/' . $user->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                        <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editUserModal" >
                                            Edit2
                                        </button> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div style=" display: flex;
                                            justify-content: center;
                                            align-items: center;
                                            height: 300px;
                                            border: 1px solid #000;">
                        <h1 style="opacity: 0.5;text-align: center;">No one</h1>
                    </div>
                    @endif
                    <div>
                        {{ $users->links('pagination.custom') }}
                    </div>
                    <!-- <h4>{{ __('Your Information') }}</h4>
                    <form action="{{ route('users.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div>
                            @if(Auth::user()->img)
                            <img style="width: 50px;height: 50px;border-radius: 50%;" src="{{ asset('storage/' . Auth::user()->img) }}" alt="User Image" class="img-fluid mb-2" style="max-width: 150px; height: auto;">
                            @else
                            <p>{{ __('No image uploaded') }}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="img">{{ __('Image') }}</label>
                            <input type="file" class="form-control" name="img">
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('New Password') }}</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                    </form> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Modal create -->
    <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">{{ __('Create New User') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form tạo mới người dùng -->
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="form-group">
                            <label for="name">{{ __('Name') }}</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">{{ __('Role') }}</label>
                            <select name="role" class="form-control">
                                <option value="user">user</option>
                                <option value="admin">admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="img">{{ __('Image') }}</label>
                            <!-- Hiển thị ảnh nếu có -->
                            <input type="file" class="form-control" name="img" accept="image/*">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Create User') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal Edit User -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">{{ __('Edit User') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update', ':id') }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editName">{{ __('Name') }}</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">{{ __('Email') }}</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">{{ __('Role') }}</label>
                            <select name="role" id="editRole" class="form-control">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Sự kiện xác nhận trước khi xóa
        $(document).on('submit', '.delete-form', function(e) {
            var confirmed = confirm('Are you sure you want to delete this user?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
        $(document).on('submit', '.restore-form', function(e) {
            var confirmed = confirm('Are you sure you want to restore this user?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection