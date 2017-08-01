<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        \App\Models\Baoshe::truncate();
        \App\Models\CheckDetail::truncate();
        \App\Models\Customer::truncate();
        \App\Models\Department::truncate();
        \App\Models\Input::truncate();
        \App\Models\InputP::truncate();
        \App\Models\JituanConfig::truncate();
        \App\Models\Menber::truncate();
        \App\Models\Periodical::truncate();
        \App\Zhenggg\Auth\Database\Administrator::whereColumn('id', '!=', 'user_id')->delete();
        \App\Models\Target::truncate();
        \App\Models\UCheckout::truncate();
        \App\Models\Zhifu::where('user_id','!=',0)->delete();
    }
}
