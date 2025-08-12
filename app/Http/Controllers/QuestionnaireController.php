<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuestionnaireController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        dd($request);
        // Questionnaire::create($request->all());

        return redirect()->route('questionnaire.create');
    }

    public function create(): Response
    {
        return Inertia::render('questionnaire/create');
    }
}
