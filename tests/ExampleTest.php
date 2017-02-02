<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Contact;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        Contact::create(['name'=>'carlos','zipCode'=>'797238']);
        Contact::create(['name'=>'darwin','zipCode'=>'74237482']);
        $this->visit('/')
            ->see('Darwin Rocha Guerrero')
            ->click('Add a agents')
            ->seePageIs('/cargaragents')
            ->click('Add a CSV')
            ->seePageIs('/cargarcsv')
            ->seeInDatabase('contacts', ['name'=>'darwin','zipCode'=>'74237482']);
    }

    public function testBasicExample2()
    {
       
       
             
    }
}
?>