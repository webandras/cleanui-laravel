<?php

namespace Modules\Clean\Traits;

trait InteractsWithBanner
{
    /**
     * @param  string  $message
     * @param  string  $style
     * @return void
     */
    public function banner(string $message, string $style = 'success'): void
    {
        request()->session()->flash('flash.banner', $message);
        request()->session()->flash('flash.bannerStyle', $style);
    }
}
