<?php
class Plans_model extends MY_Model{
     	
    function __construct (){
        parent::__construct();
        $this->table_name = 'mst_plans';
        $this->primary_key = 'mst_plans.id';
		$this->order_by = 'mst_plans.id ASC';
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
        $result = $this->db->from('mst_plans')
                        ->count_all_results();
        return $result;
    }
	
}

/* End of file plans_model.php */
/* Location: ./application/models/plans_model.php */