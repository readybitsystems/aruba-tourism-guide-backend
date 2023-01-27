<?php

namespace App\Models;

use App\Concerns\Flagable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
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

            return url('/') . '/public/assets/tours/' . $this->id . '/' . $this->image;
        }
        return null;
    }

    public function places()
    {
        return $this->hasMany(Place::class, 'tour_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id')->withTrashed();
    }
}
