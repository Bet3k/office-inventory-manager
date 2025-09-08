<?php

namespace App\Actions\PersonalDataType;

use App\Dtos\PersonalDataTypeDto;
use App\Models\PersonalDataType;
use App\Models\User;
use App\Repository\PersonalDataTypeRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class UpdatePersonalDataTypeAction
{
    private PersonalDataTypeRepository $personalProcessedType;

    public function __construct(PersonalDataTypeRepository $personalProcessedType)
    {
        $this->personalProcessedType = $personalProcessedType;
    }

    /**
     * @throws Throwable
     */
    public function execute(
        PersonalDataTypeDto $dto,
        PersonalDataType $personalProcessedType
    ): ?PersonalDataType {
        return DB::transaction(function () use ($dto, $personalProcessedType) {
            /** @var User $user */
            $user = Auth::user();

            $personalProcessedType->data_type = $dto->data_type;
            $personalProcessedType->user_id = $user->id;

            return $this->personalProcessedType->save($personalProcessedType);
        });
    }
}
