<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    protected $fillable = ['name', 'icon', 'sort_order', 'is_active'];

    public function categorySettings()
    {
        return $this->hasMany(CategorySetting::class);
    }
}
