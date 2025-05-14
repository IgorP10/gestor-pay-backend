<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrganizationRequest;

class OrganizationController extends Controller
{
    public function index()
    {
        return Organization::all();
    }

    public function store(StoreOrganizationRequest $request)
    {
        return Organization::create($request->validated());
    }

    public function update(StoreOrganizationRequest $request, Organization $organization)
    {
        $organization->update($request->validated());
        return $organization;
    }

    public function destroy(Organization $organization)
    {
        $organization->delete();
        return response()->noContent();
    }
}
