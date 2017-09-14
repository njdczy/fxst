@extends('menber::index')

@section('content')
    <section class="content-header">
        <h1>
            {{ $header or trans('menber::lang.title') }}
            <small>{{ $description or trans('menber::lang.description') }}</small>
        </h1>

    </section>

    <section class="content">

        @include('menber::partials.error')
        @include('menber::partials.success')
        @include('menber::partials.exception')
        @include('menber::partials.toastr')

        {!! $content !!}

    </section>
@endsection