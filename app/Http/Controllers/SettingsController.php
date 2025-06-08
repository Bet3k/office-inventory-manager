<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class SettingsController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('settings/index');
    }
}
