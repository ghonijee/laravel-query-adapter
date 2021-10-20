<?php

namespace Floo\DxAdapter\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function test()
    {
        return $this->belongsTo(TestModel::class);
    }
}
