<?php
class Personnel_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_personnel';
        $this->primary_key = 'mst_personnel.id';
		$this->order_by = 'mst_personnel.id ASC';
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
        $result = $this->db->from('mst_personnel')
                        ->count_all_results();
        return $result;
    }
	
	public function list_person() {
		$this->db->select('mst_personnel.code');
		$this->db->select("CONCAT(mst_personnel.firstname,' ',mst_personnel.lastname) AS name",FALSE);
		return $this->get();
    }
	
}

/* End of file personnel_model.php */
/* Location: ./application/models/personnel_model.php */