<?php

if (!function_exists('front_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function front_path($path = '')
    {
        return ucfirst(config('front.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('front_url')) {
    /**
     * Get admin url.
     *
     * @param string $url
     *
     * @return string
     */
    function front_url($url = '')
    {
        $prefix = trim(config('front.prefix'), '/');

        return url($prefix ? "/$prefix" : '').'/'.trim($url, '/');
    }
}

if (!function_exists('front_toastr')) {

    /**
     * Flash a toastr messaage bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function front_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

        \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
    }
}
