<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22
 * Time: 14:08
 */

namespace App\Observer;


class CustomerObserver
{
    public function deleted($customer)
    {
        $customer->customer_piao->delete();
    }
}