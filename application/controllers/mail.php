<?php
class Mail extends CI_Controller {
	
    private $TH_Month = array(1=>"มกราคม", 2=>"กุมภาพันธ์", 3=>"มีนาคม", 4=>"เมษายน", 5=>"พฤษภาคม", 6=>"มิถุนายน", 7=>"กรกฏาคม", 8=>"สิงหาคม", 9=>"กันยายน", 10=>"ตุลาคม", 11=>"พฤศจิกายน", 12=>"ธันวาคม");   

	function __construct() {
		parent::__construct();
		$this->load->model('dashboard_model');
        $this->load->model('approve_model');
        $this->load->model('budget_main_model');
		$this->load->helper('myfunction');
		$this->load->helper('general');
		$this->load->helper('menu');
        $this->load->library("mpdf");
		
		//Accesscontrol_helper::is_logged_in();
	}
	
	public function index()
	{
        $data["title"] = "รายงานประจำเดือนทางอีเมล์";
		$data["path"] = array("งานการเงิน","รายงาน","รายงานประจำเดือนทางอีเมล์");
		$data["submenu"] = Finance_menu(3);

        $data["th_month"] = $this->TH_Month;
		$this->template->load('template', 'report/report_mail_view', $data);
    
        
       // Debug point 
     //   $data = $this->dashboard_model->paymented_by_date('12', '2015-01');
     //   dump($data);
	 //   $this->output->enable_profiler(TRUE);
	}
    
    
    public function sendmail($example = 0)
	{  
       $before_month = date("m")-1;
       
       //display before year. case 'December' 
       if($before_month == 0){
           $month_name = $this->TH_Month[12];
           $current_year = date("Y") - 1;
       }
       else{  // normal
           $month_name = $this->TH_Month[$before_month];
           $current_year = date("Y");
       }
      
       $year = (date("m") < 11)? date("Y") - 1: date("Y");
       $data = $this->budget_main_model->budget_by_date($year);
       $budget_id = $data[0]["id"];
       $budget_title = $data[0]["title"];
       // dump($year);
        
           
       if($example == 1){
           if(!empty($budget_id)){
              $this->pdf($budget_id, $budget_title, $current_year, $month_name, 1);
           }
       }
       else{
           // send mail manual
           if(isset($_REQUEST['email']) && !empty($_REQUEST['email'])){
              $mailto = $_REQUEST['email'];
           }
           else{ // send mail auto
              $mailto = 'niti.c@psu.ac.th';
              //$mailto = array('niti.c@psu.ac.th', 'sanan.s@psu.ac.th', 'jutarat.s@psu.ac.th');
           }
           
           if(!empty($budget_id)){
                  $newFile = $this->pdf($budget_id, $budget_title, $current_year, $month_name, 0);
           }
        
               $subject = "รายงานการเงินประจำเดือน ".$month_name." ".(date("Y")+543)." จากระบบ TTM-FMIS (".date("d-m-Y H:i",time()).")";
               
               $message =  "เรียน ท่านผู้บริหาร \r\n \r\n";
               $message .= "ระบบบริหารจัดการเงินรายได้เงินขอส่งรายงาน \r\n";
               $message .= "สรุปการเบิกจ่ายประจำเดือน ".$month_name." ".(date("Y")+543)." ตามเอกสารแนบ \r\n";
               $message .= "ทั้งนี้ท่านสามารถเข้าไปดูรายละเอียดการเบิกจ่ายได้ที่ http://192.168.80.5/finance \r\n \r\n";
               $message .= "จึงเรียนมาเพื่อโปรดทราบ";
           
               $result = $this->psumail($mailto, $subject, $message, $newFile);
               if($result == 1){
	   	          echo json_encode(array('success'=>true));
	           }
	           else {
		           echo json_encode(array('msg'=>$result));
	           }
           
      }
     
	}
    
   public function psumail($to, $subject, $message, $attach = "")
   {
        $config = array(
              'protocol' => 'smtp',
              'smtp_host' => 'smtp.psu.ac.th',
              'smtp_port' => 25,
              'smtp_user' => 'niti.c',
              'smtp_pass' => 't-arakengi454244012',
              'mailtype'  => 'html', 
              'crlf'  => '\r\n',
              'newline'  => '\r\n',
              'charset'   => 'utf-8'
        );
              
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
      
        $this->email->from('niti.c@psu.ac.th', 'TTM-FMIS');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        
        if(!empty($attach)){
         $this->email->attach($attach);
        }
        
        if($this->email->send()) {
          return 1;
        } 
        else {
          return $this->email->print_debugger();
        }
   } 
    
   // gmail don't use
   public function gmail($to, $subject, $message, $attach)
   {
       // google
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'ttmed.psu@gmail.com',
            'smtp_pass' => 'ttmed123',
            'mailtype'  => 'html', 
            'charset'   => 'utf-8'
        );
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
      
