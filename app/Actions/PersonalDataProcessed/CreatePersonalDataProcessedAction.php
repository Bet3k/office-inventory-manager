<?php

namespace App\Actions\PersonalDataProcessed;

use App\Dtos\PersonalDataProcessedDto;
use App\Models\PersonalDataProcessed;
use App\Models\User;
use App\Repository\PersonalDataProcessedRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreatePersonalDataProcessedAction
{
    private PersonalDataProcessedRepository $personalProcessedData;

    public function __construct(PersonalDataProcessedRepository $personalProcessedData)
    {
        $this->personalProcessedData = $personalProcessedData;
    }

    /**
     * @throws Throwable
     */
    public function execute(PersonalDataProcessedDto $dto): ?PersonalDataProcessed
    {
        return DB::transaction(function () use ($dto) {
            /** @var User $user */
            $user = Auth::user();

            $pdp = new PersonalDataProcessed();
            $pdp->name = $dto->name;
            $pdp->user_id = $user->id;

            return $this->personalProcessedData->save($pdp);
        });
    }
}
