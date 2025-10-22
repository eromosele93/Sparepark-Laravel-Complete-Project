<x-layout>
  <x-breadcrumbs :links="['Login' => '#']" class="mb-4 mx-auto mt-8 max-w-2xl" />

  <h1 class="my-8 text-center text-3xl sm:text-4xl font-medium text-slate-700">
    Sign in to your account
  </h1>

  <x-card class="p-6 sm:p-8 mx-4 sm:mx-auto max-w-xl w-full">

    <form action="{{ route('auth.store') }}" method="POST">
      @csrf

      <div class="mb-6">
        <x-label :required="true" for="email">E-mail</x-label>
        <x-text-input name="email" placeholder="Enter your email" />
      </div>

      <div class="mb-6">
        <x-label for="password" :required="true">Password</x-label>
        <x-text-input name="password" type="password" placeholder="Enter your password" />
      </div>

      <div class="flex flex-col sm:flex-row justify-between mb-6 text-sm font-medium gap-2">
        <div class="flex items-center space-x-2">
          <input class="rounded-sm border-slate-500" type="checkbox" name="remember" id="remember" />
          <label for="remember">Remember me</label>
        </div>
        <div>
          <a class="text-indigo-700 hover:underline" href="#">Forgot password?</a>
        </div>
      </div>

      <button class="w-full bg-green-500 rounded-md py-2 text-white font-semibold hover:bg-green-600">
        Login
      </button>
    </form>

  </x-card>
</x-layout>
