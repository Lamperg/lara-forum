<?php

if (!function_exists('create')) {
    /**
     * Creates new model by name
     *
     * @param string $class
     * @param array  $attributes
     *
     * @return mixed
     */
    function create(string $class, array $attributes = [])
    {
        return factory($class)->create($attributes);
    }
}

if (!function_exists('make')) {
    /**
     * Makes new model by name
     *
     * @param string $class
     * @param array  $attributes
     *
     * @return mixed
     */
    function make(string $class, array $attributes = [])
    {
        return factory($class)->make($attributes);
    }
}
