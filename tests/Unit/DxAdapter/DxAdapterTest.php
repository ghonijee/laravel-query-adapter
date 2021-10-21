<?php

use Floo\DxAdapter\DxAdapter;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Floo\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = new Request();
});

test('can load query with method statis DxAdapter::load()', function () {
    $instance = DxAdapter::load(TestModel::query());
    expect($instance)->toBeInstanceOf(DxAdapter::class);
});

test('can load query with method statis DxAdapter::for()', function () {
    $instance = DxAdapter::for(TestModel::class);
    expect($instance)->toBeInstanceOf(DxAdapter::class);
});

test('can initializeQueryModel', function () {
    $dxAdapter = new DxAdapter(TestModel::query());
    expect($dxAdapter->query)->toBeInstanceOf(EloquentBuilder::class);
});

test('can initializeRequest', function () {
    $dxAdapter = new DxAdapter(TestModel::query(), $this->request);
    expect($dxAdapter->request)->toBeInstanceOf(Request::class);
});

test('can process query builder', function () {
    $dxAdapter = new DxAdapter(TestModel::query());
    expect($dxAdapter->process())->toBeInstanceOf(EloquentBuilder::class);
});

test('can use eloquest method by magic method __call()', function () {
    $dxAdapter = DxAdapter::load(TestModel::query(), $this->request)->get();
    $expextation = TestModel::get();

    expect($dxAdapter)->toEqual($expextation);
});

test('can use params into eloquest method by magic method __call()', function () {
    $dxAdapter = DxAdapter::load(TestModel::query(), $this->request)->get('name');
    $expextation = TestModel::get('name');

    expect($dxAdapter)->toEqual($expextation);
});
