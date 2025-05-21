<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrganizationRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class OrganizationController extends Controller
{
    public function index(): Collection
    {
        return Organization::all();
    }

    public function store(StoreOrganizationRequest $request): Organization
    {
        $organization = Organization::create($request->validated());
        $organization->users()->attach($request->user()->id);
        return $organization;
    }

    public function update(StoreOrganizationRequest $request, Organization $organization): Organization
    {
        $organization->update($request->validated());
        return $organization;
    }

    public function destroy(Organization $organization): Response
    {
        $organization->delete();
        return response()->noContent();
    }

    public function share(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $organization = Organization::findOrFail($id);

        if (!$organization->users->contains(auth()->id())) {
            return response()->json(['message' => 'Você não tem permissão para compartilhar esta organização'], 403);
        }

        $organization->users()->syncWithoutDetaching($request->user_id);

        return response()->json(['message' => 'Organização compartilhada com sucesso']);
    }
}
