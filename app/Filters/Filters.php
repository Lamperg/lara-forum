<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class Filters
 *
 * @package   App\Filters
 */
abstract class Filters
{
    /**
     * @var Request
     */
    protected $request;
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $filters = [];

    /**
     * ThreadFilters constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Applies the filters to the given queryBuilder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Retrieves active filters from request.
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->request->only($this->filters);
    }
}
