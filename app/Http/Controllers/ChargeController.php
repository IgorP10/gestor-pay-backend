<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateChargeRequest;
use App\Models\Charge;
use Illuminate\Http\Request;
use App\Http\Requests\StoreChargeRequest;

class ChargeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'status' => 'nullable|in:paid,pending',
            'organization_id' => 'nullable|exists:organizations,id',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Charge::query()
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->organization_id, fn($q) => $q->where('organization_id', $request->organization_id));

        return $query->with('organization')->paginate($request->input('per_page', 15));
    }

    public function store(StoreChargeRequest $request)
    {
        return Charge::create($request->validated());
    }

    public function update(UpdateChargeRequest $request, Charge $charge)
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
