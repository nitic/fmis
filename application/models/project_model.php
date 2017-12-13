<?php
class Project_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_project';
        $this->primary_key = 'mst_project.id';
		$this->order_by = 'mst_project.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_project.id, mst_project.name AS name, mst_project.product_id, mst_product.name AS product, mst_project.is_active , mst_project.create_date');
		$this->db->select("CONCAT(LPAD(mst_product.id,2,'0'),LPAD(mst_project.id,3,'0')) AS code",FALSE);
		$this->db->join('mst_product', 'mst_product.id = mst_project.product_id','INNER');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_project')
                        ->count_all_results();
        return $result;
    }
	 
}

/* End of file project_model.php */
/* Location: ./application/models/project_model.php */