<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    public  $timestamps = false;
    public $primaryKey = 'code';

    public function scopeProvince()
    {
        return $this->where('parent_code', 0);
    }

    public function scopeCity()
    {
        return $this->where('parent_code', '<=',35);
    }

    public function scopeDistrict()
    {
        return $this->where('parent_code', '>',35);
    }

    public function parent()
    {
        return $this->belongsTo(Region::class, 'parent_code','code');
    }

    public function children()
    {
        return $this->hasMany(Region::class, 'parent_code','code');
    }

    public function brothers()
    {
        return $this->parent->children();
    }

    public static function options($id)
    {
        if (! $self = static::find($id)) {
            return [];
        }

        return $self->brothers()->pluck('name', 'code');
    }
}