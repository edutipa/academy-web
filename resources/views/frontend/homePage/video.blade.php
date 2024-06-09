<section class="recent-videos-section bg-cover p-t-80 p-b-80 p-t-sm-40 p-b-sm-50" style="background-image: url({{ static_asset('frontend/img/section/recent-video-section-bg.jpg') }});">
    <div class="container container-1278">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="common-heading color-white text-center m-b-40 m-b-sm-30">
                    <h3>{{ $section->contents['title'] }}</h3>
                    <p>{{ $section->contents['sub_title'] }}</p>
                </div>
            </div>
        </div>
        <div class="row recent-videos recent-video-slider slider-primary justify-content-center" data-aos="fade-up" dir="{{ systemLanguage() ? systemLanguage()->text_direction : 'ltr' }}">
            <div class="col-lg-10">
{{--                1030*520--}}
                <div class="recent-video-player"
                     @if($section->image_1)
                         data-poster="{{ getFileLink('296x285',$section->image_1) }}"
                     @endif
                     data-plyr-provider="youtube" data-plyr-embed-id="{{ $section->contents['url'] }}"></div>
            </div>
<!--            <div class="col-lg-10">
                <div class="recent-video-player" data-poster="{{ static_asset('frontend/img/video/recent-video-thumbnail-2.jpg') }}" data-plyr-provider="youtube" data-plyr-embed-id="ScMzIvxBSi4"></div>
            </div>
            <div class="col-lg-10">
                <div class="recent-video-player" data-poster="{{ static_asset('frontend/img/video/recent-video-thumbnail-1.jpg') }}" data-plyr-provider="youtube" data-plyr-embed-id="bTqVqk7FSmY"></div>
            </div>-->
        </div>
    </div>
</section>
