<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

//use App\contactslist;

class mulutest extends TestCase
{
   
    public function test_mulu()
    {
    //	contactslist::create(["Name"=>"Michael"]);//, "zipCode"=>"85273"]); 

//        contactslist::create(["Name"=>"James", "zipCode"=>"85750"]);

  //      contactslist::create(["Name"=>"Brian", "zipCode"=>"85751"]);

    	$this->visit("home")
    	      ->see("DARWIN MIGUEL ROCHA GUERRERO");
    //	->see("cargar CSV")
    //	->see("cargar agentes")
    //	->see("MATCH");
    }
       
}
