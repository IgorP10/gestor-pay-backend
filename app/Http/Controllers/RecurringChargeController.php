<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\RecurringCharge;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecurringChargeRequest;

class RecurringChargeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'organization_id' => 'nullable|exists:organizations,id',
            'active' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $query = RecurringCharge::query()
            ->when($request->organization_id, fn($q) => $q->where('organization_id', $request->organization_id))
            ->when(!is_null($request->active), fn($q) => $q->where('active', $request->boolean('active')))
            ->whereIn('organization_id', auth()->user()->organizations->pluck('id'));

        return $query->paginate($request->input('per_page', 15));
    }

    public function store(StoreRecurringChargeRequest $request)
    {
        $organization = Organization::findOrFail($request->organization_id);

        if (!$organization->users->contains(auth()->id())) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        $recurringCharge = RecurringCharge::create($request->validated());

        return response()->json($recurringCharge, 201);
    }

    public function show($id)
    {
        $charge = RecurringCharge::findOrFail($id);

        if (!$charge->organization->users->contains(auth()->id())) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        return $charge;
    }

    public function update(StoreRecurringChargeRequest $request, $id)
    {
        $charge = RecurringCharge::findOrFail($id);

        if (!$charge->organization->users->contains(auth()->id())) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        $charge->update($request->validated());

        return $charge;
    }

    public function destroy($id)
    {
        $charge = RecurringCharge::findOrFail($id);

        if (!$charge->organization->users->contains(auth()->id())) {
            return response()->json(['message' => 'Acesso negado.'], 403);
        }

        $charge->delete();

        return response()->noContent();
    }
}
