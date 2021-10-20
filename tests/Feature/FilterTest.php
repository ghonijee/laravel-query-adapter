<?php

use Floo\DxAdapter\DxAdapter;
use Floo\DxAdapter\Models\TestComment;
use Floo\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

test('table test model has 3 data', function () {
    $data = TestModel::all();

    $this->assertCount(3, $data);
});

test('table test comment has 7 data', function () {
    $data = TestComment::all();

    $this->assertCount(7, $data);
});

test('can get data with single filter', function () {
    $request = new Request();
    $filter = ['name', 'contains', 'ahmad'];
    $request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $request)->get();

    $this->assertCount(2, $data);
    expect($data)->toHaveCount(2);
});

test('can multi filter with conjungtion AND', function () {
    $request = new Request();
    $filter = [['name', 'contains', 'ahmad'], 'and', ['active', '=', 0]];
    $request->replace(['filter' => $filter]);

    $query = TestModel::query();

    $data = DxAdapter::load($query, $request)->get();

    // $this->assertCount(1, $data);
    expect($data)->toHaveCount(1);
});
