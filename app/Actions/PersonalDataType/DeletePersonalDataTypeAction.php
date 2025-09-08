<?php

namespace App\Actions\PersonalDataType;

use App\Models\PersonalDataType;
use App\Repository\PersonalDataTypeRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeletePersonalDataTypeAction
{
    private PersonalDataTypeRepository $personalProcessedType;

    public function __construct(PersonalDataTypeRepository $personalProcessedType)
    {
        $this->personalProcessedType = $personalProcessedType;
    }

    /**
     * @throws Throwable
     */
    public function execute(PersonalDataType $personalDataType): ?bool
    {
        return DB::transaction(function () use ($personalDataType) {
            return $this->personalProcessedType->delete($personalDataType);
        });
    }
}
