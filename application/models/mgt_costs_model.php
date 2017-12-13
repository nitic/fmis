<?php
class Mgt_Costs_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_mgt_costs';
        $this->primary_key = 'trn_mgt_costs.id';
		$this->order_by = 'trn_mgt_costs.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($where) {
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.mgt_product_id, mst_product.name AS product, mst_plans.name AS plan, trn_mgt_costs.amount');
		$this->db->select('trn_mgt_product.mgt_plans_id, trn_mgt_plans.budget_main_id');
		$this->db->select('trn_mgt_costs.costs_id, trn_mgt_costs.costs_group_id, trn_mgt_costs.costs_type_id, trn_mgt_costs.costs_lists_id, trn_mgt_costs.costs_sublist_id');
		
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
		$this->db->select('mst_costs.name AS costs, mst_costs_group.name AS costs_group, mst_costs_type.name AS costs_type');
		
		$this->db->select('trn_mgt_costs.mgt_product_id, trn_mgt_product.mgt_plans_id , trn_mgt_plans.budget_main_id');
		$this->db->select("CONCAT(mst_budget.initial,' ',(trn_budget_main.year + 543)) AS year",FALSE);
		
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		
		$this->db->join('mst_costs','mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group','mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type','mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists','mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
		
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($where) {
    	
		if(!empty($where))
		   $result = $this->db->from('trn_mgt_costs')
		   			 ->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id')
		   			 ->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id')
		             ->where('trn_mgt_plans.budget_main_id',$where)
		             ->count_all_results();
		else
           $result = $this->db->from('trn_mgt_costs')->count_all_results();
        
          return $result;
    }

	function get_product_balance($mgt_product_ID)
	{
		$this->db->select('trn_mgt_product.amount');
		$this->db->select('(trn_mgt_product.amount - sum(trn_mgt_costs.amount)) AS balance',FALSE);
		$this->db->join('trn_mgt_product', 'trn_mgt_product.id = trn_mgt_costs.mgt_product_id');
	    $this->db->where('trn_mgt_costs.mgt_product_id =', $mgt_product_ID);
		return $this->get();
	}
    
    function get_by_id($mgt_costs_ID)
	{
		$this->db->select('trn_mgt_costs.mgt_product_id, trn_mgt_costs.costs_id, trn_mgt_costs.costs_group_id, trn_mgt_costs.costs_type_id, trn_mgt_costs.costs_lists_id');
		$this->db->select('trn_mgt_product.mgt_plans_id, trn_mgt_product.product_id');
        //$this->db->select('trn_mgt_plans.id AS planID');
        //$this->db->select('(trn_mgt_product.amount - sum(trn_mgt_costs.amount)) AS balance',FALSE);
		
        $this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
	    
        $this->db->where('trn_mgt_costs.id =', $mgt_costs_ID);
		return $this->get();
	}
	
	public function summary_page($where) {
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.mgt_product_id, mst_product.name AS product, mst_plans.name AS plans, trn_mgt_product.amount');
		$this->db->select("CONCAT(mst_budget.initial,' ',(trn_budget_main.year + 543)) AS budget",FALSE);
		$this->db->select('(trn_mgt_product.amount - sum(trn_mgt_costs.amount)) AS balance',FALSE);
		$this->db->select('sum(trn_mgt_costs.amount) AS total',FALSE);
		
		$this->db->join('trn_mgt_product','trn_mgt_product.id = trn_mgt_costs.mgt_product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->group_by("trn_mgt_costs.mgt_product_id");
		$this->db->order_by('trn_budget_main.year','desc');
		return $this->get();
    }
	
	public function list_by($mgt_product_ID) {
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.amount');
		
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
		$this->db->select('mst_costs.name AS costs, mst_costs_group.name AS costs_group, mst_costs_type.name AS costs_type');
		
		$this->db->join('mst_costs','mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_group','mst_costs_group.id = trn_mgt_costs.costs_group_id');
		$this->db->join('mst_costs_type','mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists','mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
		
		$this->db->where('trn_mgt_costs.mgt_product_id =', $mgt_product_ID);
		return $this->get();
    }
    
    public function list_by_cost_all($mgt_product_ID, $costs_ID, $costs_group_ID, $costs_type_ID) {
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.amount');
		
		$this->db->select("IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name)) AS name",FALSE);
		//$this->db->select('mst_costs.name AS costs, mst_costs_group.name AS costs_group, mst_costs_type.name AS costs_type');
		
		//$this->db->join('mst_costs','mst_costs.id = trn_mgt_costs.costs_id');
		//$this->db->join('mst_costs_group','mst_costs_group.id = trn_mgt_costs.costs_group_id');
		//$this->db->join('mst_costs_type','mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists','mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
		
		$this->db->where('trn_mgt_costs.mgt_product_id =', $mgt_product_ID);
        $this->db->where('trn_mgt_costs.costs_id =', $costs_ID);
        $this->db->where('trn_mgt_costs.costs_group_id =', $costs_group_ID);
        $this->db->where('trn_mgt_costs.costs_type_id =', $costs_type_ID);
		return $this->get();
    }

    
	// for report_planners.php
	public function report_page($mgt_product_id) {
		$this->db->select('trn_mgt_costs.id, trn_mgt_costs.amount');
		
		$this->db->select("CONCAT(mst_costs.name, ' >> ', mst_costs_type.name, ' >> ', IF(trn_mgt_costs.costs_sublist_id = 0, mst_costs_lists.name, CONCAT(mst_costs_lists.name,' / ', mst_costs_sublist.name))) AS name",FALSE);
		
		$this->db->join('mst_costs','mst_costs.id = trn_mgt_costs.costs_id');
		$this->db->join('mst_costs_type','mst_costs_type.id = trn_mgt_costs.costs_type_id');
		$this->db->join('mst_costs_lists','mst_costs_lists.id = trn_mgt_costs.costs_lists_id');
		$this->db->join('mst_costs_sublist','mst_costs_sublist.id = trn_mgt_costs.costs_sublist_id',"LEFT OUTER");
		$this->db->where('trn_mgt_costs.mgt_product_id', $mgt_product_id);
		return $this->get();
    }

	// for report_planners.php
	public function report_num_page($mgt_product_id) {
		$result = $this->db->from('trn_mgt_costs')
		             ->where('trn_mgt_costs.mgt_product_id', $mgt_product_id)
		             ->count_all_results();
		return $result;
    }
    

}

/* End of file mgt_costs_model.php */
/* Location: ./application/models/mgt_costs_model.php */