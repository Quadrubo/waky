<?php

declare(strict_types=1);

namespace App\Filament\Resources\Concerns;

trait ResourceMetadata
{
    public static function getModelLabel(): string
    {
        return __(static::$translationPrefix.'.label') !== static::$translationPrefix.'.label' ? __(static::$translationPrefix.'.label') : parent::getModelLabel();
    }

    public static function getPluralModelLabel(): string
    {
        return __(static::$translationPrefix.'.plural_label') !== static::$translationPrefix.'.plural_label' ? __(static::$translationPrefix.'.plural_label') : parent::getPluralModelLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __(static::$translationPrefix.'.navigation_group') !== static::$translationPrefix.'.navigation_group' ? __(static::$translationPrefix.'.navigation_group') : parent::getNavigationGroup();
    }
}
