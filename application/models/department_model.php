<?php
class Department_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_department';
        $this->primary_key = 'mst_department.id';
		$this->order_by = 'mst_department.id ASC';
    }
	 
	public $limit;
        public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_department.id, mst_department.name, mst_department.faculty_code, mst_faculty.name as faculty');
		$this->db->join('mst_faculty', 'mst_faculty.code = mst_department.faculty_code','INNER');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_department')
                        ->count_all_results();
        return $result;
    }
}

/* End of file department_model.php */
/* Location: ./application/models/department_model.php */
