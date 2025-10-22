<x-layout>
    <div class="max-w-4xl mx-auto">
    <x-bread-crumbs class="p-4" :links="[$space->address => '#']"></x-bread-crumbs>
    <x-card class=" mb-4">
    <div class="grid grid-cols-4 mt-2 p-2 gap-2">
@if (!$space->name)
<div class="col-span-1">

<img class="rounded-lg" width="150px" height="150px" src="{{asset('/images/No.PNG')}}" alt="Logo"/>
</div>

@else
<div class="col-span-1">

<img class="rounded-lg" width="150px" height="150px" src="{{asset('storage/images/'.$space->name)}}" alt="Logo"/>
</div>
@endif

<div class="col-span-3">
<div class="text-slate-500 font-medium mb-4">{{$space->address}}</div>
<div class="flex justify-between mb-4">
<div class="text-slate-500 text-sm">{{$space->city}}</div>
<div class="text-slate-500 text-sm">{{$space->postcode}}</div>
</div>
<div class="flex justify-between mb-4">
<div class="text-slate-500 text-sm">
<div>{{number_format($space->reviews_avg_rating, 1)}} out of 5</div>
<div><x-star-rating :rating="$space->reviews_avg_rating" /></div>
<div> {{$space->reviews_count}} {{Str::plural('Review', $space->eviews_count)}}</div>    
</div>
<div class="text-slate-500 text-sm">{{$space->bookings->count()}}  {{Str::plural('Booking', $space->bookings->count())}}</div>
</div>
<div class="flex justify-between gap-2">
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm"><a href="{{route('spaces.index', ['category' => $space->category])}}"> {{Str::ucfirst($space->category)}}</a></div>
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm"><a href="{{route('spaces.index', ['ev' => $space->ev])}}">Electric Charging: {{Str::ucfirst($space->ev)}}</a></div>
</div>
</div>

</div>
<a href="{{route('space.booking.create', $space)}}">
<button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">Book for £{{$space->rate}} per hour</button>

</a>

</x-card>
<div class="bg-slate-100 rounded-md mt-16 p-4">
    <h1 class="text-center text-slate-800 font-medium text-2xl mb-2">Reviews</h1>

    @forelse ($space->reviews as $reviews)
        <div class="border border-slate-300 p-2 mb-4 rounded-md">
            <h1 class="mb-2 text-lg text-slate-500 font-medium ">{{$reviews->booking->user->name}}</h1>
            <div><x-star-rating :rating="$reviews->rating" /></div>
          <div class="text-sm text-slate-500">  {{$reviews->review}}</div>
        </div>
    @empty
        <div class="text-center text-lg font-medium text-slate-500">No reviews yet</div>
    @endforelse
</div>

<div class="mt-16 p-4">
    <h1 class="text-center text-slate-800 font-medium text-2xl mb-2">Other spaces by the space owner</h1>
@foreach ($space->spaceOwner->spaces as $other_spaces)
<x-card class=" mb-4">
    <div class="grid grid-cols-4 mt-2 p-2 gap-2">
@if (!$other_spaces->name)
<div class="col-span-1">

<img class="rounded-lg" width="150px" height="150px" src="{{asset('/images/No.PNG')}}" alt="Logo"/>
</div>

@else
<div class="col-span-1">

<img class="rounded-lg" width="150px" height="150px" src="{{asset('storage/images/'. $other_spaces->name)}}" alt="Logo"/>
</div>
@endif

<div class="col-span-3">
<div class="text-slate-500 font-medium mb-4">{{$other_spaces->address}}</div>
<div class="flex justify-between mb-4">
<div class="text-slate-500 text-sm">{{ $other_spaces->city}}</div>
<div class="text-slate-500 text-sm">{{ $other_spaces->postcode}}</div>
</div>
<div class="flex justify-between mb-4">
<div class="text-slate-500 text-sm">
<div>{{number_format( $other_spaces->reviews_avg_rating, 1)}} out of 5</div>
<div><x-star-rating :rating="$space->reviews_avg_rating" /></div>
<div> {{ $other_spaces->reviews_count}} {{Str::plural('Review',  $other_spaces->eviews_count)}}</div>    
</div>
<div class="text-slate-500 text-sm">{{ $other_spaces->bookings->count()}}  {{Str::plural('Booking', $space->bookings->count())}}</div>
</div>
<div class="flex justify-between gap-2">
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm"> {{Str::ucfirst($space->category)}}</div>
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm">Electric Charging: {{Str::ucfirst($space->ev)}}</div>
</div>
</div>

</div>
<a href="{{route('spaces.show',  $other_spaces)}}">
<button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">Show more</button>

</a>

</x-card>
@endforeach
    
</div>
    </div>


</x-layout>