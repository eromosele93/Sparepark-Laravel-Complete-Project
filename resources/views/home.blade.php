<x-layout>
    
    <div class="mt-4 bg-slate-100 border rounded-md p-4">
        <h1 class="text-center font-bold text-4xl mb-2">Search, Book, Park...</h1> 
        <p class="text-center font-semibold text-2xl">We are UK's biggest parking website.</p>

        <form action="{{route('spaces.index')}}" method="GET">
            <div class="flex gap-1">
                <input required class="w-full p-2 border border-green-500 mt-8 rounded-md" type="search" name="search" placeholder="Search by postcode">
                <button class="bg-green-500 mt-8 p-2 rounded-md text-white" type="submit">Search</button>
            </div>
            <div class="flex justify-center mt-4">
                <x-radio-group name="category" :options="\App\Models\Space::$category"/>
            </div>
            
            <div class="mt-2">
                <div class="text-center font-medium text-gray-900">Electric Charging</div>
                <div class="flex justify-center">  
                    <x-radio-group name="ev" :options="\App\Models\Space::$ev"/>
                </div>
            </div>
        </form>
    </div>

    <!-- Map section -->
    <div class="container mx-auto text-center mt-10">
        <h2 class="text-2xl font-semibold text-purple-600 mb-4">Nearby Parking Spaces</h2>
        <p class="text-gray-500 mb-4">Allow location access to see spaces near you.</p>

        <div id="map" style="height: 500px; width: 100%; border-radius: 10px;"></div>
    </div>

    @push('scripts')
   <script>
document.addEventListener('DOMContentLoaded', () => {
    const spaces = @json($spaces ?? []); // all spaces with lat/lng
    const mapContainer = document.getElementById('map');
    let map, userMarker;

    // Initialize map (default London)
    function initMap(lat = 51.509865, lng = -0.118092) {
        map = new google.maps.Map(mapContainer, {
            center: { lat, lng },
            zoom: 13,
        });

        // Blue marker for user
        userMarker = new google.maps.Marker({
            position: { lat, lng },
            map,
            title: "You are here!",
            icon: { url: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png" }
        });

        showNearbySpaces(lat, lng);
    }

    // Show spaces near the user
    function showNearbySpaces(userLat, userLng) {
        const radiusKm = 5; // radius for nearby spaces
        const bounds = new google.maps.LatLngBounds();

        spaces.forEach(space => {
            if (!space.latitude || !space.longitude) return;

            const lat = parseFloat(space.latitude);
            const lng = parseFloat(space.longitude);
            const distance = getDistanceKm(userLat, userLng, lat, lng);

            if (distance > radiusKm) return; // skip far ones

            // Create marker for space
            // const marker = new google.maps.Marker({
            //     position: { lat, lng },
            //     map,
            //     title: space.address,
            // });
//             const marker = new google.maps.Marker({
//     position: { lat, lng },
//     map,
//     title: space.address,
//     icon: {
//         url: '/images/parking.png', // path to your custom image
//         scaledSize: new google.maps.Size(40, 40) // size in pixels
//     }
// });
const marker = new google.maps.Marker({
    position: { lat, lng },
    map,
    title: space.address,
    icon: {
        url: "/images/parking.png", // your custom 'P' icon or logo
        scaledSize: new google.maps.Size(20, 20), // resize the icon (width, height)
        labelOrigin: new google.maps.Point(20, 25) // position text relative to icon
    },
    label: {
       text: `SparePark-\n£${space.rate}/hr`,
        color: "#2E8B57", // green text
        fontWeight: "bold",
        fontSize: "10px"
    }
});



            // Create InfoWindow for this space
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="min-width:150px">
                        <strong>${space.address}</strong><br>
                        ${space.city}<br>
                        £${space.rate}/hr<br>
                        EV Charging: ${space.ev ? "Yes" : "No"}<br>
                        Category: ${space.category}<br>
                        Distance: ${distance.toFixed(2)} km
                    </div>
                `
            });

            // Show InfoWindow when marker clicked
            marker.addListener('click', () => infoWindow.open(map, marker));

            bounds.extend({ lat, lng });
        });

        if (!bounds.isEmpty()) {
            map.fitBounds(bounds);
        }
    }

    // Haversine formula
    function getDistanceKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a =
            Math.sin(dLat/2) * Math.sin(dLat/2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon/2) * Math.sin(dLon/2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    // Get user location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            pos => initMap(pos.coords.latitude, pos.coords.longitude),
            err => initMap() // fallback London
        );
    } else {
        initMap(); // fallback
    }
});
</script>

    <!-- Google Maps API -->
    <script async src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    @endpush
</x-layout>
