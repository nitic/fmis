<?php
class Disbursement extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('disbursement_model');
		$this->load->model('payment_model');
		$this->load->model('approve_model');
        $this->load->helper('general');
		$this->load->helper('myfunction');
		$this->load->helper('menu');
	}
	
	public function index()
	{
		$data["title"] = "2.ประวัติการเบิกจ่ายทั้งหมด";
		$data["path"] = array("งานการเงิน","เบิกจ่ายงบประมาณ","ประวัติการเบิกจ่ายทั้งหมด");
		$data["submenu"] = Finance_menu(2);
		$this->template->load('template', 'disbursement_view', $data);
	}
	
	public function form($approve_id = 0, $disbursement_id = 0)
	{
		$data["title"] = "1.เพิ่มข้อมูลเบิกจ่าย";
		$data["path"] = array("งานการเงิน","เบิกจ่ายงบประมาณ","เพิ่มข้อมูลเบิกจ่าย");
		$data["submenu"] = Finance_menu(2);
		
		$data["approve_id"] = $approve_id;
		$data["disbursement_id"] = $disbursement_id;
		$this->template->load('template', 'disbursement_form_view',$data);
	}
	
	public function get($keyword = '')
	{
		 $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'doc_date';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc'; 
		 $offset = ($page-1)*$rows;
		 
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		
         $keyword = str_replace("_", "/", $keyword);
		 $where = !empty($keyword) ? mysql_real_escape_string($keyword) : '';
		 
		 $this->disbursement_model->limit = $rows;
		 $this->disbursement_model->offset = $offset;
		 $this->disbursement_model->sort = $sort;
		 $this->disbursement_model->order = $order;
		 $result['total'] = $this->disbursement_model->num_page($budget_main_ID, $where);
		 $result['rows'] = $this->disbursement_model->list_page($budget_main_ID, $where);
		
		 header('Content-type: application/json');
         echo json_encode($result);
		// dump($result['rows']);
	    //	$this->output->enable_profiler(TRUE);
	}
	

	public function get_by($disbursement_id)
	{
		
		$data = $this->disbursement_model->get_by('trn_disbursement.id',$disbursement_id);
		header('Content-type: application/json');
        echo json_encode($data);
	}
    
    public function check_payment($approve_id)
	{
		
		$data = $this->disbursement_model->get_by('trn_disbursement.approve_id',$approve_id);
        echo count($data);
       // header('Content-type: application/json');
       // echo json_encode($data);
	}
	
	public function get_detail($approve_id)
	{
		$data = $this->approve_model->approve_by($approve_id);
		header('Content-type: application/json');
        echo json_encode($data);
       // print_r($data);
	   //	$this->output->enable_profiler(TRUE);
	}
	
	public function combobox()
	{
		 $data = $this->disbursement_model->get();
		 header('Content-type: application/json');
         echo json_encode($data);
	}
	
	public function add()
	{
       $pay_date = !empty($_REQUEST['pay_date']) ? formatDateToMySql($_REQUEST['pay_date']) : date('Y-m-d');
       
	   $data = array(
	   		'approve_id' => $_REQUEST['approveid'],
	        'doc_number' => $_REQUEST['paydoc_number'],
	        'file_number' => $_REQUEST['payfile_number'],
            'doc_date' => $pay_date,
        	'invoice_number' => $_REQUEST['invoice_number'],
            'budget_main_id' => $this->session->userdata('budget_year_id'),
            'mgt_plans_id' => $_REQUEST['ccplans'],
            'mgt_product_id' => $_REQUEST['ccproduct'],
            'costs_id' => $_REQUEST['txtcosts'],
	        'costs_group_id' => $_REQUEST['ccgroup'],
	        'costs_type_id' => $_REQUEST['cctype'],
	        'costs_lists_id' => $_REQUEST['cclists'],
	        'costs_sublist_id' => $_REQUEST['ccsublist'],
            'note' => $_REQUEST['paynote']);

      // print_r($_REQUEST);
       
       $id = $this->disbursement_model->save($data);
	   
	   
       // Update Approve Status
	   $this->approve_model->save(array('status' => $_REQUEST['approve_status']),$_REQUEST['approveid']);
	
	   // Add Payment
	   if(isset($id)){
		    $pid = 0;	
		    $arrPayer = array_combine($_REQUEST['ccpayer'], $_REQUEST['sum']);
	   	  	
	   	  	foreach ($arrPayer as $code => $value) {
				$data = array(
			        'disbursement_id' => $id,
			        'payer_code' => $code,
					'amount' => $value);
				$pid = $this->payment_model->save($data);	 
			}
			if(isset($pid)){
	   	        echo json_encode(array('success'=>true));
			}else {
				echo json_encode(array('msg'=>'Some errors occured.'));
			}
	   }
	   else {
		   echo json_encode(array('msg'=>'Some errors occured.'));
	   }
     
	}
	
	
	public function update($eid)
	{
	  if(isset($eid)){
		  $data = array(
	   		'approve_id' => $_REQUEST['approveid'],
	        'doc_number' => $_REQUEST['paydoc_number'],
	        'file_number' => $_REQUEST['payfile_number'],
            'doc_date' => formatDateToMySql($_REQUEST['pay_date']),
        	'invoice_number' => $_REQUEST['invoice_number'],
            'budget_main_id' => $this->session->userdata('budget_year_id'),
            'mgt_plans_id' => $_REQUEST['ccplans'],
            'mgt_product_id' => $_REQUEST['ccproduct'],
            'costs_id' => $_REQUEST['txtcosts'],
	        'costs_group_id' => $_REQUEST['ccgroup'],
	        'costs_type_id' => $_REQUEST['cctype'],
	        'costs_lists_id' => $_REQUEST['cclists'],
	        'costs_sublist_id' => $_REQUEST['ccsublist'],
            'note' => $_REQUEST['paynote']);
			 			
	        $id = $this->disbursement_model->save($data,$eid);
	      
            // Edit Approve Status
	        $this->approve_model->save(array('status' => $_REQUEST['approve_status']),$_REQUEST['approveid']);
            
		    // Update Payment
		    if(isset($id)){
		   	    $pid = 0;
				$arrCount = 1;
				$arrID = $_REQUEST['payerid'];
			    $arrPayer = array_combine($_REQUEST['ccpayer'], $_REQUEST['sum']);
				
		   	  	foreach ($arrPayer as $code => $value) {
					
					if(empty($arrID[$arrCount])){
					 	$data = array(
				                'disbursement_id' => $eid,
				                'payer_code' => $code,
						        'amount' => $value);
					    $pid = $this->payment_model->save($data);
					}else{
						$data = array(
				                'payer_code' => $code,
						        'amount' => $value);	
					    $pid = $this->payment_model->save($data,$arrID[$arrCount]);
					}
					$arrCount++;
				}
				if(isset($pid)){
		   	        echo json_encode(array('success'=>true));
				}else {
					echo json_encode(array('msg'=>'Some errors occured.'));
				}
		    }
		   else {
			   echo json_encode(array('msg'=>'Some errors occured.'));
		    }
		  
	  }
	}
	
	public function delete() {
       if(isset($_REQUEST['id'])){
       	$id = intval($_REQUEST['id']);	  
        
		//Delete Payment
        $this->payment_model->delete_by('trn_payment.disbursement_id',$id);
		
        $this->disbursement_model->delete($id);
		
		echo json_encode(array('success'=>true));
	  }
    }

}