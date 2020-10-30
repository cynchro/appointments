<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Appointments;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AppointmentsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
    /**
     * Test if Api works calling a simple service (GET)
     */
    public function testApiWorks()
    {
        $date = '2010-10-10';
        $result = $this->call('GET', 'api/appointments/' . env('TOKEN').'/'.$date.'/free')->content();
        print_r($result);
        $result = collect($result);
        $this->assertEquals($result->count() > 0, true);
    }
    
    /**
     * TESTING GET
     * Shows free slots for 10/10/2010
     */
    public function testShowFreeSlots(){
        $Ok = '{"slots":["10:00","10:30","11:00","11:30","12:00"]}';
        $date = '2010-10-10';
        $result = $this->call('GET', 'api/appointments/' . env('TOKEN').'/'.$date.'/free')->content();
        $this->assertEquals($result , $Ok);
    }
    
    
    /**
     * TESTING POST
     * Insert a single appointment at 10/10/2010
     */
    public function testInsertAppointment()
    {
        DB::beginTransaction();
        $date = '2010-10-10';
        $time = '10:30';
        $patient = 'Jeronimo';
        $result = $this->call('POST', 'api/appointments/' . env('TOKEN').'/'.$date.'/'.$time.'/'.$patient)->content();
        $this->assertContains('appointmentId:',$result);
        DB::rollback();
    }
    
    /**
     * TESTING POST AND GET
     * Insert app and test if show corrects slots
     */
    public function testInsertAppAndShowFreeSlots(){
        DB::beginTransaction();
        
        $date = '2010-10-10';
        $time = '10:30';
        $patient = 'Jeronimo';
        $Ok = '{"slots":["10:00","11:00","11:30","12:00"]}';
        $date = '2010-10-10';
        
        $this->call('POST', 'api/appointments/' . env('TOKEN').'/'.$date.'/'.$time.'/'.$patient)->content();
        
        $result = $this->call('GET', 'api/appointments/' . env('TOKEN').'/'.$date.'/free')->content();
        
        $this->assertEquals($result , $Ok);
        
        DB::rollback();
    }
    
    /**
     * TESTING POST, DELETE AND GET
     * insert delete and show free slots
     */
    public function testInsertAppDeleteAndShowFree(){
        DB::beginTransaction();
        
        $date = '2010-10-10';
        $time = '10:30';
        $patient = 'Jeronimo';
        $Ok = '{"slots":["10:00","10:30","11:00","11:30","12:00"]}';
        $date = '2010-10-10';
        
        $result = $this->call('POST', 'api/appointments/' . env('TOKEN').'/'.$date.'/'.$time.'/'.$patient)->content();
        
        $id = str_replace("{appointmentId:","",$result);
        $id = str_replace("}","",$id);
        
        $this->call('DELETE', 'api/appointments/' . env('TOKEN').'/'.$id)->content();
        
        $result = $this->call('GET', 'api/appointments/' . env('TOKEN').'/'.$date.'/free')->content();
        
        $this->assertEquals($result , $Ok);
        
        DB::rollback();
    }
    
    
}