@extends('layouts.app')

@section('content')
<div class="container">
    <div style="height: 100px; display: flex; justify-content: space-between;">
        <h2>Edit User</h2>
        <div >
            <form method="GET" action="/home">
                <button style="margin:5px;" id="show-all-users" class="btn btn-primary">{{ __('Home') }}</button>
            </form>
        </div>
    </div>

    <!-- Hiển thị thông báo nếu có -->
    @if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
    @endif

    <!-- Form chỉnh sửa người dùng -->
    <form action="{{ route('admin.update', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Input cho email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="name" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <!-- Input cho role -->
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-control" id="role" name="role" required>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <div class="form-group">
            <label for="img">{{ __('Image') }}</label>
            <!-- Hiển thị ảnh nếu có -->
            <input type="file" class="form-control" name="img" accept="image/*">
        </div>

        <!-- Button để gửi form -->
        <button style="float: right; margin: 5px;" type="submit" class="btn btn-primary">Update User</button>
    </form>
</div>
@endsection