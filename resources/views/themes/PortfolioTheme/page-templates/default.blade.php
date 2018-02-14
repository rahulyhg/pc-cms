@extends('themes.PortfolioTheme.layout')

@section('meta_title')
    {!! Theme::getMetaTitle($page->meta_title) !!}
@endsection

@section('meta_description')
    {!! Theme::getMetaDescription($page->meta_description) !!}
@endsection

@section('meta_robots')
    {!! Theme::getMetaRobots($page->allow_indexed) !!}
@endsection

@section('content')
    @include('themes.PortfolioTheme.components.page-banner')

    <section class="pc-section pc-contact-page">
        <div class="container">
            {!! $page->content !!}
        </div>
    </section>

    {{--@include('themes.components.blog')--}}
    {{--@include('themes.components.portfolio')--}}
@endsection