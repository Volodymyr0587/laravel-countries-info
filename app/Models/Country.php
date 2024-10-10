<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'alpha2',
        'alpha3',
        'country_code',
        'iso2_code',
        'phone_code',
        'is_ilo_member',
        'official_lang_code',
        'is_receiving_quest',
        'geo_point_2d',
        'phone_code',
        'languages',
        'currencies',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'geo_point_2d' => 'array',
            'languages' => 'array',
            'currencies' => 'array',
        ];
    }
}
