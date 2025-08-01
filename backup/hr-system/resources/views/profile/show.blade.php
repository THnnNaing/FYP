@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>My Profile</h3>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="profile-avatar">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                            <p>
                                <span class="badge bg-primary">
                                    {{ ucfirst($user->user_type) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Account Created</label>
                                <p>{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Last Updated</label>
                                <p>{{ $user->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                            Edit Profile
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                            Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: #3498db;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        margin: 0 auto 15px;
    }
</style>
@endpush