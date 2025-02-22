<div class="col-lg-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ 200 * $loop->iteration}}">
    <div class="blog-post-item">
        <div class="post-thumbnail">
            <a href="#"><img src="{{ getFileLink('406x240',$blog->image) }}" alt="Blog Thumbnail"></a>
            <ul class="post-meta">
                <li class="date"><a href="#"><i class="fal fa-calendar"></i> {{ Carbon\Carbon::parse($blog->published_date)->format('d M Y') }}</a></li>
            </ul>
        </div>
        <div class="post-content">
            <h4 class="title">
                <a href="#">{{ $blog->lang_title }}</a>
            </h4>
            <p class="content">
                {{ $blog->lang_short_description }}
            </p>
            <div class="post-meta-wrapper">
                <div class="left-content">
                    <ul class="post-meta">
                        <li><a href="#"><i class="fal fa-comment-alt"></i> 203</a></li>
                        <li><a href="#"><i class="fal fa-user"></i>{{ @$blog->user->name }}</a></li>
                    </ul>
                </div>
                <div class="right-content">
                    <a href="#" class="read-more-btn">{{__('read_more') }}<i class="fas fa-long-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
