<?php
class Company_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_company';
        $this->primary_key = 'mst_company.id';
		$this->order_by = 'mst_company.id ASC';
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
        $result = $this->db->from('mst_company')
                        ->count_all_results();
        return $result;
    }
}

/* End of file company_model.php */
/* Location: ./application/models/company_model.php */