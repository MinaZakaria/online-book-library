<?php

namespace App\Models;

use App\Models\Traits\SupportCamelCaseProps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, SupportCamelCaseProps;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
