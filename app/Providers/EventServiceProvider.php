<?php

namespace App\Providers;


use App\Models\Baoshe;
use App\Models\Department;
use App\Models\Input;
use App\Models\InputP;
use App\Models\Menber;
use App\Observer\BaosheObserver;
use App\Zhenggg\Auth\Database\Menu;
use App\Models\Periodical;


use App\Observer\DepartmentObserver;
use App\Observer\InputObserver;
use App\Observer\MenuObserver;
use App\Observer\InputPObserver;
use App\Observer\MenberObserver;
use App\Observer\PeriodicalObserver;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Baoshe::observe(new BaosheObserver);
        Department::observe(new DepartmentObserver);
        Input::observe(new InputObserver);
        InputP::observe(new InputPObserver);
        Menber::observe(new MenberObserver);
        Menu::observe(new MenuObserver);
        Periodical::observe(new PeriodicalObserver);

    }
}
