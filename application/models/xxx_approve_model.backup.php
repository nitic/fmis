<?php
class Approve_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_approve';
        $this->primary_key = 'trn_approve.id';
		$this->order_by = 'trn_approve.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($budget_main_ID) {
		
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.detail, trn_approve.mgt_costs_id, trn_approve.amount');
		//$this->db->select('trn_approve.faculty_code, trn_approve.department_id, trn_approve.division_id');
        $this->db->select("trn_approve.status+0 AS status_id", FALSE);
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->select("IF(trn_approve.division_id = 0, mst_department.name, CONCAT(mst_department.name,' / ', mst_division.name)) AS department",FALSE);
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs_list",FALSE);
        
        $this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS payment',FALSE);
        $this->db->select('(trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)) AS balance',FALSE);
        
		$this->db->join('mst_department', 'mst_department.id = trn_approve.department_id','LEFT OUTER');
		$this->db->join('mst_division', 'mst_division.id = trn_approve.division_id','LEFT OUTER');
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
        $this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
		
		if(!empty($budget_main_ID))
		    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		
		$this->db->group_by("trn_approve.id");
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($budget_main_ID) {
                        
		if(!empty($budget_main_ID))
		   $result = $this->db->from('trn_approve')->where('trn_approve.budget_main_id', $budget_main_ID)->count_all_results();
		else
           $result = $this->db->from('trn_approve')->count_all_results();
		   
        return $result;
    }

	public function approve_detail($approve_ID) {
		
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.detail, trn_approve.amount, trn_approve.budget_main_id');
		
		$this->db->select('mst_faculty.name AS faculty, mst_department.name AS department, mst_division.name AS division');
		
		$this->db->select('mst_plans.name AS plans, mst_product.name AS product, mst_project.name AS project, mst_activity.name AS activity');
		
		//$this->db->select('mst_costs_group.name AS costs_group, mst_costs_type.name AS costs_type, mst_costs_lists.name AS costs_lists, mst_costs_sublist.name AS costs_sublist');
		
		$this->db->select("CONCAT(mst_costs.name,' --> ', mst_costs_type.name,' --> ',IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS costs",FALSE);
		
		$this->db->select("CONCAT(mst_budget.title,' ',trn_budget_main.year + 543) AS budget_amount",FALSE);
		
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
		$this->db->join('mst_faculty', 'mst_faculty.code = trn_approve.faculty_code');
		$this->db->join('mst_department', 'mst_department.id = trn_approve.department_id','LEFT OUTER');
		$this->db->join('mst_division', 'mst_division.id = trn_approve.division_id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_approve.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_project', 'mst_project.id = trn_approve.project_id','LEFT OUTER');
		$this->db->join('mst_activity', 'mst_activity.id = trn_approve.activity_id','LEFT OUTER');
		
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
		
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		
		$this->db->where('trn_approve.id =', $approve_ID);
		return $this->get();
    }

	function real_balance($mgt_costs_ID)
	{
		$this->db->select('(trn_mgt_costs.amount - sum(trn_payment.amount)) AS amount',FALSE);
		
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id');
		
	    $this->db->where('trn_approve.mgt_costs_id =', $mgt_costs_ID);
		return $this->get();
	}

	function approve_total($mgt_costs_ID)
	{
		$this->db->select('trn_mgt_costs.amount');
		
		$this->db->select('SUM(IFNULL(trn_payment.amount,trn_approve.amount)) AS total',FALSE);
		
		//$this->db->select('SUM(CASE WHEN trn_approve.status = 1 THEN trn_approve.amount ELSE trn_payment.amount END) AS payment', FALSE);
		
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
	    $this->db->where('trn_approve.mgt_costs_id =', $mgt_costs_ID);
		
		return $this->get();
	}

	function num_balance($mgt_costs_ID)
	{
		$result = $this->db->from('trn_approve')
						   ->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id')
						   ->join('trn_disbursement', 'trn_disbursement.approve_id = trn_approve.id')
						   ->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id')
						   ->where('trn_approve.mgt_costs_id =', $mgt_costs_ID)
                           ->count_all_results();
		
		return $result;
	}
    
    function approve_check($document_number, $budget_main_ID)
	{
        $this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.mgt_costs_id');
        $this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		$this->db->select('(trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)) AS amount',FALSE);
        
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
        $this->db->where('trn_approve.doc_number =', $document_number);
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		$this->db->group_by("trn_approve.id");
        
		return $this->get();
	}
	
	
	function approve_check_by_file_number($document_file_number, $budget_main_ID)
	{
        $this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.mgt_costs_id');
        $this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		$this->db->select('(trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)) AS amount',FALSE);
        
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
        $this->db->where('trn_approve.file_number =', $document_file_number);
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		$this->db->group_by("trn_approve.id");
        
		return $this->get();
	}
    
    function approve_check_by_id($approve_id)
	{
        $this->db->select('trn_approve.doc_number, trn_approve.subject, trn_approve.mgt_costs_id');
        
        $this->db->select('(trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)) AS amount',FALSE);
        
        $this->db->select("trn_approve.status+0 AS status_id", FALSE);
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
        $this->db->where('trn_approve.id =', $approve_id);   
		return $this->get();
	}
    
    function approve_detail_by_id($approve_id)
	{
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.detail, trn_approve.amount');
        $this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		$this->db->select("trn_approve.status+0 AS status_id", FALSE);
        
        $this->db->select('mst_faculty.name AS faculty, mst_department.name AS department, mst_division.name AS division');
        
        $this->db->select('mst_plans.name AS plans, mst_product.name AS product');
        $this->db->select("CONCAT(mst_costs.name,' / ', mst_costs_group.name) AS costs_group", FALSE);
        $this->db->select('mst_costs_type.name AS costs_type');
        $this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs_lists",FALSE);
      
        // faculty-department-division
        $this->db->join('mst_faculty', 'mst_faculty.code = trn_approve.faculty_code');
		$this->db->join('mst_department', 'mst_department.id = trn_approve.department_id','LEFT OUTER');
		$this->db->join('mst_division', 'mst_division.id = trn_approve.division_id','LEFT OUTER');
        
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
		
        // costs
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id','LEFT OUTER');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id','LEFT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id','LEFT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
        
        // product
        $this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id','LEFT OUTER');
        $this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id','LEFT OUTER');
        
        // plans
        $this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id','LEFT OUTER');
        $this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id', 'LEFT OUTER');
        
	    $this->db->where('trn_approve.id =', $approve_id);
        
		return $this->get();
	}
	
	// search.php
	function search_doc_number($budget_main_ID, $q)
	{
	    $q = urldecode($q);
		$pagesize = 50; 
		$table_db = "trn_approve"; 
		$find_field ="trn_approve.doc_number"; 
		
		return $this->db->query("select trn_approve.id, trn_approve.doc_number from $table_db where trn_approve.budget_main_id = '$budget_main_ID' AND locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize");
	}
	
	// search.php
	function search_file_number($budget_main_ID, $q)
	{
	    $q = urldecode($q);
		$pagesize = 50; 
		$table_db = "trn_approve"; 
		$find_field ="trn_approve.file_number"; 
		
		return $this->db->query("select trn_approve.id, trn_approve.file_number from $table_db where trn_approve.budget_main_id = '$budget_main_ID' AND locate('$q', $find_field) > 0 order by locate('$q', $find_field), $find_field limit $pagesize");
	}
	

	function approve_plans_report($budget_main_ID)
	{
		$this->db->select('trn_approve.id, trn_approve.mgt_plans_id, trn_approve.budget_main_id, mst_plans.name');
		$this->db->select('sum(trn_approve.amount) AS total',FALSE);
		$this->db->select("CONCAT(mst_budget.title,' ',trn_budget_main.year + 543) AS year",FALSE);
		
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		
		$this->db->group_by("trn_approve.mgt_plans_id");
		$this->db->order_by('trn_budget_main.year','desc');
		
		
		if(!empty($budget_main_ID))
		    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		
		return $this->get();
	}


	function approve_costs_report($budget_main_ID, $mgt_plans_ID)
	{
		$this->db->select('trn_approve.id');
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		$this->db->select("CONCAT(mst_costs.name,' >> ', mst_costs_group.name,' >> ', mst_costs_type.name,' >> ',IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS costs",FALSE);
		
		$this->db->select('trn_approve.amount AS total',FALSE);
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_approve.budget_main_id');
		
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
		
	    
	    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
		$this->db->where('trn_approve.mgt_plans_id =', $mgt_plans_ID);
		
		return $this->get();
	}
    
    function approve_nopayment_report($budget_main_ID)
	{
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject');
		$this->db->select("trn_approve.status+0 AS status_id", FALSE);
		$this->db->select('trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)  AS real_amount',FALSE);
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS payment',FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
        $this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs",FALSE);
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
		
        // costs
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');

        
	    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        
		// old 
		//$this->db->having('payment = 0.00'); 
		
		$this->db->where('trn_approve.status IN (1,2)');
        $this->db->group_by("trn_approve.id");
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
        
		return $this->get();
	}
    
    public function num_nopayment_report($budget_main_ID) {
        $this->db->select('trn_approve.id'); 
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS payment',FALSE);
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        $this->db->having('payment = 0.00'); 
        $this->db->group_by("trn_approve.id");
        return $this->get();
    }
    
    // for report_manager.php
    public function amount_approve_only($mgt_costs_ID) {
        $this->db->select('trn_approve.mgt_costs_id'); 
       // $this->db->select("trn_approve.status+0 AS status_id", FALSE);
       // $this->db->select('SUM(trn_approve.amount) AS amount');
        //$this->db->select('trn_approve.amount');
       // $this->db->select("SUM(trn_payment.amount) AS payment", FALSE);
        $this->db->select('IF(trn_approve.status+0 = 2, trn_approve.amount - SUM(trn_payment.amount), trn_approve.amount)  AS balance',FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
       // $this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
        
         
        $this->db->where('trn_approve.mgt_costs_id =', $mgt_costs_ID);
        $this->db->where('trn_approve.status IN (1,2)');
         
        $this->db->group_by("trn_approve.id");
       // $this->db->group_by("trn_approve.mgt_costs_id");
        return $this->get();
    }
    
    public function approve_only_by_budget($budget_main_ID) {
       // $this->db->select('trn_approve.mgt_costs_id'); 
        $this->db->select('IFNULL(SUM(trn_approve.amount),0)  AS amount',FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_mgt_costs', 'trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
        
        $this->db->where('trn_disbursement.approve_id IS NULL');
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
    
        $this->db->group_by("trn_approve.budget_main_id");
        return $this->get();
    }
    

    
    function approve_paymented($budget_main_ID)
	{
		$this->db->select('trn_approve.id, trn_approve.doc_number, trn_approve.file_number, trn_approve.subject, trn_approve.amount');
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS payment',FALSE);
        $this->db->select('(trn_approve.amount - IFNULL(SUM(trn_payment.amount),0)) AS balance',FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_approve.doc_date, '%d'),'/',DATE_FORMAT(trn_approve.doc_date, '%m'),'/',DATE_FORMAT(trn_approve.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
        $this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs",FALSE);
        $this->db->select("trn_approve.status+0 AS status_id", FALSE);
        $this->db->select("CONCAT(trn_approve.status+0,' : ',trn_approve.status) AS status", FALSE);
        
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
        $this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','LEFT OUTER');
		
        // costs
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id','LEFT OUTER');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_mgt_costs.costs_group_id','LEFT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id','LEFT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id','LEFT OUTER');
        
        
	    $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        $this->db->having('payment > 0.00'); 
        $this->db->group_by("trn_approve.id");
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
        
		return $this->get();
	}
    
     public function num_paymented_report($budget_main_ID) {
        $this->db->select('trn_approve.id'); 
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS payment',FALSE);
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        $this->db->having('payment > 0.00'); 
        $this->db->group_by("trn_approve.id");
        return $this->get();
        
    }
    

    // report_summary.php (controllers)
	function plans_level_report($budget_main_ID)
	{
		$this->db->select('trn_mgt_plans.id, mst_plans.name ,trn_mgt_product.amount');
		$this->db->select('trn_mgt_product.id AS product_id, trn_approve.id AS approve_id');
		
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_approve.mgt_plans_id','RIGHT OUTER');
		$this->db->join('trn_mgt_product','trn_mgt_product.mgt_plans_id = trn_mgt_plans.id','RIGHT OUTER');
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
	
	    $this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		$this->db->group_by("trn_mgt_product.id,trn_approve.id");
		$this->db->order_by('trn_mgt_plans.id,trn_mgt_product.id');
	    
		return $this->get();
	}

    // report_summary.php (controllers) 
	function product_level_report($Mgt_Plans_ID)
	{
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.mgt_product_id, mst_product.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id','RIGHT OUTER');
		$this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id');
	
	    $this->db->where('trn_mgt_product.mgt_plans_id =', $Mgt_Plans_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
		
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_level_report($Mgt_Product_ID)
	{
		$this->db->select('trn_mgt_costs.id, mst_costs.id AS costs_id, mst_costs.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_type_level_report($Mgt_Product_ID,$Costs_ID)
	{
		$this->db->select('trn_mgt_costs.id, mst_costs_type.id AS costs_type_id, mst_costs_type.name, trn_mgt_costs.amount');
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->where('trn_mgt_costs.costs_id =', $Costs_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		
		return $this->get();
	}
	
	// report_summary.php (controllers)
	function costs_lists_level_report($Mgt_Product_ID, $Costs_Type_ID)
	{
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.amount');
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
		
		$this->db->select('IFNULL(trn_approve.amount,0) AS approve',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
	
		$this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.id = trn_approve.mgt_costs_id','RIGHT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.costs_lists_id = mst_costs_lists.id',"LEFT OUTER");
	
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $Mgt_Product_ID);
		$this->db->where('trn_mgt_costs.costs_type_id =', $Costs_Type_ID);
		$this->db->group_by("trn_approve.id");
		$this->db->order_by('trn_mgt_costs.id');
	    
		return $this->get();
	}
	
	// new report
	function plans_approve_only_level($budget_main_ID, $mgt_plans_id, $start_date, $end_date)
	{
		if(!empty($start_date) && !empty($end_date))
		   $where_date = 'AND `trn_approve`.`doc_date` BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		
		$query = "SELECT Z.mgt_plans_id, SUM(Z.real_amount) AS amount FROM(SELECT  `trn_approve`.`mgt_plans_id`, trn_approve.amount - IFNULL(SUM(trn_payment.amount), 0) AS real_amount
		FROM (`trn_approve`)
		LEFT OUTER JOIN `trn_disbursement` ON `trn_disbursement`.`approve_id` = `trn_approve`.`id`
		LEFT OUTER JOIN `trn_payment` ON `trn_payment`.`disbursement_id` = `trn_disbursement`.`id`
		WHERE `trn_approve`.`budget_main_id` = $budget_main_ID
		AND `trn_approve`.`mgt_plans_id` = $mgt_plans_id
		AND `trn_approve`.`status` IN (1,2)
		$where_date 
		GROUP BY `trn_approve`.`id`)Z GROUP BY Z.mgt_plans_id";
		
		return $this->db->query($query);
	}
	
	function product_approve_only_level($budget_main_ID, $mgt_product_id, $start_date, $end_date)
	{
		if(!empty($start_date) && !empty($end_date))
		   $where_date = 'AND `trn_approve`.`doc_date` BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		   
		$query = "SELECT Z.mgt_product_id, SUM(Z.real_amount) AS amount FROM(SELECT `trn_approve`.`mgt_product_id`, trn_approve.amount - IFNULL(SUM(trn_payment.amount), 0) AS real_amount
		FROM (`trn_approve`)
		LEFT OUTER JOIN `trn_disbursement` ON `trn_disbursement`.`approve_id` = `trn_approve`.`id`
		LEFT OUTER JOIN `trn_payment` ON `trn_payment`.`disbursement_id` = `trn_disbursement`.`id`
		WHERE `trn_approve`.`budget_main_id` = $budget_main_ID
		AND `trn_approve`.`mgt_product_id` = $mgt_product_id
		AND `trn_approve`.`status` IN (1,2)
		$where_date
		GROUP BY `trn_approve`.`id`)Z GROUP BY Z.mgt_product_id";
		
		return $this->db->query($query);
	}
	
	function costs_main_approve_only_level($budget_main_ID, $mgt_product_id, $costs_id, $start_date, $end_date)
	{
		if(!empty($start_date) && !empty($end_date))
		   $where_date = 'AND `trn_approve`.`doc_date` BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		   
		$query = "SELECT Z.costs_id, SUM(Z.real_amount) AS amount FROM(SELECT `trn_mgt_costs`.`costs_id`, trn_approve.amount - IFNULL(SUM(trn_payment.amount), 0) AS real_amount 
        FROM (`trn_approve`) 
        LEFT OUTER JOIN `trn_disbursement` ON `trn_disbursement`.`approve_id` = `trn_approve`.`id` 
        LEFT OUTER JOIN `trn_payment` ON `trn_payment`.`disbursement_id` = `trn_disbursement`.`id` 
        JOIN `trn_mgt_costs` ON `trn_mgt_costs`.`id` = `trn_approve`.`mgt_costs_id`
        WHERE `trn_approve`.`budget_main_id` = $budget_main_ID
        AND `trn_mgt_costs`.`mgt_product_id` = $mgt_product_id
        AND `trn_mgt_costs`.`costs_id` = $costs_id 
        AND `trn_approve`.`status` IN (1,2)
		$where_date
        GROUP BY `trn_approve`.`id`)Z GROUP BY Z.costs_id";
		
		return $this->db->query($query);
	}
	
	function costs_type_approve_only_level($budget_main_ID, $mgt_product_id, $costs_id, $costs_type_id, $start_date, $end_date)
	{
		if(!empty($start_date) && !empty($end_date))
		   $where_date = 'AND `trn_approve`.`doc_date` BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		   
		$query = "SELECT Z.costs_type_id, SUM(Z.real_amount) AS amount FROM(SELECT `trn_mgt_costs`.`costs_type_id`, trn_approve.amount - IFNULL(SUM(trn_payment.amount), 0) AS real_amount 
        FROM (`trn_approve`) 
        LEFT OUTER JOIN `trn_disbursement` ON `trn_disbursement`.`approve_id` = `trn_approve`.`id` 
        LEFT OUTER JOIN `trn_payment` ON `trn_payment`.`disbursement_id` = `trn_disbursement`.`id` 
        JOIN `trn_mgt_costs` ON `trn_mgt_costs`.`id` = `trn_approve`.`mgt_costs_id`
        WHERE `trn_approve`.`budget_main_id` = $budget_main_ID
        AND `trn_mgt_costs`.`mgt_product_id` = $mgt_product_id
        AND `trn_mgt_costs`.`costs_id` = $costs_id 
		AND `trn_mgt_costs`.`costs_type_id` = $costs_type_id 
        AND `trn_approve`.`status` IN (1,2) 
		$where_date
        GROUP BY `trn_approve`.`id`)Z GROUP BY Z.costs_type_id";
		
		return $this->db->query($query);
	}
	
	function costs_lists_approve_only_level($budget_main_ID, $mgt_product_id, $costs_id, $costs_type_id, $costs_lists_id, $start_date, $end_date)
	{
		if(!empty($start_date) && !empty($end_date))
		   $where_date = 'AND `trn_approve`.`doc_date` BETWEEN "'.$start_date.'" AND "'.$end_date.'" ';
		   
		$query = "SELECT Z.costs_lists_id, SUM(Z.real_amount) AS amount FROM(SELECT `trn_mgt_costs`.`costs_lists_id`, trn_approve.amount - IFNULL(SUM(trn_payment.amount), 0) AS real_amount 
        FROM (`trn_approve`) 
        LEFT OUTER JOIN `trn_disbursement` ON `trn_disbursement`.`approve_id` = `trn_approve`.`id` 
        LEFT OUTER JOIN `trn_payment` ON `trn_payment`.`disbursement_id` = `trn_disbursement`.`id` 
        JOIN `trn_mgt_costs` ON `trn_mgt_costs`.`id` = `trn_approve`.`mgt_costs_id`
        WHERE `trn_approve`.`budget_main_id` = $budget_main_ID
        AND `trn_mgt_costs`.`mgt_product_id` = $mgt_product_id
        AND `trn_mgt_costs`.`costs_id` = $costs_id 
		AND `trn_mgt_costs`.`costs_type_id` = $costs_type_id 
		AND `trn_mgt_costs`.`costs_lists_id` = $costs_lists_id 
        AND `trn_approve`.`status` IN (1,2)
		$where_date
        GROUP BY `trn_approve`.`id`)Z GROUP BY Z.costs_lists_id";
		
		return $this->db->query($query);
	}

}

/* End of file approve_model.php */
/* Location: ./application/models/approve_model.php */