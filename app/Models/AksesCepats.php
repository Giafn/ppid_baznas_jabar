<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AksesCepats extends Model
{
    use HasFactory;use HasFactory, HasUuids;

    protected $table = 'akses_cepats';

    protected $guarded = [];

    public function page()
    {
        return $this->belongsTo(CustomPage::class, 'page_id');
    }
}
