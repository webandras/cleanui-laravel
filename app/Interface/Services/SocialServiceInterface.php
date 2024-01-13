<?php

namespace App\Interface\Services;

interface SocialServiceInterface
{
    /**
     * @param string $driver
     * @return bool
     */
    public function socialCallback(string $driver): bool;
}
