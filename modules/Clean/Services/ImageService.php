<?php

namespace Modules\Clean\Services;

use Modules\Clean\Interfaces\Services\ImageServiceInterface;

class ImageService implements ImageServiceInterface
{

    public function getImageAbsolutePath(string $imageUrl, int $offset = 3): string
    {
        if ($imageUrl === '') {
            return '';
        }
        $parts = explode('/', $imageUrl);
        $parts = array_slice($parts, $offset);

        // return unchanged for test image path (seeded)
        if (empty($parts)) {
            return $imageUrl;
        }

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
