<?php

namespace App\Inspections;

/**
 * Class InvalidKeywords
 *
 * @package   App\Inspections
 */
class InvalidKeywords implements Inspectionable
{
    protected $keywords = [
        'yahoo customer support',
    ];

    /**
     * {@inheritDoc}
     */
    public function detect(string $body): void
    {
        foreach ($this->keywords as $keyword) {
            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}
