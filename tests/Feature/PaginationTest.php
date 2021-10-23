<?php

use GhoniJee\DxAdapter\DxAdapter;
use GhoniJee\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = Request::create('/test');
});

test('can build query get data with pagination', function () {
    $sort = ['desc' => false, 'selector' => 'name'];

    $this->request->replace(['sort' => $sort]);

    $query = DxAdapter::for(TestModel::class, $this->request)->paginate();
    $queryExpectation = TestModel::orderBy('name')->paginate();

    expect($query)->toEqual($queryExpectation);
});
