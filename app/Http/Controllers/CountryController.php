<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('alpha2', 'like', "%{$search}%")
                  ->orWhere('alpha3', 'like', "%{$search}%")
                  ->orWhere('phone_code', 'like', "%{$search}%")
                  ->orWhere('currencies', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_ilo_member')) {
            $query->where('is_ilo_member', $request->is_ilo_member);
        }

        if ($request->filled('is_receiving_quest')) {
            $query->where('is_receiving_quest', $request->is_receiving_quest);
        }

        $countries = $query->orderBy('name')->paginate(10);

        // Persist request parameters across pagination links
        $countries->appends($request->all());

        return view('countries.index', compact('countries'));
    }
}
