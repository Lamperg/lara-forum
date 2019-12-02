@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads._list')
            </div>

            <div class="col-md-4">
                <div class="card mt-2">
                    <div class="card-header">
                        Trending Threads
                    </div>
                    <div class="card-body">
                        @foreach($trending as $thread)
                            <li>
                                <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                            </li>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
