<?php

namespace Floo\DxAdapter\Tests;

use Floo\DxAdapter\Models\TestComment;
use Floo\DxAdapter\Models\TestModel;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    protected function setUpDatabase(Application $app)
    {
        $this->usesMySqlConnection($this->app);

        Schema::dropAllTables();

        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        Schema::create('test_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('test_model_id');
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        $data = [
            [
                'name' => "Ahmad",
                'last_name' => "Yunus",
                'address' => "Jl. Pendidikan",
                'gender' => "L",
                'active' => true
            ],
            [
                'name' => "Ahmad",
                'last_name' => "Ghoni",
                'address' => "Jl. Pendidikan 2",
                'gender' => "L",
                'active' => false
            ],
            [
                'name' => "Yunus",
                'last_name' => "Ghoni",
                'address' => "Jl. Pendidikan 3",
                'gender' => "L",
                'active' => false
            ]
        ];

        TestModel::insert($data);

        $comment = [
            [
                'test_model_id' => 1,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 3,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 1,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 2,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 1,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 2,
                'comment' => "hahsdhshadas"
            ],
            [
                'test_model_id' => 3,
                'comment' => "hahsdhshadas"
            ]
        ];
        TestComment::insert($comment);
    }

    protected function usesMySqlConnection(Application $app)
    {
        $app->config->set('database.default', 'mysql');
        $app->config->set('database.connections.mysql.database', 'test_package');
        $app->config->set('database.connections.mysql.username', 'root');
        $app->config->set('database.connections.mysql.password', 'asd1234!');
        $app->config->set('dx-adapter.request.filter', 'filter');
        $app->config->set('dx-adapter.request.select', 'select');
        $app->config->set('dx-adapter.request.order', 'order');
        $app->config->set('dx-adapter.query.contains', 'LIKE');
    }
}