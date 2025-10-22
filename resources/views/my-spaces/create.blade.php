<x-layout>
    <div class="mx-auto mt-10 max-w-2xl">
        <x-breadcrumbs :links="['My Spaces' => route('my-space.index'), 'Create' => '#']" class="mb-4" />

        <x-card class="mb-8 mt-8">
            <form action="{{ route('my-space.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Postcode --}}
                <div class="mb-4 relative">
                    <x-label for="postcode" :required="true">Postcode</x-label>
                    <input type="text" id="postcode" name="postcode" placeholder="Enter UK postcode" autocomplete="off" class="w-full rounded-md px-2 py-1" />
                    <ul id="postcode-suggestions" 
                        class="absolute bg-white border w-full mt-1 rounded-md z-50 hidden max-h-60 overflow-y-auto"></ul>
                </div>

                {{-- Address --}}
                <div class="mb-4">
                    <x-label for="address" :required="true">Address</x-label>
                    <input type="text" id="address" name="address" placeholder="Auto-filled from postcode" readonly class="w-full rounded-md px-2 py-1" />
                </div>

                {{-- City --}}
                <div class="mb-4">
                    <x-label for="city" :required="true">City</x-label>
                    <input type="text" id="city" name="city" placeholder="Auto-filled from postcode" readonly class="w-full rounded-md px-2 py-1" />
                </div>
                {{-- Location Preview --}}
                <div class="mb-4">
                    <x-label>Location Preview</x-label>
                    <div id="map" class="w-full h-64 rounded-md border"></div>
                </div>

                {{-- Rate --}}
                <div class="mb-4">
                    <x-label for="rate" :required="true">Rate Per Hour</x-label>
                    <x-text-input name="rate" type="number" />
                </div>

                {{-- Photo --}}
                <div class="mb-4">
                    <x-label for="photo" :required="true">Photo</x-label>
                    <x-text-input name="photo" type="file" />
                </div>

                {{-- EV --}}
                <div class="mb-4">
                    <x-label for="ev" :required="true">EV Charging</x-label>
                    <x-radio-group :allOption="false" name="ev" :value="old('ev')" :options="\App\Models\Space::$ev" />
                </div>

                {{-- Category --}}
                <div class="mb-4">
                    <x-label for="category" :required="true">Category</x-label>
                    <x-radio-group :allOption="false" name="category" :value="old('category')" :options="\App\Models\Space::$category" />
                </div>
<input type="hidden" id="latitude" name="latitude">
<input type="hidden" id="longitude" name="longitude">

                {{-- Submit --}}
                <div class="mb-4">
                    <button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">
                        Create Space
                    </button>
                </div>
            </form>
        </x-card>
    </div>

    @push('scripts')
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const postcodeInput = document.getElementById('postcode');
    const suggestionsList = document.getElementById('postcode-suggestions');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const mapContainer = document.getElementById('map');

    let map, marker;

    // ✅ Initialize Google Map
    function initMap(lat = 51.5074, lng = -0.1278) { // default London
        map = new google.maps.Map(mapContainer, {
            center: { lat, lng },
            zoom: 13,
        });
        marker = new google.maps.Marker({
            position: { lat, lng },
            map: map,
        });
    }

 function updateMarker(lat, lng) {
    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    if (!map) return initMap(lat, lng);

    marker.setMap(null); // remove old marker
    marker = new google.maps.Marker({
        position: { lat, lng },
        map: map,
        animation: google.maps.Animation.DROP
    });
    map.panTo({ lat, lng });
}


    // Initialize map once
    initMap();

    // Autocomplete / suggestions fetch
    let timeout = null;

    postcodeInput.addEventListener('input', () => {
        clearTimeout(timeout);
        const value = postcodeInput.value.trim();

        if (value.length < 3) {
            suggestionsList.innerHTML = '';
            suggestionsList.classList.add('hidden');
            return;
        }

        timeout = setTimeout(async () => {
            try {
                const res = await fetch(`/geocode-proxy?address=${encodeURIComponent(value)}`);
                const data = await res.json();

                suggestionsList.innerHTML = '';
                if (!data.addresses || data.addresses.length === 0) {
                    suggestionsList.classList.add('hidden');
                    return;
                }

                data.addresses.forEach(fullAddress => {
                    const li = document.createElement('li');
                    li.textContent = fullAddress;
                    li.classList.add('cursor-pointer','p-2','hover:bg-gray-200');

                    li.addEventListener('click', async () => {
                        addressInput.value = fullAddress;

                        // Extract city (second-to-last segment)
                        const parts = fullAddress.split(',');
                        cityInput.value = parts.length >= 2 ? parts[parts.length - 2].trim() : '';

                        postcodeInput.value = value.toUpperCase();

                        suggestionsList.innerHTML = '';
                        suggestionsList.classList.add('hidden');

                        // ✅ Geocode the selected address for coordinates
                        const geocodeUrl = `https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(fullAddress)}&key={{ env('GOOGLE_MAPS_API_KEY') }}`;

                        const geoRes = await fetch(geocodeUrl);
                        const geoData = await geoRes.json();

                        if (geoData.status === 'OK') {
                            const { lat, lng } = geoData.results[0].geometry.location;
                            updateMarker(lat, lng);
                        } else {
                            console.warn('Geocode failed:', geoData.status);
                        }
                    });

                    suggestionsList.appendChild(li);
                });

                suggestionsList.classList.remove('hidden');
            } catch (err) {
                console.error('Error fetching addresses:', err);
            }
        }, 500);
    });

    document.addEventListener('click', (e) => {
        if (!suggestionsList.contains(e.target) && e.target !== postcodeInput) {
            suggestionsList.innerHTML = '';
            suggestionsList.classList.add('hidden');
        }
    });
});
</script>

    @endpush
</x-layout>
