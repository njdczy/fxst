<?php

use App\Models\Baoshe;
use App\Models\Customer;
use App\Models\CustomerPiao;
use App\Models\Department;
use App\Models\Input;
use App\Models\JituanConfig;
use App\Models\LiushuiLog;
use App\Models\Menber;
use App\Models\MenberPer;
use App\Models\Periodical;
use App\Models\PiaoLog;
use App\Models\Target;
use App\Models\TargetD;
use App\Models\TargetM;
use App\Models\UCheckout;
use App\Zhenggg\Auth\Database\Administrator;
use Illuminate\Database\Seeder;

class ClearDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Zhenggg\Auth\Database\OperationLog::truncate();
        \App\Models\Type::where('user_id', '!=', 0)->delete();

        Administrator::whereColumn('id', '!=', 'user_id')->delete();

        Baoshe::truncate();
        Customer::truncate();
        CustomerPiao::truncate();
        Department::truncate();
        Input::truncate();
        JituanConfig::truncate();
        LiushuiLog::truncate();
        Menber::truncate();
        MenberPer::truncate();
        Periodical::truncate();
        PiaoLog::truncate();
        Target::truncate();
        TargetD::truncate();
        TargetM::truncate();
        UCheckout::truncate();
    }
}
