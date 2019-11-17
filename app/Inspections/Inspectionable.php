<?php

namespace App\Inspections;

/**
 * Interface Inspectionable
 *
 * @package   App\Inspections
 */
interface Inspectionable
{
    /**
     * @param string $body
     */
    public function detect(string $body): void;
}
