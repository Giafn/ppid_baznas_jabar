<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiPublikItems extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'informasi_publik_items';

    protected $fillable = [
        'golongan',
        'group',
        'nama',
        'type',
        'url',
        'page_id',
    ];

    // relasi ke pages
    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id');
    }
}
