<?php

namespace App\Services\Core;

use App\Traits\ElementTrait;

/**
 * Class BaseService
 *
 * @package App\Services\Core
 */
abstract class BaseService
{
    use ElementTrait;

    /**
     * Get Other Instance Service by Service class name and params
     * eg: $this->getServiceInstance(BaseService::class);
     *
     * @param string $service Service class name
     * @param array  $params  Params for init new Instance
     * @return BaseService|null
     */
    public function getServiceInstance(string $service, array $params = []): ?BaseService
    {
        $instance = resolve($service, $params);
        if (!empty($instance) && $instance instanceof BaseService) {
            return $instance;
        }
        return null;
    }
}
