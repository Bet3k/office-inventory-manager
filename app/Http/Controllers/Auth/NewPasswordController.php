<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\NewPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\NewPasswordRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class NewPasswordController extends Controller
{
    /**
     * Show the password-reset page.
     */
    public function create(
        string $token,
        string $id,
        NewPasswordAction $action
    ): Response {
        $record = $action->checkToken($id);
        $validationError = $action->validateToken($record, $token);

        if ($validationError) {
            return Inertia::render('error', ['validationError' => $validationError]);
        }

        return Inertia::render('auth/reset-password', [
            'token' => $token,
            'id' => $id,
        ]);
    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function store(
        NewPasswordRequest $request,
        NewPasswordAction $action
    ): RedirectResponse|Response {
        $record = $action->checkToken($request->string('id')->value());
        $token = $request->string('token')->value();

        $validationError = $action->validateToken($record, $token);

        if ($validationError) {
            return Inertia::render('error', ['validationError' => $validationError]);
        }

        if ($record) {
            $action->execute($request, $record);
        }

        return to_route('login')
            ->with('success', 'Password reset successfully.');
    }
}
