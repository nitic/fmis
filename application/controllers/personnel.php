<?php
class personnel extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('personnel_model');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$this->template->load('template', 'personnel_view',NULL);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->personnel_model->limit = $rows;
		 $this->personnel_model->offset = $offset;
		 $this->personnel_model->sort = $sort;
		 $this->personnel_model->order = $order;
		 $result['total'] = $this->personnel_model->num_page();
		 $result['rows'] = $this->personnel_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function combobox()
	{
		 $data = $this->personnel_model->list_person();
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
         $id = $this->personnel_model->save($data);
	   
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
	         $id = $this->personnel_model->save($data,$eid);
		   
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
        $this->personnel_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}