<?php

namespace App\Actions\Software;

use App\Models\Software;
use App\Repository\SoftwareRepository;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class DeleteSoftwareAction
{
    private SoftwareRepository $softwareRepository;

    public function __construct(SoftwareRepository $softwareRepository)
    {
        $this->softwareRepository = $softwareRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(Software $software): ?bool
    {
        return DB::transaction(function () use ($software) {
            return $this->softwareRepository->delete($software);
        });
    }
}
