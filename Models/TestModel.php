<?php

namespace GhoniJee\DxAdapter\Models;

use Database\Factories\TestModelFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TestModel extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $guarded = [];

    public static function createWithNameAndLastName(string $name, $lastName): self
    {
        return static::create([
            'name' => $name,
            'last_name' => $lastName,
        ]);
    }

    public static function createWithNameAndLastNameAndGenderAndStatus(string $name, string $lastName, string $gender, bool $active): self
    {
        return static::create([
            'name' => $name,
            'last_name' => $lastName,
            'gender' => $gender,
            'active' => $active,
        ]);
    }

    public function comments()
    {
        return $this->hasMany(TestComment::class, 'test_model_id');
    }

    public function scopeActive(Builder $query)
    {
        $query->where('active', 1);
    }
}
