<?php

use GhoniJee\DxAdapter\DxAdapter;
use GhoniJee\DxAdapter\Models\TestComment;
use GhoniJee\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = new Request();
});

test('can filter where like', function () {
    $filter = ['name', 'contains', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'like', '%ahmad%')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where not like', function () {
    $filter = ['name', 'notcontains', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'not like', '%ahmad%')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where startswith like%', function () {
    $filter = ['name', 'startswith', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'like', 'ahmad%')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where endswith %like', function () {
    $filter = ['name', 'endswith', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'like', '%ahmad')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where equals (=)', function () {
    $filter = ['name', '=', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'ahmad')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where not equals (!=)', function () {
    $filter = ['name', '!=', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', '!=', 'ahmad')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter where <>', function () {
    $filter = ['name', '<>', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', '<>', 'ahmad')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter string data', function () {
    $filter = ['name', 'contains', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('name', 'like', '%ahmad%')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter numeric data', function () {
    $filter = ['active', '=', '0'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('active', 0)->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter date data', function () {
    $filter = ['created_at', '=', '2021-10-12'];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();
    $queryExpectation = TestModel::where('created_at', '=', '2021-10-12')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter boolean data', function () {
    $filter = ['active', '=', true];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();

    $queryExpectation = TestModel::where('active', true)->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter with null data', function () {
    $filter = ['active', '=', NULL];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();

    $queryExpectation = TestModel::whereNull('active')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter with not null data', function () {
    $filter = ['active', '!=', null];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();

    $queryExpectation = TestModel::whereNotNull('active')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter multiple null data', function () {
    $filter = [['active', '!=', null], 'or', ['nama', '=', null]];

    $this->request->replace(['filter' => $filter]);

    $query = DxAdapter::load(TestModel::query(), $this->request)->toSql();

    $queryExpectation = TestModel::whereNotNull('active')->orWhereNull('nama')->toSql();

    expect($query)->toEqual($queryExpectation);
});

test('can filter data with single condition', function () {
    $filter = ['name', 'contains', 'ahmad'];

    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $this->request)->get();
    $expect = TestModel::where('name', 'like', 'ahmad')->get();

    expect($data)->toEqual($expect);
});

test('can multi filter with conjungtion AND', function () {
    $filter = [['name', 'contains', 'ahmad'], 'and', ['active', '=', 0]];
    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $this->request);
    $query = $data->toSql();
    $queryExpectation = TestModel::where('name', 'like', '%ahmad%')->where('active', 0)->toSql();
    expect($query)->toEqual($queryExpectation);
    expect($data->get())->toHaveCount(1);
});

test('can multi filter with conjungtion OR', function () {
    $filter = [['name', 'contains', 'ahmad'], 'or', ['active', '=', 0]];
    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $this->request)->toSql();
    $expected = TestModel::where('name', 'like', 'ahmad')->orWhere('active', 0)->toSql();

    expect($data)->toEqual($expected);
});

test('can multi filter with conjungtion NOT', function () {
    $filter = [['name', 'contains', 'ahmad'], '!', ['active', '=', 0]];
    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $this->request)->toSql();
    $expected = TestModel::where('name', 'like', 'ahmad')->whereNot('active', 1)->toSql();

    expect($data)->toEqual($expected);
});

test('can filter data with grouping condition', function () {
    $filter = [['name', 'contains', 'ahmad'], 'and', [['active', '=', 0], 'or', ['active', '=', 1]]];
    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();
    $queryBuilder = DxAdapter::load($query, $this->request)->toSql();
    $expected = TestModel::where('name', 'like', 'ahmad')->where(function ($q) {
        $q->where('active', 0);
        $q->orWhere('active', 1);
    })->toSql();

    expect($queryBuilder)->toEqual($expected);
});

test('can filter data with relations condition', function () {
    $filter = [['comments.comment', 'contains', 'test'], 'and', [['active', '=', 0], 'or', ['active', '=', 1]]];
    $this->request->replace(['filter' => $filter]);

    $query = TestModel::query();
    $queryBuilder = DxAdapter::load($query, $this->request)->toSql();
    $expected = TestModel::whereHas('comments', function ($queryComment) {
        $queryComment->where('comment', 'like', 'ahmad');
    })->where(function ($q) {
        $q->where('active', 0);
        $q->orWhere('active', 1);
    })->toSql();

    expect($queryBuilder)->toEqual($expected);
});


test('can filter multi relation data with conjungtion OR', function () {
    $filter = [[['dataComments.comment', 'contains', 'test'], 'or', ['dataComments.comment', 'contains', 'est']], 'and', ['active', '=', 1]];
    $this->request->replace(['filter' => json_encode($filter)]);

    $query = TestModel::query();
    $queryBuilder = DxAdapter::load($query, $this->request)->toSql();

    $expected = TestModel::where(function ($q) {
        $q->whereHas('dataComments', function ($queryComment) {
            $queryComment->where('comment', 'like', 'test');
        })->orWhereHas('dataComments', function ($queryCommentNew) {
            $queryCommentNew->where('comment', 'like', 'est');
        });
    })->where('active', 1)->toSql();

    expect($queryBuilder)->toEqual($expected);
});
test('can filter multi relation data with conjungtion AND', function () {
    $filter = [[['dataComments.comment', 'contains', 'test'], 'and', ['dataComments.comment', 'contains', 'est']], 'and', ['active', '=', 1]];
    $this->request->replace(['filter' => json_encode($filter)]);

    $query = TestModel::query();
    $queryBuilder = DxAdapter::load($query, $this->request)->toSql();

    $expected = TestModel::where(function ($q) {
        $q->whereHas('dataComments', function ($queryComment) {
            $queryComment->where('comment', 'like', 'test');
        })->whereHas('dataComments', function ($queryCommentNew) {
            $queryCommentNew->where('comment', 'like', 'est');
        });
    })->where('active', 1)->toSql();

    expect($queryBuilder)->toEqual($expected);
});
test('can filter multi relation data with conjungtion NOT', function () {
    $filter = [[['dataComments.comment', 'contains', 'test'], '!', ['dataComments.comment', 'contains', 'est']], 'and', ['active', '=', 1]];
    $this->request->replace(['filter' => json_encode($filter)]);

    $query = TestModel::query();
    $queryBuilder = DxAdapter::load($query, $this->request)->toSql();

    $expected = TestModel::where(function ($q) {
        $q->whereHas('dataComments', function ($queryComment) {
            $queryComment->where('comment', 'like', 'test');
        })->whereDoesntHave('dataComments', function ($queryCommentNew) {
            $queryCommentNew->where('comment', 'like', 'est');
        });
    })->where('active', 1)->toSql();

    expect($queryBuilder)->toEqual($expected);
});
