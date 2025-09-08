<?php

namespace App\Actions\PersonalDataType;

use App\Models\PersonalDataType;
use App\Repository\PersonalDataTypeRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ListPersonalDataTypesAction
{
    private PersonalDataTypeRepository $personalProcessedType;

    public function __construct(PersonalDataTypeRepository $personalProcessedType)
    {
        $this->personalProcessedType = $personalProcessedType;
    }

    /**
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, PersonalDataType>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->personalProcessedType->all($request);
    }
}
