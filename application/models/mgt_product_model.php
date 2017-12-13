<?php
class Mgt_Product_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_mgt_product';
        $this->primary_key = 'trn_mgt_product.id';
		$this->order_by = 'trn_mgt_product.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($where) {
		$this->db->select('trn_mgt_product.id, trn_mgt_product.product_id,mst_product.name, trn_mgt_plans.plan_id, mst_plans.name AS plans, trn_mgt_product.amount');
		$this->db->select('trn_mgt_product.mgt_plans_id, trn_mgt_plans.budget_main_id');
		$this->db->select("CONCAT(mst_budget.title,': ',(trn_budget_main.year + 543)) AS year",FALSE);
		
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($where) {
    	
		if(!empty($where))
		   $result = $this->db->from('trn_mgt_product')->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id')
		             ->where('trn_mgt_plans.budget_main_id',$where)
		             ->count_all_results();
		else
           $result = $this->db->from('trn_mgt_product')->count_all_results();
        
          return $result;
    }

	function get_plans_balance($mgt_plans_ID)
	{
		$this->db->select('trn_mgt_plans.amount');
		$this->db->select('(trn_mgt_plans.amount - sum(trn_mgt_product.amount)) AS balance',FALSE);
		$this->db->join('trn_mgt_plans', 'trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
	    $this->db->where('trn_mgt_product.mgt_plans_id =', $mgt_plans_ID);
		return $this->get();
	}
	
	public function summary_page($where) {
		$this->db->select('trn_mgt_plans.id, mst_plans.name, mst_budget.title, (trn_budget_main.year + 543) as year, trn_mgt_plans.amount');
		$this->db->select('(trn_mgt_plans.amount - sum(trn_mgt_product.amount)) AS balance',FALSE);
		$this->db->select('sum(trn_mgt_product.amount) AS total',FALSE);
		
		$this->db->join('trn_mgt_plans','trn_mgt_plans.id = trn_mgt_product.mgt_plans_id');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->group_by("trn_mgt_product.mgt_plans_id");
		$this->db->order_by('trn_budget_main.year','desc');
		return $this->get();
    }
	
	public function list_by($mgt_plans_ID) {
		$this->db->select('trn_mgt_product.id, trn_mgt_product.product_id, mst_product.name, trn_mgt_product.amount');
		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
		$this->db->where('trn_mgt_product.mgt_plans_id =', $mgt_plans_ID);
		return $this->get();
    }

	// for report_planners.php
	public function report_page($mgt_plans_id) {
		$this->db->select('trn_mgt_product.id, mst_product.name, trn_mgt_product.amount');
		$this->db->select('FORMAT(IFNULL((trn_mgt_product.amount - SUM(trn_mgt_costs.amount)),trn_mgt_product.amount),2) as balance', FALSE);

		$this->db->join('mst_product','mst_product.id = trn_mgt_product.product_id');
	    $this->db->where('trn_mgt_product.mgt_plans_id',$mgt_plans_id);
		
		$this->db->join('trn_mgt_costs','trn_mgt_costs.mgt_product_id = trn_mgt_product.id' ,"LEFT OUTER");
		
		$this->db->group_by("trn_mgt_product.id");
		return $this->get();
    }

	// for report_planners.php
	public function report_num_page($mgt_plans_id) {
		$result = $this->db->from('trn_mgt_product')
		             ->where('trn_mgt_product.mgt_plans_id', $mgt_plans_id)
		             ->count_all_results();
		return $result;
    }
}

/* End of file mgt_product_model.php */
/* Location: ./application/models/mgt_product_model.php */