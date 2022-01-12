@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center">
      <a href="{{ route('admin.collections.index') }}" class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        files
      </a>
      <a href="{{ route('admin.files.create') }}" class="bg-indigo-800 rounded p-3 text-white ml-auto inline-block">
        Subir archivos
      </a>
    </div>
    <div class="col-span-12 bg-white rounded p-3 shadow">
      <div class="grid grid-cols-12 p-2">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-9">
          Name
        </div>
        <div class="col-span-2">
          Collection
        </div>
      </div>
      <div class="grid divide-y">
        @foreach ($files as $file)
        <a href="{{ route('admin.files.show', $file) }}">
          <div class="grid grid-cols-12 p-2">
            <div class="col-span-1">
              {{ $file->id }}
            </div>
            <div class="col-span-9">
              {{ $file->name }}
            </div>
            <div class="col-span-2">
              {{ $file->collection->name }}
            </div>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
