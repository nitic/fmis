<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ThaiDate { 
    function __construct() {
		ini_set('default_charset', 'UTF-8'); 
        date_default_timezone_set('Asia/Bangkok'); 
	}

    # Set date format 
    public function setDateFormat($date, $f) { 
        // Full month array 
        $f_m = array("01"=>"มกราคม",  
                "02"=>"กุมภาพันธ์",  
                "03"=>"มีนาคม",  
                "04"=>"เมษายน",  
                "05"=>"พฤษภาคม",  
                "06"=>"มิถุนายน",  
                "07"=>"กรกฎาคม",  
                "08"=>"สิงหาคม",  
                "09"=>"กันยายน", 
                "10"=>"ตุลาคม", 
                "11"=>"พฤศจิกายน", 
                "12"=>"ธันวาคม" 
        ); 
         
        // Quick month array 
        $q_m = array("01"=>"ม.ค.",  
                "02"=>"ก.พ.",  
                "03"=>"มี.ค.",  
                "04"=>"เม.ย.",  
                "05"=>"พ.ค.",  
                "06"=>"มิ.ย.",  
                "07"=>"ก.ค.",  
                "08"=>"ส.ค.",  
                "09"=>"ก.ย.",  
                "10"=>"ต.ค.",  
                "11"=>"พ.ย.",  
                "12"=>"ธ.ค." 
        ); 
         
        if($f == '1')  
            return ((int) substr($date, 8)).' '. 
                         $q_m[substr($date, 5, -3)].' '.(substr($date, 2, -6)+43); 
        if($f == '2')  
            return (int)substr($date, 8).' '. 
                         $f_m[substr($date, 5, -3)].' '.((int)substr($date, 0, -6) + 543); 
        if($f == '3')  
            return 'วันที่ '.(int)substr($date, 8).' เดือน '. 
                         $f_m[substr($date, 5, -3)].' พ.ศ. '.((int)substr($date, 0, -6) + 543);  
    } 
     
    # Set time format 
    public function setTimeFormat($time, $f) { 
        if($f == '1')  
            return substr($time, 0, -6).':'. 
                         substr($time, 3, -3).' น.'; 
        if($f == '2')  
            return substr($time, 0, -6).':'. 
                         substr($time, 3, -3).':'. 
                         substr($time, 6); 
    } 
} 
