<?php


use App\Models\Baoshe;
use App\Models\Customer;
use App\Models\CustomerPiao;
use App\Models\Department;
use App\Models\Input;
use App\Models\JituanConfig;
use App\Models\LiushuiLog;
use App\Models\Menber;
use App\Models\Periodical;
use App\Models\PiaoLog;
use App\Models\Target;
use App\Models\TargetD;
use App\Models\TargetM;
use App\Models\UCheckout;
use App\Zhenggg\Auth\Database\Administrator;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            \App\Zhenggg\Auth\Database\OperationLog::truncate();
            \App\Models\Type::where('user_id', '!=', 0)->delete();

            $now = \Carbon::now();
            $startOfYear = $now->startOfYear()->toDateTimeString();
            $endOfYear = $now->endOfYear()->toDateTimeString();
            $now = \Carbon::now();

            Administrator::whereColumn('id', '!=', 'user_id')->delete();
            $admin = Administrator::first();

            JituanConfig::truncate();
            JituanConfig::insert([
                [
                    'user_id' => $admin->user_id,
                    'jituan_name' => '新华报业集团',
                ],
            ]);
            Baoshe::truncate();
            Baoshe::insert([
                [
                    'user_id' => $admin->user_id,
                    'name' => '江苏经济报社',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '都市报社',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            Department::truncate();
            Department::insert([
                [
                    'user_id' => $admin->user_id,
                    'name' => '江苏经济报社',
                    'parent_id' => 0,
                    'menber_count' => 1,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '都市报社',
                    'parent_id' => 0,
                    'menber_count' => 0,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '记者部',
                    'parent_id' => 1,
                    'menber_count' => 1,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '记者部',
                    'parent_id' => 0,
                    'menber_count' => 1,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            Periodical::truncate();
            Periodical::insert([
                [
                    'user_id' => $admin->user_id,
                    'name' => '江苏经济报',
                    'm_price' => 100.00,
                    'j_price' => 300.00,
                    'b_price' => 600.00,
                    'y_price' => 1200.00,
                    'per' => 3.00,
                    'baoshe_id' => 1,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '都市报',
                    'm_price' => 100.00,
                    'j_price' => 300.00,
                    'b_price' => 600.00,
                    'y_price' => 1200.00,
                    'per' => 3.00,
                    'baoshe_id' => 2,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            Menber::truncate();
            Menber::insert([
                [
                    'user_id' => $admin->user_id,
                    'd_id' => 3,
                    'name' => '发行人1',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),

                ],
                [
                    'user_id' => $admin->user_id,
                    'd_id' => 4,
                    'name' => '发行人2',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            Customer::truncate();
            Customer::insert([
                [
                    'user_id' => $admin->user_id,
                    'name' => '客户1',
                    'province' => 10,
                    'city' => 162,
                    'district' => 2036,
                    'youbian' => '223200',
                    'address' => '客户地址1',
                    'type' => 5,
                    'hangye' => 13,
                    'contacts' => '客户1',
                    'mobile' => '123456789',
                    'source' => 0,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'name' => '客户2',
                    'province' => 10,
                    'city' => 162,
                    'district' => 2036,
                    'youbian' => '223200',
                    'address' => '客户地址2',
                    'type' => 6,
                    'hangye' =>14,
                    'contacts' => '客户2',
                    'mobile' => '123456798',
                    'source' => 0,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            CustomerPiao::truncate();
            CustomerPiao::insert([
                [
                    'user_id' => $admin->user_id,
                    'c_id' => 1,
                    'name' => '开票名称1',
                    'hao' => '999999999',
                    'addr' => '开票地址1',
                    'phone' => '123456789',
                    'bank' => '工行',
                    'bank_account' => '66666123456789',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),

                ],
                [
                    'user_id' => $admin->user_id,
                    'c_id' => 2,
                    'name' => '开票名称2',
                    'hao' => '999999999',
                    'addr' => '开票地址2',
                    'phone' => '123456789',
                    'bank' => '建行',
                    'bank_account' => '66666123456798',
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            Target::truncate();

            Target::insert([
                [
                    'user_id' => $admin->user_id,
                    'p_id' => 1,
                    'num' => 30000,
                    'numed' => 0,
                    'money' => 800000.00,
                    'moneyed' => 0.00,
                    's_time' => $startOfYear,
                    'e_time' => $endOfYear,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'p_id' => 2,
                    'num' => 20000,
                    'numed' => 0,
                    'money' => 500000.00,
                    'moneyed' => 0.00,
                    's_time' => $startOfYear,
                    'e_time' => $endOfYear,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            TargetD::truncate();
            TargetD::insert([
                [
                    'user_id' => $admin->user_id,
                    'p_id' => 1,
                    'target_id' => 1,
                    'd_id' => 1,
                    'd_name' => '江苏经济报社',
                    'num' => 5000,
                    'numed' => 0,
                    'money' => 200000.00,
                    'moneyed' => 0.00,
                    'parent_d_id' => 0,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'user_id' => $admin->user_id,
                    'p_id' => 1,
                    'target_id' => 1,
                    'd_id' => 3,
                    'd_name' => '记者部',
                    'num' => 2000,
                    'numed' => 0,
                    'money' => 100000.00,
                    'moneyed' => 0.00,
                    'parent_d_id' => 1,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            TargetM::truncate();
            TargetM::insert([
                [
                    'user_id' => $admin->user_id,
                    'user_name' => '发行人1',
                    'u_id' => 1,
                    'num' => 500,
                    'numed' => 10,
                    't_id' => 1,
                    't_d_id' => 2,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            UCheckout::truncate();
            Input::truncate();
            Input::insert([
                [
                    'c_id' => 1,
                    'customer_name' => '客户1',
                    'user_id' => $admin->user_id,
                    'u_id' => 1,
                    'menber_name' => '发行人1',
                    'd_id' => 3,
                    'p_id' => 1,
                    'p_name' => '江苏经济报',
                    'source' => 0,
                    'num' => 10,
                    'input_type' => 'm',
                    'input_status' => 0,
                    'piao_status' => 0,
                    'dis_status' => 0,
                    'pay_status' => 0,
                    'pay_name' => 1,
                    'p_money' => 100.00,
                    'p_amount' => 1000.00,
                    'money_paid' => 0.00,
                    'money_kou' => 0.00,
                    'piao_money' => 0.00,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
                [
                    'c_id' => 1,
                    'customer_name' => '客户1',
                    'user_id' => $admin->user_id,
                    'u_id' => 1,
                    'menber_name' => '发行人1',
                    'd_id' => 3,
                    'p_id' => 1,
                    'p_name' => '江苏经济报',
                    'source' => 0,
                    'num' => 5,
                    'input_type' => 'b',
                    'input_status' => 0,
                    'piao_status' => 0,
                    'dis_status' => 0,
                    'pay_status' => 0,
                    'pay_name' => 1,
                    'p_money' => 600.00,
                    'p_amount' => 3000.00,
                    'money_paid' => 0.00,
                    'money_kou' => 0.00,
                    'piao_money' => 0.00,
                    'created_at' => $now->toDateTimeString(),
                    'updated_at' => $now->toDateTimeString(),
                ],
            ]);
            PiaoLog::truncate();
            LiushuiLog::truncate();
            //FenChengLog::truncate();
        });
    }
}
