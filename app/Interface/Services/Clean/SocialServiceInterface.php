<?php

namespace App\Interface\Services\Clean;

interface SocialServiceInterface
{
    /**
     * @param string $driver
     * @return bool
     */
    public function socialCallback(string $driver): bool;
}
