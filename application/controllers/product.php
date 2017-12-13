<?php
class Product extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('product_model');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลรายการผลผลิต";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานแผนงบประมาณ","จัดการข้อมูลรายการผลผลิต");
		$data["submenu"] = Admin_menu(2);
		$this->template->load('template', 'category/product_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->product_model->limit = $rows;
		 $this->product_model->offset = $offset;
		 $this->product_model->sort = $sort;
		 $this->product_model->order = $order;
		 $result['total'] = $this->product_model->num_page();
		 $result['rows'] = $this->product_model->list_page();
		
		header('Content-type: application/json');
                echo json_encode($result);
		 //dump($data);
		 //$this->output->enable_profiler(TRUE);
	}
	
	public function combobox()
	{
		$data = $this->product_model->get();
		header('Content-type: application/json');
        echo json_encode($data);
	}

	public function get_by($plans_id)
	{
		$data = $this->product_model->get_by('plans_id',$plans_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'ordering' => $_REQUEST['ordering'],
            'name' => $_REQUEST['name'],
            'plans_id' => $_REQUEST['plan'],
            'is_active' => $_REQUEST['is_active']);
	   	
	   $id = $this->product_model->save($data);
	   
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
	        'ordering' => $_REQUEST['ordering'],
            'name' => $_REQUEST['name'],
            'plans_id' => $_REQUEST['plan'],
            'is_active' => $_REQUEST['is_active']);
	        
	        $id = $this->product_model->save($data,$eid);
		   
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
        $this->product_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}
