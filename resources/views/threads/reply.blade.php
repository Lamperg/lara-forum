<reply-base
    inline-template
    v-cloak
    :attributes="{{ $reply }}"
>
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
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" rows="3" v-model="body">{{ $reply->body }}</textarea>
                    <button class="btn btn-primary btn-sm" @click="update">Update</button>
                    <button class="btn btn-link btn-sm" @click="editing=false">Cancel</button>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>

        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn btn-secondary btn-sm mr-2" @click="editing=true">Edit</button>
                <button class="btn btn-danger btn-sm" @click="destroy">Delete</button>
            </div>
        @endcan
    </div>
</reply-base>
