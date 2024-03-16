<?php

namespace App\Interface\Entities\Clean;

interface PostInterface
{
    /**
     *
     */
    public const RECORDS_PER_PAGE = 6;

    /**
     * Used for DateTime formatting
     *
     * setlocale(LC_ALL, 'hu_HU.UTF-8');
     * $dtFormat = 'Y. F j.';
     */
    public const DT_FORMAT = 'jS \o\f F Y';
}
