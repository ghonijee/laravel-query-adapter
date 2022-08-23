<?php

namespace GhoniJee\DxAdapter;

use Exception;
use GhoniJee\DxAdapter\Actions\SerializeData;
use GhoniJee\DxAdapter\Builders\FilterQuery;
use GhoniJee\DxAdapter\Builders\PaginationQuery;
use GhoniJee\DxAdapter\Builders\SortByQuery;
use GhoniJee\DxAdapter\Builders\SelectQuery;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;

class DxAdapter
{
    use FilterQuery;
    use SelectQuery;
    use SerializeData;
    use SortByQuery;
    use PaginationQuery;

    /**
     * @var \Illuminate\Database\Eloquent\Builder $query
     */
    public $query;

    /**
     * @var \Illuminate\Http\Request $request
     */
    public $request;

    /**
     * @var \Illuminate\Support\Collection $filter
     */
    public $filter;

    /**
     * @var string $conjungtion
     */
    public $conjungtion;

    /**
     * @var Array $select
     */
    public $select;

    /**
     * @var \Illuminate\Support\Collection $filter
     */
    public $relationSelect;

    /**
     * @var \Illuminate\Support\Collection $filter
     */
    public $sort;


    public function init($query, ?Request $request = null): void
    {
        $this->initializeQueryModel($query)
            ->initializeRequest($request);
    }

    public static function load($query, ?Request $request = null): self
    {
        if (is_subclass_of($query, Model::class)) {
            $query = $query::query();
        }

        $instance = new self();
        $instance->init($query, $request);

        $instance->process();

        return $instance;
    }

    public static function for($subject, ?Request $request = null): self
    {
        if (is_subclass_of($subject, Model::class)) {
            $subject = $subject::query();
        }
        $instance = new self();
        $instance->init($subject, $request);
        $instance->process();
        return $instance;
    }

    public function initializeQueryModel($query, ?Request $request = null): self
    {
        throw_unless(
            $query instanceof EloquentBuilder || $query instanceof Relation,
            new Exception(
                sprintf(
                    'Param %s is invalid. param must instance of Builder or Relation class',
                    is_object($query)
                        ? sprintf('class `%s`', get_class($query))
                        : sprintf('type `%s`', gettype($query))
                )
            )
        );

        $this->query = $query;

        return $this;
    }

    public function initializeRequest($request): self
    {
        $this->request = $request ?: app(DxAdapterRequest::class);

        return $this;
    }

    public function process(): EloquentBuilder
    {
        if ($this->request->has(config('dx-adapter.request.filter'))) {
            $this->parseFilter();
        }
        if ($this->request->has(config('dx-adapter.request.select'))) {
            $this->parseSelect();
        }

        if ($this->request->has(config('dx-adapter.request.order'))) {
            $this->applySort();
        }

        $this->setNextPagePaginate();

        return $this->query;
    }

    public function __call($method, $arguments)
    {
        try {
            return $this->query->{$method}(...$arguments);
        } catch (Exception $e) {
            throw new Exception("Something wrong with Eloquent query builder", 500, $e);
        }
    }
}
