<x-layout>
<div class="mx-auto mt-10 max-w-2xl">
<x-breadcrumbs :links="['My Spaces' => route('my-space.index'), 'Bookings' => '#']" class="mb-4" />
@forelse ($space->bookings as $bookings)
    <x-card class="mb-4">
<div class="flex gap-2 text-sm font-medium text-slate-500 mb-2">
<div>Booked by {{$bookings->user->name}} - </div>
<div>For {{$bookings->duration}} {{Str::plural('Hour', $bookings->duration)}} - </div>
<div>Booked {{$bookings->created_at->diffForHumans()}}</div>
</div>
<div class="flex gap-2 text-sm font-medium text-slate-500">
<div>Booking Date: {{$bookings->date_time}} - </div>
@if ($bookings->date_time > now())
<div>Not Completed</div>
  @else  
  <div>Completed</div>
@endif

</div>

<div>
<div class="mb-4 text-center font-medium text-slate-500 mt-4 underline">Review</div>
@if ($bookings->review)
    <div>
    <div class="mb-1 text-slate-500 font-medium">{{$bookings->user->name}}</div>
    <div><x-star-rating :rating="$bookings->review->rating" /></div>
    <div class="text-slate-500 text-sm ">{{$bookings->review->review}}</div>
    </div>
    @else
<div class="text-center text-sm text-slate-500">Not reviewed yet</div>
@endif
</div>

        
        </x-card>

@empty
    <div class="text-center font-medium text-slate-500 mt-16 mb-80">No bookings yet

    <div class="mt-4">
    <a href="{{route('my-space.index')}}" class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100 ">Back</a>
    </div>
    </div>
    
@endforelse
</div>


</x-layout>