<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'link', 'parent_id', 'sort', 'class',
        'menu_id', 'depth', 'role_id', 'target', 'icon', 'status'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // Recursive relationship for nested menus
    public function children()
    {
        return $this->hasMany(MenuItem::class, 'parent_id')
            ->where('status', 1)
            ->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }
}
