@extends('layout')

@section('content')

<h1>Tabla de Match entre los Agentes y los contactos</h1>
 
          <table class="table table-hover">
            <tr>
                   <th>AgenteId</th><th>Name</th><th>zipCode</th><th>distance</th><th>time in bici</th>
               </tr>
           @foreach($group1 as $contact)
               <tr>
                   <td>{{$response["agent1"]}}</td><td>{{$contact['contactName']}}</td><td> {{$contact['zipCode']}}</td><td> {{$contact['distance']}}</td><td> {{$contact['time']}}</td>
               </tr>
            @endforeach

             @foreach($group2 as $contact)
               <tr>
                   <td>{{$response["agent2"]}}</td><td>{{$contact['contactName']}}</td><td> {{$contact['zipCode']}}</td><td> {{$contact['distance']}}</td><td> {{$contact['time']}}</td>
               </tr>
            @endforeach

             @foreach($group3 as $contact)
               <tr>
                   <td>N/A</td></td><td>{{$contact['contactName']}}</td><td> {{$contact['zipCode']}}</td><td> {{$contact['distance']}}</td><td> {{$contact['time']}}</td>
               </tr>
            @endforeach
           </table>
          
<a href="{{ url('/') }}" class="btn btn-danger">Cancel</a>
     @endsection