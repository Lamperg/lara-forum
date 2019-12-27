@extends('layouts.app')

@section('content')
    <search-form api-key="{{ config('scout.algolia.key') }}"
                 app-id="{{ config('scout.algolia.id') }}"
    ></search-form>
@endsection
