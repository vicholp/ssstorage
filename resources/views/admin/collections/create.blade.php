@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-4">
    @error('name')
      <div class="col-start-4 col-span-6 bg-red-400 rounded shadow-red-lg p-3 py-4 text-white text-center font-medium">{{ $message }}</div>
    @enderror
    <form action="{{ route('admin.collections.store') }}" method="POST" class="col-span-6 col-start-4 flex flex-col gap-3 bg-white shadow p-3 rounded " enctype="multipart/form-data">
      @csrf
      <h2 class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">New collection</h2>
      <div class="grid grid-cols-12 gap-3 items-center">
        <span class="col-span-6">Name: </span>
        <input class="col-span-6 rounded" type="text" name="name" class="rounded">
      </div>
      <div class="grid grid-cols-12 gap-3">
        <span class="col-span-6">Parent collection: </span>
        <select class="col-span-6 rounded" name="collection_id" class="rounded">
          <option value="">No</option>
          @foreach ($collections as $collection)
          <option value="{{ $collection->id }}">{{ $collection->name }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="bg-indigo-800 rounded p-3 mt-4 text-white">Create</button>
    </form>
  </div>
@endsection
