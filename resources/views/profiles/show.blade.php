@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
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

                @foreach($threads as $thread)
                    <div class="card mt-2">
                        <div class="card-header">
                            <div class="level">
                         <span class="flex">
                             <a href="#">{{ $thread->owner->name }}</a> posted:
                             {{ $thread->title }}
                         </span>
                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach

                <div class="mt-2">
                    {{ $threads->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
