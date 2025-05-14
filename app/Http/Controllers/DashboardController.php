<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use App\Models\Organization;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary()
    {
        return response()->json([
            'total_paid' => Charge::where('status', 'paid')->sum('amount'),
            'total_pending' => Charge::where('status', 'pending')->sum('amount'),
            'total_organizations' => Organization::count(),
        ]);
    }
}
