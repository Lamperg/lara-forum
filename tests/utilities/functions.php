<?php

/**
 * The 'create' function helper
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

/**
 * The 'make' function helper
 *
 * @param string $class
 * @param array  $attributes
 *
 * @return mixed
 */
function make(string $class, array $attributes = [])
{
    return factory($class)->create($attributes);
}
