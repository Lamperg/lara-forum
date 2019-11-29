@forelse($threads as $thread)
    <div class="card mt-2">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}"
                           @auth()
                           class="{{ $thread->hasUpdatesFor(auth()->user()) ?: "text-secondary" }}"
                            @endauth
                        >
                            {{ $thread->title }}
                        </a>
                    </h4>

                    <h5>Posted By: <a href="{{ route('profiles.show', $thread->owner) }}">
                            {{ $thread->owner->name }}
                        </a>
                    </h5>
                </div>

                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ \Str::plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="body">{{ $thread->body }}</div>
        </div>
    </div>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse
