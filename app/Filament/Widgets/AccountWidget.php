<?php

namespace Filament\Widgets;

class AccountWidget extends Widget
{
    protected static ?int $sort = -3;
    protected array|string|int $columnSpan = 2;
    /**
     * @var view-string
     */
    protected static string $view = 'filament-panels::widgets.account-widget';

}
