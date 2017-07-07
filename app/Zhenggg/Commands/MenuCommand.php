<?php

namespace App\Zhenggg\Commands;

use App\Zhenggg\Facades\Front;
use Illuminate\Console\Command;

class MenuCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'front:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show the front menu.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $menu = Front::menu();

        echo json_encode($menu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), "\r\n";
    }
}
