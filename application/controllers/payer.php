<?php
class payer extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('payer_model');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "ข้อมูลผู้รับเงิน";
		$data["path"] = array("ผู้ดูแลระบบ","ข้อมูลพื้นฐานผู้รับเงิน","จัดการข้อมูลผู้รับเงิน");
		$data["submenu"] = Admin_menu(5);
		$this->template->load('template', 'payer_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->payer_model->limit = $rows;
		 $this->payer_model->offset = $offset;
		 $this->payer_model->sort = $sort;
		 $this->payer_model->order = $order;
		 $result['total'] = $this->payer_model->num_page();
		 $result['rows'] = $this->payer_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->payer_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'payer_code' => $_REQUEST['payer_code'],
	        'name' => $_REQUEST['ccpayer'],
            'type' => $_REQUEST['cctype'],
            'ordering' => $_REQUEST['ordering']);
       
	    $id = $this->payer_model->save($data);
	   
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
	        'payer_code' => $_REQUEST['payer_code'],
	        'name' => $_REQUEST['ccpayer'],
            'type' => $_REQUEST['cctype'],
            'ordering' => $_REQUEST['ordering']);
			
	         $id = $this->payer_model->save($data,$eid);
		   
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
        $this->payer_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}