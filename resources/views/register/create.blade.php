<x-layout>
  <x-breadcrumbs :links="['Register' => '#']" class="mb-4 mx-auto mt-8 max-w-2xl" />

  <h1 class="my-8 text-center text-3xl sm:text-4xl font-medium text-slate-700">
    Register
  </h1>

  <x-card class="p-6 sm:p-8 mx-4 sm:mx-auto max-w-xl w-full">

    <form action="{{ route('register.store') }}" method="POST">
      @csrf

      <div class="mb-6">
        <x-label :required="true" for="email">E-mail</x-label>
        <x-text-input name="email" placeholder="Enter your email" />
      </div>

      <div class="mb-6">
        <x-label :required="true" for="name">Full Name</x-label>
        <x-text-input name="name" placeholder="Enter your full name" />
      </div>

      <div class="mb-6">
        <x-label for="password" :required="true">Password</x-label>
        <x-text-input name="password" type="password" placeholder="Enter your password" />
      </div>

      <div class="mb-6">
        <x-label for="confirm_password" :required="true">Confirm Password</x-label>
        <x-text-input name="confirm_password" type="password" placeholder="Confirm your password" />
      </div>

      <button class="w-full bg-green-500 py-2 rounded-md text-white font-semibold hover:bg-green-600">
        Register
      </button>
    </form>

  </x-card>
</x-layout>
