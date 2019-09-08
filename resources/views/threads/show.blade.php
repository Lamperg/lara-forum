@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->owner->name }}</a> posted {{ $thread->title }}
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div class="mt-2">
                    {{ $replies->links() }}
                </div>

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

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <p>
                            This thread was published {{ $thread->created_at->diffForHumans() }}
                            by <a href="#">{{ $thread->owner->name }}</a>,
                            and currently has {{ $thread->replies_count }} {{ \Str::plural('comment', $thread->replies_count) }}.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
