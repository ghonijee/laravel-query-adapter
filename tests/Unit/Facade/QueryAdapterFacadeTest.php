<?php

use GhoniJee\DxAdapter\DxAdapter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use GhoniJee\DxAdapter\Models\TestModel;
use GhoniJee\DxAdapter\QueryAdapter;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = new Request();
});

test('can use facade class to build query builder adapter', function () {
    $instance =  QueryAdapter::load(TestModel::query());
    expect($instance)->toBeInstanceOf(DxAdapter::class);
});

test('can filter and select query builder adapter with Facade', function () {
    $filter = ['name', 'contains', 'ahmad'];
    $select = ['name'];

    $this->request->replace(['filter' => $filter, 'select' => $select]);

    $query = QueryAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'like', '%ahmad%')->select($select)->toSql();

    expect($query)->toEqual($queryExpectation);
});
