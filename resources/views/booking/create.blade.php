<x-layout>
<x-breadcrumbs :links="['Back' => route('spaces.show', $space), 'Book' => '#']" class="mb-4 m-16" />
    <h1 class="my-4 text-center text-4xl font-medium text-slate-700">Book Space</h1>
    <x-card class="p-8 m-16">

    <form action="{{route('space.booking.store', $space)}}" method="POST">
    @csrf
    <div class="mb-8">
        <x-label :required="true" for="duration">Duration (Hours)</x-label>
        <x-text-input type="number"  name="duration" placeholder="Enter number of hours"/>
    </div>
    <div class="mb-8">
        <x-label for="date_time" :required="true">Date and time</x-label>
        <x-text-input name="date_time" type="datetime-local" />
</div>
    <button class="w-full bg-green-500 rounded-md text-white"> Book and Pay </button>
    </form>
    </x-card>
</x-layout>