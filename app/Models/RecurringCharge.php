<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecurringCharge extends Model
{
    protected $fillable = [
        'organization_id',
        'description',
        'amount',
        'due_day',
        'active',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
