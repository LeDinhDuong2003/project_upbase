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

                    @if (Auth::user()->role == 'admin')
                        <h4>{{ __('User Management') }}</h4>
                        
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
                        <form id="search-form" method="POST" style="display:flex;align-items:center;">
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
                                <!-- Dữ liệu người dùng sẽ được tải vào đây bằng AJAX -->
                                @foreach ($users as $user)
                                    <tr >
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->name}}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $user->img) }}" alt="" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;">
                                        </td>
                                        <td>{{ $user->role }}</td>
                                        <td>
                                            <div style="display: flex; gap: 10px;">
                                                <form action="{{ url('/admin/edit/' . $user->id) }}" method="get">
                                                    <button type="submit" class="btn btn-primary">Edit</button>
                                                </form>
                                                <form action="{{ url('/users/destroy/' . $user->id) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $users->links('pagination.custom') }}
                        </div>

                        <h4>{{ __('Create New User') }}</h4>
                        <form action="{{ route('user.store') }}" method="POST">
                            @csrf
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
                            <button type="submit" class="btn btn-primary">{{ __('Create User') }}</button>
                        </form>

                    @else
                        <h4>{{ __('Your Information') }}</h4>
                        <form action="{{ route('user.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
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
                                <!-- Hiển thị ảnh nếu có -->
                                
                                <input type="file" class="form-control" name="img">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('New Password') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
</form>

                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        function fetchUsers(query = '') {
            $.ajax({
                url: '/users/search',
                type: 'GET',
                data: { search: query },
                success: function(data) {
                    var usersHtml = '';
                    data.forEach(function(user) {
                        usersHtml += `
                            <tr>
                                <td>${user.email}</td>
                                <td>${user.name}</td>
                                <td>
                                    <img src="${window.location.origin}/storage/${user.img}" alt="" style="width: 50px;height: 50px;border-radius: 50%;object-fit: cover;">
                                </td>
                                <td>${user.role}</td>
                                <td>
                                    <div style="display: flex; gap: 10px;">
                                        <form action="/user/edit/${user.id}" method="get">
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </form>
                                        <form action="/users/destroy/${user.id}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    $('#users-table-body').html(usersHtml);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching data: ", error);
                }
            });
        }

        // Gọi hàm fetchUsers khi có từ khóa tìm kiếm
        $('#search-form').on('submit', function(e) {
            e.preventDefault();
            var query = $('#search').val();
            fetchUsers(query); // Gửi từ khóa tìm kiếm vào server
        });

        // Sự kiện xác nhận trước khi xóa
        $(document).on('submit', '.delete-form', function(e) {
            var confirmed = confirm('Are you sure you want to delete this user?');
            if (!confirmed) {
                e.preventDefault();
            }
        });

        // Fetch dữ liệu người dùng ban đầu
        // fetchUsers();
    });
</script>
@endsection
