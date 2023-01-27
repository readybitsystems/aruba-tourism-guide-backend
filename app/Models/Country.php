<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use Flagable, SoftDeletes;

    public const FLAG_ACTIVE = 1;

    protected $hidden = [
        'flags',
        'image'
    ];

    protected $appends    = ['active', 'image_url'];


    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {

            return url('/') . '/public/assets/countries/' . $this->id . '/' . $this->image;
        }
        return null;
    }

    public function tours()
    {
        return $this->hasMany(Tour::class, 'country_id');
    }
}
