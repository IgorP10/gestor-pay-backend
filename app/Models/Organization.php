<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function charges()
    {
        return $this->hasMany(Charge::class);
    }
}
