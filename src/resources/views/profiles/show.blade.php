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

                    @can('update', $profileUser)
                        <form method="post"
                              enctype="multipart/form-data"
                              action="{{ route('api.avatar_store', $profileUser) }}"
                        >
                            @csrf

                            <div class="input-group">
                                <div class="custom-file">
                                    <label class="custom-file-label" for="avatar">Choose avatar</label>
                                    <input type="file" class="custom-file-input" name="avatar" id="avatar">
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Save avatar</button>
                                </div>
                            </div>
                        </form>
                        <br/>
                    @endcan

                    <img class="img-thumbnail"
                         alt="{{ $profileUser->name }}"
                         src="{{ asset("/storage/{$profileUser->avatar_path}") }}"
                    >
                </div>

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
