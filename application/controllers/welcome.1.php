<?php

class Welcome extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->model('users_model');
		$this->load->model('budget_main_model');
	  
		$this->load->helper('psupassport');
		
	}
	
	public function index()
	{
		 $this->load->helper('form');
		 
		 $data["budget"] = $this->budget_main_model->lists_source(2);
		 $this->load->view('login_view',$data);
		// print_r($data);
	}
	
	public function login()
	{
		$check_password = lib_psulogin_authenticate($_POST['usr'],$_POST['pwd']);
		if($check_password == "true"){
			
			$user_details = lib_psulogin_getStaffID($_POST['usr'],$_POST['pwd']);
			
			$data = $this->users_model->user_page($user_details);
			foreach ($data as $key => $value) {
			   $this->session->set_userdata('StaffCode', $value["code"]);
			   $this->session->set_userdata('UserName', $value["firstname"]." ".$value["lastname"]);
			   $this->session->set_userdata('Email', $value["email"]);
			   $this->session->set_userdata('Role', $value["role"]);
		    }


			$data = $this->budget_main_model->budgetyear_name($_POST["budget_year"]);
		    foreach ($data as $key => $value) {
			  $this->session->set_userdata('budget_year_id', $value["id"]);
			  $this->session->set_userdata('budget_year_title', $value["title"]);
			  $this->session->set_userdata('budget_year_year', $value["year"]);
			  $this->session->set_userdata('budget_year_amount', $value["amount"]);
		    }
		    
		    redirect('dashboard', 'refresh');
			
		}else{
		   redirect('welcome', 'refresh');
		} 	

	}
	
	public function logout()
	{
		 session_start();
		 
		 $this->session->unset_userdata('StaffCode');
		 $this->session->unset_userdata('UserName');
		 $this->session->unset_userdata('Email');
		 $this->session->unset_userdata('Role');
         $this->session->unset_userdata('budget_year_id');
		 $this->session->unset_userdata('budget_year_title');
		 $this->session->unset_userdata('budget_year_year');
		 $this->session->unset_userdata('budget_year_amount');
		 
         session_destroy();
         redirect('welcome', 'refresh');
	}
	
	public function change()
	{
		$this->load->helper('form');
		 
		$data["budget"] = $this->budget_main_model->lists_source();
		$this->load->view('change_view',$data);
	}
	
	
	public function comeback()
	{
		$data = $this->budget_main_model->budgetyear_name($_POST["budget_year"]);
	    foreach ($data as $key => $value) {
			  $this->session->set_userdata('budget_year_id', $value["id"]);
			  $this->session->set_userdata('budget_year_title', $value["title"]);
			  $this->session->set_userdata('budget_year_year', $value["year"]);
			  $this->session->set_userdata('budget_year_amount', $value["amount"]);
		}
			
		redirect('dashboard', 'refresh');
	}
}
