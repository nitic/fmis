<?php
class Mgt_Plans extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('mgt_plans_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "1.จัดสรรงบประมาณระดับแผนงาน";
		$data["path"] = array("งานแผน","จัดสรรงบประมาณประจำปี","จัดสรรงบประมาณระดับแผนงาน");
		$data["submenu"] = Plans_menu(2);
		$this->template->load('template', 'budget/mgt_plans_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		 
		 $this->mgt_plans_model->limit = $rows;
		 $this->mgt_plans_model->offset = $offset;
		 $this->mgt_plans_model->sort = $sort;
		 $this->mgt_plans_model->order = $order;
		 $result['total'] = $this->mgt_plans_model->num_page($where);
		 $result['rows'] = $this->mgt_plans_model->list_page($where);
		
		header('Content-type: application/json');
        echo json_encode($result);
        // dump($data);
		// $this->output->enable_profiler(TRUE);
	}
	
	public function get_summary()
	{
		$session_budget_id = $this->session->userdata('budget_year_id');
		$where = isset($session_budget_id) ? mysql_real_escape_string($session_budget_id) : '';
		$data = $this->mgt_plans_model->summary_page($where);
		header('Content-type: application/json');
        echo json_encode($data);	
	}
	
	public function get_by($budget_main_id)
	{
		$data = $this->mgt_plans_model->list_by($budget_main_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function combobox($budget_main_id)
	{
		 $data = $this->mgt_plans_model->list_by($budget_main_id);
		 
		 $inserted = array(array('id' => '0','plan_id'=>'0','name' => 'เลือกทั้งหมด','amount'=>'0.00'));
		 $data = array_merge($inserted,$data);
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function get_balance($budget_main_id)
	{
		$data = $this->mgt_plans_model->get_budget_balance($budget_main_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function get_amount()
	{
		$data = $this->mgt_plans_model->get_amount();
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	
	public function add()
	{
	   $session_budget_id = $this->session->userdata('budget_year_id');
	   $chk = count($this->mgt_plans_model->get_by(array('budget_main_id' => $session_budget_id, 'plan_id ' => $_REQUEST['ccplan'])));	
	   if($chk == 0){	
		       $data = array(
		        'budget_main_id' => $session_budget_id,
	            'plan_id' => $_REQUEST['ccplan'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));
		  
		   $id = $this->mgt_plans_model->save($data);  
		   
		   if(isset($id)){
		   	  echo json_encode(array('success'=>true));
		   }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		   }
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured. duplicate budget and plan'));
	   }
	}
	
	public function update($eid)
	{
	  if(isset($eid)){
			$data = array(
	            'plan_id' => $_REQUEST['ccplan'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));
           
		       $id = $this->mgt_plans_model->save($data,$eid);
			   if(isset($id)){
			   	  echo json_encode(array('success'=>true));
			    }
			    else {
				   echo json_encode(array('msg'=>'Some errors occured.'));
			    }			  
	  }
	}
	
	public function delete() {
       if(isset($_REQUEST['id'])){
       	$id = intval($_REQUEST['id']);	  
        $this->mgt_plans_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}