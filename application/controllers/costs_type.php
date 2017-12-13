<?php
class Costs_Type extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('costs_type_model');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลประเภทรายจ่าย";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานงบประมาณรายจ่าย","จัดการข้อมูลประเภทรายจ่าย");
		$data["submenu"] = Admin_menu(3);
		$this->template->load('template', 'costs/costs_type_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->costs_type_model->limit = $rows;
		 $this->costs_type_model->offset = $offset;
		 $this->costs_type_model->sort = $sort;
		 $this->costs_type_model->order = $order;
		 $result['total'] = $this->costs_type_model->num_page();
		 $result['rows'] = $this->costs_type_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->costs_type_model->get();
		 header('Content-type: application/json');
                 echo json_encode($data);
	}
	
	public function combobox2()
	{
		 $data = $this->costs_type_model->get();
		 header('Content-type: application/json');
		
		 $inserted = array(array('id' => '','name' => 'Select all','costs_group_id' => 0));
		 $data = array_merge($inserted,$data);
                 echo json_encode($data);
	}

	public function get_by($group_id)
	{
		$data = $this->costs_type_model->get_by('costs_group_id',$group_id);
		header('Content-type: application/json');
                echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	           'name' => $_REQUEST['name'],
               'costs_group_id' => $_REQUEST['group']);
         $id = $this->costs_type_model->save($data);
	   
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
                    'costs_group_id' => $_REQUEST['group']);
	         $id = $this->costs_type_model->save($data,$eid);
		   
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
        $this->costs_type_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
