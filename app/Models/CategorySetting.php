<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySetting extends Model
{
    protected $fillable = [
        'original_category_name',
        'main_category_id',
        'custom_name',
        'is_active',
        'sort_order'
    ];

    public function mainCategory()
    {
        return $this->belongsTo(MainCategory::class);
    }
}
