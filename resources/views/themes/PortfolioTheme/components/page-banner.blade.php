<!-- Banner -->
<section class="pc-banner pc-banner-page" data-image-src="{{ getImageUrl(json_decode($page->thumbnail, true), 'blog_thumbnail') }}">
    <div class="pc-banner-content">
        <div class="container">
            <h3 class="text-uppercase text-center pc-banner-content-header animated slideInRight">{{ $page->title }}</h3>
        </div>
    </div>
    <a class="pc-banner-btn" href="{{ url('/') }}"><span class="fa fa-angle-left"></span> Strona główna</a>
</section>