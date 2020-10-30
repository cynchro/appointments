<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointments extends Model
{
    protected $table = 'appointments';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'slot_id',
        'date',
        'patient'
    ];
    
    /*
     Check if that time is free
     */
    public function hasAppointment($date,$time){
        return $this->join('slot','slot.id','=','appointments.slot_id')
        ->where('appointments.date',$date)
        ->where('slot.slot',$time)
        ->count();
        
    }
    
    public function saveAppointment($date,$patient,$slotId){
        $this->date = $date;
        $this->patient = $patient;
        $this->slot_id = $slotId;
        
        $this->save();
        
        return $this->id;
    }
    
    public function deleteById($appointmentId){
        $appointment = $this::find($appointmentId);
        
        if($appointment&&$appointment->delete()){
            return true;
        }
        
        return false;
    }
}