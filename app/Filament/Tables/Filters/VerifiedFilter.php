<?php

namespace App\Filament\Tables\Filters;

use Filament\Tables\Filters\TernaryFilter;

class VerifiedFilter extends TernaryFilter
{
    public static function getDefaultName(): ?string
    {
        return 'email_verified_at';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('app.filament.tables.filters.verified.label'));

        $this->placeholder(__('app.filament.tables.filters.verified.placeholder'));

        $this->trueLabel(__('app.filament.tables.filters.verified.true_label'));

        $this->falseLabel(__('app.filament.tables.filters.verified.false_label'));

        $this->queries(
            true: fn ($query) => $query->whereNotNull('email_verified_at'),
            false: fn ($query) => $query->whereNull('email_verified_at'),
            blank: fn ($query) => $query,
        );
    }
}
