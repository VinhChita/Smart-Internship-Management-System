<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::withCount('programs')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        return response()->json(Company::create($this->validated($request)), 201);
    }

    public function update(Request $request, Company $company)
    {
        $company->update($this->validated($request));

        return response()->json($company);
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return response()->json(['message' => 'Deleted']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email',
            'contact_phone' => 'nullable|string|max:30',
            'website' => 'nullable|string|max:255',
        ]);
    }
}
