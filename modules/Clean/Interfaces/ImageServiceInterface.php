<?php

namespace Modules\Clean\Interfaces;

interface ImageServiceInterface
{
    /**
     * @param  string  $imageUrl
     * @return string
     */
    public function getImageAbsolutePath(string $imageUrl): string;
}
