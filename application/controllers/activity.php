<?php
class Activity extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('activity_model');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลรายการกิจกรรม";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานแผนงบประมาณ","จัดการข้อมูลรายการกิจกรรม");
		$data["submenu"] = Admin_menu(2);
		$this->template->load('template', 'category/activity_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->activity_model->limit = $rows;
		 $this->activity_model->offset = $offset;
		 $this->activity_model->sort = $sort;
		 $this->activity_model->order = $order;
		 $result['total'] = $this->activity_model->num_page();
		 $result['rows'] = $this->activity_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
		//dump($data);
		//$this->output->enable_profiler(TRUE);
	}
	
	public function combobox()
	{
		$data = $this->activity_model->get();
		header('Content-type: application/json');
                echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
            'name' => $_REQUEST['name'],
            'detail' => $_REQUEST['detail'],
            'is_active' => $_REQUEST['is_active'],
			'create_date' => date('Y-m-d H:i:s'));
	   				
	     $id = $this->activity_model->save($data);
	   
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
            'detail' => $_REQUEST['detail'],
            'is_active' => $_REQUEST['is_active'],
			'create_date' => date('Y-m-d H:i:s'));
	         
	         $id = $this->activity_model->save($data,$eid);
		   
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
        $this->activity_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
