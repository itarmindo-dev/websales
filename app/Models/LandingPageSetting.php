<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LandingPageSetting extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'locations' => 'array',
            'tco_enabled' => 'boolean',
            'tco_benefits' => 'array',
            'models_enabled' => 'boolean',
            'testimonials_enabled' => 'boolean',
            'service_promises' => 'array',
            'contact_enabled' => 'boolean',
            'dealer_benefits' => 'array',
        ];
    }
}
