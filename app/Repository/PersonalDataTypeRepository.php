<?php

namespace App\Repository;

use App\Models\PersonalDataType;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PersonalDataTypeRepository
{
    /**
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, PersonalDataType>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        return PersonalDataType::query()
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where('data_type', 'like', '%' . $request->string('search')->value() . '%')
            )
            ->orderBy(
                $request->input('sort_field') === 'name'
                    ? $request->string('sort_field')->value()
                    : 'created_at',
                in_array($request->input('sort_order'), ['asc', 'desc'], true)
                    ? $request->string('sort_order')->value()
                    : 'desc'
            )
            ->paginate(
                $request->filled('per_page')
                    ? $request->integer('per_page')
                    : 15
            )
            ->withQueryString();
    }

    /**
     * @param  PersonalDataType  $personalDataType
     *
     * @return PersonalDataType
     */
    public function save(PersonalDataType $personalDataType): PersonalDataType
    {
        $personalDataType->save();

        return $personalDataType->refresh();
    }

    /**
     * @param  PersonalDataType  $personalDataType
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(PersonalDataType $personalDataType): ?bool
    {
        return $personalDataType->delete();
    }
}
