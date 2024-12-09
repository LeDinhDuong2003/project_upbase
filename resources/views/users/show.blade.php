@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Details {{ $user->name }}'s information</h5>
                </div>
                <div class="card-body text-center">
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ $user->role }}</p>
                    <div class="user-image">
                        <img src="{{ asset('storage/' . $user->img) }}" alt="{{ $user->name }}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card {
        margin-top: 50px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .user-image img {
        max-width: 100%;
        border-radius: 50%;
        object-fit: cover;
        margin-top: 20px;
    }

    .card-header h1 {
        font-size: 2rem;
        color: #007bff;
    }

    .card-body p {
        font-size: 1.1rem;
        margin: 10px 0;
    }
</style>
@endpush
