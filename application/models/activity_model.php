<?php
class Activity_model extends MY_Model{
     	
    function __construct (){
        parent::__construct();
        $this->table_name = 'mst_activity';
        $this->primary_key = 'mst_activity.id';
		$this->order_by = 'mst_activity.id ASC';
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
        $result = $this->db->from('mst_activity')
                        ->count_all_results();
        return $result;
    }
	
}

/* End of file activity_model.php */
/* Location: ./application/models/activity_model.php */