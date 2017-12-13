<?php
class Users_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'mst_users';
        $this->primary_key = 'mst_users.id';
		$this->order_by = 'mst_users.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
		
		$this->db->select('mst_users.id, mst_users.code, mst_users.firstname, mst_users.lastname, mst_users.email, mst_users.avatar');
	    $this->db->select('mst_roles.name AS role');
		$this->db->join('mst_roles', 'mst_roles.id = mst_users.roles_id');
		
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('mst_users')
                        ->count_all_results();
        return $result;
    }
	
	
	public function user_page($user_code) {
		
		$this->db->select('mst_users.code, mst_users.firstname, mst_users.lastname, mst_users.email, mst_users.avatar');
	    $this->db->select('mst_roles.name AS role');
		$this->db->join('mst_roles', 'mst_roles.id = mst_users.roles_id');
		
		$this->db->where('mst_users.code',$user_code);
		return $this->get();
    }
	
}

/* End of file users_model.php */
/* Location: ./application/models/users_model.php */