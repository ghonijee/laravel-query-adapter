<?php

use GhoniJee\DxAdapter\DxAdapter;
use GhoniJee\DxAdapter\Models\TestComment;
use GhoniJee\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = new Request();
});

test('can build query to select field table', function () {
    $select = ['name', 'active'];

    $this->request->replace(['select' => $select]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::select($select)->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can build query to select relation field table', function () {
    $select = ['comments.comment', 'comments.test_model_id', 'id', 'active'];

    $this->request->replace(['select' => $select]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->get();
    $queryExpectation = TestModel::with(['comments' => function ($q) {
        $q->select('test_model_id', 'comment');
    }])->select(['id', 'active'])->get();

    expect($query)->toEqual($queryExpectation);
});
