@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->owner->name }}</a> posted {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if(auth()->check())
                    <div class="card mt-2">
                        <div class="card-body">

                            <form action="{{ route('threads.replies_store', [$thread->channel, $thread]) }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="body">Reply:</label>
                                    <textarea class="form-control"
                                              name="body"
                                              id="body"
                                              rows="3"
                                              placeholder="Have something to say?"
                                    ></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Post</button>
                            </form>

                        </div>
                    </div>
                @else
                    <p class="text-center mt-3">
                        Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
