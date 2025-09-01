<?php

namespace App\Repository;

use App\Models\PersonalDataProcessed;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PersonalDataProcessedRepository
{
    /**
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, PersonalDataProcessed>
     */
    public function all(Request $request): LengthAwarePaginator
    {
        return PersonalDataProcessed::query()
            ->when(
                $request->filled('search'),
                fn ($q) => $q->where('name', 'like', '%' . $request->string('search')->value() . '%')
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
     * @param  PersonalDataProcessed  $personalDataProcessed
     *
     * @return PersonalDataProcessed
     */
    public function save(PersonalDataProcessed $personalDataProcessed): PersonalDataProcessed
    {
        $personalDataProcessed->save();

        return $personalDataProcessed->refresh();
    }

    /**
     * @param  PersonalDataProcessed  $personalDataProcessed
     *
     * @return bool|null
     *
     * @throws Exception
     */
    public function delete(PersonalDataProcessed $personalDataProcessed): ?bool
    {
        return $personalDataProcessed->delete();
    }
}
