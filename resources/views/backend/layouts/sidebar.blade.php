<header class="navbar-dark-v1">
    <div class="header-position">
        <span class="sidebar-toggler">
            <i class="las la-times"></i>
        </span>
        <div class="dashboard-logo d-flex justify-content-center align-items-center py-20">
            <a class="logo" href="{{ route('admin.dashboard') }}">
                <img
                    src="{{ setting('admin_logo') && @is_file_exists(setting('admin_logo')['original_image']) ? get_media(setting('admin_logo')['original_image']) : get_media('images/default/logo/logo-green-white.png') }}"
                    alt="Logo">
            </a>
            @can('dashboard_statistic')
                <a class="logo-icon" href="{{ route('admin.dashboard') }}">
                    <img
                        src="{{ setting('admin_mini_logo') && @is_file_exists(setting('admin_mini_logo')['original_image']) ? get_media(setting('admin_mini_logo')['original_image']) : get_media('images/default/logo/logo-green-mini.png') }}"
                        alt="Logo">
                </a>
            @endcan
        </div>
        <nav class="side-nav">
            <ul>
                @can('admin.dashboard')
                    <li class="{{ menuActivation(['admin/dashboard', 'admin'], 'active') }}">
                        <a href="{{ route('admin.dashboard') }}" role="button" aria-expanded="false"
                           aria-controls="dashboard">
                            <i class="las la-tachometer-alt"></i>
                            <span>{{ __('dashboard') }}</span>
                        </a>
                    </li>
                @endcan


                <li class="{{ menuActivation(['admin/category/*', 'admin/category', 'admin/subjects/*', 'admin/subjects', 'admin/tags/*', 'admin/tag', 'admin/level/*', 'admin/level', 'admin/courses/*', 'admin/courses', 'admin/quizzes*', 'admin/certificates*'], 'active') }}">
                    <a href="#course" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/category/*', 'admin/category', 'admin/subjects/*', 'admin/subjects', 'admin/tag/*', 'admin/tag', 'admin/level/*', 'admin/level', 'admin/courses/*', 'admin/courses', 'admin/quizzes*', 'admin/certificates*'], 'true', 'false') }}"
                       aria-controls="course">
                        <i class="las la-book"></i>
                        <span>{{ __('course') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/category/*', 'admin/category', 'admin/subjects/*', 'admin/subjects', 'admin/tag/*', 'admin/tag', 'admin/level/*', 'admin/level', 'admin/courses/*', 'admin/courses', 'admin/quizzes*', 'admin/certificates*'], 'show') }}"
                        id="course">
                        @can('courses.index')
                            <li>
                                <a class="{{ menuActivation(['admin/courses/*', 'admin/courses', 'admin/quizzes*'], 'active') }}"
                                   href="{{ route('courses.index') }}">{{ __('course_list') }}</a>
                            </li>
                        @endcan

                        @can('categories.index')
                            <li><a class="{{ menuActivation(['admin/category/*', 'admin/category'], 'active') }}"
                                   href="{{ route('category.index') }}">{{ __('category') }}</a></li>
                        @endcan

                        @can('subjects.index')
                            <li><a class="{{ menuActivation(['admin/subjects/*', 'admin/subjects'], 'active') }}"
                                   href="{{ route('subjects.index') }}">{{ __('subject') }}</a></li>
                        @endcan
                        @can('tag.index')
                            <li><a class="{{ menuActivation(['admin/tag/*', 'admin/tag'], 'active') }}"
                                   href="{{ route('tag.index') }}">{{ __('tags') }}</a></li>
                        @endcan

                        @can('level.index')
                            <li><a class="{{ menuActivation(['admin/level/*', 'admin/level'], 'active') }}"
                                   href="{{ route('level.index') }}">{{ __('levels') }}</a></li>
                        @endcan

                        @can('certificates.index')
                            <li><a class="{{ menuActivation(['admin/certificates*'], 'active') }}"
                                   href="{{ route('certificates.index') }}">{{ __('certificates') }}</a></li>
                        @endcan

                    </ul>
                </li>


                @can('students.index')
                    <li
                        class="{{ menuActivation(['admin/students', 'admin/students/*', 'admin/students/create'], 'active') }}">
                        <a href="{{ route('students.index') }}">
                            <i class="las la-certificate"></i>
                            <span>{{ __('manage_students') }}</span>
                        </a>
                    </li>
                @endcan


                <li
                    class="{{ menuActivation(['admin/instructors', 'admin/instructors/*', 'admin/instructors/create', 'admin/expertise', 'admin/expertise/*'], 'active') }}">
                    <a href="#manageInstructor" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/instructors', 'admin/instructors/*', 'admin/instructors/create', 'admin/expertise', 'admin/expertise/*'], 'true', 'false') }}"
                       aria-controls="manageInstructor">
                        <i class="las la-user-tie"></i>
                        <span>{{ __('manage_instructors') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/instructors', 'admin/instructors/*', 'admin/instructors/create', 'admin/expertise', 'admin/expertise/*'], 'show') }}"
                        id="manageInstructor">

                        @can('instructors.index')
                            <li>
                                <a class="{{ menuActivation(['admin/instructors'], 'active') }}"
                                   href="{{ route('instructors.index') }}">{{ __('instructor_list') }}</a>
                            </li>
                        @endcan


                        @can('instructors.create')
                            <li><a class="{{ menuActivation('admin/instructors/create', 'active') }}"
                                   href="{{ route('instructors.create') }}">{{ __('add_instructor') }}</a></li>
                        @endcan

                        @can('expertise.index')
                            <li>
                                <a class="{{ menuActivation(['admin/expertise', 'admin/expertise/*'], 'active') }}"
                                   href="{{ route('expertise.index') }}">{{ __('expertises') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="{{ menuActivation(['admin/organizations*'], 'active') }}">
                    <a href="#manageOrganisation" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/organizations*'], 'true', 'false') }}"
                       aria-controls="manageOrganisation">
                        <i class="las la-school"></i>
                        <span>{{ __('manage_organisation') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/organizations*'], 'show') }}"
                        id="manageOrganisation">

                        @can('organizations.index')
                            <li>
                                <a class="{{ menuActivation('admin/organizations', 'active') }}"
                                   href="{{ route('organizations.index') }}">{{ __('organisation_list') }}</a>
                            </li>
                        @endcan

                        @can('organizations.create')
                            <li><a class="{{ menuActivation('admin/organizations/create', 'active') }}"
                                   href="{{ route('organizations.create') }}">{{ __('add_organisation') }}</a></li>
                        @endcan
                    </ul>
                </li>
                <li
                    class="{{ menuActivation(['admin/staffs', 'admin/staffs/create','admin/staffs/*/edit','admin/roles/*/edit', 'admin/roles/create', 'admin/roles'], 'active') }}">
                    <a href="#staff" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/staffs', 'admin/staffs/create','admin/staffs/*/edit','admin/roles/*/edit', 'admin/roles/create', 'admin/roles'], 'true', 'false') }}"
                       aria-controls="staff">
                        <i class="las la-user-friends"></i>
                        <span>{{ __('staff') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/staffs', 'admin/roles/create', 'admin/staffs/create','admin/staffs/*/edit','admin/roles/*/edit', 'admin/roles'], 'show') }}"
                        id="staff">

                        @can('staffs.index')
                            <li><a class="{{ menuActivation('admin/staff*', 'active') }}"
                                   href="{{ route('staffs.index') }}">{{ __('all_staff') }}</a></li>
                        @endcan

                        @can('roles.index')
                            <li><a class="{{ menuActivation('admin/roles*', 'active') }}"
                                   href="{{ route('roles.index') }}">{{ __('roles') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>

                @can('media-library.index')
                    <li class="{{ menuActivation('admin/media-library', 'active') }}">
                        <a href="{{ route('media-library.index') }}">
                            <i class="las la-images"></i>
                            <span>{{ __('media_library') }}</span>
                        </a>
                    </li>
                @endcan

                @can('ai.writer')
                    <li class="{{ menuActivation('admin/ai-writer', 'active') }}">
                        <a href="{{ route('ai.writer') }}">
                            <i class="las la-robot"></i>
                            <span>{{ __('ai_writer') }}</span>
                        </a>
                    </li>
                @endcan

                <li
                    class="{{ menuActivation(['admin/blogs', 'admin/blogs/*', 'admin/blogs/create', 'admin/blog-categories', 'admin/blog-categories/*', 'admin/blog-categories/create'], 'active') }}">
                    <a href="#blog" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/blogs', 'admin/blogs/*', 'admin/blogs/create', 'admin/blog-categories', 'admin/blog-categories/*', 'admin/blog-categories/create'], 'true', 'false') }}"
                       aria-controls="blog">
                        <i class="las la-blog"></i>
                        <span>{{ __('blog') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/blogs', 'admin/blogs/*', 'admin/blogs/create', 'admin/blog-categories', 'admin/blog-categories/*', 'admin/blog-categories/create'], 'show') }}"
                        id="blog">
                        @can('blogs.index')
                            <li>
                                <a class="{{ menuActivation(['admin/blogs','admin/blogs/*'], 'active') }}"
                                   href="{{ route('blogs.index') }}">{{ __('all_post') }}</a>
                            </li>
                        @endcan

                        @can('blogs.create')
                            <li><a class="{{ menuActivation('admin/blogs/create', 'active') }}"
                                   href="{{ route('blogs.create') }}">{{ __('add_new_post') }}</a></li>
                        @endcan

                        @can('blog-categories.index')
                            <li>
                                <a class="{{ menuActivation(['admin/blog-categories', 'admin/blog-categories/*'], 'active') }}"
                                   href="{{ route('blog-categories.index') }}">{{ __('category') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>


                @can('payment.gateway')
                    <li class="{{ menuActivation('admin/payment-gateway', 'active') }}">
                        <a href="{{ route('payment.gateway') }}">
                            <i class="las la-credit-card"></i>
                            <span>{{ __('payment_gateway') }}</span>
                        </a>
                    </li>
                @endcan


                @if (setting('wallet_system'))
                    <li class="{{ menuActivation('admin/wallet-request', 'active') }}">
                        <a href="{{ route('wallet.request') }}">
                            <i class="las la-wallet"></i>
                            <span>{{ __('wallet_request') }}</span>
                        </a>
                    </li>
                @endif
                <li class="{{ menuActivation(array('admin/payouts*'), 'active') }}">
                    <a href="#payout" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(array('admin/payouts*'), 'true', 'false') }}"
                       aria-controls="otp_settings">
                        <i class="las la-file-invoice-dollar"></i>
                        <span>{{__('payout') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/payouts*'], 'show') }}" id="payout">

                        @can('payouts.method-setting')
                            <li><a class="{{ menuActivation(['admin/payouts/method-setting'], 'active') }}"
                                   href="{{ route('payouts.method-setting') }}">{{ __('payout_method') }}</a></li>
                        @endcan

                        @can('payouts.create')
                            <li><a class="{{ menuActivation(['admin/payouts/create'], 'active') }}"
                                   href="{{ route('payouts.create') }}">{{ __('payout_request') }}</a></li>
                        @endcan


                        @can('payouts.index')
                            <li><a class="{{ menuActivation(['admin/payouts'], 'active') }}"
                                   href="{{ route('payouts.index') }}">{{ __('payout_request_list') }}</a></li>
                        @endcan
                    </ul>
                </li>

                <li
                    class="{{ menuActivation(['admin/pusher-notification', 'admin/one-signal-notification', 'admin/custom-notification', 'admin/custom-notification*'], 'active') }}">
                    <a href="#notification" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/pusher-notification', 'admin/one-signal-notification', 'admin/custom-notification', 'admin/custom-notification*'], 'true', 'false') }}"
                       aria-controls="otp_settings">
                        <i class="las la-bell"></i>
                        <span>{{ __('notification') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/pusher-notification', 'admin/one-signal-notification', 'admin/custom-notification', 'admin/custom-notification*'], 'show') }}"
                        id="notification">

                        @can('custom-notification.index')
                            <li>
                                <a class="{{ menuActivation(['admin/custom-notification', 'admin/custom-notification*'], 'active') }}"
                                   href="{{ route('custom-notification.index') }}">{{ __('custom_notification') }}</a>
                            </li>
                        @endcan

                        @can('pusher.notification')
                            <li><a class="{{ menuActivation('admin/pusher-notification', 'active') }}"
                                   href="{{ route('pusher.notification') }}">{{ __('pusher') }}</a></li>
                        @endcan

                        @can('onesignal.notification')
                            <li><a class="{{ menuActivation('admin/one-signal-notification', 'active') }}"
                                   href="{{ route('onesignal.notification') }}">{{ __('onesignal') }}</a></li>
                        @endcan
                    </ul>
                </li>

                <li
                    class="{{ menuActivation(['admin/departments', 'admin/departments/*', 'admin/tickets', 'admin/tickets/*'], 'active') }}">
                    <a href="#support" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/departments', 'admin/departments/*', 'admin/tickets', 'admin/tickets/*'], 'true', 'false') }}"
                       aria-controls="support">
                        <i class="las la-headset"></i>
                        <span>{{ __('support') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/departments', 'admin/departments/*', 'admin/tickets', 'admin/tickets/*', 'admin/student-faqs*'], 'show') }}"
                        id="support">

                        @can('tickets.index')
                            <li><a class="{{ menuActivation(['admin/tickets', 'admin/tickets/*'], 'active') }}"
                                   href="{{ route('tickets.index') }}">{{ __('ticket') }}</a></li>
                        @endcan


                        @can('student-faqs.index')
                            <li>
                                <a class="{{ menuActivation(['admin/student-faqs', 'admin/student-faqs/*'], 'active') }}"
                                   href="{{ route('student-faqs.index') }}">{{ __('faq') }}</a></li>
                        @endcan


                        @can('departments.index')
                            <li><a class="{{ menuActivation(['admin/departments', 'admin/departments/*'], 'active') }}"
                                   href="{{ route('departments.index') }}">{{ __('department') }}</a></li>
                        @endcan
                    </ul>
                </li>
                <li
                    class="{{ menuActivation(['admin/coupons', 'admin/coupons/*', 'admin/coupons/create', 'admin/subscribers', 'admin/bulk-sms'], 'active') }}">
                    <a href="#coupon" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/coupons', 'admin/coupons/*', 'admin/coupons/create', 'admin/subscribers', 'admin/bulk-sms'], 'true', 'false') }}"
                       aria-controls="coupon">
                        <i class="las la-th"></i>
                        <span>{{ __('marketing') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/coupons', 'admin/coupons/*', 'admin/coupons/create', 'admin/subscribers', 'admin/bulk-sms'], 'show') }}"
                        id="coupon">
                        @if (setting('coupon_system'))
                            @can('coupons.index')
                                <li>
                                    <a class="{{ menuActivation(['admin/coupons', 'admin/coupons/*'], 'active') }}"
                                       href="{{ route('coupons.index') }}">{{ __('all_coupons') }}</a>
                                </li>
                            @endcan
                        @endif

                        @can('subscribers.index')
                            <li><a class="{{ menuActivation('admin/subscribers', 'active') }}"
                                   href="{{ route('subscribers.index') }}">{{ __('subscribers') }}</a></li>
                        @endcan

                        @can('bulk.sms')
                            <li><a class="{{ menuActivation('admin/bulk-sms', 'active') }}"
                                   href="{{ route('bulk.sms') }}">{{ __('bulk_sms') }}</a></li>
                        @endcan
                    </ul>
                </li>
                @if (addon_is_activated('accounts_system'))
                    <li
                        class="{{ menuActivation(
                            [
                                'admin/accounts',
                                'admin/accounts/*',
                                'admin/bank-accounts',
                                'admin/bank-accounts/*',
                                'admin/incomes',
                                'admin/incomes/*',
                                'admin/expenses',
                                'admin/expenses/*',
                                'admin/transfers',
                                'admin/transfers/*',
                            ],
                            'active',
                        ) }}">
                        <a href="#accounts" class="dropdown-icon" data-bs-toggle="collapse"
                           aria-expanded="{{ menuActivation(
                                [
                                    'admin/accounts',
                                    'admin/accounts/*',
                                    'admin/bank-accounts',
                                    'admin/bank-accounts/*',
                                    'admin/incomes',
                                    'admin/incomes/*',
                                    'admin/expenses',
                                    'admin/expenses/*',
                                    'admin/transfers',
                                    'admin/transfers/*',
                                ],
                                'true',
                                'false',
                            ) }}"
                           aria-controls="accounts">
                            <i class="las la-dollar-sign"></i>
                            <span>{{ __('accounts') }}</span>
                        </a>
                        <ul class="sub-menu collapse {{ menuActivation(
                            [
                                'admin/accounts',
                                'admin/accounts/*',
                                'admin/bank-accounts',
                                'admin/bank-accounts/*',
                                'admin/incomes',
                                'admin/incomes/*',
                                'admin/expenses',
                                'admin/expenses/*',
                                'admin/transfers',
                                'admin/transfers/*',
                            ],
                            'show',
                        ) }}"
                            id="accounts">
                            @can('accounts.index')
                                <li><a class="{{ menuActivation(['admin/accounts', 'admin/accounts/*'], 'active') }}"
                                       href="{{ route('accounts.index') }}">{{ __('accounts') }}</a></li>
                            @endcan

                            @can('bank-accounts.index')
                                <li>
                                    <a class="{{ menuActivation(['admin/bank-accounts', 'admin/bank-accounts/*'], 'active') }}"
                                       href="{{ route('bank-accounts.index') }}">{{ __('bank_accounts') }}</a>
                                </li>
                            @endcan

                            @can('incomes.index')
                                <li><a class="{{ menuActivation(['admin/incomes', 'admin/incomes/*'], 'active') }}"
                                       href="{{ route('incomes.index') }}">{{ __('income') }}</a></li>
                            @endcan

                            @can('expenses.index')
                                <li><a class="{{ menuActivation(['admin/expenses', 'admin/expenses/*'], 'active') }}"
                                       href="{{ route('expenses.index') }}">{{ __('expense') }}</a></li>
                            @endcan

                            @can('transfers.index')
                                <li><a class="{{ menuActivation(['admin/transfers', 'admin/transfers/*'], 'active') }}"
                                       href="{{ route('transfers.index') }}">{{ __('transfer') }}</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
                <li
                    class="{{ menuActivation(['admin/book-sale', 'admin/course-sale', 'admin/commission-history', 'admin/payment-history', 'admin/payout-history', 'admin/wishlist'], 'active') }}">
                    <a href="#report" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/book-sale', 'admin/course-sale', 'admin/commission-history', 'admin/payment-history', 'admin/payout-history', 'admin/wishlist'], 'true', 'false') }}"
                       aria-controls="report">
                        <i class="las la-clipboard-list"></i>
                        <span>{{ __('reports') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/book-sale', 'admin/course-sale', 'admin/commission-history', 'admin/payment-history', 'admin/payout-history', 'admin/wishlist'], 'show') }}"
                        id="report">

                        @can('backend.admin.report.course_sale')
                            <li><a class="{{ menuActivation(['admin/course-sale'], 'active') }}"
                                   href="{{ route('backend.admin.report.course_sale') }}">{{ __('course_sale') }}</a>
                            </li>
                        @endcan


                        @can('backend.admin.report.commission_history')
                            <li><a class="{{ menuActivation(['admin/commission-history'], 'active') }}"
                                   href="{{ route('backend.admin.report.commission_history') }}">{{ __('commission_history') }}</a>
                            </li>
                        @endcan

                        @can('backend.admin.report.payment_history')
                            <li><a class="{{ menuActivation(['admin/payment-history'], 'active') }}"
                                   href="{{ route('backend.admin.report.payment_history') }}">{{ __('payment_history') }}</a>
                            </li>
                        @endcan

                        @can('backend.admin.report.payout_history')
                            <li><a class="{{ menuActivation(['admin/payout-history'], 'active') }}"
                                   href="{{ route('backend.admin.report.payout_history') }}">{{ __('payout_history') }}</a>
                            </li>
                        @endcan

                        @can('backend.admin.report.wishlist')
                            <li><a class="{{ menuActivation(['admin/wishlist'], 'active') }}"
                                   href="{{ route('backend.admin.report.wishlist') }}">{{ __('wishlist') }}</a></li>
                        @endcan
                    </ul>
                </li>
                <li id="home-screen"
                    class="{{ menuActivation(['admin/onboards','admin/onboards/*', 'admin/android-setting', 'admin/sliders','admin/sliders/*', 'admin/apikeys', 'admin/android', 'admin/ios*', 'admin/mobile-home-screen', 'admin/mobile-gdpr'], 'active') }}">
                    <a href="#mobileApp" class="dropdown-icon" data-bs-toggle="collapse" role="button"
                       aria-expanded="{{ menuActivation(['admin/onboards', 'admin/onboards/*','admin/android-setting', 'admin/sliders','admin/sliders/*', 'admin/apikeys', 'admin/android', 'admin/ios*', 'admin/mobile-home-screen', 'admin/mobile-gdpr'], 'true', 'false') }}"
                       aria-controls="mobileApp">
                        <i class="las la-mobile"></i>
                        <span>{{ __('mobile_app_settings') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/onboards', 'admin/onboards/*','admin/android-setting','admin/sliders/*', 'admin/sliders', 'admin/apikeys*', 'admin/android', 'admin/ios*', 'admin/mobile-home-screen', 'admin/mobile-gdpr'], 'show') }}"
                        id="mobileApp">

                        @can('onboards.index')
                            <li><a class="{{ menuActivation('admin/onboards*', 'active') }}"
                                   href="{{ route('onboards.index') }}">{{ __('on_board') }}</a></li>
                        @endcan

                        @can('sliders.index')
                            <li><a class="{{ menuActivation('admin/sliders*', 'active') }}"
                                   href="{{ route('sliders.index') }}">{{ __('slider') }}</a></li>
                        @endcan

                        @can('apikeys.index')
                            <li><a class="{{ menuActivation('admin/apikeys*', 'active') }}"
                                   href="{{ route('apikeys.index') }}">{{ __('api_settings') }}</a></li>
                        @endcan

                        @can('android.setting')
                            <li><a class="{{ menuActivation('admin/android-setting', 'active') }}"
                                   href="{{ route('android.setting') }}">{{ __('android_settings') }}</a></li>
                        @endcan

                        @can('')
                            <li><a class="{{ menuActivation('admin/ios*', 'active') }}"
                                   href="{{ route('ios.setting') }}">{{ __('ios_setting') }}</a></li>
                        @endcan

                        @can('mobile.gdpr')
                            <li><a class="{{ menuActivation('admin/mobile-gdpr', 'active') }}"
                                   href="{{ route('mobile.gdpr') }}">{{ __('gdpr') }}</a></li>
                        @endcan

                        @can('mobile.home.screen')
                            <li><a class="{{ menuActivation('admin/mobile-home-screen', 'active') }}"
                                   href="{{ route('mobile.home.screen') }}">{{ __('home_screen_settings') }}</a></li>
                        @endcan

                    </ul>
                </li>
                <li
                    class="{{ menuActivation(['admin/success-stories*', 'admin/pages', 'admin/create-404*', 'admin/pages*', 'admin/testimonials*', 'admin/brands*'], 'active') }}">
                    <a href="#cms_settings" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/success-stories*', 'admin/create-404*', 'admin/pages', 'admin/pages*', 'admin/testimonials*', 'admin/brands*'], 'true', 'false') }}"
                       aria-controls="cms_settings">
                        <i class="las la-layer-group"></i>
                        <span>{{ __('cms') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/success-stories*', 'admin/create-404*', 'admin/pages', 'admin/pages*', 'admin/testimonials*', 'admin/brands*'], 'show') }}"
                        id="cms_settings">

                        @can('pages.index')
                            <li><a class="{{ menuActivation('admin/pages*', 'active') }}"
                                   href="{{ route('pages.index') }}">{{ __('all_pages') }}</a></li>
                        @endcan

                        @can('success-stories.index')
                            <li><a class="{{ menuActivation('admin/success-stories*', 'active') }}"
                                   href="{{ route('success-stories.index') }}">{{ __('success_story') }}</a></li>
                        @endcan

                        @can('testimonials.index')
                            <li><a class="{{ menuActivation('admin/testimonials*', 'active') }}"
                                   href="{{ route('testimonials.index') }}">{{ __('testimonial') }}</a></li>
                        @endcan
                        @can('brands.index')
                            <li><a class="{{ menuActivation('admin/brands*', 'active') }}"
                                   href="{{ route('brands.index') }}">{{ __('brands') }}</a></li>
                        @endcan
                    </ul>
                </li>
                <li
                    class="{{ menuActivation(
                        [
                            'admin/home-page',
                            'admin/call-to-action',
                            'admin/social-link-setting',
                            'admin/newsletter-setting',
                            'admin/useful-link-setting',
                            'admin/resource-link-setting',
                            'admin/quick-link-setting',
                            'admin/apps-link-setting',
                            'admin/payment-banner-setting',
                            'admin/copyright-setting',
                            'admin/become-instructor-content',
                            'admin/header-logo',
                            'admin/theme-options',
                            'admin/website-themes',
                            'admin/website-popup',
                            'admin/website-seo',
                            'admin/google-setup',
                            'admin/custom-js',
                            'admin/custom-css',
                            'admin/facebook-pixel',
                            'admin/gdpr',
                            'admin/header-menu',
                            'admin/header-footer',
                            'admin/header-content',
                            'admin/footer-menu',
                        ],
                        'active',
                    ) }}">
                    <a href="#website_settings" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(
                            [
                                'admin/home-page',
                                'admin/social-link-setting',
                                'admin/newsletter-setting',
                                'admin/useful-link-setting',
                                'admin/resource-link-setting',
                                'admin/quick-link-setting',
                                'admin/apps-link-setting',
                                'admin/payment-banner-setting',
                                'admin/copyright-setting',
                                'admin/become-instructor-content',
                                'admin/call-to-action',
                                'admin/header-logo',
                                'admin/theme-options',
                                'admin/website-themes',
                                'admin/website-popup',
                                'admin/website-seo',
                                'admin/google-setup',
                                'admin/custom-js',
                                'admin/custom-css',
                                'admin/header-topbar',
                                'admin/facebook-pixel',
                                'admin/header-menu',
                                'admin/gdpr',
                                'admin/header-footer',
                                'admin/header-content',
                                'admin/footer-menu',
                            ],
                            'true',
                            'false',
                        ) }}"
                       aria-controls="website_settings">
                        <i class="las la-tools"></i>
                        <span>{{ __('website_settings') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(
                        [
                            'admin/home-page',
                            'admin/become-instructor-content',
                            'admin/call-to-action',
                            'admin/social-link-setting',
                            'admin/newsletter-setting',
                            'admin/useful-link-setting',
                            'admin/resource-link-setting',
                            'admin/quick-link-setting',
                            'admin/apps-link-setting',
                            'admin/payment-banner-setting',
                            'admin/copyright-setting',
                            'admin/header-topbar',
                            'admin/header-logo',
                            'admin/theme-options',
                            'admin/website-themes',
                            'admin/website-popup',
                            'admin/website-seo',
                            'admin/google-setup',
                            'admin/custom-js',
                            'admin/custom-css',
                            'admin/facebook-pixel',
                            'admin/gdpr',
                            'admin/header-topbar',
                            'admin/header-menu',
                            'admin/header-footer',
                            'admin/header-content',
                            'admin/hero-section',
                            'admin/footer-menu',
                        ],
                        'show',
                    ) }}"
                        id="website_settings">

                        @can('website.themes')
                            <li><a class="{{ menuActivation('admin/website-themes', 'active') }}"
                                   href="{{ route('website.themes') }}">{{ __('website_themes') }}</a></li>
                        @endcan

                        @can('theme.options')
                            <li><a class="{{ menuActivation('admin/theme-options', 'active') }}"
                                   href="{{ route('theme.options') }}">{{ __('theme_options') }}</a></li>
                        @endcan

                        @can('header.logo')
                            <li>
                                <a class="{{ menuActivation('admin/header-logo', 'admin/header-topbar', 'admin/header-menu', 'active') }}"
                                   href="{{ route('header.logo') }}">{{ __('header_content') }}</a></li>
                        @endcan

                        @can('hero.section')
                            <li><a class="{{ menuActivation('admin/hero-section', 'active') }}"
                                   href="{{ route('hero.section') }}">{{ __('hero_section') }}</a></li>
                        @endcan

                        @can('footer.social-links')
                            <li><a class="{{ menuActivation([
                                'admin/social-link-setting',
                                'admin/newsletter-setting',
                                'admin/useful-link-setting',
                                'admin/resource-link-setting',
                                'admin/quick-link-setting',
                                'admin/apps-link-setting',
                                'admin/payment-banner-setting',
                                'admin/copyright-setting'
                            ], 'active') }}"
                                   href="{{ route('footer.social-links') }}">{{ __('footer_content') }}</a></li>
                        @endcan

                        @can('website.cta')
                            <li><a class="{{ menuActivation('admin/call-to-action', 'active') }}"
                                   href="{{ route('website.cta') }}">{{ __('call_to_action_content') }}</a></li>
                        @endcan

                        @can('website.popup')
                            <li><a class="{{ menuActivation('admin/website-popup', 'active') }}"
                                   href="{{ route('website.popup') }}">{{ __('website_popup') }}</a></li>
                        @endcan

                        @can('website.seo')
                            <li><a class="{{ menuActivation('admin/website-seo', 'active') }}"
                                   href="{{ route('website.seo') }}">{{ __('website_seo') }}</a></li>
                        @endcan

                        @can('custom.js')
                            <li><a class="{{ menuActivation('admin/custom-js', 'active') }}"
                                   href="{{ route('custom.js') }}">{{ __('custom_js') }}</a></li>
                        @endcan

                        @can('website.instructor_content')
                            <li><a class="{{ menuActivation('admin/become-instructor-content', 'active') }}"
                                   href="{{ route('website.instructor_content') }}">{{ __('instructor_content') }}</a>
                            </li>
                        @endcan

                        @can('custom.css')
                            <li><a class="{{ menuActivation('admin/custom-css', 'active') }}"
                                   href="{{ route('custom.css') }}">{{ __('custom_css') }}</a></li>
                        @endcan

                        @can('google.setup')
                            <li><a class="{{ menuActivation('admin/google-setup', 'active') }}"
                                   href="{{ route('google.setup') }}">{{ __('google_setup') }}</a></li>
                        @endcan

                        @can('fb.pixel')
                            <li><a class="{{ menuActivation('admin/facebook-pixel', 'active') }}"
                                   href="{{ route('fb.pixel') }}">{{ __('fb_pixel') }}</a></li>
                        @endcan

                        @can('gdpr')
                            <li><a class="{{ menuActivation('admin/gdpr', 'active') }}"
                                   href="{{ route('gdpr') }}">{{ __('gdpr') }}</a></li>
                        @endcan

                        @can('home.page.builder')
                            <li><a class="{{ menuActivation('admin/home-page', 'active') }}"
                                   href="{{ route('home.page.builder') }}">{{ __('home_page_builder') }}</a></li>
                        @endcan

                    </ul>
                </li>
                <li
                    class="{{ menuActivation(['admin/email/server-configuration*', 'admin/email/template*'], 'active') }}">
                    <a href="#emailSetting" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/email/server-configuration*', 'admin/email/template*'], 'true', 'false') }}"
                       aria-controls="emailSetting">
                        <i class="las la-envelope"></i>
                        <span>{{ __('email_settings') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/email/server-configuration*', 'admin/email/template*'], 'show') }}"
                        id="emailSetting">

                        @can('email.template')
                            <li><a class="{{ menuActivation('admin/email/template*', 'active') }}"
                                   href="{{ route('email.template') }}">{{ __('email_template') }}</a></li>
                        @endcan

                        @can('email.server-configuration')
                            <li><a class="{{ menuActivation('admin/email/server-configuration*', 'active') }}"
                                   href="{{ route('email.server-configuration') }}">{{ __('server_configuration') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
                <li class="{{ menuActivation(['admin/otp-setting', 'admin/sms-templates'], 'active') }}">
                    <a href="#otp_settings" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/otp-setting', 'admin/sms-templates'], 'true', 'false') }}"
                       aria-controls="otp_settings">
                        <i class="las la-sms"></i>
                        <span>{{ __('sms_otp') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/otp-setting', 'admin/sms-templates'], 'show') }}"
                        id="otp_settings">

                        @can('otp.setting')
                            <li><a class="{{ menuActivation('admin/otp-setting', 'active') }}"
                                   href="{{ route('otp.setting') }}">{{ __('otp_setting') }}</a></li>
                        @endcan
                        @can('sms.templates')
                            <li><a class="{{ menuActivation('admin/sms-templates', 'active') }}"
                                   href="{{ route('sms.templates') }}">{{ __('sms_templates') }}</a></li>
                        @endcan
                    </ul>
                </li>

                <li
                    class="{{ menuActivation(['admin/currencies','admin/countries','admin/states','admin/cities', 'admin/ai-writer-setting', 'admin/languages','admin/language/*', 'admin/system-setting', 'admin/cache', 'admin/firebase', 'admin/preference', 'admin/storage-setting', 'admin/chat-messenger', 'admin/panel-setting', 'admin/miscellaneous-setting', 'admin/refund-setting'], 'active') }}">
                    <a href="#settingTools" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/currencies','admin/countries','admin/states','admin/cities', 'admin/ai-writer-setting', 'admin/languages','admin/language/*', 'admin/gsystem-setting', 'admin/cache', 'admin/firebase', 'admin/preference', 'admin/storage-setting', 'admin/chat-messenger', 'admin/panel-setting', 'admin/miscellaneous-setting', 'admin/refund-setting'], 'true', 'false') }}"
                       aria-controls="settingTools">
                        <i class="las la-cog"></i>
                        <span>{{ __('system_setting') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/currencies','admin/countries','admin/states','admin/cities', 'admin/ai-writer-setting', 'admin/languages','admin/language/*', 'admin/system-setting', 'admin/cache', 'admin/firebase', 'admin/preference', 'admin/storage-setting', 'admin/chat-messenger', 'admin/panel-setting', 'admin/miscellaneous-setting', 'admin/refund-setting'], 'show') }}"
                        id="settingTools">

                        @can('general.setting')
                            <li><a class="{{ menuActivation('admin/system-setting', 'active') }}"
                                   href="{{ route('general.setting') }}">{{ __('general_setting') }}</a></li>
                        @endcan

                        @can('preference')
                            <li><a href="{{ route('preference') }}"
                                   class="{{ menuActivation('admin/preference', 'active') }}">{{ __('preference') }}</a>
                            </li>
                        @endcan

                        @can('currencies.index')
                            <li><a class="{{ menuActivation('admin/currencies', 'active') }}"
                                   href="{{ route('currencies.index') }}">{{ __('currency') }}</a></li>
                        @endcan


                        @can('languages.index')
                            <li><a class="{{ menuActivation(['admin/languages','admin/language/*'], 'active') }}"
                                   href="{{ route('languages.index') }}">{{ __('language_settings') }}</a></li>
                        @endcan

                        @can('admin.cache')
                            <li><a class="{{ menuActivation('admin/cache', 'active') }}"
                                   href="{{ route('admin.cache') }}">{{ __('cache_setting') }}</a></li>
                        @endcan

                        @can('admin.panel-setting')
                            <li><a class="{{ menuActivation('admin/panel-setting', 'active') }}"
                                   href="{{ route('admin.panel-setting') }}">{{ __('admin_panel_setting') }}</a></li>
                        @endcan

                        @can('admin.firebase')
                            <li><a class="{{ menuActivation('admin/firebase', 'active') }}"
                                   href="{{ route('admin.firebase') }}">{{ __('firebase') }}</a></li>
                        @endcan


                        @can('storage.setting')
                            <li><a class="{{ menuActivation('admin/storage-setting', 'active') }}"
                                   href="{{ route('storage.setting') }}">{{ __('storage_setting') }}</a></li>
                        @endcan

                        @can('chat.messenger')
                            <li><a class="{{ menuActivation('admin/chat-messenger', 'active') }}"
                                   href="{{ route('chat.messenger') }}">{{ __('chat_messenger') }}</a></li>
                        @endcan

                        {{-- @can('admin.refund')
                            <li><a class="{{ menuActivation('admin/refund-setting', 'active') }}"
                                    href="{{ route('admin.refund') }}">{{ __('refund_setting') }}</a></li>
                        @endcan --}}

                        @can('miscellaneous.setting')
                            <li><a class="{{ menuActivation('admin/miscellaneous-setting', 'active') }}"
                                   href="{{ route('miscellaneous.setting') }}">{{ __('miscellaneous') }}</a></li>
                        @endcan

                        @can('ai_writer.setting')
                            <li><a class="{{ menuActivation('admin/ai-writer-setting', 'active') }}"
                                   href="{{ route('ai_writer.setting') }}">{{ __('open_ai_setting') }}</a></li>
                        @endcan
                        @can('ai_writer.setting')
                            <li><a class="{{ menuActivation('admin/countries', 'active') }}"
                                   href="{{ route('countries.index') }}">{{ __('country') }}</a></li>
                        @endcan
                        @can('ai_writer.setting')
                            <li><a class="{{ menuActivation('admin/states', 'active') }}"
                                   href="{{ route('states.index') }}">{{ __('state') }}</a></li>
                        @endcan
                        @can('ai_writer.setting')
                            <li><a class="{{ menuActivation('admin/cities', 'active') }}"
                                   href="{{ route('cities.index') }}">{{ __('city') }}</a></li>
                        @endcan

                    </ul>
                </li>
                @can('addon.index')
                    <li class="{{ menuActivation('admin/addon', 'active') }}">
                        <a href="{{ route('addon.index') }}">
                            <i class="las la-puzzle-piece"></i>
                            <span>{{ __('addon') }}</span>
                        </a>
                    </li>
                @endcan
                <li
                    class="{{ menuActivation(['admin/server-info', 'admin/system-info', 'admin/extension-library', 'admin/file-system-permission', 'admin/system-update'], 'active') }}">
                    <a href="#utility" class="dropdown-icon" data-bs-toggle="collapse"
                       aria-expanded="{{ menuActivation(['admin/server-info', 'admin/system-info', 'admin/extension-library', 'admin/file-system-permission', 'admin/system-update'], 'true', 'false') }}"
                       aria-controls="utility">
                        <i class="las la-cogs"></i>
                        <span>{{ __('utility') }}</span>
                    </a>
                    <ul class="sub-menu collapse {{ menuActivation(['admin/server-info', 'admin/system-info', 'admin/extension-library', 'admin/file-system-permission', 'admin/system-update'], 'show') }}"
                        id="utility">

                        @can('system.update')
                            <li><a class="{{ menuActivation(['admin/system-update'], 'active') }}"
                                   href="{{ route('system.update') }}">{{ __('system_update') }}</a></li>
                        @endcan

                        @can('server.info')
                            <li>
                                <a class="{{ menuActivation(['admin/server-info', 'admin/system-info', 'admin/extension-library', 'admin/file-system-permission'], 'active') }}"
                                   href="{{ route('server.info') }}">{{ __('server_information') }}</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</header>
