@extends('layout')

@section('content')
<br>
<hr>
    <form method="POST" enctype="multipart/form-data" action="{{ url('cargarcsv') }}" class="form-horizontal">
        {!! csrf_field() !!}
           <input id="archivo" accept=".csv" name="archivo" type="file" /> <br>
    <button type="submit" class="btn btn-primary">add File</button>

        <a href="{{ url('/') }}" class="btn btn-danger">Cancel</a>

    </form>

    </form>
    <a href="{{ url('/') }}" class="btn btn-danger">Cancel</a>
     @endsection