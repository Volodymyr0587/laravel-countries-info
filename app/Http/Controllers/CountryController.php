<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('alpha2', 'like', "%{$search}%")
                  ->orWhere('alpha3', 'like', "%{$search}%")
                  ->orWhere('phone_code', 'like', "%{$search}%")
                  ->orWhere('currencies', 'like', "%{$search}%");
        }

        // if ($request->has('is_ilo_member')) {
        //     $query->where('is_ilo_member', $request->input('is_ilo_member'));
        // }

        // if ($request->has('official_lang_code')) {
        //     $query->where('official_lang_code', $request->input('official_lang_code'));
        // }

        $countries = $query->orderBy('name')->paginate(15);

        // $languages = Country::distinct('official_lang_code')->pluck('official_lang_code')->filter();

        return view('countries.index', compact('countries'));
    }
}
