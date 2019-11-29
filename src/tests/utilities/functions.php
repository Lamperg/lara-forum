<?php

if (!function_exists('create')) {
    /**
     * Creates new model by name
     *
     * @param string   $class
     * @param array    $attributes
     *
     * @param int|null $times
     *
     * @return mixed
     */
    function create(string $class, array $attributes = [], int $times = null)
    {
        return factory($class, $times)->create($attributes);
    }
}

if (!function_exists('make')) {
    /**
     * Makes new model by name
     *
     * @param string   $class
     * @param array    $attributes
     *
     * @param int|null $times
     *
     * @return mixed
     */
    function make(string $class, array $attributes = [], int $times = null)
    {
        return factory($class, $times)->make($attributes);
    }
}
