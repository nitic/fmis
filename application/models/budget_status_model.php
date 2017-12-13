<?php
class Budget_Status_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_budget_status';
        $this->primary_key = 'mst_budget_status.id';
		$this->order_by = 'mst_budget_status.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_budget_status')
                        ->count_all_results();
        return $result;
    }
}

/* End of file budget_status_model.php */
/* Location: ./application/models/budget_status_model.php */