        $this->email->from('ttmed.psu@gmail.com', 'TTMED-PSU');
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->attach($attach);
        
        if($this->email->send()) {
        echo 'Your email was sent.';
        } 
        else {
        show_error($this->email->print_debugger());
        }
   } 
	
    public function pdf($budget_id, $budget_title, $current_year, $month_name, $preview = 0)
	{
       $data = $this->dashboard_model->total_chart($budget_id);
       $budget = $data[0]["budget"];
       $useable = $data[0]["payment"];
	   $balance = $budget-$useable;
        
       // Case: approve only status = 1
       $data = $this->approve_model->approve_only_by_budget($budget_id);
       if(count($data) > 0){
         $approve_only = $data[0]["amount"];
       }
       else{
         $approve_only = 0.00;
       }
       
       // Case: approve only status = 2
       $data = $this->dashboard_model->approveonly_status2($budget_id, '');
        foreach($data as $items){
             foreach($items as $result){
                $approve_only += $result;
             }
        }
       
        $real_balance =  $balance - $approve_only;
      
        $html = '<h2>รายงานการเบิกจ่ายงบประมาณ ประจำเดือน'.$month_name.' '.($current_year+543).'</h2>';
        $html .= "<h5>แหล่งเงิน: ".$budget_title." (จำนวนเงิน ".number_format($budget, 2)." บาท)</h5>";
        
        $year_month = date("Y-m", strtotime("first day of previous month"));
        $html .= $this->month_summary($budget_id, $year_month, $month_name);
        
        $html .= "<p></p>";
        $html .= "<p><h4><u>สรุปยอดเงินคงเหลือ (ทั้งปีงบประมาณ)</u></h4>";
        $html .= "<table border='1'><tr><th>รวมเงินเบิกจ่ายทั้งหมด</th><th>คงเหลือ</th><th>รวมเงินอนุมัติยังไม่เบิกจ่ายทั้งหมด</th><th style='background-color:#999'>คงเหลือสุทธิ</th></tr>";
        $html .= '<tr><td class="relation">'.number_format($useable,2)."</td><td>".number_format($balance,2).'</td><td>'.number_format($approve_only,2).'</td><td style="background-color:#ddd">'.number_format($real_balance,2)."</td></tr>";
        $html .= "</table></p>";
    
        $html .= $this->plan_summary($budget_id);
        $html .= $this->costs_summary($budget_id);
        $html .= $this->costslists_summary($budget_id);
        
        $this->mpdf = new mPDF('utf-8', 'A4');
        $stylesheet = file_get_contents(base_url('assets/css/report_month.css'));
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

        $this->mpdf->defaultheaderfontsize = 8;	// in pts
        $this->mpdf->defaultheaderfontstyle = '';	// blank, B, I, or BI 
        $this->mpdf->defaultheaderline = 1; 	// 1 to include line below header/above footer

        $this->mpdf->defaultfooterfontsize = 8;	// in pts
        $this->mpdf->defaultfooterfontstyle = '';	// blank, B, I, or BI 
        $this->mpdf->defaultfooterline = 1; 	// 1 to include line below header/above footer


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}');	// defines footer for Odd and Even Pages - placed at Outer margin 
        
        $this->mpdf->WriteHTML($stylesheet,1);
        $this->mpdf->WriteHTML($html);
        
        if($preview == 1){
           $this->mpdf->Output();
        }
        else{
          $newFile  = $_SERVER['DOCUMENT_ROOT']. "finance/assets/uploads/files/".$year_month.".pdf";
          $this->mpdf->Output($newFile, 'F');
        
          return $newFile;
        
        } 
	}
    
    public function month_summary($budget_id, $year_month, $month_name)
    {
        $data = $this->dashboard_model->paymented_by_date($budget_id, $year_month);
        $payment = $data[0]["amount"];
    
        $data = $this->dashboard_model->approveonly_status1($budget_id, $year_month);
        $approve_only = $data[0]["amount"];
        
        $data = $this->dashboard_model->approveonly_status2($budget_id, $year_month);
        foreach($data as $items){
             foreach($items as $result){
                $approve_only += $result;
             }
        }

        //Display Date
        list($year,$month) = preg_split('/[: -]/', $year_month);
        $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $start_date = "01/".$month."/".($year+543);
        $end_date = $day."/".$month."/".($year+543);
        
        
        $month_name = $month_name ." ".($year+543);
        
        $html .= "<p><h4><u>สรุปยอดเงินเบิกจ่ายประจำเดือน</u></h4>";
        $html .= "<table border='1'><tr><th>รอบวันที่</th><th>จำนวนเงินที่เบิกจ่าย</th><th>เงินอนุมัติยังไม่เบิกจ่าย</th><th>รวมเป็นเงิน</th></tr>";
        $html .= "<tr><td>".$month_name." <br/>(".$start_date." - ".$end_date.")</td><td>".number_format($payment,2)."</td><td>".number_format($approve_only,2)."</td><td>".number_format(($payment+$approve_only),2)."</td></tr>";
        $html .= "</table></p>";
        
        return $html;
        
    }
    
    public function get(){
         $data = $this->dashboard_model->payment_costs_summary('12','2015-01');
        // dump($data);
	    // $this->output->enable_profiler(TRUE);
    
    }
    
    public function plan_summary($budget_id)
    {
        $data = $this->dashboard_model->total_chart($budget_id);
        $payment = $data[0]["payment"];
    
        $data = $this->dashboard_model->payment_plans_summary($budget_id);
        
        $html = "<p><h4><u>รายละเอียดการเบิกจ่าย จำแนกตามแผนงาน (ทั้งปีงบประมาณ)</u></h4>";
        $html .= "<table border='1'><tr><th>ชื่อแผนงาน</th><th>จำนวนเงินที่จัดสรร</th><th>จำนวนเงินเบิกจ่าย</th><th>คงเหลือ</th></tr>";
        
        $total_amount = 0.0;
        $total_payment = 0.0;
        $total_all = 0.0;
        foreach ($data as $key => $value){
        
               $total_amount += $value["amount"];
               $total_payment += $value["payment"];
               
               $calculator = $value["amount"]-$value["payment"];
               $total_all += $calculator;
               
               $html .= '<tr><td class="name" >'.$value["name"].'</td><td class="money">'.number_format($value["amount"],2).'</td><td class="money">'.number_format($value["payment"],2).'</td><td class="money">'.number_format($calculator,2)."</td></tr>";
        }
        $html .= '<tr><td>รวมเงินทั้งหมด</td><td class="money">'.number_format($total_amount,2).'</td><td class="money relation">'.number_format($total_payment,2).'</td><td class="money">'.number_format($total_all,2).'</td>';
        $html .= "</table></p>";
        
        return $html;
    }
    
    public function costs_summary($budget_id)
    {
        $data = $this->dashboard_model->total_chart($budget_id);
        $payment = $data[0]["payment"];
    
        $data = $this->dashboard_model->payment_costs_chart($budget_id);
        
        $html .= "<p><h4><u>รายละเอียดการเบิกจ่าย จำแนกตามงบรายจ่าย (ทั้งปีงบประมาณ)</u></h4>";
        $html .= "<table border='1'><tr><th>ชื่องบรายจ่าย</th><th>จำนวนเงิน</th><th>คิดเป็นเปอร์เซ็นต์(%)</th></tr>";
        
        $total_amount = 0.0;
        $total_present = 0.0;
        foreach ($data as $key => $value){
               $total_amount += $value["amount"];
               $present = ($value["amount"]*100)/$payment;
               $total_present += $present;
               
               $html .= '<tr><td class="name" >'.$value["name"]."</td><td>".number_format($value["amount"],2)."</td><td>".number_format($present,2)." %</td></tr>";
        }
        $html .= '<tr><td>รวมทั้งหมด</td><td class="relation">'.number_format($total_amount,2).'</td><td>'.number_format($total_present,2).' %</td>';
        $html .= "</table></p>";
        
        return $html;
    }
    
    public function costslists_summary($budget_id)
    {
        $data = $this->dashboard_model->total_chart($budget_id);
        $payment = $data[0]["payment"];
    
        $data = $this->dashboard_model->payment_coststype_chart($budget_id);
        
        $html .= "<p><h4><u>รายละเอียดการเบิกจ่าย จำแนกตามประเภทค่าใช้จ่าย (ทั้งปีงบประมาณ)</u></h4>";
        $html .= "<table border='1'><tr><th>ชื่อค่าใช้จ่าย</th><th>จำนวนเงิน</th><th>คิดเป็นเปอร์เซ็นต์(%)</th></tr>";
        
        $total_amount = 0.0;
        $total_present = 0.0;
        foreach ($data as $key => $value){
               $total_amount += $value["amount"];
               $present = ($value["amount"]*100)/$payment;
               $total_present += $present;
               
               $html .= '<tr><td class="name" >'.$value["name"]."</td><td>".number_format($value["amount"],2)."</td><td>".number_format($present,2)." %</td></tr>";
        }
        $html .= '<tr><td>รวมทั้งหมด</td><td class="relation">'.number_format($total_amount,2).'</td><td>'.number_format($total_present,2).' %</td>';
        $html .= "</table></p>";
        
        return $html;
    }
    
   
    
    
}