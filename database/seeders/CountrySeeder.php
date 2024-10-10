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

        // Читання JSON-файлу з основними даними про країни
        $json = File::get(database_path('seeders/countries-codes.json'));
        $countries = json_decode($json, true);

        $this->command->info('Total countries fetched: ' . count($countries));

        // Читання JSON-файлу з телефонними кодами
        $phoneCodesJson = File::get(database_path('seeders/countries-phone-codes.json'));
        $phoneCodes = json_decode($phoneCodesJson, true);

        // Читання JSON-файлу з мовами та валютами
        $langCurrencyJson = File::get(database_path('seeders/languages-currencyISO.json'));
        $langCurrencyData = json_decode($langCurrencyJson, true);

        // Створення асоціативних масивів для швидкого пошуку
        $phoneCodeMap = array_column($phoneCodes, 'dial_code', 'code');
        $langCurrencyMap = array_column($langCurrencyData, null, 'code');

        foreach ($countries as $country) {
            $iso2Code = $country['iso2_code'];

            $languagesAndCurrencies = $langCurrencyMap[$iso2Code] ?? null;

            Country::updateOrCreate(
                ['iso2_code' => $iso2Code],
                [
                    'name' => $country['label_en'],
                    'alpha2' => $iso2Code,
                    'alpha3' => $country['iso3_code'],
                    'country_code' => $country['onu_code'],
                    'is_ilo_member' => $country['is_ilomember'],
                    'official_lang_code' => $country['official_lang_code'],
                    'is_receiving_quest' => $country['is_receiving_quest'],
                    'geo_point_2d' => $country['geo_point_2d'],
                    'phone_code' => $phoneCodeMap[$iso2Code] ?? null,
                    'languages' => $languagesAndCurrencies['languages'] ?? [],
                    'currencies' => $languagesAndCurrencies['currencysISO'] ?? [],
                ]
            );
        }

        $this->command->info('All countries data has been fetched and saved.');
    }
}
