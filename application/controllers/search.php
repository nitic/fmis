<?php

class Search extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('menu');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->model('approve_model');
        $this->load->model('disbursement_model');
		
	}
	
	public function index()
	{
		$data["title"] = "ค้นหา";
		$data["path"] = array("งานการเงิน","ค้นหา","ค้นหาเลขหนังสือและลำดับแฟ้ม");
		$data["submenu"] = Admin_menu(5);

		$this->template->load('template', 'search_view', $data);
	}
	
	public function approve_docnumber($q = ""){
		
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		 $budget_main_ID = isset($budget_main_ID) ? mysql_real_escape_string($budget_main_ID) : '';
		 
		 $approve_doc_number = str_replace("_", "/", $q);
		 $data = $this->approve_model->search_doc_number($budget_main_ID, $approve_doc_number);
	   
			foreach ($data->result() as $row)
			{
				$id = $row->id; // ฟิลที่ต้องการส่งค่ากลับ
				$name = $row->doc_number; // ฟิลที่ต้องการแสดงค่า
				// ป้องกันเครื่องหมาย '
				$name = str_replace("'", "'", $name);
				// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
				$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
				echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";
			}
	     
		 //$this->output->enable_profiler(TRUE);
	}
    
    
    public function approve_docnumber_paymented($q = ""){
		
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		 $budget_main_ID = isset($budget_main_ID) ? mysql_real_escape_string($budget_main_ID) : '';
		 
		 $approve_doc_number = str_replace("_", "/", $q);
		 $data = $this->approve_model->search_docNumber_paymented($budget_main_ID, $approve_doc_number);
	 
			foreach ($data->result() as $row)
			{
				$id = $row->id; // ฟิลที่ต้องการส่งค่ากลับ
				$name = $row->doc_number; // ฟิลที่ต้องการแสดงค่า
				// ป้องกันเครื่องหมาย '
				$name = str_replace("'", "'", $name);
				// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
				$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
				echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";
			}
         
        //dump($data->result());
		//$this->output->enable_profiler(TRUE);
	}
    
    public function disbursement_docnumber($q = ""){
		
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		 $budget_main_ID = isset($budget_main_ID) ? mysql_real_escape_string($budget_main_ID) : '';
		 
		 $approve_doc_number = str_replace("_", "/", $q);
		 $data = $this->disbursement_model->search_doc_number($budget_main_ID, $approve_doc_number);
	 
			foreach ($data->result() as $row)
			{
				$id = $row->id; // ฟิลที่ต้องการส่งค่ากลับ
				$name = $row->doc_number; // ฟิลที่ต้องการแสดงค่า
				// ป้องกันเครื่องหมาย '
				$name = str_replace("'", "'", $name);
				// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
				$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
				echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";
			}
      
       // dump($data->result());
		//$this->output->enable_profiler(TRUE);
	}
    
	
	public function approve_filenumber($q = ""){
		
		 $budget_main_ID = $this->session->userdata('budget_year_id');
		 $budget_main_ID = isset($budget_main_ID) ? mysql_real_escape_string($budget_main_ID) : '';
		 
		 $approve_file_number = str_replace("_", "/", $q);
		 $data = $this->approve_model->search_file_number($budget_main_ID, $approve_file_number);
	   
			foreach ($data->result() as $row)
			{
				$id = $row->id; // ฟิลที่ต้องการส่งค่ากลับ
				$name = $row->file_number; // ฟิลที่ต้องการแสดงค่า
				// ป้องกันเครื่องหมาย '
				$name = str_replace("'", "'", $name);
				// กำหนดตัวหนาให้กับคำที่มีการพิมพ์
				$display_name = preg_replace("/(" . $q . ")/i", "<b>$1</b>", $name);
				echo "<li onselect=\"this.setText('$name').setValue('$id');\">$display_name</li>";
			}
	   
	}
	
	
}
