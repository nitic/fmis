<?php
class Budget_Status extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('budget_status_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "สถานะแหล่งงบประมาณ";
		$data["path"] = array("งานแผน","จัดการแหล่งเงินงบประมาณ","เปิด-ปิดแหล่งงบประมาณ");
		$data["submenu"] = Plans_menu(1);
		
		$data['rows'] = $this->budget_main_model->status_page();
		$this->template->load('template', 'budget/status_view',$data);
	}
	
	public function get()
	{
		 $data['rows'] = $this->budget_main_model->status_page();
         print_r($data['rows']);
	}
	
	public function combobox()
	{
		 $data = $this->budget_status_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function update($eid,$state)
	{
	  if(isset($eid)){
			if($state == 'on'){	
			   $data = array('status_id' => 2);
			}
			elseif($state == 'off'){	
			   $data = array('status_id' => 3);
			}
	        $id = $this->budget_main_model->save($data,$eid);
		   
		    if(isset($id)){
		   	  echo json_encode(array('success'=>true));
		    }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		    }
	  }
	}
	

}