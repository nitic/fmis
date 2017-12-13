<?php
class Mgt_Plans_model extends MY_Model{
  
	function __construct (){
        parent::__construct();
        $this->table_name = 'trn_mgt_plans';
        $this->primary_key = 'trn_mgt_plans.id';
		$this->order_by = 'trn_mgt_plans.id ASC';
    }
	
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($where) {
		$this->db->select('trn_mgt_plans.id, mst_plans.name, trn_mgt_plans.budget_main_id, trn_mgt_plans.plan_id, trn_mgt_plans.amount as amount');
		$this->db->select("CONCAT(mst_budget.title,' ปี: ',(trn_budget_main.year + 543)) AS title",FALSE);
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
		   $result = $this->db->from('trn_mgt_plans')->where('trn_mgt_plans.budget_main_id',$where)->count_all_results();
		else
           $result = $this->db->from('trn_mgt_plans')->count_all_results();
        
          return $result;
    }
	
	public function list_by($budget_main_ID) {
		$this->db->select('trn_mgt_plans.id, trn_mgt_plans.plan_id, mst_plans.name, trn_mgt_plans.amount');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
    }
	
	public function summary_page($where) {
		$this->db->select('trn_budget_main.id, mst_budget.title, (trn_budget_main.year + 543) as year, trn_budget_main.amount, mst_budget_status.name AS status');
		$this->db->select('(trn_budget_main.amount - sum(trn_mgt_plans.amount)) AS balance',FALSE);
		$this->db->select('sum(trn_mgt_plans.amount) AS total',FALSE);
		
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		$this->db->join('mst_budget_status', 'mst_budget_status.id = trn_budget_main.status_id','INNER');
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->group_by("trn_mgt_plans.budget_main_id");
		$this->db->order_by('trn_budget_main.year','desc');
		
		return $this->get();
    }

	
	function get_budget_balance($budget_main_ID)
	{
		$this->db->select('trn_budget_main.amount');
		$this->db->select('(trn_budget_main.amount - sum(trn_mgt_plans.amount)) AS balance',FALSE);
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
	    $this->db->where('trn_mgt_plans.budget_main_id =', $budget_main_ID);
		return $this->get();
	}
	
	function get_amount()
	{
		$this->db->select('trn_budget_main.id,mst_budget.title,(trn_budget_main.year + 543) AS year');
		$this->db->select('FORMAT(IFNULL((trn_budget_main.amount - sum(trn_mgt_plans.amount)),trn_budget_main.amount),2) as amount', FALSE);
		$this->db->select('FORMAT(trn_budget_main.amount,2) AS budget',FALSE);
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id','right');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		$this->db->group_by("trn_budget_main.id"); 
		return $this->get();
	}

	// for report_planners.php
	public function report_page($where) {
		$this->db->select('trn_mgt_plans.id, mst_plans.name, trn_mgt_plans.amount');
		$this->db->select('FORMAT(IFNULL((trn_mgt_plans.amount - SUM(trn_mgt_product.amount)),trn_mgt_plans.amount),2) as balance', FALSE);
		
		$this->db->join('trn_budget_main', 'trn_budget_main.id = trn_mgt_plans.budget_main_id');
		$this->db->join('mst_plans','mst_plans.id = trn_mgt_plans.plan_id');
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		
		$this->db->join('trn_mgt_product', 'trn_mgt_product.mgt_plans_id = trn_mgt_plans.id',"LEFT OUTER");
		
		if(!empty($where))
		    $this->db->where('trn_mgt_plans.budget_main_id',$where);
		
		$this->db->group_by("trn_mgt_plans.id");
		return $this->get();
    }

}  


/* End of file mgt_plans_model.php */
/* Location: ./application/models/mgt_plans_model.php */