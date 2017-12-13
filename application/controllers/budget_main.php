<?php
class Budget_Main extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลพื้นฐานแหล่งเงิน";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานแหล่งเงิน","จัดการปีงบประมาณ");
		$data["submenu"] = Admin_menu(1);
		$this->template->load('template', 'budget/main_view',$data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
	
		 $this->budget_main_model->limit = $rows;
		 $this->budget_main_model->offset = $offset;
		 $this->budget_main_model->sort = $sort;
		 $this->budget_main_model->order = $order;
		 $result['total'] = $this->budget_main_model->num_page();
		 $result['rows'] = $this->budget_main_model->list_page();
		 
		header('Content-type: application/json');
        echo json_encode($result);
        //dump($result['rows']);
		 //$this->output->enable_profiler(TRUE);
	}
	
	//budget source list
	public function combobox($status_id = "")
	{
		 $where = !empty($status_id) ? mysql_real_escape_string($status_id) : '';
		
		 $data = $this->budget_main_model->lists_source($where);
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	// All budget source list with label 'Select all'
	public function combobox2()
	{
		 $data = $this->budget_main_model->lists_source();
		 header('Content-type: application/json');
	
		 $inserted = array(array('id' => '0','year' => '0000','amount'=>'0.00','title' => 'Select all'));
		 $data = array_merge($inserted,$data);
         echo json_encode($data);
	}
	
	
	public function add()
	{
	   $data = array(
            'budget_id' => $_REQUEST['title'],
            'year' => $_REQUEST['year']-543,
			'start_date' => formatDateToMySql($_REQUEST['start_date']),
            'end_date' => formatDateToMySql($_REQUEST['end_date']),
			'amount' => $_REQUEST['amount'],
			'status_id' => $_REQUEST['status']);
	    $id = $this->budget_main_model->save($data);  
	   
	   if(isset($id)){
	   	  echo json_encode(array('success'=>true));
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured.'));
	   }
	}
	
	public function update($eid)
	{
	  if(isset($eid)){
			$data = array(
            'budget_id' => $_REQUEST['title'],
            'year' => $_REQUEST['year']-543,
			'start_date' => formatDateToMySql($_REQUEST['start_date']),
            'end_date' => formatDateToMySql($_REQUEST['end_date']),
			'amount' => $_REQUEST['amount'],
			'status_id' => $_REQUEST['status']);
	        $id = $this->budget_main_model->save($data,$eid);
		    if(isset($id)){
                if ($id === $this->session->userdata('budget_year_id'))
                {
                     $this->session->set_userdata('budget_year_amount', $_REQUEST['amount']);
                }
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
        $this->budget_main_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
