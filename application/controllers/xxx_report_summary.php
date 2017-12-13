<?php
class Report_Summary extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('approve_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		
		$data["title"] = "สรุปภาพรวมรายจ่าย";
		$data["path"] = array("ผู้บริหาร","รายงาน","สรุปภาพรวมรายจ่าย");
		$data["submenu"] = Mananger_menu(1);
		
		$budget_id = $this->session->userdata('budget_year_id');
		$data["budget_name"] = $this->budget_main_model->budgetyear_name($budget_id);
		
		$data["treegrid"] = $this->get_plans_level($budget_id);
		
		$this->template->load('template', 'budget/report_summary_view', $data);
	}
	
	public function get_plans_level($budget_id)
	{
	
		$data = $this->approve_model->plans_level_report($budget_id);
		
		$html = "";
		$temp_id = 0;

		if(count($data) > 0){	
			 $arr = array();
			 foreach ($data as $key => $value) {
				 	$arr[$value["id"]]["name"] = $value["name"];
				    
				    if(!isset($arr[$value["id"]]["amount"]))
					    $arr[$value["id"]]["amount"] = 0;
					
					if(!isset($arr[$value["id"]]["approve"]))
					 $arr[$value["id"]]["approve"] = 0;
					
					if(!isset($arr[$value["id"]]["payment"]))
					 $arr[$value["id"]]["payment"] = 0;
					 
					 // amount plan
					 if($temp_id != $value["product_id"]){
						 $arr[$value["id"]]["amount"] += $value["amount"]; 
					 }	 
					 $temp_id = $value["product_id"];
					 
					 // first time, work one time
					 if(!isset($temp_array)){
					    $temp_array[] = $value["approve_id"];
						$arr[$value["id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["id"]]["payment"] += floatval($value["payment"]);
					 }
					 
					// if not found!. go-in to if  
					if (in_array($value["approve_id"], $temp_array) == FALSE) {
					    $arr[$value["id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["id"]]["payment"] += floatval($value["payment"]);
						$temp_array[] = $value["approve_id"];
					}
					 
			 }
	   
	   			$sum_amount = 0;
				$sum_approve = 0;
				$sum_payment = 0;
				$sum_total_amount = 0;
				
				foreach ($arr as $key => $value) {
					
					 $total_amount = ($value["amount"]-$value["approve"]) + ($value["approve"]-$value["payment"]);		
							
			         $html .= '<tr class="teegrid-'.$key.'">';
			         $html .= '<td>'.$value["name"].'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["amount"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';	 
					 $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($total_amount,2).'</td>';
			         $html .= '</tr>';
					 $html .= $this->get_product_level($key);
					 
					 $sum_amount += $value["amount"];
					 $sum_approve += $value["approve"];
					 $sum_payment += $value["payment"];
					 $sum_total_amount += $total_amount;
				}
				 
				 // sum footer 
				 $html .= '<tr style="background-color: #EEEEEE"><td><strong>รวมเงินทั้งหมด</strong></td>';
				 $html .= '<td style="text-align: right">'.number_format($sum_amount,2).'</td>';
				 $html .= '<td style="text-align: right">'.number_format($sum_approve,2).'</td>';
				 $html .= '<td style="text-align: right">'.number_format($sum_payment,2).'</td>';
				 $html .= '<td style="text-align: right">'.number_format($sum_total_amount,2).'</td>';
				 $html .= '</tr>';
		}
		return $html;

		//dump($arr);
	    //$this->output->enable_profiler(TRUE);
	}
	
	
	
	public function get_product_level($plans_id)
	{
		 $data = $this->approve_model->product_level_report($plans_id);
		
		 $html = "";
		 $temp_id = 0;
		 
		 if(count($data) > 0){
				 $arr = array();
			 	
				 foreach ($data as $key => $value) {
					 	$arr[$value["mgt_product_id"]]["name"] = $value["name"];
					   
					    if(!isset($arr[$value["mgt_product_id"]]["amount"]))
					       $arr[$value["mgt_product_id"]]["amount"] = 0;
						
						if(!isset($arr[$value["mgt_product_id"]]["approve"]))
						 $arr[$value["mgt_product_id"]]["approve"] = 0;
						
						if(!isset($arr[$value["mgt_product_id"]]["payment"]))
						 $arr[$value["mgt_product_id"]]["payment"] = 0;
						 
						 if($temp_id != $value["id"]){
						   $arr[$value["mgt_product_id"]]["amount"] += $value["amount"]; 
						}
						 
						$temp_id = $value["id"];
						 
						$arr[$value["mgt_product_id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["mgt_product_id"]]["payment"] += floatval($value["payment"]);
				 }
			  	 
              
				foreach ($arr as $key => $value) {
					
					 $total_amount = ($value["amount"]-$value["approve"]) + ($value["approve"]-$value["payment"]);
					
					 $html .= '<tr class="teegrid-'.$plans_id.$key.' teegrid-parent-'.$plans_id.'">';
					 $html .= '<td>'.$value["name"].'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["amount"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';	 
					 $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($total_amount,2).'</td>';
			         $html .= '</tr>';
					 $html .= $this->get_costs_level($plans_id,$key);
				}
		 }
		
		 return $html;
		 
		//dump($arr);
	    //$this->output->enable_profiler(TRUE);
	}
	
	public function get_costs_level($plans_id,$product_id)
	{
		 $parent = $plans_id.$product_id;
		
		 $data = $this->approve_model->costs_level_report($product_id);
		
		 $html = "";
		 $temp_id = 0;
		 $temp_costs_id = 0;
		 
		 if(count($data) > 0){
				 $arr = array();
			 	
				 foreach ($data as $key => $value) {
					 	$arr[$value["costs_id"]]["name"] = $value["name"];
					    
					    if(!isset($arr[$value["costs_id"]]["amount"]))
					       $arr[$value["costs_id"]]["amount"] = 0;
					 
						if(!isset($arr[$value["costs_id"]]["approve"]))
						 $arr[$value["costs_id"]]["approve"] = 0;
						
						if(!isset($arr[$value["costs_id"]]["payment"]))
						 $arr[$value["costs_id"]]["payment"] = 0;
						
						$temp_costs_id = $value["costs_id"];
						
						if($temp_id != $value["id"] && $temp_costs_id == $value["costs_id"]){
						   $arr[$value["costs_id"]]["amount"] += $value["amount"]; 
						}
						
						//echo "if temp_id(". $temp_id. ") !=" .$value["id"]." AND  costs_id(".$temp_costs_id.") == ".$value["costs_id"]."<br>"; 
						//echo "Result amount ".$arr[$value["costs_id"]]["amount"]."<br><br>";
						
						$temp_id = $value["id"];
						
						
						$arr[$value["costs_id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["costs_id"]]["payment"] += floatval($value["payment"]);
				 }
			  	 
             
				foreach ($arr as $key => $value) {
					
					 $total_amount = ($value["amount"]-$value["approve"]) + ($value["approve"]-$value["payment"]);
					
					 $html .= '<tr class="teegrid-'.$parent.$key.' teegrid-parent-'.$parent.'">';
					 $html .= '<td>'.$value["name"].'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["amount"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';	 
					 $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($total_amount,2).'</td>';
			         $html .= '</tr>';
					 $html .= $this->get_coststype_level($plans_id,$product_id,$key);
				}
		 }
		
		return $html;
		 
		//dump($data);
	  // $this->output->enable_profiler(TRUE);
	}


	public function get_coststype_level($plans_id,$product_id,$costs_id)
	{
		 $parent = $plans_id.$product_id.$costs_id;
		
		 $data = $this->approve_model->costs_type_level_report($product_id,$costs_id);
		
		 $html = "";
		 $temp_id = 0;
		 $temp_coststype_id = 0;
		 
		 if(count($data) > 0){
				 $arr = array();
			 	
				 foreach ($data as $key => $value) {
					 	$arr[$value["costs_type_id"]]["name"] = $value["name"];
					   
						if(!isset($arr[$value["costs_type_id"]]["amount"]))
						 $arr[$value["costs_type_id"]]["amount"] = 0;
						
						if(!isset($arr[$value["costs_type_id"]]["approve"]))
						 $arr[$value["costs_type_id"]]["approve"] = 0;
						
						if(!isset($arr[$value["costs_type_id"]]["payment"]))
						 $arr[$value["costs_type_id"]]["payment"] = 0;
						
						$temp_coststype_id = $value["costs_type_id"];
						
						if($temp_id != $value["id"] && $temp_coststype_id == $value["costs_type_id"]){
						   $arr[$value["costs_type_id"]]["amount"] += $value["amount"]; 
						}else {
						    $arr[$value["costs_type_id"]]["amount"] = $value["amount"];
						}
						
						$temp_id = $value["id"];
						
						$arr[$value["costs_type_id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["costs_type_id"]]["payment"] += floatval($value["payment"]);
				 }
			  	 
             
				foreach ($arr as $key => $value) {
					
					 $total_amount = ($value["amount"]-$value["approve"]) + ($value["approve"]-$value["payment"]);
					
					 $html .= '<tr class="teegrid-'.$parent.$key.' teegrid-parent-'.$parent.'">';
					 $html .= '<td>'.$value["name"].'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["amount"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';	 
					 $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($total_amount,2).'</td>';
			         $html .= '</tr>';
					 $html .= $this->get_costslists_level($plans_id, $product_id, $costs_id, $key);
				}
		 }
		
	     return $html;
		 
		// dump($arr);
	   // $this->output->enable_profiler(TRUE);
	}

	public function get_costslists_level($plans_id, $product_id, $costs_id, $costs_type_id)
	{
		 $parent = $plans_id.$product_id.$costs_id.$costs_type_id;
		
		 $data = $this->approve_model->costs_lists_level_report($product_id, $costs_type_id);
		
		 $html = "";
		 if(count($data) > 0){
				 $arr = array();
			 	
				 foreach ($data as $key => $value) {
					 	$arr[$value["id"]]["name"] = $value["name"];
					    $arr[$value["id"]]["amount"] = $value["amount"];
						
						if(!isset($arr[$value["id"]]["approve"]))
						 $arr[$value["id"]]["approve"] = 0;
						
						if(!isset($arr[$value["id"]]["payment"]))
						 $arr[$value["id"]]["payment"] = 0;
						 
						$arr[$value["id"]]["approve"] += floatval($value["approve"]);
						$arr[$value["id"]]["payment"] += floatval($value["payment"]);
				 }
			  	 
          
				foreach ($arr as $key => $value) {
					 	
					 $total_amount = ($value["amount"]-$value["approve"]) + ($value["approve"]-$value["payment"]);
					
					 $html .= '<tr class="teegrid-'.$parent.$key.' teegrid-parent-'.$parent.'">';
					 $html .= '<td><i class="icon-minus"></i> '.$value["name"].'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["amount"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($value["approve"],2).'</td>';	 
					 $html .= '<td style="text-align: right">'.number_format($value["payment"],2).'</td>';
					 $html .= '<td style="text-align: right">'.number_format($total_amount,2).'</td>';
			         $html .= '</tr>';
				}
		   
	
		 }
	
	   return $html;
		 
		//dump($arr);
	   // $this->output->enable_profiler(TRUE);
	}
	

}