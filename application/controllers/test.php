<?php

class Test extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		$this->load->helper('myfunction');
        $this->load->model('mgt_plans_model');
        $this->load->model('mgt_product_model');
        $this->load->model('mgt_costs_model');
        $this->load->model('disbursement_model');
        $this->load->model('approve_model');
		$this->load->helper('general');
		$this->load->helper('menu');
        $this->load->library('email');
        $this->load->library("mpdf");
       
	}
	
	public function index()
	{
		$data["title"] = "test";
		$data["path"] = array("งานแผน","รายงาน","สรุปข้อมูลการจัดสรรงบประมาณ");
		$data["submenu"] = Plans_menu(3);
        
        $this->template->load('template', 'report/report', $data);

		 //print_r(apache_get_modules());
	}
    
    public function gen(){
      $newFile  = $_SERVER['DOCUMENT_ROOT']. "/finance/assets/uploads/files/";
   
      $this->mpdf = new mPDF('utf-8', 'A4');
      $this->mpdf->SetAutoFont();
      $this->mpdf->WriteHTML('<p>Hello There</p>');
      
      
     // $this->mpdf->Output($newFile."demo2.pdf", 'F'); //Close and output PDF document
    }
    
    
     public function get()
     {
       $mailto = 'niti.c@psu.ac.th'; //Mailto here
       $subject = "FMIS-".date("d-m-Y_H-i",time()); //Your Filename whit local date and time
       
       $newFile  = $_SERVER['DOCUMENT_ROOT']. "/finance/assets/uploads/files/demo2.pdf";
       
       $message = '
        <html>
        <head>
          <title>Birthday Reminders for August</title>
        </head>
        <body>
          <p>Here are the birthdays upcoming in August!</p>
          <table>
            <tr>
              <th>Person</th><th>Day</th><th>Month</th><th>Year</th>
            </tr>
            <tr>
              <td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
            </tr>
            <tr>
              <td>Sally</td><td>17th</td><td>August</td><td>1973</td>
            </tr>
          </table>
        </body>
        </html>
        ';
        
       $this->gmail($mailto, $subject, $message, $newFile);
      
        exit;
    
       // dump($data);
	   // $this->output->enable_profiler(TRUE);
     }
    
   public function my(){
        $subject="Test mail for local";
        $to="niti.c@psu.ac.th";
        $body="This is a test mail";
        if (mail($to,$subject,$body))
        echo "Mail sent successfully!";
        else
        echo"Mail not sent!";
   }  
     
     
   public function mail()
   {
          $config = array(
              'protocol' => 'smtp',
              'smtp_host' => 'smtp.psu.ac.th',
              'smtp_port' => 25,
              'smtp_user' => 'niti.c',
              'smtp_pass' => 't-arakengi454244012',
              'charset' => 'utf-8',
              'mailtype' => 'text'
              );
          $this->load->library('email',$config);
          $this->email->set_newline("\r\n");
     
          $this->email->from('niti.c@psu.ac.th', 'Niti Chotkaew');
          $this->email->to('niti.c@psu.ac.th');
        
          $message =  "เรียน ท่านผู้บริหาร \r\n \r\n";
          $message .= "ระบบบริหารจัดการเงินรายได้เงินขอส่งรายงานสรุปการเบิกจ่ายรอบวันที่ ".date("d-M-Y")." ตามเอกสารแนบ \r\n ";
          $message .= "และท่านสามารถเข้าไปดูรายละเอียดการเบิกจ่ายได้ที่ http://192.168.80.7/finance \r\n \r\n";
          $message .= "จึงเรียนมาเพื่อโปรดทราบ";
          
          $this->email->subject('รายงานการ');
          $this->email->message($message);
     
          if($this->email->send()) {
            echo 'Your email was sent.';
          } 
          else {
           show_error($this->email->print_debugger());
          }
   } 
   
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
   
   public function chart()
   {
        include $_SERVER['DOCUMENT_ROOT']."/finance/application/libraries/libchart/classes/libchart.php";
        $newFile  = $_SERVER['DOCUMENT_ROOT']. "/finance/assets/uploads/files/";
        
        $chart = new HorizontalBarChart(500, 170);

	    $dataSet = new XYDataSet();
	    $dataSet->addPoint(new Point("/wiki/Instant_messenger", 50));
	    $dataSet->addPoint(new Point("/wiki/Web_Browser", 83));
	    $dataSet->addPoint(new Point("/wiki/World_Wide_Web", 142));
	    $chart->setDataSet($dataSet);

	    $chart->setTitle("Most visited pages for www.example.com");
	    $chart->render($newFile."demo2.png");
       
        $path = base_url()."assets/uploads/files";
        
        echo "<img alt='Pie chart'  src='".$path."/demo2.png' style='border: 1px solid gray;'/>";
      // $this->load->view('chart_view');
    
   }
    
    public function pdf_temp()
    {
        $html = "<table border='1'><tr><th>ลำดับ</th><th>รายการ</th></tr>";
        $html .= "<tr><td>ลำดับ</td><td>รายการ</td></tr>";
        $html .= "</table>";
        
        $this->mpdf = new mPDF('utf-8', 'A4');
        $this->mpdf->SetAutoFont();

        $this->mpdf->mirrorMargins = 1;	// Use different Odd/Even headers and footers and mirror margins

        $this->mpdf->defaultheaderfontsize = 10;	/* in pts */
        $this->mpdf->defaultheaderfontstyle = B;	/* blank, B, I, or BI */
        $this->mpdf->defaultheaderline = 1; 	/* 1 to include line below header/above footer */

        $this->mpdf->defaultfooterfontsize = 12;	/* in pts */
        $this->mpdf->defaultfooterfontstyle = B;	/* blank, B, I, or BI */
        $this->mpdf->defaultfooterline = 1; 	/* 1 to include line below header/above footer */


        $this->mpdf->SetHeader('{DATE j-m-Y}|{PAGENO}/{nb}| FMIS Report');
        $this->mpdf->SetFooter('{PAGENO}');	/* defines footer for Odd and Even Pages - placed at Outer margin */
        
       
        $this->mpdf->WriteHTML($html);
        $this->mpdf->Output();
       
        echo $html;
    }
    
}
