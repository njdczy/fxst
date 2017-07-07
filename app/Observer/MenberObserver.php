<?php


namespace App\Observer;


class MenberObserver
{
    public function created($menber)
    {
        // I want to create the $book book, but first...
    }


    public function deleted($menber)
    {
        dd($menber);exit;
        // I just saved the $book book, so....
    }
}