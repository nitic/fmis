<?php
class Budget extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('budget_model');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลพื้นฐานแหล่งงบประมาณ";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานแหล่งเงิน","จัดการแหล่งงบประมาณ");
		$data["submenu"] = Admin_menu(1);
		$this->template->load('template', 'budget/budget_view',$data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->budget_model->limit = $rows;
		 $this->budget_model->offset = $offset;
		 $this->budget_model->sort = $sort;
		 $this->budget_model->order = $order;
		 $result['total'] = $this->budget_model->num_page();
		 $result['rows'] = $this->budget_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->budget_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'ordering' => $_REQUEST['ordering'],
	        'title' => $_REQUEST['title'],
            'initial' => $_REQUEST['initial'],
            'define' => $_REQUEST['define']);
         $id = $this->budget_model->save($data);
	   
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
		        'title' => $_REQUEST['title'],
	            'initial' => $_REQUEST['initial'],
	            'define' => $_REQUEST['define']);
	         $id = $this->budget_model->save($data,$eid);
		   
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
        $this->budget_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}