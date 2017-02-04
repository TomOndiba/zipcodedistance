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
        
        if($tamanio>0)
        {     
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
             
                   //guardamos en base de datos la línea leida con su locations
                    $location= $this->getLocation($zipcode);

                   // var_dump($location);
                    Contact::create(['name'=>$nombre,'zipCode'=>$zipcode,'latitud'=>$location["lat"],'longitud'=>$location["lng"]]);

             
                   //cerramos condición
               }
             
               /*Cuando pase la primera pasada se incrementará nuestro valor y a la siguiente pasada ya 
               entraremos en la condición, de esta manera conseguimos que no lea la primera línea.*/
               $i++;
               //cerramos bucle
            }
            return redirect()->to('/');
        }
        else
        {
         echo "<script>alert('debe subir un archivo');</script>";
         return view('cargarcsv');
        }
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

        $location= $this->getLocation($request->input('zipCode'));

        $agent1 = array("name"=>$request->input('name'),"zipCode"=>$request->input('zipCode'),"agentId"=>$request->input('agentId'),"location"=> $location);

        $location= $this->getLocation($request->input('zipCode2'));

        $agent2 = array("name"=>$request->input('name2'),"zipCode"=>$request->input('zipCode2'),"agentId"=>$request->input('agentId2'),"location"=> $location);
                              

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




public function matchDistance()
    {
        
          $contacts = Contact::all();
          $agent1 =  session()->get('agent1');
          $agent2 =  session()->get('agent2');
         
          $ii=0;

          $group1= array();
          $group2= array();
          $group3= array();

          try {

          foreach ($contacts  as $contact) 
          {
     
             if($contact->latitud!=0 && $contact->longitud!=0)
             {


              $distance1= $this->distanceCalculation($agent1['location']['lat'],$agent1['location']['lng'],$contact->latitud,$contact->longitud);

              $distance2= $this->distanceCalculation($agent2['location']['lat'],$agent2['location']['lng'],$contact->latitud,$contact->longitud);

                if($distance1<$distance2)
                {
                    $set = array('distance' => $distance1,'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);

                    $group1[]=$set ;
                }
                else
                {
                  $set = array('distance' => $distance2,'contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);
                    
                    $group2[]=$set ;
                }
                
             }
             else 
             {
  
                $set = array('distance' => 'no se pudo calcular','contactName'=>$contact->name, 'zipCode'=>$contact->zipCode);
                        
                $group3[]=$set ;

              }
           }

          $response = array();
          $response["agent1"]=$agent1['agentId'];
          $response["agent2"]=$agent2['agentId'];
      
         
         return view('showmatchd',compact('group3','group2','group1','response'));

         } catch (Exception $e)
         {
   

            echo "<script> alert('algo salio mal Oops!')</script>";
            return redirect()->to('/');
          } 
    }
/*************************/

    private  function getLocation($zipcode)
    {
      ini_set('max_execution_time', 60);

      $url="https://maps.googleapis.com/maps/api/geocode/json?components=postal_code:".$zipcode."&key={api_key_google}";
      $json = file_get_contents($url);
      $response=json_decode($json, true);
     


      $location = array("lat"=>0,"lng"=>0);
      if( $response["status"]=="OK")
      {
        $location =  $response["results"][0]["geometry"]["location"];

      }
   
     
      

      return $location;
    }


 
private function distanceCalculation($point1_lat, $point1_long, $point2_lat, $point2_long, $unit = 'km', $decimals = 2) {
      /*
Descripción: Cálculo de la distancia entre 2 puntos en función de su latitud/longitud
Autor: Rajesh Singh (2014)
Sito web: AssemblySys.com
 
Si este código le es útil, puede mostrar su
agradecimiento a Rajesh ofreciéndole un café ;)
PayPal: rajesh.singh@assemblysys.com
 
Mientras estos comentarios (incluyendo nombre y detalles del autor) estén
incluidos y SIN ALTERAR, este código está distribuido bajo la GNU Licencia
Pública General versión 3: http://www.gnu.org/licenses/gpl.html
*/
  // Cálculo de la distancia en grados
  $degrees = rad2deg(acos((sin(deg2rad($point1_lat))*sin(deg2rad($point2_lat))) + (cos(deg2rad($point1_lat))*cos(deg2rad($point2_lat))*cos(deg2rad($point1_long-$point2_long)))));
 
  // Conversión de la distancia en grados a la unidad escogida (kilómetros, millas o millas naúticas)
  switch($unit) {
    case 'km':
      $distance = $degrees * 111.13384; // 1 grado = 111.13384 km, basándose en el diametro promedio de la Tierra (12.735 km)
      break;
    case 'mi':
      $distance = $degrees * 69.05482; // 1 grado = 69.05482 millas, basándose en el diametro promedio de la Tierra (7.913,1 millas)
      break;
    case 'nmi':
      $distance =  $degrees * 59.97662; // 1 grado = 59.97662 millas naúticas, basándose en el diametro promedio de la Tierra (6,876.3 millas naúticas)
  }
  return round($distance, $decimals);
}
}  