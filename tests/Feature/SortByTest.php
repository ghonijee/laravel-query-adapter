<?php

use GhoniJee\DxAdapter\DxAdapter;
use GhoniJee\DxAdapter\Models\TestComment;
use GhoniJee\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = Request::create('/test');
});

test('can build query adapter with orderBy field name', function () {
    $sort = ['desc' => false, 'selector' => 'name'];

    $this->request->replace(['sort' => $sort]);

    $query = DxAdapter::for(TestModel::class, $this->request)->toSql();
    $queryExpectation = TestModel::orderBy('name')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query adapter with orderBy ASC', function () {
    $sort = ['desc' => false, 'selector' => 'name'];

    $this->request->replace(['sort' => $sort]);

    $query = DxAdapter::for(TestModel::class, $this->request)->toSql();
    $queryExpectation = TestModel::orderBy('name', 'asc')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query adapter with orderBy Desc', function () {
    $sort = ['desc' => true, 'selector' => 'name'];

    $this->request->replace(['sort' => $sort]);

    $query = DxAdapter::for(TestModel::class, $this->request)->toSql();
    $queryExpectation = TestModel::orderBy('name', 'desc')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query adapter with multiple order field', function () {
    $sort = [['desc' => true, 'selector' => 'name'], ['desc' => false, 'selector' => 'created_at']];

    $this->request->replace(['sort' => $sort]);

    $query = DxAdapter::for(TestModel::class, $this->request)->toSql();
    $queryExpectation = TestModel::orderBy('name', 'desc')->orderBy('created_at')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query for select and orderBy DESC', function () {
    $sort = ['desc' => true, 'selector' => 'name'];
    $select = ['name', 'active'];

    $this->request->replace(['sort' => $sort, 'select' => $select]);

    $query = DxAdapter::for(TestModel::class, $this->request)->toSql();
    $queryExpectation = TestModel::select($select)->orderBy('name', 'desc')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query for order by relation fieldname with select', function () {
    $sort = ['desc' => true, 'selector' => 'test.name'];
    $select = ['test_model_id', 'comment'];

    $this->request->replace(['sort' => $sort, 'select' => $select]);

    $result = DxAdapter::load(TestComment::query()->with('test'), $this->request)->get();
    $expected = TestComment::select(['comment', 'test_model_id'])->with('test')->orderBy(
        TestModel::select('name')->whereColumn('test_models.id', 'test_comments.test_model_id')
    )->get();
    expect($result)->toEqual($expected);
});

test('can build query for order by relation fieldname without select', function () {
    $sort = ['desc' => true, 'selector' => 'test.name'];

    $this->request->replace(['sort' => $sort]);

    $result = DxAdapter::for(TestComment::class, $this->request)->first();
    $expected = TestComment::where('id', 4)->first();
    expect($result)->toEqual($expected);
});
