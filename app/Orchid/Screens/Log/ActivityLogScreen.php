<?php

namespace App\Orchid\Screens\Log;

use Orchid\Support\Facades\Layout;
use Orchid\Screen\Screen;

class ActivityLogScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'ActivityLogScreen';

    /**
     * Display header description.
     *
     * @var string|null
     */
    public $description = 'ActivityLogScreen';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [];
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): array
    {
        return [];
    }
}
