<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlideLanding extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'slide_landings';

    protected $guarded = [];
}
