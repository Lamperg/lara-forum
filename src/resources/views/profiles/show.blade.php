@extends('layouts.app')

@php
    /** @var App\Models\Activity $activity */
    /** @var App\Models\User $profileUser */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>

                <avatar-form :user="{{ $profileUser }}"></avatar-form>

                @forelse($activities as $date => $records)
                    <h3 class="page-header">{{ $date }}</h3>

                    @foreach($records as $activity)
                        @if(view()->exists("profiles.activities.{$activity->type}"))
                            @include("profiles.activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <p>There's no activity for this user yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
