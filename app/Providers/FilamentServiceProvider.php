<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Filament::serving(function () {
            \Filament\Support\Components\ViewComponent::macro('localize', function (?string $translatorPrefix = '', ?bool $label = true, ?bool $helper = true, ?bool $hint = true, ?bool $datetime = false, ?array $labelAttributes = [], ?array $helperAttributes = [], ?array $hintAttributes = []) {
                if (! str_ends_with($translatorPrefix, '.')) {
                    $translatorPrefix = $translatorPrefix.'.';
                }

                if ($label) {
                    $this->label(__($translatorPrefix.'label', $labelAttributes));
                } else {
                    $this->label = '';
                }

                if ($helper) {
                    $this->helperText(__($translatorPrefix.'helper', $helperAttributes));
                } else {
                    $this->helper = '';
                }

                if ($hint) {
                    $this->hint(__($translatorPrefix.'hint', $hintAttributes));
                } else {
                    $this->hint = '';
                }

                return $this;
            });
        });
    }
}
