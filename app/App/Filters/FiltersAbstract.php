<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 12/20/2017
 * Time: 5:41 PM
 */

namespace SAASBoilerplate\App\Filters;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class FiltersAbstract
{
    /**
     * A list of filters.
     *
     * @var array
     */
    protected $filters = [];

    /**
     * A list of default filters.
     *
     * @var array
     */
    protected $defaultFilters = [];

    /**
     * The request.
     *
     * @var Request
     */
    protected $request;

    /**
     * FiltersAbstract constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Loops through filters and builds them up.
     *
     * @param Builder $builder
     * @return Builder
     */
    public function filter(Builder $builder)
    {
        foreach ($this->getFilters() as $filter => $value) {
            $this->resolveFilter($filter)->filter($builder, $value);
        }

        return $builder;
    }

    /**
     * Add filters.
     *
     * @param array $filters
     * @return $this
     */
    public function add(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);

        return $this;
    }

    /**
     * Returns all filters.
     *
     * @return array
     */
    public function getFilters()
    {
        //return default filters if request is empty
        if ($this->filteredFiltersCount() == 0) {
            return $this->getDefaultFilters();
        }

        $this->removeDefaultFiltersIfPresentInRequest();

        if ($this->filteredFiltersCount() != 0 && $this->defaultFiltersCount() != 0) {
            return $this->mergeDefaultFiltersWithRequestFilters();
        }

        //return only filters in request
        return $this->filterFilters($this->filters);
    }

    /**
     * Returns default filters.
     *
     * @return array
     */
    protected function getDefaultFilters()
    {
        return $this->defaultFilters;
    }

    /**
     * Return count of default filters.
     *
     * @return int
     */
    public function defaultFiltersCount()
    {
        return count($this->defaultFilters);
    }

    /**
     * Return count of filtered filters.
     *
     * @return int
     */
    public function filteredFiltersCount()
    {
        return count($this->filterFilters($this->filters));
    }

    /**
     * Merges default filters not present in request (with passed filters).
     */
    protected function mergeDefaultFiltersWithRequestFilters()
    {
        $cleanFilters = $this->filterFilters($this->filters);

        $mergedFilters = array_merge($cleanFilters, $this->defaultFilters);

        return $mergedFilters;
    }

    /**
     * Remove default filters that have been passed in request.
     */
    protected function removeDefaultFiltersIfPresentInRequest()
    {
        foreach ($this->defaultFilters as $key => $filter) {
            if ($this->request->has($key)) {
                $this->defaultFilters = array_except($this->defaultFilters, $key);
            }
        }
    }

    /**
     * Instantiates a filter.
     *
     * @param $filter
     * @return mixed
     */
    protected function resolveFilter($filter)
    {
        return new $this->filters[$filter];
    }

    /**
     * Filter filters that are only in the request.
     *
     * @param $filters
     * @return mixed
     */
    protected function filterFilters($filters)
    {
        return array_filter($this->request->only(array_keys($this->filters)));
    }
}