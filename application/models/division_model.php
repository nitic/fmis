<?php
class Division_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_division';
        $this->primary_key = 'mst_division.id';
		$this->order_by = 'mst_division.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_division.id, mst_division.name, mst_division.department_id, mst_department.name AS department, mst_faculty.name as faculty');
		$this->db->join('mst_department', 'mst_department.id = mst_division.department_id','INNER');
		$this->db->join('mst_faculty', 'mst_faculty.code = mst_department.faculty_code');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_division')
                        ->count_all_results();
        return $result;
    }
}

/* End of file division_model.php */
/* Location: ./application/models/division_model.php */
