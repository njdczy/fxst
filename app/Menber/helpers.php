<?php

if (!function_exists('menber_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function menber_path($path = '')
    {
        return ucfirst(config('menber.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('menber_url')) {
    /**
     * Get admin url.
     *
     * @param string $url
     *
     * @return string
     */
    function menber_url($url = '')
    {
        $prefix = trim(config('menber.prefix'), '/');

        return url($prefix ? "/$prefix" : '').'/'.trim($url, '/');
    }
}

if (!function_exists('menber_toastr')) {

    /**
     * Flash a toastr messaage bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     *
     * @return string
     */
    function menber_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

        \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
    }
}
