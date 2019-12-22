@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <thread-view
        inline-template
        :thread="{{ $thread }}"
    >
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                <img class="img-thumbnail mr-2"
                                     alt="{{ $thread->owner->name }}"
                                     src="{{ $thread->owner->avatar_path }}"
                                     width="50"
                                >
                                <span class="flex">
                                <a href="{{ route('profiles.show', $thread->owner) }}">
                                    {{ $thread->owner->name }}
                                </a> posted {{ $thread->title }}
                                </span>

                                @can('update', $thread)
                                    <form action="{{ $thread->path() }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-link">Delete Thread</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies-list @added="repliesCount++" @removed="repliesCount--"></replies-list>

                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <p>
                                This thread was published {{ $thread->created_at->diffForHumans() }}
                                by <a href="#">{{ $thread->owner->name }}</a>,
                                and currently
                                has <span v-text="repliesCount"></span> {{ \Str::plural('comment', $thread->replies_count) }}.
                            </p>
                            <p>
                                <subscribe-btn :active="@json($thread->isSubscribedTo)" v-if="signedIn"></subscribe-btn>

                                <button class="btn btn-dark"
                                        v-if="authorize('isAdmin')"
                                        v-text="locked ? 'Unlock': 'Lock'"
                                        @click="toggleLock"
                                ></button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
