<?php
class Payment_model extends MY_Model{
     	
     function __construct (){
        parent::__construct();
        $this->table_name = 'trn_payment';
        $this->primary_key = 'trn_payment.id';
		$this->order_by = 'trn_payment.id ASC';
    }
	 
	public $limit;
    public $offset; 
	public $sort;
	public $order;
	
	public function list_page() {
			
		$this->db->select('trn_payment.id, trn_payment.payer_code, trn_payment.amount, mst_payer.name');
		$this->db->join('mst_payer', 'mst_payer.payer_code = trn_payment.payer_code');
		$this->db->order_by($this->sort,$this->order);
		$this->db->limit($this->limit, $this->offset);
		return $this->get();
    }
 
    public function num_page() {
        $result = $this->db->from('trn_payment')
                        ->count_all_results();
        return $result;
    }
	
	public function payment_by($disbursement_ID) {
			
		$this->db->select('trn_payment.id, trn_payment.payer_code AS code, trn_payment.amount, mst_payer.name');
		$this->db->join('mst_payer', 'mst_payer.payer_code = trn_payment.payer_code');
		$this->db->where('trn_payment.disbursement_id =', $disbursement_ID);
		return $this->get();
    }
}

/* End of file payment_model.php */
/* Location: ./application/models/payment_model.php */