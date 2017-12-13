<?php
class Project extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('project_model');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลรายการโครงการ";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานแผนงบประมาณ","จัดการข้อมูลรายการโครงการ");
		$data["submenu"] = Admin_menu(2);
		$this->template->load('template', 'category/project_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->project_model->limit = $rows;
		 $this->project_model->offset = $offset;
		 $this->project_model->sort = $sort;
		 $this->project_model->order = $order;
		 $result['total'] = $this->project_model->num_page();
		 $result['rows'] = $this->project_model->list_page();
		
		header('Content-type: application/json');
                echo json_encode($result);
		 //dump($data);
		 //$this->output->enable_profiler(TRUE);
	}

	public function combobox()
	{
		$data = $this->project_model->get();
		header('Content-type: application/json');
                echo json_encode($data);
	}

	public function get_by($product_id)
	{
		$data = $this->project_model->get_by('product_id',$product_id);
		header('Content-type: application/json');
                echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
            'name' => $_REQUEST['name'],
            'product_id' => $_REQUEST['product'],
            'is_active' => $_REQUEST['is_active'],
			'create_date' => date('Y-m-d H:i:s'));
	   	
	   $id = $this->project_model->save($data);
	   
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
            'product_id' => $_REQUEST['product'],
            'is_active' => $_REQUEST['is_active'],
			'create_date' => date('Y-m-d H:i:s'));
	        
	        $id = $this->project_model->save($data,$eid);
		   
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
        $this->project_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
