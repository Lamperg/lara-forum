<?php

namespace App\Utilities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Spam
 *
 * @package App\Utilities
 */
class Spam extends Model
{
    /**
     * @param string $body
     *
     * @return bool
     * @throws \Exception
     */
    public function detect(string $body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    /**
     * @param string $body
     *
     * @throws \Exception
     */
    protected function detectInvalidKeywords(string $body)
    {
        $invalidKeywords = [
            'yahoo customer support',
        ];

        foreach ($invalidKeywords as $keyword) {

            if (stripos($body, $keyword) !== false) {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}
