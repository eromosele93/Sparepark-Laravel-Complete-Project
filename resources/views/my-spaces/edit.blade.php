<x-layout>
    <div class="mx-auto mt-10 max-w-2xl">
    <x-breadcrumbs :links="['My Spaces' => route('my-space.index'), 'Edit' => '#']" class="mb-4" />

<x-card class="mb-8 mt-8">

<form action="{{route('my-space.update', $space)}}" method="POST"   enctype="multipart/form-data">
@method('PUT')
@csrf

<div>

<div class="mb-4">
<x-label for="address" :required="true">Address</x-label>

<x-text-input name="address" value="{{$space->address}}"/>
</div>
<div class="mb-4">
<x-label for="city" :required="true">City</x-label>
<x-text-input name="city" value="{{$space->city}}"/>
</div>
<div class="mb-4">
<x-label for="postcode" :required="true">Postcode</x-label>
<x-text-input name="postcode" value="{{$space->postcode}}"/>
</div>
<div class="mb-4">
<x-label for="rate" :required="true">Rate Per Hour</x-label>
<x-text-input name="rate" type="number" value="{{$space->rate}}"/>
</div>
<div class="mb-4">
      <x-label for="ev" :required="true">EV Charging</x-label>
      <x-radio-group :allOption="false" name="ev" :all-option="false" :value="$space->ev"
        :options="\App\Models\Space::$ev" />
    </div>

    <div class="mb-4">
      <x-label for="category" :required="true">Category</x-label>
      <x-radio-group :allOption="false" name="category" :all-option="false" :value="$space->category"
        :options="\App\Models\Space::$category" />
    </div>

    <div class="mb-4">
      <button class="w-full text-center border border-green-500 rounded-md bg-green-500 text-white font-medium">Update Space</button>
    </div>
</div>
</form>
</x-card>
    </div>
    
</x-layout>