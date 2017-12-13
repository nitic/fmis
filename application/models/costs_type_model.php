<?php
class Costs_Type_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_costs_type';
        $this->primary_key = 'mst_costs_type.id';
		$this->order_by = 'mst_costs_type.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_costs_type.id, mst_costs_type.name, mst_costs_type.costs_group_id, mst_costs_group.name AS costs_group');
		$this->db->join('mst_costs_group', 'mst_costs_group.id = mst_costs_type.costs_group_id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_costs_type')
                        ->count_all_results();
        return $result;
    }
}

/* End of file costs_type_model.php */
/* Location: ./application/models/costs_type_model.php */