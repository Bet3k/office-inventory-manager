<?php

namespace App\Actions\PersonalDataProcessed;

use App\Models\PersonalDataProcessed;
use App\Repository\PersonalDataProcessedRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

class DeletePersonalDataProcessedAction
{
    private PersonalDataProcessedRepository $personalProcessedData;

    public function __construct(PersonalDataProcessedRepository $personalProcessedData)
    {
        $this->personalProcessedData = $personalProcessedData;
    }

    /**
     * @throws Throwable
     */
    public function execute(PersonalDataProcessed $personalDataProcessed): ?bool
    {
        return DB::transaction(function () use ($personalDataProcessed) {
            return $this->personalProcessedData->delete($personalDataProcessed);
        });
    }
}
