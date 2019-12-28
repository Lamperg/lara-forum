@extends('layouts.app')

@section('head')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>
                    <div class="card-body">
                        <form action="{{ route('threads.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="channel_id">Choose a channel:</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">Choose One...</option>

                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                            {{ old('channel_id') == $channel->id ? 'selected' : '' }}
                                        >
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text"
                                       class="form-control"
                                       name="title"
                                       id="title"
                                       value="{{ old('title') }}"
                                       required
                                >
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <wysiwyg-editor name="body"></wysiwyg-editor>
                            </div>

                            <div class="form-group">
                                <div class="g-recaptcha" data-sitekey="6LdfbckUAAAAAH3Hea9EfPVPZnSablt1pW_LDdFY"></div>
                            </div>

                            <button type="submit" class="btn btn-primary">Publish</button>
                        </form>

                        @if($errors->any())
                            <ul class="alert alert-danger mt-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
