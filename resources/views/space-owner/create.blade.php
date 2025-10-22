<x-layout>
    <div class="mx-auto mt-10 max-w-2xl">
    <x-breadcrumbs :links="['Register as a space owner' => '#']" class="mb-4" />

<x-card class="mb-8 mt-8">

<form action="{{route('space-owner.store')}}" method="POST">
@csrf
<div>

<div class="mb-4">
<x-label for="phone" :required="true">Phone number</x-label>

<x-text-input name="phone" />
</div>

    <div class="mb-4">
      <button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">Register</button>
    </div>
</div>
</form>
</x-card>
    </div>
    
</x-layout>