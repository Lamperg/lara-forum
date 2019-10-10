@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <thread-view
        inline-template
        :initial-replies-count="{{ $thread->replies_count }}"
    >
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
