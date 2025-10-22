<x-layout>
<x-breadcrumbs :links="['Back' => route('my-booking.index'), 'Rate' => '#']" class="mb-4 m-16" />
    <h1 class="my-4 text-center text-4xl font-medium text-slate-700">Rate Booking</h1>
    <x-card class="p-8 m-16">

    <form action="{{route('booking.review.store', $booking)}}" method="POST">
    @csrf
    <div class="mb-8">
        
        <x-label :required="true" for="rating">Rating</x-label>
        <x-text-input type="number"  name="rating" placeholder="Enter rating (1-5)"/>
    </div>
    <div class="mb-8">
        <x-label for="review" :required="true">Review</x-label>
        <textarea class="w-full rounded-md px-2 py-1 text-sm ring-1  placeholder:text-slate-400 focus:ring-2"  name="review" >


        </textarea>
@error('review')
    <div class="mt-1 text-sm text-red-500">
    {{$message}}
    </div>
@enderror
</div>
    <button class="w-full bg-green-500 rounded-md text-white"> Rate </button>
    </form>
    </x-card>
</x-layout>