<?php
class Report_Mgt_model extends MY_Model{
  
	function __construct (){
        parent::__construct();
        $this->table_name = 'trn_mgt_plans';
        $this->primary_key = 'trn_mgt_plans.id';
		$this->order_by = 'trn_mgt_plans.id ASC';
    }
	
	
	public function plans_level($budget_main_id, $mgt_plans_id) {
		$this->db->select('trn_mgt_plans.id AS plan_id, mst_plans.name AS plan_name, trn_mgt_plans.amount AS plan_amount');
			
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id');
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.mgt_product_id = trn_mgt_product.id');
		
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
			
		
	    $this->db->where('trn_mgt_plans.budget_main_id',$budget_main_id);
		
		if(!empty($mgt_plans_id))
		    $this->db->where('trn_mgt_plans.id =', $mgt_plans_id);
			
		$this->db->group_by("trn_mgt_plans.id");
		$this->db->order_by("trn_mgt_plans.id");
		return $this->get();
    }
	
	
	public function product_level($budget_main_id, $mgt_product_id) {
		$this->db->select('mgt_plans_id');
		
		$this->db->select('trn_mgt_product.id AS product_id,  mst_product.name AS product_name, trn_mgt_product.amount AS product_amount');
			
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id');
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.mgt_product_id = trn_mgt_product.id');
		
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
			
	    $this->db->where('trn_mgt_plans.budget_main_id',$budget_main_id);
		
		if(!empty($mgt_product_id))
		    $this->db->where('trn_mgt_product.id =', $mgt_product_id);
		
		$this->db->group_by("trn_mgt_product.id");
		$this->db->order_by("trn_mgt_product.mgt_plans_id");
		
		return $this->get();
    }
	
	public function costs_main_level($budget_main_id) {
		$this->db->select('mgt_product_id');
		
		$this->db->select('trn_mgt_costs.costs_id,  mst_costs.name AS cost_main_name');
	    $this->db->select('sum(trn_mgt_costs.amount) AS cost_main_amount',FALSE);	
			
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id');
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.mgt_product_id = trn_mgt_product.id');
		
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_costs', 'mst_costs.id = trn_mgt_costs.costs_id');
			
		
	    $this->db->where('trn_mgt_plans.budget_main_id',$budget_main_id);
		
		$this->db->group_by("trn_mgt_product.id, trn_mgt_costs.costs_id");
		$this->db->order_by("trn_mgt_product.id");
		return $this->get();
    }
	
	public function costs_type_level($budget_main_id) {
		$this->db->select('mgt_product_id, trn_mgt_costs.costs_id AS costs_main_id');
		
		$this->db->select('trn_mgt_costs.costs_type_id,  mst_costs_type.name AS cost_type_name');
	    $this->db->select('sum(trn_mgt_costs.amount) AS cost_type_amount',FALSE);	
			
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id');
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.mgt_product_id = trn_mgt_product.id');
		
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = trn_mgt_costs.costs_type_id');
			
		
	    $this->db->where('trn_mgt_plans.budget_main_id', $budget_main_id);
		
		$this->db->group_by("trn_mgt_product.id, trn_mgt_costs.costs_type_id");
		$this->db->order_by("trn_mgt_product.id");
		return $this->get();
    }
	
	public function costs_lists_level($budget_main_id) {
		$this->db->select('mgt_product_id, trn_mgt_costs.costs_id AS costs_main_id, trn_mgt_costs.costs_type_id');
		
		$this->db->select('trn_mgt_costs.costs_lists_id');
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS costs_lists_name",FALSE);
	    $this->db->select('sum(trn_mgt_costs.amount) AS costs_lists_amount',FALSE);	
			
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id');
		$this->db->join('trn_mgt_costs', 'trn_mgt_costs.mgt_product_id = trn_mgt_product.id');
		
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_costs_lists','mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
			
		
	    $this->db->where('trn_mgt_plans.budget_main_id',$budget_main_id);
		
		$this->db->group_by("trn_mgt_product.id, trn_mgt_costs.costs_lists_id");
		$this->db->order_by("trn_mgt_product.id");
		return $this->get();
    }

}  


/* End of file mgt_plans_model.php */
/* Location: ./application/models/mgt_plans_model.php */