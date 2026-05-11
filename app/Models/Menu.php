<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort');
    }

    // Eager load only top-level items with recursive children
    public function rootItems()
    {
        return $this->hasMany(MenuItem::class)
            ->where('parent_id', 0)
            ->where('status', 1)
            ->orderBy('sort');
    }
}
