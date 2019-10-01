@php
    /** @var App\Models\Reply $reply */;
@endphp
<div id="reply-{{ $reply->id }}" class="card mt-2">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                <a href="{{ route('profiles.show', $reply->owner) }}">
                    {{ $reply->owner->name }}
                </a> said {{ $reply->created_at->diffForHumans() }}...
            </span>

            <div>
                <form action="{{ route('replies.favorite_store', $reply) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ \Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
