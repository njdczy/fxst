<?php

namespace App\Zhenggg\Commands;

use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'front:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the front package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (!$this->confirm('Are you sure to uninstall laravel-front?')) {
            return;
        }

        $this->removeFilesAndDirectories();

        $this->line('<info>Uninstalling laravel-front!</info>');
    }

    /**
     * Remove files and directories.
     *
     * @return void
     */
    protected function removeFilesAndDirectories()
    {
        $this->laravel['files']->deleteDirectory(config('front.directory'));
        $this->laravel['files']->deleteDirectory(public_path('packages/front/'));
        $this->laravel['files']->delete(config_path('front.php'));
    }
}
