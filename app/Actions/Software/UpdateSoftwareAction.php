<?php

namespace App\Actions\Software;

use App\Dtos\SoftwareDto;
use App\Models\Software;
use App\Models\User;
use App\Repository\SoftwareRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class UpdateSoftwareAction
{
    private SoftwareRepository $softwareRepository;

    public function __construct(SoftwareRepository $softwareRepository)
    {
        $this->softwareRepository = $softwareRepository;
    }

    /**
     * @throws Throwable
     */
    public function execute(SoftwareDto $dto, Software $software): ?Software
    {
        return DB::transaction(function () use ($dto, $software) {
            /** @var User $user */
            $user = Auth::user();

            $software->name = $dto->name;
            $software->status = $dto->status;
            $software->user_id = $user->id;

            return $this->softwareRepository->save($software);
        });
    }
}
