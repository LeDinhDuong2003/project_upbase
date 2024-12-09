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
                    <div style="display:flex;justify-content:space-between">
                        <h4>{{ __('User In Trash') }}</h4>
                        <div>
                            <form method="GET" action="/home">
                                <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Users Management') }}</button>
                            </form> 
                            <form method="GET" action="/users/trash">
                                <button style="margin:5px;float:right" id="show-all-users" class="btn btn-primary">{{ __('Show all trash') }}</button>
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
                        <form action="/users/trash/search" id="search-form" method="GET" style="display:flex;align-items:center;">
                            <div class="form-group">
                                <input style="width:600px" type="text" class="form-control" id="search" name="search" placeholder="Search by email or name">
                            </div>
                            <div>
                                <button style="float: right;" type="submit" class="btn btn-primary">{{ __('Search') }}</button>
                            </div>
                        </form>
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
                                                            <form action="{{ url('/users/restore/' . $user->id) }}" method="POST" class="restore-form">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit" class="btn btn-danger">Restore</button>
                                                            </form>
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
                                    <h1 style="opacity: 0.5;text-align: center;">Trash is emty</h1>
                                </div>
                            @endif
                        <div>
                            {{ $users->links('pagination.custom') }}
                        </div>

                        
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
        $(document).on('submit', '.restore-form', function(e) {
            var confirmed = confirm('Are you sure you want to restore this user?');
            if (!confirmed) {
                e.preventDefault();
            }
        });
    });
</script>
@endsection
