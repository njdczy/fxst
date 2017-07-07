@extends('front::index')

@section('content')
    <section class="content-header">
        <h1>
            {{ $header or trans('front::lang.title') }}
            <small>{{ $description or trans('front::lang.description') }}</small>
        </h1>

    </section>

    <section class="content">

        @include('front::partials.error')
        @include('front::partials.success')
        @include('front::partials.exception')
        @include('front::partials.toastr')

        {!! $content !!}

    </section>
@endsection