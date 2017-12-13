<?php
class Report_Approve extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->model('approve_model');
        $this->load->model('disbursement_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
		
		Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{

	}
    
    public function nopayment()
	{
		$data["title"] = "2.เอกสารอนุมัติแต่ยังไม่เบิกจ่าย";
		$data["path"] = array("งานการเงิน","ขออนุมัติใช้งบประมาณ","เอกสารอนุมัติแต่ยังไม่เบิกจ่าย");
		$data["submenu"] = Finance_menu(1);
		$this->template->load('template', 'approve_no_payment_view', $data);
	}
    
     public function paymented()
	{
		$data["title"] = "3.เอกสารอนุมัติเบิกจ่ายแล้ว";
		$data["path"] = array("งานการเงิน","ขออนุมัติใช้งบประมาณ","เอกสารอนุมัติเบิกจ่ายแล้ว");
		$data["submenu"] = Finance_menu(1);
		$this->template->load('template', 'approve_paymented_view', $data);
	}
	
	public function get_nopayment()
	{
         $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc'; 
		 $offset = ($page-1)*$rows;
    
		 $budget_id = $this->session->userdata('budget_year_id');
         
         $this->approve_model->limit = $rows;
		 $this->approve_model->offset = $offset;
		 $this->approve_model->sort = $sort;
		 $this->approve_model->order = $order;
         $result['total'] = count($this->approve_model->num_nopayment_report($budget_id));
         $result['rows'] = $this->approve_model->approve_nopayment_report($budget_id);
		 
		 header('Content-type: application/json');
         echo json_encode($result);
		 
	     //dump($result['rows']);
	    // $this->output->enable_profiler(TRUE);
	}
	
	public function get_paymented($keyword = '')
	{
         $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
		 $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 20;
		 $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';  
         $order = isset($_POST['order']) ? strval($_POST['order']) : 'desc'; 
		 $offset = ($page-1)*$rows;
    
         $budget_id = $this->session->userdata('budget_year_id');
		 
		 $keyword = str_replace("_", "/", $keyword);
		 $where = !empty($keyword) ? mysql_real_escape_string($keyword) : '';
		 
         $this->approve_model->limit = $rows;
		 $this->approve_model->offset = $offset;
		 $this->approve_model->sort = $sort;
		 $this->approve_model->order = $order;
         $result['total'] = count($this->approve_model->num_paymented_report($budget_id, $where));
         $result['rows'] = $this->approve_model->approve_paymented($budget_id, $where);

		 header('Content-type: application/json');
         echo json_encode($result);
         
       //  dump($result['rows']);
	   //  $this->output->enable_profiler(TRUE);
		 
	}
    
    public function get_deatil($approve_ID)
	{ 
        $data = $this->approve_model->approve_detail_by_id($approve_ID);

		header('Content-type: application/json');
        echo json_encode($data);
         
       //  dump($data);
	   // $this->output->enable_profiler(TRUE);
		 
	}
    
	 public function get_disbursement_lists($approve_ID)
	{ 
        $data = $this->disbursement_model->approve_paymented_lists($approve_ID);

        $sum_payment = 0.0;
        foreach($data as $value){
            $sum_payment += $value['total_payment'];
        }
        
        $sum_payment = number_format($sum_payment, 2, '.','');
        $data = array('total' => count($data), 'rows'=> $data, 'footer' => array(array('costs' => 'รวมเงินทั้งหมด','total_payment'=> $sum_payment)));
        
	    header('Content-type: application/json');
        echo json_encode($data);
         
       //dump($data);
	  // $this->output->enable_profiler(TRUE);
		 
	}
	
    public function get_disbursement_deatil($disbursement_ID)
	{ 
        $data = $this->disbursement_model->disbursement_paymented_detail($disbursement_ID);

		header('Content-type: application/json');
        echo json_encode($data);
         
       // dump($data);
	   // $this->output->enable_profiler(TRUE);
		 
	}
	

}