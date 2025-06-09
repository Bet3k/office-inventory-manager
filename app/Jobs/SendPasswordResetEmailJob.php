<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ForgotPasswordNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;

class SendPasswordResetEmailJob implements ShouldQueue
{
    use Queueable;
    use SerializesModels;

    protected string $token;

    protected User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->user->notify(new ForgotPasswordNotification($this->token));
    }
}
