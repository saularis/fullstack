<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $hidden = ['id', 'user_id','created_at'];

    /**
     * Get the updated_at attribute as a human-readable string.
     *
     * @return string
     */
    public function getUpdatedAtAttribute($value)
    {
        return $this->attributes['updated_at'] = now()
            ->createFromTimeString($value)
            ->diffForHumans();
    }
}
