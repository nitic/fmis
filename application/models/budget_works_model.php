<?php
class Budget_Works_model extends MY_Model{
  
	function __construct (){
        parent::__construct();
        $this->table_name = 'trn_budget_works';
        $this->primary_key = 'trn_budget_works.id';
		$this->order_by = 'trn_budget_works.id ASC';
    }
	
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('trn_budget_works.id,mst_works.id AS wid, mst_works.name AS name, mst_plans.id AS pid, mst_plans.name AS plan, trn_budget_works.budget_plans_id, trn_budget_works.amount, trn_budget_works.create_date');
		$this->db->join('mst_works','mst_works.id = trn_budget_works.work_id');
		$this->db->join('trn_budget_plans', 'trn_budget_plans.id = trn_budget_works.budget_plans_id');
		$this->db->join('mst_plans','mst_plans.id = trn_budget_plans.plan_id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('trn_budget_works')
                        ->count_all_results();
        return $result;
    }	
	

	function get_amount()
	{
		$this->db->select('trn_budget_plans.id AS id,mst_plans.id AS pid, mst_plans.name,FORMAT(trn_budget_plans.amount,2) AS plan',FALSE);
		$this->db->select('FORMAT(IFNULL((trn_budget_plans.amount - sum(trn_budget_works.amount)),trn_budget_plans.amount),2) as amount', FALSE);
		$this->db->join('trn_budget_plans', 'trn_budget_plans.id = trn_budget_works.budget_plans_id','right');
		$this->db->join('mst_plans','mst_plans.id = trn_budget_plans.plan_id');
		$this->db->group_by("trn_budget_plans.id");
		$this->db->order_by("trn_budget_plans.id");
		return $this->get();
	}
}  


/* End of file budget_works_model.php */
/* Location: ./application/models/budget_works_model.php */