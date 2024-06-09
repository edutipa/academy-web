<?php

namespace App\Http\Controllers;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function cacheClear()
    {
        try {
            Artisan::call('all:clear');
            Artisan::call('migrate', ['--force' => true]);
            Toastr::success(__('cache_cleared_successfully'));

            return back();
        } catch (\Exception $e) {
            Toastr::error($e->getMessage(), 'Error!');

            return back();
        }
    }

    public function changeLanguage($locale): \Illuminate\Http\RedirectResponse
    {
        cache()->put('locale', $locale);
        app()->setLocale($locale);

        return redirect()->back();
    }
}
