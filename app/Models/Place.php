<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends Model
{
    use Flagable, SoftDeletes;

    public const FLAG_ACTIVE = 1;

    protected $hidden = [
        'flags',
        'image',
        'video'
    ];

    protected $appends    = ['active', 'image_url','video_url', 'audio_url'];

    public function getActiveAttribute()
    {
        return ($this->flags & self::FLAG_ACTIVE) == self::FLAG_ACTIVE;
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {

            return url('/') . '/public/assets/places/' . $this->id . '/' . $this->image;
        }
        return null;
    }

    public function getVideoUrlAttribute()
    {
        if ($this->video) {

            return url('/') . '/public/assets/places/' . $this->id . '/' . $this->video;
        }
        return null;
    }

    public function getAudioUrlAttribute()
    {
        if ($this->audio) {

            return url('/') . '/public/assets/places/' . $this->id . '/' . $this->audio;
        }
        return null;
    }

    public function placeImages()
    {
        return $this->hasMany(PlaceImage::class, 'place_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function tour()
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id')->withTrashed();
    }
}
