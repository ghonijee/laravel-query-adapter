<?php

namespace GhoniJee\DxAdapter\Tests;

use GhoniJee\DxAdapter\Models\TestComment;
use GhoniJee\DxAdapter\Models\TestModel;
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
        $this->usesMySqlConnection($app);

        Schema::dropAllTables();

        $this->createTestModel();

        $this->createTestComment();
    }

    protected function usesMySqlConnection(Application $app)
    {
        $app->config->set('database.default', 'mysql');
        $app->config->set('database.connections.mysql.host', $_ENV['DB_HOST']);
        $app->config->set('database.connections.mysql.port', $_ENV['DB_PORT']);
        $app->config->set('database.connections.mysql.database', $_ENV['DB_DATABASE']);
        $app->config->set('database.connections.mysql.username', $_ENV['DB_USERNAME']);
        if (isset($_ENV['DB_PASSWORD'])) {
            $app->config->set('database.connections.mysql.password', $_ENV['DB_PASSWORD']);
        }
        $app->config->set('dx-adapter.request.filter', 'filter');
        $app->config->set('dx-adapter.request.select', 'select');
        $app->config->set('dx-adapter.request.order', 'sort');
        $app->config->set('dx-adapter.request.skip', 'skip');
        $app->config->set('dx-adapter.request.take', 'take');
        $app->config->set('dx-adapter.query.contains', 'like');
    }

    protected function getPackageProviders($app)
    {
        return [
            'GhoniJee\\DxAdapter\\DxAdapterServiceProvider',
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            "QueryAdapter" => "GhoniJee\\DxAdapter\\QueryAdapter"
        ];
    }

    protected function createTestModel()
    {
        Schema::create('test_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });

        $data = [
            [
                'name' => "Jee",
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
    }

    protected function createTestComment()
    {
        Schema::create('test_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('test_model_id');
            $table->string('comment')->nullable();
            $table->timestamps();
        });

        $comment = [
            [
                'test_model_id' => 1,
                'comment' => "ccc"
            ],
            [
                'test_model_id' => 3,
                'comment' => "ddd"
            ],
            [
                'test_model_id' => 1,
                'comment' => "bbb"
            ],
            [
                'test_model_id' => 2,
                'comment' => "aaa"
            ],
            [
                'test_model_id' => 1,
                'comment' => "eee"
            ],
            [
                'test_model_id' => 2,
                'comment' => "ffff"
            ],
            [
                'test_model_id' => 3,
                'comment' => "gggg"
            ]
        ];
        TestComment::insert($comment);
    }
}
