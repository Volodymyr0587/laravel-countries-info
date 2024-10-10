<!-- resources/views/countries/index.blade.php -->
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Countries</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-gray-100">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-3xl font-bold mb-6">
                <a href="{{ route('countries.index') }}" class="text-blue-500 hover:underline">Countries</a>
            </h1>

            <form action="{{ route('countries.index') }}" method="GET" class="mb-6">
                <input type="text" name="search" placeholder="Search..." class="p-2 border rounded"
                    value="{{ request('search') }}">
                <select name="is_ilo_member" class="p-2 border rounded">
                    <option value="">ILO Membership</option>
                    <option value="Y" {{ request('is_ilo_member') == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ request('is_ilo_member') == 'N' ? 'selected' : '' }}>No</option>
                </select>
                <select name="is_receiving_quest" class="p-2 border rounded">
                    <option value="">Receiving guests</option>
                    <option value="Y" {{ request('is_receiving_quest') == 'Y' ? 'selected' : '' }}>Yes</option>
                    <option value="N" {{ request('is_receiving_quest') == 'N' ? 'selected' : '' }}>No</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Search</button>
            </form>

            <table class="w-full bg-white shadow-md rounded">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Flag</th>
                        <th class="py-3 px-6 text-left">Name</th>
                        <th class="py-3 px-6 text-left">Alpha-2</th>
                        <th class="py-3 px-6 text-left">Alpha-3</th>
                        <th class="py-3 px-6 text-left">Country Code</th>
                        <th class="py-3 px-6 text-left">Phone Code</th>
                        <th class="py-3 px-6 text-left">Currencies</th>
                        <th class="py-3 px-6 text-left">ILO Member</th>
                        <th class="py-3 px-6 text-left">Official Languages</th>
                        <th class="py-3 px-6 text-left">Receiving Guest</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    @foreach($countries as $country)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">
                            <x-icon name="flag-country-{{ Str::lower($country->iso2_code) }}" />
                        </td>
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $country->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $country->alpha2 }}</td>
                        <td class="py-3 px-6 text-left">{{ $country->alpha3 }}</td>
                        <td class="py-3 px-6 text-left">{{ $country->country_code }}</td>
                        <td class="py-3 px-6 text-left">{{ $country->phone_code }}</td>
                        <td class="py-3 px-6 text-left">
                            @if(is_array($country->currencies) && !empty($country->currencies))
                            <ul>
                                @foreach($country->currencies as $currency)
                                <li>{{ $currency }}</li>
                                @endforeach
                            </ul>
                            @else
                            No currencies available
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">{{ $country->is_ilo_member }}</td>
                        <td class="py-3 px-6 text-left">
                            @if(is_array($country->languages) && !empty($country->languages))
                            <ul>
                                @foreach($country->languages as $language)
                                <li>{{ $language }}</li>
                                @endforeach
                            </ul>
                            @else
                            No languages available
                            @endif
                        </td>
                        <td class="py-3 px-6 text-left">{{ $country->is_receiving_quest }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6 grid grid-cols-2 gap-10">
                {{ $countries->links() }}
            </div>
        </div>
    </body>

</html>
