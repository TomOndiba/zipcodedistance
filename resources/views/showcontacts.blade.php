@extends('layout')

@section('content')

<h1>Tabla de contacts</h1>

           <table class="table table-hover">
            <tr>
                   <th>Name</th><th>zipCode</th><th>Latitud</th><th>Longitud</th>
               </tr>
           @foreach($contacts as $contact)
               <tr>
                   <td>{{$contact->name}}</td><td> {{$contact->zipCode}}</td><td> {{$contact->latitud}}</td> 
                   <td>{{$contact->longitud}}</td>
               </tr>
            @endforeach
           </table>


     @endsection