<?php

namespace Modules\Social\Interfaces\Services;

interface SocialServiceInterface
{
    /**
     * @param string $driver
     * @return bool
     */
    public function socialCallback(string $driver): bool;
}
