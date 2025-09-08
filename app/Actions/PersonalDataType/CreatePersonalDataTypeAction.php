<?php

namespace App\Actions\PersonalDataType;

use App\Dtos\PersonalDataTypeDto;
use App\Models\PersonalDataType;
use App\Models\User;
use App\Repository\PersonalDataTypeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class CreatePersonalDataTypeAction
{
    private PersonalDataTypeRepository $personalProcessedType;

    public function __construct(PersonalDataTypeRepository $personalProcessedType)
    {
        $this->personalProcessedType = $personalProcessedType;
    }

    /**
     * @throws Throwable
     */
    public function execute(PersonalDataTypeDto $dto): ?PersonalDataType
    {
        return DB::transaction(function () use ($dto) {
            /** @var User $user */
            $user = Auth::user();

            $pdp = new PersonalDataType();
            $pdp->data_type = $dto->data_type;
            $pdp->user_id = $user->id;

            return $this->personalProcessedType->save($pdp);
        });
    }
}
