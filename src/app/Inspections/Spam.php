<?php

namespace App\Inspections;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Spam
 *
 * @package App\Inspections
 */
class Spam extends Model
{
    protected $inspections = [
        KeyHeldDown::class,
        InvalidKeywords::class,
    ];

    /**
     * @param string $body
     *
     * @return bool
     * @throws \Exception
     */
    public function detect(string $body)
    {
        foreach ($this->inspections as $inspection) {
            /** @var Inspectionable $inspection */
            $inspection = app($inspection);
            $inspection->detect($body);
        }

        return false;
    }
}
