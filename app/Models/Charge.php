<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_id',
        'description',
        'amount',
        'due_date',
        'status',
        'payment_date'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
