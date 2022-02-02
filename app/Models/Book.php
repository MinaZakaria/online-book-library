<?php

namespace App\Models;

use App\Models\Traits\SupportCamelCaseProps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, SupportCamelCaseProps;

    protected $fillable = ['name', 'author', 'categoryId'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
