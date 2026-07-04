<?php 

class Model_registration extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	 

	/* get the brand data */
	public function getBillingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration WHERE iClientId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration  order by iClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
	public function getBillingDatalastsno($month)
	{
	 
		  $sql = "SELECT * FROM client_registration where 1=1 AND `received_date` >= '2024-01-01' order by sno desc,iClientId desc limit 0,1";
		$query = $this->db->query($sql);  
		return $query->row_array();
	}
	
	public function getBillingbalanceData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration as c INNER JOIN reports as r ON c.uid_no = r.uid_no WHERE status = 'Complete' AND balance_dues > 0 AND iClientId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration as c INNER JOIN reports as r ON c.uid_no = r.uid_no WHERE status = 'Complete' AND balance_dues > 0 order by iClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
		public function getBillingbalancereportData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration WHERE report_copy != '' AND balance_dues > 0 AND iClientId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration WHERE report_copy != '' AND balance_dues > 0 order by iClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
	
	public function getBillingpaymentnotupdateData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration WHERE total_payment = ''  AND iClientId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration where total_payment = '' order by iClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
	public function getlabBillingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM client_registration WHERE assign_to = 'lab' AND iClientId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM client_registration  WHERE assign_to = 'lab' order by iClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
	
	
	public function daywisetotalamount($date)
	{
	
        $sql = "SELECT SUM(total_payment) as `total_payment` FROM client_registration where received_date = '".$date."'";
	     $query = $this->db->query($sql);
		return $query->result_array();
	}
	public function daywisetotalrecivedamount($date)
	{
	
        $sql = "SELECT SUM(advance_payment) as `total_recived_payment` FROM client_registration where received_date = '".$date."'";
	     $query = $this->db->query($sql);
		return $query->result_array();
	}
	public function daywisetotalbalanceamount($date)
	{
	
        $sql = "SELECT SUM(balance_dues) as `total_balance_payment` FROM client_registration where received_date = '".$date."'";
	     $query = $this->db->query($sql);
		return $query->result_array();
	}
	
	public function getBillingDatabyFilter($start_date,$end_date)
	{
	
     $sql = "SELECT * FROM client_registration where received_date >='".$start_date."' AND received_date <= '".$end_date."'";
	 $query = $this->db->query($sql);
		return $query->result_array();
	}
	public function fetchbillingDatabyupdateuid()
	{
        $startdate = date('Y-m-d 00:00:00');
        $enddate = date('Y-m-d 23:59:59');
	    
		$sql = "SELECT * FROM client_registration_update as c INNER JOIN users as u ON u.id = c.updated_by where c.created_date > '".$startdate."' AND c.created_date < '".$enddate."' order by iUClientId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}
	public function totalreg()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT * FROM client_registration";
		
		$query = $this->db->query($sql);
	 
		return $query->num_rows();
	}
	public function totalamount()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT SUM(total_payment) as `total_payment` FROM client_registration where 1=1";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	public function totalreports()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT * FROM reports";
		
		$query = $this->db->query($sql);
	 
		return $query->num_rows();
	}
	public function todaytotalreports()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT * FROM reports where create_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->num_rows();
	}
	public function todaytotalreg()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT * FROM client_registration where received_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->num_rows();
	}
	public function totalreciveamount()
	{ 
		$sql = "SELECT SUM(advance_payment) as `total_recivepayment` FROM client_registration";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
		public function totalcashamount()
	{ 
		$sql = "SELECT SUM(total_payment) as `total_cashpayment` FROM client_registration where `advance_payment` = 0 AND `balance_dues` = 0";
	    $query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	 
	 public function totalcashamountrecived()
	 {
	     	$sql = "SELECT SUM(advance_payment) as `total_cashpaymentrecived`  FROM client_registration where `mode_of_payment` IN('cash','upi','cheque')"; 
		    $query = $this->db->query($sql);
		    	return $query->result_array();
	 }
	 
		public function totaltodaycashamount()
	{ 
	      $startdate = date('Y-m-d'); 
		$sql = "SELECT SUM(total_payment) as `total_todaycashpayment` FROM client_registration where `advance_payment` = 0 AND `balance_dues` = 0  AND received_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	public function totalbalanceamount()
	{ 
		$sql = "SELECT SUM(balance_dues) as `total_balancepayment` FROM client_registration";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	 
	 
	public function todaytotalamount()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT SUM(total_payment) as `total_payment` FROM client_registration where received_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	public function todaytotalreciveamount()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT SUM(advance_payment) as `total_recivepayment` FROM client_registration where received_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	 public function todaytotalbalanceamount()
	{
        $startdate = date('Y-m-d'); 
	    
		$sql = "SELECT SUM(balance_dues) as `total_balancepayment` FROM client_registration where received_date = '".$startdate."'";
		
		$query = $this->db->query($sql);
	 
		return $query->result_array();
	}
	public function create_report($data)
	{
	    if($data) {
			$insert = $this->db->insert('all_reports', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
	public function createscan_copy($data)
	{
	    if($data) {
			$insert = $this->db->insert('scan_copy', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
	
	
	
	public function create($data)
	{
	    if($data) {
			$insert = $this->db->insert('client_registration', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
public function create_registrationcopy($data)
	{
	    if($data) {
			$insert = $this->db->insert('client_registration_update', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('iClientId', $id);
			$update = $this->db->update('client_registration', $data);
		//	print_r($this->db->last_query());
			//die;
			return ($update == true) ? true : false;
		}
	}

	public function remove($id)
	{
		if($id) {
			$this->db->where('iClientId', $id);
			$delete = $this->db->delete('client_registration');
			return ($delete == true) ? true : false;
		}
	}
	
	
    public function countTotalConsignor()
	{
		$sql = "SELECT * FROM client_registration";
		$query = $this->db->query($sql);
		return $query->num_rows();
	}






	public function getfinalallDueOrdersData()
	{
		 
		$date = date('Y-m-d', strtotime('-7 days'));
	     $sql = "SELECT * FROM client_registration WHERE `uid_no` NOT IN(SELECT DISTINCT `uid_no` FROM reports WHERE 1=1) AND report_no = '' AND report_copy = '' AND received_date < '".$date."' ORDER BY received_date DESC ";
		$query = $this->db->query($sql); 
		return $query->result_array();
	}








}