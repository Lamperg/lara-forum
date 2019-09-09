@php
    /** @var App\Models\Reply $reply */;
@endphp
<div class="card mt-2">
    <div class="card-header">
        <div class="level">
            <span class="flex">
                <a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
            </span>

            <div>
                @php
                    $favoritesCount = $reply->favorites()->count();
                @endphp
                <form action="{{ route('replies.favorite_store', $reply) }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $favoritesCount }} {{ \Str::plural('Favorite', $favoritesCount) }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
