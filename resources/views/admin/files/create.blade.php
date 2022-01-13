@extends('admin.template.main')

@section('content')
  <div class="grid grid-cols-12 p-3 gap-3">
    <form action="{{ route('admin.files.store') }}" method="POST" class="col-span-12 flex flex-col gap-3" enctype="multipart/form-data">
      @csrf
      <div class="grid grid-cols-12 gap-3">
        <input class="col-start-5 col-span-6" type="file" name="files[]" id="a" multiple>
      </div>
      <div class="grid grid-cols-12 gap-3">
        <span class="col-start-5 col-span-2">Parent collection: </span>
        <select class="col-span-2" name="data[collection_id]" class="rounded">
          @foreach ($collections as $collection)
            <option value="{{ $collection->id }}">{{ $collection->name }}</option>
          @endforeach
        </select>
      </div>
      <button type="submit" class="bg-indigo-800 rounded p-3 text-white w-96 mx-auto">Create</button>
    </form>
  </div>
@endsection
