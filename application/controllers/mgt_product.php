<?php
class Mgt_Product extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('mgt_product_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "2.จัดสรรงบประมาณระดับผลผลิต";
		$data["path"] = array("งานแผน","จัดสรรงบประมาณประจำปี","จัดการจัดสรรงบประมาณระดับผลผลิต");
		$data["submenu"] = Plans_menu(2);
		$this->template->load('template', 'budget/mgt_product_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		 
		 $this->mgt_product_model->limit = $rows;
		 $this->mgt_product_model->offset = $offset;
		 $this->mgt_product_model->sort = $sort;
		 $this->mgt_product_model->order = $order;
		 $result['total'] = $this->mgt_product_model->num_page($where);
		 $result['rows'] = $this->mgt_product_model->list_page($where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
         //dump($result['rows']);
		// $this->output->enable_profiler(TRUE);
	}
	
	public function get_summary()
	{
		$where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		$data = $this->mgt_product_model->summary_page($where);
		header('Content-type: application/json');
        echo json_encode($data);	
		//$this->output->enable_profiler(TRUE);
	}
	
	public function get_by($mgt_plans_id)
	{
		$data = $this->mgt_product_model->list_by($mgt_plans_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	public function combobox($mgt_plans_id)
	{
		$data = $this->mgt_product_model->list_by($mgt_plans_id);
		$inserted = array(array('id' => '0','product_id'=>'0','name' => 'เลือกทั้งหมด','amount'=>'0.00'));
		$data = array_merge($inserted,$data);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	
	public function get_balance($mgt_plans_id)
	{
		$data = $this->mgt_product_model->get_plans_balance($mgt_plans_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	
	public function add()
	{
	   $chk = count($this->mgt_product_model->get_by(array('mgt_plans_id' => $_REQUEST['ccplan'], 'product_id ' => $_REQUEST['ccproduct'])));	
	   if($chk == 0){	
		       $data = array(
		        'mgt_plans_id' => $_REQUEST['ccplan'],
	            'product_id' => $_REQUEST['ccproduct'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));
		 
		   $id = $this->mgt_product_model->save($data);  
		   
		   if(isset($id)){
		   	  echo json_encode(array('success'=>true));
		   }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		   }
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured. duplicate budget and plan'));
	   }
	}
	
	public function update($eid)
	{
	  if(isset($eid)){
			$data = array(
	            'product_id' => $_REQUEST['ccproduct'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));
           
		        $id = $this->mgt_product_model->save($data,$eid);
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
        $this->mgt_product_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}