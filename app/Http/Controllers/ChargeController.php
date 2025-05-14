<?php

namespace App\Http\Controllers;

use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChargeRequest;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $query = Charge::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return $query->with('organization')->get();
    }

    public function store(StoreChargeRequest $request)
    {
        return Charge::create($request->validated());
    }

    public function update(StoreChargeRequest $request, Charge $charge)
    {
        $charge->update($request->validated());
        return $charge;
    }

    public function destroy(Charge $charge)
    {
        $charge->delete();
        return response()->noContent();
    }
}
