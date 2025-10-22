<x-layout>
<x-bread-crumbs class="mx-auto mt-10 max-w-2xl" :links="['My Spaces' => '#']"></x-bread-crumbs>

<div class="mx-auto mt-10 max-w-2xl mb-4 flex justify-between">
<a href="{{route('my-space.create')}}" class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100 ">Add Space</a>
  <a href="{{route('space-owner.index')}}" class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100 ">Edit space-owner info</a>

</div>
    @foreach ($spaces as $space)
    <div class="mx-auto max-w-2xl">
    <x-card class="w-full mb-4">
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
@if ($space->deleted_at)
    <div class="text-red-500 font-medium text-lg">Deleted</div>
@endif
<div class="text-slate-500 font-medium mb-4">{{$space->address}}</div>
<div class="flex justify-between mb-4">
<div class="text-slate-500 text-sm">{{$space->city}}</div>
<div class="text-slate-500 text-sm">{{$space->postcode}}</div>
</div>
<div class="flex justify-between mb-4">
<div class="text-sm text-slate-500">
<div>{{number_format($space->reviews_avg_rating, 1)}} out of 5</div>
<div><x-star-rating :rating="$space->reviews_avg_rating" /></div>
</div>


<div class="text-sm text-slate-500"> {{$space->reviews_count}} {{Str::plural('Review', $space->eviews_count)}}</div>    

</div>
<div class="flex justify-between gap-2 mb-4">
<div class="text-slate-500 text-sm">£{{$space->rate}} per hour</div>
<div class="text-slate-500 text-sm">Uploaded {{$space->created_at->diffForHumans()}}</div>
</div>
<div class="flex justify-between gap-2">
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm"><a href="{{route('spaces.index', ['category' => $space->category])}}"> {{Str::ucfirst($space->category)}}</a></div>
<div class="rounded-md border px-2 py-1 text-slate-500 text-sm"><a href="{{route('spaces.index', ['ev' => $space->ev])}}">Electric Charging: {{Str::ucfirst($space->ev)}}</a></div>
</div>

</div>

</div>
@if (!$space->deleted_at)
<div class="flex justify-between gap-1 mt-4">
<a href="{{route('my-space.edit', $space)}}" class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100 ">Edit</a>
  <a href="{{route('my-space.show', $space)}}" class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100 ">Bookings</a>
  
  <form action="{{route('my-space.destroy', $space)}} " method="POST">
        @csrf
        @method('DELETE')
        <button class="rounded-md border border-slate-300 px-2 py-1 
 bg-white text-center text-sm font-semibold text-black shadow-md
  hover:bg-slate-100">Delete</button>
        </form>
</div>  
@endif

</x-card>

    </div>
    
    @endforeach
</x-layout>