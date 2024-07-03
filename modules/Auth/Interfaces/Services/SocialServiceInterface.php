<?php

namespace Modules\Auth\Interfaces\Services;

interface SocialServiceInterface
{
    /**
     * @param string $driver
     * @return bool
     */
    public function socialCallback(string $driver): bool;
}
