@extends('layouts.app')

@php
    /** @var App\Models\Activity $activity */
    /** @var App\Models\User $profileUser */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="page-header">
                    <h1>{{ $profileUser->name }}</h1>
                    <small>Since {{ $profileUser->created_at->diffForHumans() }}</small>
                </div>

                @foreach($activities as $date => $records)
                    <h3 class="page-header">{{ $date }}</h3>

                    @foreach($records as $activity)
                        @if(view()->exists("profiles.activities.{$activity->type}"))
                            @include("profiles.activities.{$activity->type}")
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection
