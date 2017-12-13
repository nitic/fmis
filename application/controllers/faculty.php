<?php
class Faculty extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('faculty_model');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลคณะ";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานหน่วยงาน","จัดการข้อมูลคณะ");
		$data["submenu"] = Admin_menu(4);
		$this->template->load('template', 'faculty_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->faculty_model->limit = $rows;
		 $this->faculty_model->offset = $offset;
		 $this->faculty_model->sort = $sort;
		 $this->faculty_model->order = $order;
		 $result['total'] = $this->faculty_model->num_page();
		 $result['rows'] = $this->faculty_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->faculty_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'code' => $_REQUEST['code'],
                'name' => $_REQUEST['name']);
         $id = $this->faculty_model->save($data);
	   
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
		         'code' => $_REQUEST['code'],
                 'name' => $_REQUEST['name']);
	         $id = $this->faculty_model->save($data,$eid);
		   
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
        $this->faculty_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
