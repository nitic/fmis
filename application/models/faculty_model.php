<?php
class Faculty_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_faculty';
        $this->primary_key = 'mst_faculty.id';
		$this->order_by = 'mst_faculty.id ASC';
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
        $result = $this->db->from('mst_faculty')
                        ->count_all_results();
        return $result;
    }
}

/* End of file faculty_model.php */
/* Location: ./application/models/faculty_model.php */