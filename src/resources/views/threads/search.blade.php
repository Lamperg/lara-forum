@extends('layouts.app')

@php
    /** @var \App\Models\Thread $thread */
@endphp

@section('content')
    <thread-search
        inline-template
        api-key="{{ config('scout.algolia.key') }}"
        app-id="{{ config('scout.algolia.id') }}"
    >
        <ais-instant-search :search-client="searchClient" index-name="threads">
            <ais-configure query="{{ request('q') }}"></ais-configure>

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <ais-hits>
                            <div slot="item" slot-scope="{ item }">
                                <h5>
                                    <a :href="item.path">
                                        <ais-highlight attribute="title" :hit="item"></ais-highlight>
                                    </a>
                                </h5>
                            </div>
                        </ais-hits>
                    </div>

                    <div class="col-md-4">
                        <div class="card mt-2">
                            <div class="card-header">
                                Search
                            </div>
                            <div class="card-body">
                                <ais-search-box placeholder="Find a thread..." :autofocus="true"></ais-search-box>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-header">
                                Filter By Channel
                            </div>
                            <div class="card-body">
                                <ais-refinement-list attribute="channel.name"></ais-refinement-list>
                            </div>
                        </div>

                        @if(count($trending))
                            <div class="card mt-2">
                                <div class="card-header">
                                    Trending Threads
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        @foreach($trending as $thread)
                                            <li class="list-group-item">
                                                <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </ais-instant-search>
    </thread-search>
@endsection
