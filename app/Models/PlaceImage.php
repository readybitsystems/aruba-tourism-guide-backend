<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;

class PlaceImage extends Model
{
    use Flagable;

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
        if ($this->place_image) {

            return url('/') . '/public/assets/placeImages/' . $this->place_id . '/' .$this->place_image;
        }
        return null;
    }

    public function place(){
        return $this->belongsTo(Place::class,'place_id','id')->withTrashed();
    }
}
