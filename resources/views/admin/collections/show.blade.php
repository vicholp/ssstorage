@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
    <div class="col-span-12 flex flex-row items-center">
      <a href="{{ route('admin.collections.index') }}" class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        <- all collections
      </a>
      <a href="{{ route('admin.collections.edit', $collection) }}" class="bg-indigo-800 rounded p-3 text-white inline-block ml-auto">
        Edit
      </a>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 ">
      <h2 class="text-lg font-medium text-opacity-90 text-black">{{ $collection->name }}</h2>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <h3>Ancestors</h3>
      <div class="flex gap-2">
        @forelse  (array_slice($collection->getAncestors(), 1) as $ancestor)
          <a href="{{ route('admin.collections.show', $ancestor) }}" class="inline-block p-3 bg-gray-100 rounded">
            <div>
              {{ $ancestor->name }}
            </div>
          </a>
        @empty
          <span class="text-opacity-60 text-black">
            No ancestors
          </span>
        @endforelse
      </div>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <h3>Image Specs</h3>
      <div class="flex gap-2">
        @forelse ($collection->imageSpecs as $imageSpec)
          <div class="p-3 bg-gray-100 rounded">
            <div>
              {{ $imageSpec->width }} x {{ $imageSpec->height }}
            </div>
          </div>
        @empty
          No image specs
        @endforelse
      </div>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <h3>Files ({{ $collection->files->count() }})</h3>
      <div class="flex flex-col gap-2">
        @forelse ($collection->files as $file)
          <a href="{{ route('admin.files.show', $file) }}" class="inline-block p-3 bg-gray-100 rounded">
            <div>
              {{ $file->name }}
            </div>
          </a>
        @empty
          No image specs
        @endforelse
      </div>
    </div>
  </div>
@endsection
