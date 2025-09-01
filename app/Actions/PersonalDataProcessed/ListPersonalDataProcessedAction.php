<?php

namespace App\Actions\PersonalDataProcessed;

use App\Models\PersonalDataProcessed;
use App\Repository\PersonalDataProcessedRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ListPersonalDataProcessedAction
{
    private PersonalDataProcessedRepository $personalProcessedData;

    public function __construct(PersonalDataProcessedRepository $personalProcessedData)
    {
        $this->personalProcessedData = $personalProcessedData;
    }

    /**
     * Returns paginated, filtered list of devices
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, PersonalDataProcessed>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->personalProcessedData->all($request);
    }

}
