<?php

use Illuminate\Database\Seeder;

class TSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Baoshe::truncate();
        \App\Models\CheckDetail::truncate();
        \App\Models\Customer::truncate();
        \App\Models\Department::truncate();
        \App\Models\Input::truncate();
        \App\Models\JituanConfig::truncate();
        \App\Models\Menber::truncate();
        \App\Models\Periodical::truncate();
        \App\Zhenggg\Auth\Database\Administrator::whereColumn('id', '!=', 'user_id')->delete();
        \App\Models\Target::truncate();
        \App\Models\TargetD::truncate();
        \App\Models\TargetM::truncate();
        \App\Models\UCheckout::truncate();
        \App\Models\CustomerPiao::truncate();
        \App\Zhenggg\Auth\Database\OperationLog::truncate();
        \App\Models\Zhifu::where('user_id','!=',0)->delete();
    }
}
