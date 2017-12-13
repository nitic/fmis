<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ThaiDate { 
    function __construct() {
		ini_set('default_charset', 'UTF-8'); 
        date_default_timezone_set('Asia/Bangkok'); 
	}

    # Set date format 
    public function setDateFormat($date, $f) { 
        // Full month array 
        $f_m = array("01"=>"���Ҥ�",  
                "02"=>"����Ҿѹ��",  
                "03"=>"�չҤ�",  
                "04"=>"����¹",  
                "05"=>"����Ҥ�",  
                "06"=>"�Զع�¹",  
                "07"=>"�á�Ҥ�",  
                "08"=>"�ԧ�Ҥ�",  
                "09"=>"�ѹ��¹", 
                "10"=>"���Ҥ�", 
                "11"=>"��Ȩԡ�¹", 
                "12"=>"�ѹ�Ҥ�" 
        ); 
         
        // Quick month array 
        $q_m = array("01"=>"�.�.",  
                "02"=>"�.�.",  
                "03"=>"��.�.",  
                "04"=>"��.�.",  
                "05"=>"�.�.",  
                "06"=>"��.�.",  
                "07"=>"�.�.",  
                "08"=>"�.�.",  
                "09"=>"�.�.",  
                "10"=>"�.�.",  
                "11"=>"�.�.",  
                "12"=>"�.�." 
        ); 
         
        if($f == '1')  
            return ((int) substr($date, 8)).' '. 
                         $q_m[substr($date, 5, -3)].' '.(substr($date, 2, -6)+43); 
        if($f == '2')  
            return (int)substr($date, 8).' '. 
                         $f_m[substr($date, 5, -3)].' '.((int)substr($date, 0, -6) + 543); 
        if($f == '3')  
            return '�ѹ��� '.(int)substr($date, 8).' ��͹ '. 
                         $f_m[substr($date, 5, -3)].' �.�. '.((int)substr($date, 0, -6) + 543);  
    } 
     
    # Set time format 
    public function setTimeFormat($time, $f) { 
        if($f == '1')  
            return substr($time, 0, -6).':'. 
                         substr($time, 3, -3).' �.'; 
        if($f == '2')  
            return substr($time, 0, -6).':'. 
                         substr($time, 3, -3).':'. 
                         substr($time, 6); 
    } 
} 
