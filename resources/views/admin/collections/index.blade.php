@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center">
      <a href="{{ route('admin.collections.index') }}" class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        collections
      </a>
      <a href="{{ route('admin.collections.create') }}" class="bg-indigo-800 rounded p-3 ml-auto text-white inline-block">
        New collection
      </a>
    </div>
    <div class="col-span-12 bg-white rounded p-3 shadow ">
      <div class="grid grid-cols-12 p-2">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-9">
          Name
        </div>
        <div class="col-span-2">
          Files
        </div>
      </div>
      <div class="grid divide-y">
        @foreach ($collections as $collection)
          <a href="{{ route('admin.collections.show', $collection) }}">
            <div class="grid grid-cols-12 p-2">
              <div class="col-span-1">
                {{ $collection->id }}
              </div>
              <div class="col-span-9">
                {{ $collection->name }}
              </div>
              <div class="col-span-2">
                {{ $collection->files->count() }}
              </div>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
