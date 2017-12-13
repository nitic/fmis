<?php
class Budget_Main_model extends MY_Model{
  
	function __construct (){
        parent::__construct();
        $this->table_name = 'trn_budget_main';
        $this->primary_key = 'trn_budget_main.id';
		$this->order_by = 'trn_budget_main.id ASC';
    }
	
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		$this->db->select('trn_budget_main.id, trn_budget_main.budget_id, mst_budget.title, (trn_budget_main.year + 543) as year, trn_budget_main.amount, trn_budget_main.status_id');
		//$this->db->select("CONCAT(LPAD(mst_budget.id,2,'0'),' : ',mst_budget.title) AS title",FALSE);

		$this->db->select("CONCAT(mst_budget_status.id,' : ',mst_budget_status.name) AS status",FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_budget_main.start_date, '%d'),'/',DATE_FORMAT(trn_budget_main.start_date, '%m'),'/',DATE_FORMAT(trn_budget_main.start_date, '%Y' ) +543) AS start_date", FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_budget_main.end_date, '%d'),'/',DATE_FORMAT(trn_budget_main.end_date, '%m'),'/',DATE_FORMAT(trn_budget_main.end_date, '%Y' ) +543) AS end_date", FALSE);
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id','INNER');
		$this->db->join('mst_budget_status', 'mst_budget_status.id = trn_budget_main.status_id','INNER');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('trn_budget_main')
                        ->count_all_results();
        return $result;
    }

   function status_page()
	{
		$this->db->select('trn_budget_main.id,trn_budget_main.amount,trn_budget_main.status_id, mst_budget_status.name AS status, sum(trn_approve.amount) AS approve');
		$this->db->select('IF(sum(trn_approve.amount) IS NULL or sum(trn_approve.amount) = "",0,(trn_budget_main.amount - sum(trn_approve.amount))) AS balance',FALSE);
		
		$this->db->select("CONCAT(mst_budget.title,' ปี ',(trn_budget_main.year + 543)) AS title",FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_budget_main.start_date, '%d'),'/',DATE_FORMAT(trn_budget_main.start_date, '%m'),'/',DATE_FORMAT(trn_budget_main.start_date, '%Y' ) +543) AS start_date", FALSE);
		$this->db->select("CONCAT(DATE_FORMAT(trn_budget_main.end_date, '%d'),'/',DATE_FORMAT(trn_budget_main.end_date, '%m'),'/',DATE_FORMAT(trn_budget_main.end_date, '%Y' ) +543) AS end_date", FALSE);
		
		$this->db->join('trn_approve', 'trn_approve.budget_main_id = trn_budget_main.id','LEFT OUTER');
		
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		$this->db->join('mst_budget_status', 'mst_budget_status.id = trn_budget_main.status_id','INNER');
		
		$this->db->group_by("trn_budget_main.id");
		$this->db->order_by('trn_budget_main.year','desc');
		return $this->get();
	}
	
	function lists_source($where = "")
	{
		$this->db->select('trn_budget_main.id,(trn_budget_main.year + 543) as year,trn_budget_main.amount');
		$this->db->select("CONCAT(mst_budget.title,' ปี: ',(trn_budget_main.year + 543)) AS title",FALSE);
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
		
		if(!empty($where))
		    $this->db->where('trn_budget_main.status_id',$where);
		
   		$this->db->order_by('trn_budget_main.year','DESC');
		return $this->get();
	}
	
	
	function budgetyear_name($budget_id)
	{
		$this->db->select('trn_budget_main.id,trn_budget_main.year as year,trn_budget_main.amount');
		$this->db->select("CONCAT(mst_budget.title,' ปี ',(trn_budget_main.year + 543)) AS title",FALSE);
		$this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
        $this->db->where('trn_budget_main.id',$budget_id);
		return $this->get();
	}
    
    // mail.php
    function budget_by_date($current_year)
	{
		$this->db->select('trn_budget_main.id,trn_budget_main.year as year,trn_budget_main.amount');
        $this->db->select("CONCAT(mst_budget.title,' ปี ',(trn_budget_main.year + 543)) AS title",FALSE);
        $this->db->join('mst_budget', 'mst_budget.id = trn_budget_main.budget_id');
        $this->db->like('trn_budget_main.start_date', $current_year, 'after');
		return $this->get();
	}
	
	
}  


/* End of file budget_main_model.php */
/* Location: ./application/models/budget_main_model.php */
