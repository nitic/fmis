<?php
class Disbursement_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_disbursement';
        $this->primary_key = 'trn_disbursement.id';
		$this->order_by = 'trn_disbursement.id ASC';
    }
	 
	public $limit;
        public $offset; 
	public $sort;
	public $order;
	
	public function list_page($budget_main_ID, $where) {
		
		$this->db->select('trn_disbursement.id, trn_disbursement.doc_number, trn_disbursement.doc_date, trn_disbursement.file_number, trn_disbursement.approve_id, trn_disbursement.budget_main_id, trn_disbursement.note');
		$this->db->select('SUM(trn_payment.amount) AS total_amount');
		$this->db->select('trn_approve.subject, mst_plans.name AS plan, mst_product.name AS product, mst_costs.name AS costs, mst_costs_type.name AS coststype');
		
		$this->db->select("IF(trn_disbursement.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costsname",FALSE);
		
		//$this->db->select("CONCAT(DATE_FORMAT(trn_disbursement.doc_date, '%d'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%m'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%Y' ) +543) AS doc_date", FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.id = trn_disbursement.approve_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_disbursement.mgt_plans_id');
        $this->db->join('trn_mgt_product','trn_mgt_product.id = trn_disbursement.mgt_product_id');
        
		$this->db->join('trn_payment','trn_payment.disbursement_id = trn_disbursement.id');
        
		$this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id');
        $this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id');
        
		$this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_disbursement.costs_type_id');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_disbursement.costs_lists_id');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_disbursement.costs_sublist_id',"LEFT OUTER");
		
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        
        if(!empty($where))
		    $this->db->like('trn_disbursement.doc_number', $where);
		
		$this->db->group_by('trn_disbursement.id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 

    public function num_page($budget_main_ID, $where) {	
		if(!empty($where)){
		   $result = $this->db->from('trn_disbursement')
		                      ->join('trn_approve', 'trn_disbursement.approve_id = trn_approve.id')
		                      ->where('trn_approve.budget_main_id', $budget_main_ID)
                              ->like('trn_disbursement.doc_number', $where)
		                      ->count_all_results();
		}
		else{
           $result = $this->db->from('trn_disbursement')->where('trn_disbursement.budget_main_id', $budget_main_ID)->count_all_results();
		}
		
        return $result;
    }
    
	
	function approve_paymented_lists($approve_id)
	{
		$this->db->select('trn_disbursement.id, trn_disbursement.doc_number, trn_disbursement.file_number, trn_disbursement.invoice_number');
		$this->db->select("CONCAT(DATE_FORMAT(trn_disbursement.doc_date, '%d'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%m'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%Y' ) +543) AS doc_date", FALSE);
        $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS total_payment', FALSE);
		 
		$this->db->select("CONCAT(mst_plans.name,' / ', mst_product.name) AS plan_product",FALSE);
        $this->db->select("CONCAT(mst_costs.name,' / ', mst_costs_type.name,' / ',IF(trn_disbursement.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS costs",FALSE);
		
		 
		$this->db->join('trn_approve','trn_approve.id = trn_disbursement.approve_id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		// costs
		$this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id','LEFT OUTER');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_disbursement.costs_group_id','LEFT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_disbursement.costs_type_id','LEFT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_disbursement.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_disbursement.costs_sublist_id','LEFT OUTER');
        
        // product
        $this->db->join('trn_mgt_product','trn_mgt_product.id = trn_disbursement.mgt_product_id','LEFT OUTER');
        $this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id','LEFT OUTER');
        
        // plans
        $this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_disbursement.mgt_plans_id','LEFT OUTER');
        $this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id', 'LEFT OUTER');
		
		
		$this->db->where('trn_approve.id =', $approve_id);
        $this->db->group_by('trn_disbursement.id');
		return $this->get();
		 
	}	
	
    function disbursement_paymented_detail($disbursement_ID)
	{
		 $this->db->select('trn_disbursement.id, trn_disbursement.doc_number, trn_disbursement.file_number, trn_disbursement.invoice_number');
         $this->db->select("CONCAT(trn_approve.doc_number,'  (', trn_approve.file_number,')') AS approve_doc_number", FALSE);
         $this->db->select('IFNULL(SUM(trn_payment.amount),0)  AS total_payment',FALSE);
		
         $this->db->select('mst_plans.name AS plan, mst_product.name AS product, mst_costs_type.name AS costs_type');
		 $this->db->select("CONCAT(mst_costs.name,' / ', mst_costs_group.name) AS costs_group", FALSE);
		 $this->db->select("IF(trn_disbursement.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs_lists",FALSE);
		
		 $this->db->select("CONCAT(DATE_FORMAT(trn_disbursement.doc_date, '%d'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%m'),'/',DATE_FORMAT(trn_disbursement.doc_date, '%Y' ) +543) AS doc_date", FALSE);

        $this->db->join('trn_approve','trn_approve.id = trn_disbursement.approve_id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
         
        // costs
		$this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id','LEFT OUTER');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = trn_disbursement.costs_group_id','LEFT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_disbursement.costs_type_id','LEFT OUTER');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = trn_disbursement.costs_lists_id','LEFT OUTER');
		$this->db->join('mst_costs_sublist', 'mst_costs_sublist.id = trn_disbursement.costs_sublist_id','LEFT OUTER');
        
        // product
        $this->db->join('trn_mgt_product','trn_mgt_product.id = trn_disbursement.mgt_product_id','LEFT OUTER');
        $this->db->join('mst_product', 'mst_product.id = trn_mgt_product.product_id','LEFT OUTER');
        
        // plans
        $this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_disbursement.mgt_plans_id','LEFT OUTER');
        $this->db->join('mst_plans', 'mst_plans.id = trn_mgt_plans.plan_id', 'LEFT OUTER');
        
	    $this->db->where('trn_disbursement.id =', $disbursement_ID);
   
		return $this->get();
	}
    
    
    // for report_plans_costs.php
    function costs_level($budget_main_ID, $plans_ID, $product_ID, $start_date, $end_date)
	{
                $this->db->select('trn_disbursement.id, trn_disbursement.costs_id , mst_costs.name');
                $this->db->select('sum(trn_payment.amount) AS payment',FALSE);
                
                $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
                $this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id');
        
        
                $this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
        
        
                $this->db->where('trn_disbursement.mgt_plans_id =', $plans_ID);
                $this->db->where('trn_disbursement.mgt_product_id =', $product_ID);
                
                if(!empty($start_date) && !empty($end_date))
                $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
                
                $this->db->group_by('trn_disbursement.costs_id');
                return $this->get();
	}
    
      // for report_plans_costs.php
    function costs_groupview($budget_main_ID, $plans_ID, $product_ID, $costs_ID, $start_date, $end_date)
	{
        $this->db->select('trn_disbursement.id, trn_disbursement.doc_number, trn_disbursement.doc_date, trn_disbursement.file_number');
        $this->db->select('mst_costs_type.id AS costs_type_id, mst_costs_type.name AS costs_type_name');
        $this->db->select("IF(trn_disbursement.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
        $this->db->select('sum(trn_payment.amount) AS payment',FALSE);
		
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
        $this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id');
        $this->db->join('mst_costs_type', 'mst_costs_type.id = trn_disbursement.costs_type_id');
        $this->db->join('mst_costs_lists','mst_costs_lists.id = trn_disbursement.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_disbursement.costs_sublist_id',"LEFT OUTER");
        
       
		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
        
        
        $this->db->where('trn_disbursement.mgt_plans_id =', $plans_ID);
        $this->db->where('trn_disbursement.mgt_product_id =', $product_ID);
        $this->db->where('trn_disbursement.costs_id =', $costs_ID);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        $this->db->group_by('trn_disbursement.id');
		return $this->get();
	}
    
    
    // search.php
	function search_doc_number($budget_main_ID, $q)
	{
	    $q = urldecode($q);
		$pagesize = 50; 
		$table_db = "trn_disbursement"; 
		$find_field ="trn_disbursement.doc_number"; 
		
		return $this->db->query("select trn_disbursement.id, trn_disbursement.doc_number from $table_db where trn_disbursement.budget_main_id = '$budget_main_ID' AND locate('$q', $find_field) > 0 group by trn_disbursement.doc_number  order by locate('$q', $find_field), $find_field limit $pagesize");
	}
    
    
    // for new
    function plan_paymented_level($budget_main_id, $mgt_plan_id, $start_date, $end_date)
	{
        $this->db->select('sum(trn_payment.amount) AS payment', FALSE);
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_disbursement.budget_main_id =', $budget_main_id);
        $this->db->where('trn_disbursement.mgt_plans_id =', $mgt_plan_id);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        $this->db->group_by('trn_disbursement.mgt_plans_id');
		return $this->get();
	}
    
    function product_paymented_level($budget_main_id, $mgt_product_id, $start_date, $end_date)
	{
        $this->db->select('IFNULL(SUM(trn_payment.amount),0.00)  AS payment', FALSE);
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_disbursement.budget_main_id =', $budget_main_id);
        $this->db->where('trn_disbursement.mgt_product_id =', $mgt_product_id);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        $this->db->group_by('trn_disbursement.mgt_product_id');
		return $this->get();
	}
    
    function costs_main_paymented_level($budget_main_id, $mgt_product_id, $costs_id, $start_date, $end_date)
	{
        $this->db->select('IFNULL(SUM(trn_payment.amount),0.00)  AS payment', FALSE);
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_disbursement.budget_main_id =', $budget_main_id);
        $this->db->where('trn_disbursement.mgt_product_id =', $mgt_product_id);
        $this->db->where('trn_disbursement.costs_id =', $costs_id);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        $this->db->group_by('trn_disbursement.costs_id');
		return $this->get();
	}
    
    function costs_type_paymented_level($budget_main_id, $mgt_product_id, $costs_id, $costs_type_id, $start_date, $end_date)
	{
        $this->db->select('IFNULL(SUM(trn_payment.amount),0.00)  AS payment', FALSE);
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_disbursement.budget_main_id =', $budget_main_id);
        $this->db->where('trn_disbursement.mgt_product_id =', $mgt_product_id);
        $this->db->where('trn_disbursement.costs_id =', $costs_id);
        $this->db->where('trn_disbursement.costs_type_id =', $costs_type_id);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"');
        
        $this->db->group_by('trn_disbursement.costs_type_id');
		return $this->get();
	}
    
    function costs_lists_paymented_level($budget_main_id, $mgt_product_id, $costs_id, $costs_type_id, $costs_lists_id, $start_date, $end_date)
	{
        $this->db->select('IFNULL(SUM(trn_payment.amount),0.00)  AS payment', FALSE);
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        $this->db->where('trn_disbursement.budget_main_id =', $budget_main_id);
        $this->db->where('trn_disbursement.mgt_product_id =', $mgt_product_id);
        $this->db->where('trn_disbursement.costs_id =', $costs_id);
        $this->db->where('trn_disbursement.costs_type_id =', $costs_type_id);
        $this->db->where('trn_disbursement.costs_lists_id =', $costs_lists_id);
        
        if(!empty($start_date) && !empty($end_date))
           $this->db->where('trn_disbursement.doc_date BETWEEN "'.$start_date.'" AND "'.$end_date.'"'); 
        
        $this->db->group_by('trn_disbursement.costs_lists_id');
		return $this->get();
	}
	
}

/* End of file disbursement_model.php */
/* Location: ./application/models/disbursement_model.php */