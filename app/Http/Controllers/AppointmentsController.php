<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Slot;
use App\Appointments;


class AppointmentsController extends Controller
{
    private $Appointment;
    private $Slot;
    
    public function __construct(Appointments $appointment, Slot $slot){
        $this->Appointment = $appointment;
        $this->Slot = $slot;
    }
    
    /*
     Check All Slots
     */
    
    public function getFree(Request $request){
        
            $result = array_column($this->Slot->getAllFreeFroDate($request->date),'slot');
            return Array('slots'=>$result);
        
        return "error";
        
    }
    
    /*
     Check all slot for date
     */
    
    public function getAll(){
        
        return Array('slots'=>array_column($this->Slot->all('slot')->toArray(),'slot'));
        
        return "error";
        
    }
    
    
    /*
     Schedule a time
     */
    public function markit(Request $request){

        $slot = $this->Slot->getSlotByTime($request->time);
        
        if(!$this->Appointment->hasAppointment($request->date,$request->time)&&$slot->id){
            return '{appointmentId:'.$this->Appointment->saveAppointment($request->date,$request->patient,$slot->id).'}';
        }
        
        return '{error: “Unable to reserve the appointment”}';
        
    }
    
    /*
     Delete appointments
     */
    public function delete(Request $request){

        if($this->Appointment->deleteById($request->id)){
            return '{success}';
        }
        
        return '{error: “Unable to reserve the appointment”}';
    }
    
}
