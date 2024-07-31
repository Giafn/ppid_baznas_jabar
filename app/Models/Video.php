<?php

namespace App\Models;

use Cohensive\OEmbed\Facades\OEmbed;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'videos';

    protected $guarded = [];

    // buat aksessor untuk merubah video_url menjadi embed
    public function getVideoUrlAttribute($value)
    {
        $embed = OEmbed::get($value);
        if ($embed) {
            return $embed->html();
        }

        return `
            <div class="w-100 d-flex align-items-center justify-content-center" style="width: 315px">
                <p>Asuuu</p>
            </div>
        `;
    }

    public function getOriginalVideoUrlAttribute()
    {
        return $this->attributes['video_url'];
    }
}
