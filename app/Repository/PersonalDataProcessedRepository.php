<?php

namespace App\Repository;

use App\Models\PersonalDataProcessed;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class PersonalDataProcessedRepository
{
    /**
     * Get all software.
     *
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
}
