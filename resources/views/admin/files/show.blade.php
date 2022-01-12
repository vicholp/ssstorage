@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <a href="{{ route('admin.files.index') }}" class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        <- all files
      </a>
      <a href="{{ '/src/' . $file->getUrl() }}" class="bg-gray-200 rounded p-3 text-black inline-block ml-auto">
        Preview
      </a>
      <a  class="bg-indigo-300 rounded p-3 text-white inline-block">
        Edit
      </a>
    </div>
    <a href="{{ route('admin.collections.show', $file->collection) }}" class="col-span-3 bg-gray-300 rounded shadow p-3 gap-3">
      {{ $file->collection->name }}
    </a>
    <div class="col-span-12 bg-white rounded shadow p-3 flex items-center gap-3">
      @if ($file->file)
      <a href="{{ route('admin.files.show', $file->file) }}" class="inline-block p-3 bg-gray-100 rounded">
        <div>
          {{ $file->file->name }}
        </div>
      </a>
      @endif
      <h2 class="text-lg font-medium text-opacity-90 text-black">{{ $file->name }}</h2>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <h3>Files ({{ $file->files->count() }})</h3>
      <div class="flex flex-col gap-2">
        @forelse ($file->files as $file)
          <a href="{{ route('admin.files.show', $file) }}" class="inline-block p-3 bg-gray-100 rounded">
            <div>
              {{ $file->name }}
            </div>
          </a>
        @empty
          No files
        @endforelse
      </div>
    </div>
  </div>
@endsection
