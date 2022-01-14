@extends('admin.template.main')

@section('content')
  <div class="grid grid-cols-12 p-3 gap-3">
    <file-upload
      :collections='@json($collections)'
      csrf="{{ csrf_token() }}"
    ></file-upload>
  </div>
@endsection
