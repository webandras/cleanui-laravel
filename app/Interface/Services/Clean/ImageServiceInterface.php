<?php

namespace App\Interface\Services\Clean;

interface ImageServiceInterface
{
    /**
     * @param  string  $imageUrl
     * @return string
     */
    public function getImageAbsolutePath(string $imageUrl): string;
}
