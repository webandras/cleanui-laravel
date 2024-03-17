<?php

namespace App\Services\Clean;

use App\Interface\Services\Clean\ImageServiceInterface;

class ImageService implements ImageServiceInterface
{

    public function getImageAbsolutePath(string $imageUrl, int $offset = 3): string
    {
        if ($imageUrl === '') {
            return '';
        }
        $parts = explode('/', $imageUrl);
        $parts = array_slice($parts, $offset);

        $url = '/';
        $i = 0;
        foreach ($parts as $part) {
            $url .= $part;
            if ($i < count($parts) - 1) {
                $url .= '/';
            }
            $i++;
        }
        return $url;

    }
}
