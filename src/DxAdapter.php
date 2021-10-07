<?php

namespace Floo\DxAdapter;

use Exception;
use Floo\DxAdapter\Builders\FilterQuery;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;


class DxAdapter
{
    use FilterQuery;

    public $query;

    public $request;

    public function __construct($query, ?Request $request = null)
    {
        $this->initializeQueryModel($query)
            ->initializeRequest($request ?? app(Request::class));
    }

    public static function load($query, ?Request $request = null)
    {
        if (is_subclass_of($query, Model::class)) {
            $query = $query::query();
        }

        $instance = new static($query, $request);

        $instance->process();

        return $instance;
    }

    public function initializeQueryModel($query, ?Request $request = null)
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

    public function initializeRequest($request)
    {
        $this->request = $request
            ? DxAdapterRequest::fromRequest($request)
            : app(DxAdapterRequest::class);

        return $this;
    }

    public function process()
    {
        if ($this->request->has('filter')) {
            $this->parseFilter();
        }
        // $this->parseSelect();
        // $this->applySort();
        // $this->setNextPagePaginate();

        return $this->query;
    }

    public function __call($method, $arguments)
    {
        try {
            return $this->query->{$method}(...$arguments);
        } catch (Exception $e) {
            return $e;
        }
    }
}
