<?php
class Costs_Lists_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_costs_lists';
        $this->primary_key = 'mst_costs_lists.id';
		$this->order_by = 'mst_costs_lists.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page($where) {
		$this->db->select('mst_costs_lists.id, mst_costs_lists.name, mst_costs_lists.costs_type_id, mst_costs_type.name AS type');
		$this->db->join('mst_costs_type', 'mst_costs_type.id = mst_costs_lists.costs_type_id');
		
		if(!empty($where))
		    $this->db->where('costs_type_id',$where);
		
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page($where) {
    	
		if(!empty($where))
		   $result = $this->db->from('mst_costs_lists')->where('costs_type_id',$where)->count_all_results();
		else
           $result = $this->db->from('mst_costs_lists')->count_all_results();
        
          return $result;
    }
}

/* End of file costs_lists_model.php */
/* Location: ./application/models/costs_lists_model.php */