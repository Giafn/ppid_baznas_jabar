<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KantorLayanan extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'kantor_dan_layanan_ppid';

    protected $guarded = [];
}
