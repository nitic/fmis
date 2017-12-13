<?php
class payment extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('payment_model');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$this->template->load('template', 'payment_view',NULL);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $this->payment_model->limit = $rows;
		 $this->payment_model->offset = $offset;
		 $this->payment_model->sort = $sort;
		 $this->payment_model->order = $order;
		 $result['total'] = $this->payment_model->num_page();
		 $result['rows'] = $this->payment_model->list_page();
		
		 header('Content-type: application/json');
         echo json_encode($result);
	}
	
	public function get_detail($disbursement_ID)
	{
		$data = $this->payment_model->payment_by($disbursement_ID);
		header('Content-type: application/json');
        echo json_encode($data);
       // print_r($data);
	   //	$this->output->enable_profiler(TRUE);
	}
	
	public function get_by($disbursement_id)
	{
		
		$data = $this->payment_model->get_by('trn_payment.disbursement_id',$disbursement_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function combobox()
	{
		 $data = $this->payment_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
	   $data = array(
	        'payment_code' => $_REQUEST['payment_code'],
	        'name' => $_REQUEST['ccpayment'],
            'type' => $_REQUEST['cctype'],
            'ordering' => $_REQUEST['ordering']);
       
	    $id = $this->payment_model->save($data);
	   
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
	        'payment_code' => $_REQUEST['payment_code'],
	        'name' => $_REQUEST['ccpayment'],
            'type' => $_REQUEST['cctype'],
            'ordering' => $_REQUEST['ordering']);
			
	         $id = $this->payment_model->save($data,$eid);
		   
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
        $this->payment_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }
	
	public function delete_by($eid) {
       if(isset($eid)){
       	$id = intval($eid);	  
        $this->payment_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}