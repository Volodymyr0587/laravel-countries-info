<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Fetching all countries data...');

        // Читання JSON-файлу з даними
        $json = File::get(database_path('seeders/countries-codes.json'));

        $countries = json_decode($json, true);

        $this->command->info('Total countries fetched: ' . count($countries));

        foreach ($countries as $country) {
            Country::updateOrCreate(
                ['iso2_code' => $country['iso2_code']],
                [
                    'name' => $country['label_en'],
                    'alpha2' => $country['iso2_code'],
                    'alpha3' => $country['iso3_code'],
                    'country_code' => $country['onu_code'],
                    'iso2_code' => $country['iso2_code'],
                    'is_ilo_member' => $country['is_ilomember'],
                    'official_lang_code' => $country['official_lang_code'],
                    'is_receiving_quest' => $country['is_receiving_quest'],
                    'geo_point_2d' => json_encode($country['geo_point_2d']),
                ]
            );
        }

        // Add phone codes
        // Read phone codes data
        $phoneCodesJson = File::get(database_path('seeders/countries-phone-codes.json'));
        $phoneCodes = json_decode($phoneCodesJson, true);

        // Match phone codes with existing countries
        foreach ($phoneCodes as $phoneCode) {
            $country = Country::where('iso2_code', $phoneCode['code'])->first();

            if ($country) {
                $country->phone_code = $phoneCode['dial_code'];
                $country->save();
            }
        }

        $this->command->info('All countries data has been fetched and saved.');
    }
}
