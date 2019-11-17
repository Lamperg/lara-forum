<?php

namespace App\Inspections;

/**
 * Class KeyHeldDown
 *
 * @package  App\Inspections
 */
class KeyHeldDown implements Inspectionable
{
    /**
     * {@inheritDoc}
     */
    public function detect(string $body): void
    {
        if (preg_match('/(.)\\1{4,}/', $body)) {
            throw new \Exception('Your reply contains spam.');
        }
    }
}
