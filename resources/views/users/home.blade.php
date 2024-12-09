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
                        <h4>{{ __('Your Information') }}</h4>
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
                                <!-- Hiển thị ảnh nếu có -->
                                
                                <input type="file" class="form-control" name="img">
                            </div>
                            <div class="form-group">
                                <label for="password">{{ __('New Password') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                        </form>


                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
