<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LanguageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Repositories\LanguageRepository;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use JoeDixon\Translation\Drivers\Translation;

class LanguageController extends Controller
{
    private $translation;

    protected $language;

    public function __construct(LanguageRepository $language, Translation $translation)
    {
        $this->language    = $language;
        $this->translation = $translation;
    }

    public function index(LanguageDataTable $dataTable)
    {
        Gate::authorize('languages.index');
        try {
            $data = [
                'flags' => $this->language->flags(),
            ];

            return $dataTable->render('backend.admin.language.all-language', $data);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create()
    {
        Gate::authorize('languages.create');
        try {
            $flags = $this->language->flags();

            return view('backend.admin.language.add-language', compact('flags'));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function store(LanguageRequest $request): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status' => 'danger',
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        DB::beginTransaction();
        try {
            $this->language->store($request->all());

            cache()->forget('languages');
            DB::commit();

            return response()->json(['success' => __('create_successful')]);
        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('languages.edit');
        try {
            $language = $this->language->get($id);

            $data     = [
                'id'             => $language->id,
                'name'           => $language->name,
                'locale'         => $language->locale,
                'flag'           => $language->flag,
                'text_direction' => $language->text_direction == 'rtl',
                'status'         => (bool) $language->status,
            ];

            return response()->json($data);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(LanguageRequest $request, $id): \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
    {
        Gate::authorize('languages.update');
        if (isDemoMode()) {
            $data = [
                'status' => 'danger',
                'error'  => __('this_function_is_disabled_in_demo_server'),
                'title'  => 'error',
            ];

            return response()->json($data);
        }
        DB::beginTransaction();
        try {
            $this->language->update($request->all(), $id);
            cache()->forget('languages');
            DB::commit();

            return response()->json(['success' => __('update_successful')]);

        } catch (Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        Gate::authorize('languages.destroy');
        if (isDemoMode()) {
            $data = [
                'status'  => 'danger',
                'message' => __('this_function_is_disabled_in_demo_server'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
        try {
            $this->language->destroy($id);
            cache()->forget('languages');

            $data = [
                'status'  => 'success',
                'message' => __('delete_successful'),
                'title'   => __('success'),
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status'  => 400,
                'message' => $e->getMessage(),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
    }

    public function statusChange(Request $request): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status'  => 'danger',
                'message' => __('this_function_is_disabled_in_demo_server'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
        try {
            $this->language->statusChange($request->all());
            cache()->forget('languages');

            $data = [
                'status'  => 200,
                'message' => __('update_successful'),
                'title'   => 'success',
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status'  => 400,
                'message' => $e->getMessage(),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
    }

    public function directionChange(Request $request): \Illuminate\Http\JsonResponse
    {
        if (isDemoMode()) {
            $data = [
                'status'  => 'danger',
                'message' => __('this_function_is_disabled_in_demo_server'),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
        try {
            $this->language->directionChange($request->all());
            $data = [
                'status'  => 200,
                'message' => __('update_successful'),
                'title'   => 'success',
            ];

            return response()->json($data);
        } catch (Exception $e) {
            $data = [
                'status'  => 400,
                'message' => $e->getMessage(),
                'title'   => 'error',
            ];

            return response()->json($data);
        }
    }

    public function translationPage(Request $request, $language): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Contracts\Foundation\Application
    {
        Gate::authorize('language.translations.page');
        try {
            if ($request->has('language') && $request->get('language') !== $language) {
                return redirect()
                    ->route('language.translations.page', ['language' => $request->get('language'), 'group' => $request->get('group'), 'filter' => $request->get('filter')]);
            }
            $language = $this->language->get($language);
            $this->language->generateTranslationFolders($language->locale);
            $languages    = $this->translation->allLanguages();
            $groups       = $this->translation->getGroupsFor(config('app.locale'))->merge('single');
            $translations = $this->translation->filterTranslationsFor($language->locale, $request->get('filter'));

            if ($request->has('group') && $request->get('group')) {
                if ($request->get('group') === 'single') {
                    $translations = $translations->get('single');
                    $translations = new Collection(['single' => $translations]);
                } else {
                    $translations = $translations->get('group')->filter(function ($values, $group) use ($request) {
                        return $group === $request->get('group');
                    });
                    $translations = new Collection(['group' => $translations]);
                }
            }

            $data = [
                'language'     => $language,
                'languages'    => $languages,
                'groups'       => $groups,
                'translations' => $translations,
            ];

            return view('backend.admin.language.translation', $data);
        } catch (\Exception $e) {
            Toastr::error($e->getMessage());

            return back();
        }
    }

    public function updateTrans(Request $request, $language): array
    {
        Gate::authorize('admin.language.key.update');
        $language = $this->language->get($language);

        if (! Str::contains($request->get('group'), 'single')) {
            $this->translation->addGroupTranslation($language->locale, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language->locale, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        }

        return ['success' => true];
    }
}
