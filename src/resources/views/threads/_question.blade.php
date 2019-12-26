@php
    /** @var \App\Models\Thread $thread */
@endphp

{{--Editing the question--}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <div class="form-group mb-0 w-100">
                <input class="form-control" type="text" v-model="form.title"/>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="form-group mb-0">
            <textarea class="form-control" cols="30" rows="4" v-model="form.body"></textarea>
        </div>
    </div>

    <div class="card-footer">
        <div class="level">
            <button class="btn btn-secondary btn-sm mr-2" v-if="!editing" @click="editing=true">Edit</button>
            <button class="btn btn-success btn-sm mr-2" v-else @click="update">Update</button>
            <button class="btn btn-primary btn-sm" @click="cancel">Cancel</button>

            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="post" class="ml-auto">
                    @csrf
                    @method('delete')

                    <button type="submit" class="btn btn-danger btn-sm">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>

{{--Viewing the question--}}
<div class="card" v-else>
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
            </a> posted <span v-text="form.title"></span>
            </span>
        </div>
    </div>

    <div class="card-body" v-text="form.body"></div>

    <div class="card-footer" v-if="authorize('owns', thread)">
        <button class="btn btn-secondary btn-sm" @click="editing=true">Edit</button>
    </div>
</div>
