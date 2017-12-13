<?php
class Report_Planners extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('mgt_plans_model');
		$this->load->model('mgt_product_model');
		$this->load->model('mgt_costs_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "สรุปข้อมูลการจัดสรรงบประมาณ";
		$data["path"] = array("งานแผน","รายงาน","สรุปข้อมูลการจัดสรรงบประมาณ");
		$data["submenu"] = Plans_menu(3);
		$this->template->load('template', 'budget/report_planners_view', $data);
	}
	
	public function get()
	{

		 $where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		 $plan_data = $this->mgt_plans_model->report_page($where);
		 
         $refs = array();
         $list = array();	 
		 
		 // level 1
         foreach ($plan_data as $value) {
         	 	
			 $plan_id = $value['id'];	
         	 $thisref = &$refs[$plan_id];
        
			 $thisref['id'] = $plan_id;
         	 $thisref['name'] = $value['name'];
			 $thisref['amount'] = $value['amount'];
			 $thisref['balance'] = $value['balance'];
    			
			   // children level 2
			   if($this->mgt_product_model->report_num_page($value['id']) > 0){
				     	
				     $product_data = $this->mgt_product_model->report_page($value['id']);
			
					 foreach ($product_data as $value2) {

						 $product_id = $value['id'].$value2['id'];
						
					 	 $thisref2 = &$refs[$product_id];
						 
						 $thisref2['id'] = $product_id;
						 $thisref2['name'] = $value2['name'];
			             $thisref2['amount'] = $value2['amount'];
						 $thisref2['balance'] = $value2['balance'];
						 
					   $refs[$plan_id]['children'][] = &$thisref2;
						 
					   // children level 3
					   if($this->mgt_costs_model->report_num_page($value2['id']) > 0){

						 	$costs_data = $this->mgt_costs_model->report_page($value2['id']);
							
							foreach ($costs_data as $value3) {
								
								$costs_id = $value['id'].$value2['id'].$value3['id'];
								
								$thisref3 = &$refs[$costs_id];
								 
								$thisref3['id'] = $costs_id;
								$thisref3['name'] = $value3['name'];
			                    $thisref3['amount'] = $value3['amount'];
						        
								$refs[$product_id]['children'][] = &$thisref3;
							}
						 } // end level 3
					 }
				} // end level 2
			 
			 $list[] = $thisref;
         }
		 $mylist["rows"] = $list;
        // dump($mylist["rows"]);
		header('Content-type: application/json');
        echo json_encode($mylist["rows"]);
	   //  $this->output->enable_profiler(TRUE);
	}
	
}