<?php
class Department extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('department_model');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลภาควิชา";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานหน่วยงาน","จัดการข้อมูลภาควิชา");
		$data["submenu"] = Admin_menu(4);
		$this->template->load('template', 'department_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->department_model->limit = $rows;
		 $this->department_model->offset = $offset;
		 $this->department_model->sort = $sort;
		 $this->department_model->order = $order;
		 $result['total'] = $this->department_model->num_page();
		 $result['rows'] = $this->department_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->department_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function get_by($faculty_code)
	{
		$data = $this->department_model->get_by('faculty_code',$faculty_code);
		header('Content-type: application/json');
                echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'name' => $_REQUEST['name'],
                'faculty_code' => $_REQUEST['ccfaculty']);
         $id = $this->department_model->save($data);
	   
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
                'faculty_code' => $_REQUEST['ccfaculty']);
	         $id = $this->department_model->save($data,$eid);
		   
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
        $this->department_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
