<?php

declare(strict_types=1);

namespace App\Dtos;

use App\Contracts\DtoContract;
use App\Models\UserSession;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Jenssegers\Agent\Agent;

class SessionDto implements DtoContract
{
    public function __construct(
        public string $id,
        public string $payload,
        public string $user_agent,
        public string $ip_address,
        public string $user_id,
        public string $device,
        public string $platform,
        public string $browser,
        public Carbon $last_activity,
    ) {
    }

    /**
     * @param  Collection<int, UserSession>  $sessions
     *
     * @return array<int, array{
     *     id: string,
     *     payload: string,
     *     user_agent: string,
     *     ip_address: string,
     *     user_id: string,
     *     device: string,
     *     platform: string,
     *     browser: string,
     *     last_activity: string,
     *     last_active: string,
     *     is_current: bool
     * }>
     */
    public static function fromCollection(Collection $sessions, string $currentSessionId): array
    {
        return $sessions->map(function (UserSession $session) use ($currentSessionId) {
            $dto = self::fromModel($session);

            return [
                ...$dto->toArray(),
                'last_active' => $dto->last_activity->diffForHumans(),
                'is_current' => $dto->id === $currentSessionId,
            ];
        })->toArray();
    }

    /**
     * Convert the DTO to an array representation.
     *
     * @return array{
     *      id: string,
     *      payload: string,
     *      user_agent: string,
     *      ip_address: string,
     *      user_id: string,
     *      device: string,
     *      platform: string,
     *      browser: string,
     *      last_activity: string,
     * }
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'payload' => $this->payload,
            'user_agent' => $this->user_agent,
            'ip_address' => $this->ip_address,
            'user_id' => $this->user_id,
            'device' => $this->device,
            'platform' => $this->platform,
            'browser' => $this->browser,
            'last_activity' => $this->last_activity->format('Y-m-d H:i:s'),
        ];
    }

    public static function fromModel(object $model): self
    {
        if (! $model instanceof UserSession) {
            throw new InvalidArgumentException('Expected instance of UserSession');
        }

        $agent = new Agent();
        $agent->setUserAgent($model->user_agent);

        return new self(
            id: $model->id,
            payload: $model->payload,
            user_agent: $model->user_agent,
            ip_address: $model->ip_address,
            user_id: $model->user_id,
            device: (string) ($agent->device() ? $agent->device() : 'Unknown'),
            platform: (string) ($agent->platform() ? $agent->platform() : 'Unknown'),
            browser: (string) ($agent->browser() ? $agent->browser() : 'Unknown'),
            last_activity: Carbon::createFromTimestamp($model->last_activity),
        );
    }
}
