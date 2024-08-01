<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class GeneralContentList extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'general_content_lists';

    protected $fillable = [
        'nama',
        'page_id',
    ];

    // relasi ke pages
    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
}
