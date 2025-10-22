<x-layout>
    <x-bread-crumbs class="px-4" :links="['Search Results' => '#']" />

    <div class="lg:grid lg:grid-cols-4 p-4">
        <div class="mb-4 lg:col-span-1 bg-slate-100 p-2 rounded-md md:h-96">
            <!-- Map container -->
            <div id="map" style="width:100%; height:100%; border-radius:10px;"></div>
        </div>

        <div class="lg:col-span-3 lg:mx-auto ">
            <form class="mb-6" action="{{ route('spaces.index') }}" method="GET">
                <div class="flex gap-1">
                    <input value="{{ request('search') }}" required class="w-full p-2 border border-green-500 mt-8 rounded-md" type="search" name="search" placeholder="Search by postcode">
                </div>
                <div class="flex justify-center mt-4">
                    <x-radio-group name="category" :options="\App\Models\Space::$category"/>
                </div>
                <div class="mt-2">
                    <div class="text-center font-medium text-gray-900">Electric Charging</div>
                    <div class="flex justify-center"><x-radio-group name="ev" :options="\App\Models\Space::$ev"/></div>
                </div>
                <button class="bg-green-500 w-full mt-8 p-2 rounded-md text-white" type="submit">Search again</button>
            </form>
<div class="text-center text-slate-500 mt-4 font-bold text-2xl">Search Results</div>
            @forelse ($spaces as $space)
                <x-card class="w-full mb-4">
                    <div class="grid grid-cols-4 mt-2 p-2 gap-2">
                        <div class="col-span-1">
                            <img class="rounded-lg" width="150px" height="150px"
                                src="{{ $space->name ? asset('storage/images/' . $space->name) : asset('/images/No.PNG') }}"
                                alt="Parking Image" />
                        </div>

                        <div class="col-span-3">
                            <div class="text-slate-500 font-medium mb-4">{{ $space->address }}</div>
                            <div class="flex justify-between mb-4">
                                <div class="text-slate-500 text-sm">{{ $space->city }}</div>
                                <div class="text-slate-500 text-sm">{{ $space->postcode }}</div>
                            </div>
                            <div class="flex justify-between mb-4">
                                <div class="text-slate-500 text-sm">
                                    <div>{{ number_format($space->reviews_avg_rating, 1) }} out of 5</div>
                                    <div><x-star-rating :rating="$space->reviews_avg_rating" /></div>
                                    <div>{{ $space->reviews_count }} {{ Str::plural('Review', $space->reviews_count) }}</div>
                                </div>
                                <div class="text-slate-500 text-sm">{{ $space->bookings->count() }} {{ Str::plural('Booking', $space->bookings->count()) }}</div>
                            </div>
                            <div class="flex justify-between gap-2">
                                <div class="rounded-md border px-2 py-1 text-slate-500 text-sm">
                                    <a href="{{ route('spaces.index', ['category' => $space->category]) }}">{{ Str::ucfirst($space->category) }}</a>
                                </div>
                                <div class="rounded-md border px-2 py-1 text-slate-500 text-sm">
                                    <a href="{{ route('spaces.index', ['ev' => $space->ev]) }}">Electric Charging: {{ Str::ucfirst($space->ev) }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('spaces.show', $space) }}">
                        <button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">
                            Book for £{{ $space->rate }} per hour
                        </button>
                    </a>
                </x-card>
            @empty
                <div class="text-slate-500 font-medium text-lg text-center">No result matches this search</div>
            @endforelse
        </div>
    </div>

    @if ($spaces->count())
        <nav class="mt-4 mb-4"> {{ $spaces->links() }}</nav>
    @endif

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const paginatedData = @json($spaces);
        const spaces = paginatedData.data || [];
        console.log("Spaces from Laravel:", spaces);

        if (!spaces.length) {
            console.warn("No spaces found to display on map.");
            return;
        }

        // Center map on first space
        const firstSpace = spaces[0];
        const map = new google.maps.Map(document.getElementById("map"), {
            center: { lat: parseFloat(firstSpace.latitude), lng: parseFloat(firstSpace.longitude) },
            zoom: 13,
        });

        const bounds = new google.maps.LatLngBounds();

        spaces.forEach(space => {
            if (!space.latitude || !space.longitude) return;

            const position = {
                lat: parseFloat(space.latitude),
                lng: parseFloat(space.longitude)
            };

            const marker = new google.maps.Marker({
                position,
                map,
                icon: {
                    url: "/images/parking.png",
                    scaledSize: new google.maps.Size(20, 20), // resize the icon (width, height)
                    labelOrigin: new google.maps.Point(20, 25) // position text relative to icon
                },
                label: {
                    text: `SparePark\n£${space.rate}/hr`,
                    color: "#2E8B57",
                    fontSize: "10px",
                    fontWeight: "bold"
                }
            });
               

            const info = new google.maps.InfoWindow({
                content: `
                    <div style="max-width:200px;">
                        <strong>${space.address}</strong><br>
                        ${space.city}<br>
                        £${space.rate}/hr<br>
                        <a href="/spaces/${space.id}" style="color:green;">View Details</a>
                    </div>
                `
            });

            marker.addListener('click', () => info.open(map, marker));
            bounds.extend(position);
        });

        map.fitBounds(bounds);
    });
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}"></script>
    @endpush
</x-layout>
