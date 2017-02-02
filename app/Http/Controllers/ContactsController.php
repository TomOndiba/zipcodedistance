<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Contact;
use Session;

class ContactsController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
            $contacts = Contact::all();

             return view('showcontacts',compact('contacts'));
    }

     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createcsv()
    {
        return view('cargarcsv');
    }

   public function storecsv(Request $request)
   {
     //obtenemos el archivo .csv
            $tipo = $_FILES['archivo']['type'];
             
            $tamanio = $_FILES['archivo']['size'];
             
            $archivotmp = $_FILES['archivo']['tmp_name'];
             
            //cargamos el archivo
            $lineas = file($archivotmp);
             
            //inicializamos variable a 0, esto nos ayudará a indicarle que no lea la primera línea
            $i=0;
            //Recorremos el bucle para leer línea por línea
            foreach ($lineas as $linea_num => $linea)
            { 
               //abrimos bucle
               /*si es diferente a 0 significa que no se encuentra en la primera línea 
               (con los títulos de las columnas) y por lo tanto puede leerla*/
               if($i != 0) 
               { 
                   //abrimos condición, solo entrará en la condición a partir de la segunda pasada del bucle.
                   /* La funcion explode nos ayuda a delimitar los campos, por lo tanto irá 
                   leyendo hasta que encuentre un ; */
                   $datos = explode(",",$linea);
             
                   //Almacenamos los datos que vamos leyendo en una variable
                   $nombre = trim($datos[0]);
                   $zipcode = trim($datos[1]);
             
                   //guardamos en base de datos la línea leida
                    Contact::create(['name'=>$nombre,'zipCode'=>$zipcode]);

             
                   //cerramos condición
               }
             
               /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
               entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
               $i++;
               //cerramos bucle
            }
    return redirect()->to('/');
   }

  public function createagent()
    {
        return view('cargaragents');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     public function addAgents(Request $request)
    {
        $agent1 = array("name"=>$request->input('name'),"zipCode"=>$request->input('zipCode'),"agentId"=>$request->input('agentId'));

        $agent2 = array("name"=>$request->input('name2'),"zipCode"=>$request->input('zipCode2'),"agentId"=>$request->input('agentId2'));
                              

        session()->put('agent1', $agent1);
        session()->put('agent2', $agent2);

       return redirect()->to('/');

    }

    public function match()
    {
        ini_set('max_execution_time', 300);
          $contacts = Contact::all();
          $agent1 =  session()->get('agent1');
          $agent2 =  session()->get('agent2');
          $webservice="http://maps.googleapis.com/maps/api/distancematrix/json?";
          $ii=0;

          $group1= array();
          $group2= array();
          $group3= array();

          try {

          foreach ($contacts  as $contact) 
          {
     
            $url=$webservice."origins=".$agent1['zipCode']."&destinations=".$contact->zipCode."&mode=bicycling";
            $json = file_get_contents($url);
            $response=json_decode($json, true);

            $data1=$response["rows"][0]["elements"][0];
 
            $url=$webservice."origins=".$agent2['zipCode']."&destinations=".$contact->zipCode."&mode=bicycling";

            $json = file_get_contents($url);
            $response=json_decode($json, true);

            $data2=$response["rows"][0]["elements"][0];

             echo "<br><br>";
             if($data1["status"]=="OK" && $data2["status"]=="OK")
             {

                if($data1["distance"]["value"]<$data2["distance"]["value"])
                {
                    $set = array('distance' => $data1["distance"]["text"],'time' => $data1["duration"]["text"],'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);

                    $group1[]=$set ;
                }
                else
                {
                  $set = array('distance' => $data2["distance"]["text"],'time' => $data2["duration"]["text"],'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);
                    
                    $group2[]=$set ;
                }
                
             }
             else 
             {

                if($data1["status"]=="OK")
                {
                    $set = array('distance' => $data1["distance"]["text"],'time' => $data1["duration"]["text"],'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);

                    $group1[]=$set ;
                }
                else
                {
                    if($data2["status"]=="OK")
                    {
                        $set = array('distance' => $data2["distance"]["text"],'time' => $data2["duration"]["text"],'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);

                        $group2[]=$set ;
                    }
                    else
                    {
                        $set = array('distance' => 'no se pudo calcular','time' => 'no se pudo calcular','contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);
                        
                        $group3[]=$set ;
                    }
                }
                 
                }
           }

          $response = array();
          $response["agent1"]=$agent1['agentId'];
          $response["agent2"]=$agent2['agentId'];
      
         
         return view('showmatch',compact('group3','group2','group1','response'));

         } catch (Exception $e)
         {
   

            echo "<script> alert('web service fallo')</script>";
            return redirect()->to('/');
          } 
    }
} 