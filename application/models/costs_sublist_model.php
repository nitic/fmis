<?php
class Costs_Sublist_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_costs_sublist';
        $this->primary_key = 'mst_costs_sublist.id';
		$this->order_by = 'mst_costs_sublist.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_costs_sublist.id, mst_costs_sublist.name, mst_costs_sublist.costs_lists_id, mst_costs_lists.name AS lists, mst_costs_lists.costs_type_id, mst_costs_type.name AS type');
		$this->db->join('mst_costs_lists', 'mst_costs_lists.id = mst_costs_sublist.costs_lists_id');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = mst_costs_lists.costs_type_id');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
    	
          $result = $this->db->from('mst_costs_sublist')->count_all_results();
          return $result;
    }
}

/* End of file costs_sublist_model.php */
/* Location: ./application/models/costs_sublist_model.php */