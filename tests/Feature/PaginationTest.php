<?php

use GhoniJee\DxAdapter\DxAdapter;
use GhoniJee\DxAdapter\Models\TestComment;
use GhoniJee\DxAdapter\Models\TestModel;
use Illuminate\Http\Request;

beforeEach(function () {
    $this->request = Request::create('/test');
});

test('can build query get data with pagination with sortBy', function () {
    $sort = ['desc' => false, 'selector' => 'comment'];

    $this->request->replace(['sort' => $sort, 'skip' => 2, "take" => 2]);

    $query = DxAdapter::for(TestComment::class, $this->request)->paginate(2);
    $queryExpectation = TestComment::orderBy('comment')->paginate(2);

    expect($this->request->all())->toHaveKey('page', 2);
    expect($query)->toEqual($queryExpectation);
});

test('can build query get data with pagination', function () {
    $this->request->replace(['skip' => 2, "take" => 2]);

    $query = DxAdapter::for(TestComment::class, $this->request)->paginate(2);
    $queryExpectation = TestComment::paginate(2);

    expect($this->request->all())->toHaveKey('page', 2);
    expect($query)->toEqual($queryExpectation);
});
