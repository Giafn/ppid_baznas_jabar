<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomPage extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'custom_page';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(CategoryPage::class, 'category_page_id');
    }

    public function items()
    {
        return $this->hasMany(ItemsCustom::class, 'custom_page_id');
    }
}
