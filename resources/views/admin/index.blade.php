@extends('admin.template.main')

@section('content')
<div class="container mx-auto">
  <div class="grid grid-cols-12 p-3 gap-3">
    <a href="{{ route('admin.files.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Files
    </a>
    <a href="{{ route('admin.collections.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Collections
    </a>
  </div>
</div>
@endsection
