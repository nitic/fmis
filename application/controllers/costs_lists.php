<?php
class Costs_Lists extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('costs_lists_model');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลรายการรายจ่าย";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานงบประมาณรายจ่าย","จัดการข้อมูลรายการรายจ่าย");
		$data["submenu"] = Admin_menu(3);
		$this->template->load('template', 'costs/costs_lists_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $where = isset($_POST['costs_type_id']) ? mysql_real_escape_string($_POST['costs_type_id']) : '';
		 
		 $this->costs_lists_model->limit = $rows;
		 $this->costs_lists_model->offset = $offset;
		 $this->costs_lists_model->sort = $sort;
		 $this->costs_lists_model->order = $order;
		 $result['total'] = $this->costs_lists_model->num_page($where);
		 $result['rows'] = $this->costs_lists_model->list_page($where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
        
        //$this->output->enable_profiler(TRUE);
		//dump($result);
	}
	
	public function get_by($type_id)
	{
		$data = $this->costs_lists_model->get_by('costs_type_id',$type_id);
		header('Content-type: application/json');
                echo json_encode($data);
	}
	
	public function add()
	{   
	     $data = array(
	                'name' => $_REQUEST['name'],
	                'costs_type_id' => $_REQUEST['type']);
         $id = $this->costs_lists_model->save($data);
	   
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
	                'name' => $_REQUEST['name'],
	                'costs_type_id' => $_REQUEST['type']);
	         $id = $this->costs_lists_model->save($data,$eid);
		   
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
        $this->costs_lists_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
