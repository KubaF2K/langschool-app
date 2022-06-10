<?php

namespace App\Http\Controllers;

use App\Http\Requests\LanguageCreateRequest;
use App\Http\Requests\LanguageDeleteRequest;
use App\Http\Requests\LanguageUpdateRequest;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /*
     * Returns a view of all languages
     */
    public function index() {
        return view('language.index', ['languages' => Language::all()]);
    }

    /*
     * Returns a edit form
     */
    public function edit($id) {
        if (!Auth::check())
            abort(401);
        $language = Language::findOrFail($id);
        if (Auth::user()->can('update', $language))
            return view('language.edit', ['language' => $language]);
        abort(403);
    }

    /*
     * Updates a language
     */
    public function update(LanguageUpdateRequest $request) {
        $input = $request->all();
        $course = Language::findOrFail($request->input('id'));
        $course->update($input);
        return redirect()->route('language.index')->with(['msg' => 'Zedytowano pomyślnie!']);
    }

    /*
     * Returns a create form
     */
    public function add() {
        if (!Auth::check())
            abort(401);
        if (Auth::user()->can('create', Language::class))
            return view('language.add');
        abort(403);
    }

    /*
     * Creates a language
     */
    public function create(LanguageCreateRequest $request) {
        $input = $request->all();
        Language::create($input);
        return redirect()->route('language.index')->with(['msg' => 'Dodano język!']);
    }

    /*
     * Deletes a language if there are no courses for it
     */
    public function delete(LanguageDeleteRequest $request) {
        $language = Language::findOrFail($request->input('id'));
        foreach ($language->users as $user) {
            $user->update(['language_id' => null]);
        }
        $language->delete();
        return redirect()->route('language.index')->with(['msg' => 'Usunięto język!']);
    }
}
