@extends('backend.layouts.master')
@section('title', __('languages'))
@section('content')
    <section class="oftions" id="app">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row mb-30 justify-content-end">
                        <div class="col-lg-12">
                            <div class="header-top d-flex justify-content-between align-items-center">
                                <h3 class="section-title">{{__('languages') }}</h3>
                                <div class="oftions-content-right mb-12">
                                    <a href="javascript:void(0)" data-bs-target="#language" data-bs-toggle="modal"
                                       class="d-flex align-items-center btn sg-btn-primary gap-2">
                                        <i class="las la-plus"></i>
                                        <span>{{__('add_language') }}</span>
                                    </a>
                                </div>
                            </div>
                            <div class="bg-white redious-border p-20 p-sm-30 pt-sm-30"
                                 data-select2-id="select2-data-10-togg">
                                <div class="row">
                                    <div class="col-xxl-5"></div>
                                    <div class="col-xxl-7 col-lg-12" data-select2-id="select2-data-9-e6eh">
                                        <form action="{{ route('language.translations.page', ['language' => $language]) }}">
                                            <div class="row gx-12 gx-sm-20">
                                                <div class="col-lg-4 col-md-4 col-sm-4"
                                                     data-select2-id="select2-data-7-1q2t">
                                                    <div class="select-type-v2 mb-3 mb-sm-30">
                                                        <!-- <label for="fileType" class="form-label">File Type</label> -->
                                                        @include('translation::forms.select', ['name' => 'language', 'items' => $languages, 'submit' => true, 'selected' => $language])
                                                    </div>
                                                </div>
                                                <!-- End File Type -->

                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="select-type-v2 mb-3 mb-sm-30">
                                                        @include('translation::forms.select', ['name' => 'group', 'items' => $groups, 'submit' => true, 'selected' => Request::get('group'), 'optional' => true])
                                                    </div>
                                                </div>
                                                <!-- End Date -->

                                                <div class="col-lg-4 col-md-4 col-sm-4">
                                                    <div class="">
                                                        <div class="search mb-20 mb-sm-0">
                                                            @include('translation::forms.search', ['name' => 'filter', 'value' => Request::get('filter')])
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- End Action Action -->
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="default-list-table table-responsive lang-setting">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">{{ __('group/single') }}</th>
                                                    <th scope="col">{{ __('key') }}</th>
                                                    <th scope="col" class="text-capitalize">{{ config('app.locale') }}</th>
                                                    <th scope="col" class="text-capitalize">{{ $language->locale }}</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($translations as $type => $items)
                                                    @foreach($items as $group => $translations)
                                                        @foreach($translations as $key => $value)
                                                            @if(!is_array($value[config('app.locale')]))
                                                                <tr>
                                                                    <td>{{ $group }}</td>
                                                                    <td>{{ $key }}</td>
                                                                    <td>{{ $value[config('app.locale')] }}</td>
                                                                    <td>
                                                                        <translation-input class="lang_edit_col"
                                                                            initial-translation="{{ $value[$language->locale] }}"
                                                                            language="{{ $language->id }}"
                                                                            group="{{ $group }}"
                                                                            translation-key="{{ $key }}"
                                                                            route="{{ config('translation.ui_url') }}">
                                                                        </translation-input>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js_asset')
    <script src="{{ static_asset('/vendor/translation/js/app.js') }}"></script>
@endpush
@push('js')
    <script>
        $(document).ready(function (){
            $(document).on('change', '.without_search', function (){
                $(this).closest('form').submit();
            });
        });
    </script>
@endpush
