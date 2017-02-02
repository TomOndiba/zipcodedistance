@extends('layout')

@section('content')

           <table class="table table-hover">
            <tr>
                   <th>Name</th><th>zipCode</th>
               </tr>
           @foreach($contacts as $contact)
               <tr>
                   <td>{{$contact->name}}</td><td> {{$contact->zipCode}}</td>
               </tr>
            @endforeach
           </table>


     @endsection