@extends('auth.template.main')
@section('content')
<div class="flex justify-center">
  <div class="bg-white rounded shadow-lg mt-40 p-4 flex flex-col items-center w-96">
    <form action="{{ route('auth.authenticate') }}" method="POST">
      @csrf
      <button type="submit" class="p-4 font-medium">
        Acceder
      </button>
      <div class="mt-4">
        <input class="bg-white border rounded p-2" type="email" name="email" placeholder="Email">
      </div>
      <div class="mt-4">
        <input class="bg-white border rounded p-2" type="password" name="password" placeholder="Contraseña">
      </div>
      <div class="mt-4">
        <button class="bg-purple-800 p-3 px-6 text-white rounded">Acceder</button>
      </div>
    </form>
  </div>
</div>

@endsection
