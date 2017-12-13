<?php

function formatDateToMySql($date)
{
	list($d, $m, $y) = explode("/", $date);
    $mydate = sprintf('%4d-%02d-%02d', ($y-543), $m, $d);
	$mydate = date('Y-m-d', strtotime($mydate));
	return $mydate;
}

function formatThaiDate($date){

    list($y, $m, $d) = explode("-", $date);
    $mydate = sprintf('%02d/%02d/%4d', $d, $m, ($y+543));
	return $mydate;
}

function array_2d_to_1d ($input_array) {
    $output_array = array();
	
	foreach ($input_array as $temp_array) {
		foreach ($temp_array as $key => $value) {
			$output_array[$key] = $value;
		}
	}
	
    return $output_array;
}