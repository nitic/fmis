<?php
class Dashboard_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_budget_main';
        $this->primary_key = 'trn_budget_main.id';
		$this->order_by = 'trn_budget_main.id ASC';
    }
	 
	public function num_page() {
        $result = $this->db->from('trn_budget_main')
                        ->count_all_results();
        return $result;
    }
	
	// Pie Chart 1
	public function total_chart($budget_main_ID) {
		
		$this->db->select('IFNULL(trn_budget_main.amount,0) AS budget',FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
		
		$this->db->join('trn_disbursement','trn_disbursement.budget_main_id = trn_budget_main.id','LEFT OUTER');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		
		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 2
	public function mgt_plan_chart($budget_main_ID) {
		
		$this->db->select('mst_plans.name, trn_mgt_plans.amount');
		
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.budget_main_id = trn_budget_main.id ');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');		
		
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 3
	public function approve_nopayment_chart($budget_main_ID) {
		$this->db->select('trn_approve.id,trn_approve.amount');
		$this->db->select("trn_approve.status+0 AS status_id", FALSE);
		$this->db->select('IFNULL(sum(trn_payment.amount),0)  AS payment',FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        $this->db->group_by("trn_approve.id");
       // $this->db->having('IFNULL(sum(trn_payment.amount),0) =', 0); 
		return $this->get();
    }
    
    // Bar Chart 1
	public function payment_bar_chart($budget_main_ID) {
		
		$this->db->select('trn_disbursement.doc_date');
        $this->db->select('IFNULL(sum(trn_payment.amount),0) AS total',FALSE);
        
		$this->db->join('trn_disbursement', 'trn_disbursement.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		
		$this->db->group_by("YEAR(trn_disbursement.doc_date), MONTH(trn_disbursement.doc_date)");
		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	// Pie Chart 4
	public function payment_plans_chart($budget_main_ID) {
		
		$this->db->select('mst_plans.name');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_disbursement', 'trn_disbursement.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.id = trn_disbursement.mgt_plans_id ');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
        
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		
		$this->db->group_by("trn_disbursement.mgt_plans_id");
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
 
    // Pie Chart 5
	public function payment_costs_chart($budget_main_ID) {
		
		$this->db->select('mst_costs.name');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_disbursement', 'trn_disbursement.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		$this->db->join('mst_costs', 'mst_costs.id = trn_disbursement.costs_id','RIGHT OUTER');
		
		$this->db->group_by("mst_costs.id");
		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
		return $this->get();
    }

	// Pie Chart 6
	public function payment_coststype_chart($budget_main_ID) {
		
		$this->db->select('mst_costs_type.name');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_disbursement', 'trn_disbursement.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_disbursement.costs_type_id','RIGHT OUTER');
		
		$this->db->group_by("mst_costs_type.id");
		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
    
    // mail
	public function payment_plans_summary($budget_main_ID) {
		
		$this->db->select('trn_mgt_plans.id, mst_plans.name, trn_mgt_plans.amount');
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS payment',FALSE);
		
        $this->db->join('trn_mgt_plans', 'trn_mgt_plans.budget_main_id = trn_budget_main.id');
        $this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
        
		$this->db->join('trn_disbursement', 'trn_disbursement.mgt_plans_id = trn_mgt_plans.id', 'LEFT');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT');
        
        
	    $this->db->group_by("trn_mgt_plans.id");
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
    
    
    // mail.php
	public function paymented_by_date($budget_main_ID, $year_month) {
		
		$this->db->select('IFNULL(sum(trn_payment.amount),0) AS amount',FALSE);
		
		$this->db->join('trn_disbursement', 'trn_disbursement.budget_main_id = trn_budget_main.id');
		$this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id','LEFT OUTER');

		$this->db->where('trn_disbursement.budget_main_id =', $budget_main_ID);
        $this->db->like('trn_disbursement.doc_date', $year_month, 'after'); 
       
        $this->db->group_by("trn_disbursement.budget_main_id");
		return $this->get();
    }
   
    // mail.php approve status 1
    public function approveonly_status1($budget_main_ID, $year_month) {
        $this->db->select('IFNULL(SUM(trn_approve.amount),0) AS amount',FALSE);
        
        $this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id','LEFT OUTER');

        $this->db->where('trn_disbursement.approve_id IS NULL');
        $this->db->like('trn_approve.doc_date', $year_month, 'after');
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
         $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        
        $this->db->group_by("trn_approve.budget_main_id");
  	
		return $this->get();
    }
    
     // mail.php approve status 2
    public function approveonly_status2($budget_main_ID, $year_month) {

        $this->db->select('trn_approve.amount - SUM(trn_payment.amount) as payment');
        $this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id');
        $this->db->join('trn_disbursement','trn_disbursement.approve_id = trn_approve.id');
        $this->db->join('trn_payment', 'trn_payment.disbursement_id = trn_disbursement.id');

        $this->db->like('trn_approve.doc_date', $year_month, 'after');
        $this->db->where('trn_approve.budget_main_id =', $budget_main_ID);
        $this->db->where('trn_approve.status =', 2);
        
        $this->db->group_by("trn_approve.id");
		return $this->get();
    }
    
    
}


/* End of file dashboard_model.php */
/* Location: ./application/models/dashboard_model.php */