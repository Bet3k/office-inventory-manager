<?php

namespace App\Actions\Software;

use App\Models\Software;
use App\Repository\SoftwareRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

readonly class ListSoftwareAction
{
    private SoftwareRepository $softwareRepository;

    public function __construct(SoftwareRepository $softwareRepository)
    {
        $this->softwareRepository = $softwareRepository;
    }

    /**
     * Returns paginated, filtered list of devices
     *
     * @param  Request  $request
     *
     * @return LengthAwarePaginator<int, Software>
     */
    public function execute(Request $request): LengthAwarePaginator
    {
        return $this->softwareRepository->all($request);
    }
}
