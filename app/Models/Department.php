<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // <-- Import trait

class Department extends Model
{
    use HasFactory, SoftDeletes; // <-- Masukkan SoftDeletes

    protected $fillable = ['name'];

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
}