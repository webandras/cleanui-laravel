<?php

namespace Modules\Clean\Interfaces\Services;

interface ImageServiceInterface
{
    /**
     * @param  string  $imageUrl
     * @return string
     */
    public function getImageAbsolutePath(string $imageUrl): string;
}
