<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;

class Contacts extends Model //Mailable 
{
   // private $data;
   // public function __construct() {
      //  $this->data = $data;
    // }

    protected $table = 'contacts';
    public $timestamps = true;
    protected $fillable = array('name', 'email', 'phone', 'subject', 'message');


    //public function build()
    //{
      //  return $this->markdown('emails.contact' , ['data' => $this->data]);
   // }

} 