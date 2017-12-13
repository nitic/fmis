<?php
class Costs_Group_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_costs_group';
        $this->primary_key = 'mst_costs_group.id';
		$this->order_by = 'mst_costs_group.id ASC';
    }
	 
	public $limit;
        public $offset; 
	public $sort;
	public $order;
	
   public function list_page() {
		
		$this->db->select('mst_costs_group.id, mst_costs_group.name, mst_costs_group.costs_id, mst_costs.name AS costs');
		$this->db->join('mst_costs','mst_costs.id = mst_costs_group.costs_id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_costs_group')
                        ->count_all_results();
        return $result;
    }

    public function get_combobox() {
		$this->db->select('mst_costs_group.id, mst_costs_group.costs_id, mst_costs_group.name, mst_costs.name AS type');
		$this->db->join('mst_costs','mst_costs.id = mst_costs_group.costs_id');
		return $this->get();
    }
}

/* End of file costs_group_model.php */
/* Location: ./application/models/costs_group_model.php */
