<ul class="d-flex gap-30 justify-content-end align-items-center">
    <li>
        <a href="{{ route('courses.edit', $course->id) }}"><i class="las la-edit"></i></a>
    </li>

    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="las la-ellipsis-v"></i>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{route('course.details', $course->slug)}}">{{ __('visit_course') }}</a></li>
            <li><a class="dropdown-item" href="{{ route('course.students',$course->id) }}">{{ __('manage_student') }}</a></li>
{{--            <li><a class="dropdown-item" href="{{ route('courses.show',$course->id) }}">{{ __('statistic') }}</a></li>--}}
            <li><a class="dropdown-item" href="{{ route('courses.edit',[$course->id,'tab'=> 'curriculum']) }}">{{ __('curriculum') }}</a></li>
            <li><a class="dropdown-item" href="{{ route('courses.edit',[$course->id,'tab'=>'assignment']) }}">{{ __('assignment') }}</a></li>
            <li><a class="dropdown-item" href="{{ route('courses.edit',[$course->id,'tab'=>'faq']) }}">{{ __('faq') }}</a></li>
{{--            <li><a class="dropdown-item" href="#">{{ __('create_join_link') }}</a></li>--}}
        </ul>
    </div>
</ul>
