<?php
class Product_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_product';
        $this->primary_key = 'mst_product.id';
		$this->order_by = 'mst_product.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('mst_product.id, mst_product.ordering, mst_product.name AS name, mst_product.plans_id, mst_plans.name AS plan, mst_product.is_active');
		$this->db->join('mst_plans', 'mst_plans.id = mst_product.plans_id','INNER');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_product')
                        ->count_all_results();
        return $result;
    }
	 
}

/* End of file product_model.php */
/* Location: ./application/models/product_model.php */