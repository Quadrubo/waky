<?php

namespace App\Support\Concerns;

trait InteractsWithBanner
{
    public function banner(string $message, string $style = 'success'): void
    {
        request()->session()->flash('flash.banner', $message);
        request()->session()->flash('flash.bannerStyle', $style);
    }
}
