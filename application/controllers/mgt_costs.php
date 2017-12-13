<?php
class Mgt_Costs extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('mgt_costs_model');
		$this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
		$data["title"] = "3.จัดสรรงบประมาณระดับรายจ่าย";
		$data["path"] = array("งานแผน","จัดสรรงบประมาณประจำปี","จัดการจัดสรรงบประมาณระดับรายจ่าย");
		$data["submenu"] = Plans_menu(2);
		$this->template->load('template', 'budget/mgt_costs_view', $data);
	}
	
	public function get()
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'asc'; 
		 $offset = ($page-1)*$rows;
		 
		 $where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		 
		 $this->mgt_costs_model->limit = $rows;
		 $this->mgt_costs_model->offset = $offset;
		 $this->mgt_costs_model->sort = $sort;
		 $this->mgt_costs_model->order = $order;
		 $result['total'] = $this->mgt_costs_model->num_page($where);
		 $result['rows'] = $this->mgt_costs_model->list_page($where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
        // dump($result['rows']);
		// $this->output->enable_profiler(TRUE);
	}
	
	public function get_summary()
	{
		$where = isset($_POST['budget_main_id']) ? mysql_real_escape_string($_POST['budget_main_id']) : '';
		$data = $this->mgt_costs_model->summary_page($where);
		header('Content-type: application/json');
        echo json_encode($data);	
		//$this->output->enable_profiler(TRUE);
	}
	
	public function get_by($mgt_product_id)
	{
		$data = $this->mgt_costs_model->list_by($mgt_product_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
    
    //for approve_view.php
    public function get_by_cost($mgt_product_id, $costs_id, $costs_group_id, $costs_type_id)
	{
		$data = $this->mgt_costs_model->list_by_cost_all($mgt_product_id, $costs_id, $costs_group_id, $costs_type_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
    
     //for approve_view.php
    public function get_all_id($mgt_costs_id)
	{
		$data = $this->mgt_costs_model->get_by_id($mgt_costs_id);
        //dump($data);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	
	public function get_balance($mgt_product_id)
	{
		$data = $this->mgt_costs_model->get_product_balance($mgt_product_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
	
	
	public function add()
	{
		
		
	   $chk = count($this->mgt_costs_model->get_by(array('mgt_product_id' => $_REQUEST['ccproduct'],
	   													 'costs_id' => $_REQUEST['txtcosts'],
	   													 'costs_group_id' => $_REQUEST['ccgroup'],
	   													 'costs_type_id' => $_REQUEST['cctype'],
	   													 'costs_lists_id' => $_REQUEST['cclists'], 
	                                                     'costs_sublist_id ' => $_REQUEST['ccsublist'])));	
	   if($chk == 0){	
		       $data = array(
		        'mgt_product_id' => $_REQUEST['ccproduct'],
	            'costs_id' => $_REQUEST['txtcosts'],
	            'costs_group_id' => $_REQUEST['ccgroup'],
	            'costs_type_id' => $_REQUEST['cctype'],
	            'costs_lists_id' => $_REQUEST['cclists'],
	            'costs_sublist_id' => $_REQUEST['ccsublist'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));

		   $id = $this->mgt_costs_model->save($data);  
		   
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
		        'mgt_product_id' => $_REQUEST['ccproduct'],
	            'costs_id' => $_REQUEST['txtcosts'],
	            'costs_group_id' => $_REQUEST['ccgroup'],
	            'costs_type_id' => $_REQUEST['cctype'],
	            'costs_lists_id' => $_REQUEST['cclists'],
	            'costs_sublist_id' => $_REQUEST['ccsublist'],
				'amount' => $_REQUEST['amount'],
				'create_date' => date('Y-m-d H:i:s'));
				    
		   // print_r($_REQUEST);	
		      $id = $this->mgt_costs_model->save($data,$eid);
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
        $this->mgt_costs_model->delete($id);
		echo json_encode(array('success'=>true));
	  }
    }

}