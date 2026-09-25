@extends('layouts.tutor')

@section('title', 'Tutor Profile')

@section('content')

    <div class="profile-header">
        <h1>Tutor Profile</h1>
        <p class="profile-description">
            View and manage your tutor profile information.
        </p>
    </div>

    @if ($tutorProfile)
        <div class="card profile-card">
            <div class="card-body">
                <h2 class="section-title">Profile Information</h2>
                <div class="profile-info-grid">
                    <div class="info-item">
                        <span class="info-label">Bio</span>
                        <strong>
                            {{ $tutorProfile->bio ?: 'No bio added yet.' }}
                        </strong>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Experience</span>

                        <strong>
                            {{ $tutorProfile->experience_years }} years
                        </strong>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Rating</span>

                        <strong>
                            {{ number_format($tutorProfile->average_rating, 2) }} / 5.00
                        </strong>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Teaching Mode</span>

                        <strong>
                            {{ ucfirst($tutorProfile->teaching_mode) }}
                        </strong>
                    </div>
                </div>

                <div class="profile-actions">

                    <a href="{{ route('tutor.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>

    @else
        <div class="empty-profile">
            <h2>Tutor Profile Not Found</h2>
            <p>
                You don't have a tutor profile yet.
            </p>
        </div>

    @endif
@endsection