<?php 

class Model_dailyexpenses extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}

	/*get the active brands information*/
	 

	/* get the brand data */
	public function getDailyBillingData($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM daily_expenses WHERE id = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		}

		$sql = "SELECT * FROM daily_expenses  order by iExpensesId desc";
		$query = $this->db->query($sql);  
		return $query->result_array();
	}

    public function getDailyBillingDatabyiExpensesId($id = null)
	{
		if($id) {
			$sql = "SELECT * FROM daily_expenses WHERE iExpensesId = ?";
			$query = $this->db->query($sql, array($id));
			return $query->row_array();
		} 
	}
	
    public function getDailyBillingLastEntry()
	{
	
			 $sql = "SELECT * FROM daily_expenses WHERE 1=1 order by iExpensesId desc limit 0,1";
			$query = $this->db->query($sql);
		   //print_r($this->db->last_query());
			return $query->row_array();
		
	}
	
    public function getDailyBillingLastDatabyDate($date)
	{
		if($date) {
			 $sql = "SELECT * FROM daily_expenses WHERE date = ? order by iExpensesId desc";
			$query = $this->db->query($sql, array($date)); 
			return $query->row_array();
		} 
	}
 
 public function getDailyBillingLastDatabyallDate($date)
	{
		if($date) {
			  $sql = "SELECT * FROM daily_expenses WHERE date > ? order by iExpensesId desc";
			$query = $this->db->query($sql, array($date));
			 //print_r($this->db->last_query());
			return $query->result_array();
		} 
	}
	
 
    public function getBillingDatabyFilter($start_date,$end_date,$expenses_category_fil)
	{
	    $start_date1 = date('Y-m-d',strtotime($start_date));
	    $end_date1 = date('Y-m-d',strtotime($end_date));
	     
	 
	     if($expenses_category_fil == 'all')
	     {
	         $expenses_category = '';
	     }
	     else
	     {
	         $expenses_category = "AND expenses_category = '".$expenses_category_fil."'";
	     }
	     
          $sql = "SELECT * FROM daily_expenses where date >='".$start_date1."' AND date <= '".$end_date1."' $expenses_category order by id desc";
        
        $query = $this->db->query($sql);
    	return $query->result_array();
	}
	
  

	public function create($data)
	{
	    if($data) {
			$insert = $this->db->insert('daily_expenses', $data);
			//print_r($this->db->last_query());
			return ($insert == true) ? true : false;
		}
	}
	 
	public function update($data, $id)
	{
		if($data && $id) {
			$this->db->where('id', $id);
			$update = $this->db->update('daily_expenses', $data);
			return ($update == true) ? true : false;
		}
	}
	
	public function updatebyiExpensesId($data, $id)
	{
		if($data && $id) {
			$this->db->where('iExpensesId', $id);
			$update = $this->db->update('daily_expenses', $data);
			return ($update == true) ? true : false;
		}
	}
	 
	public function remove($id)
	{
		if($id) {
			$this->db->where('id', $id);
			$delete = $this->db->delete('daily_expenses');
			return ($delete == true) ? true : false;
		}
	}
	 
	 public function getAllCategoryCount($first_day_this_month,$last_day_this_month,$category)
	{
	
        $sql = "SELECT SUM(total_expenses) as `total_payment` FROM daily_expenses where expenses_category='".$category."' AND date BETWEEN '".$first_day_this_month."' AND '".$last_day_this_month."'";
	     $query = $this->db->query($sql);
		return $query->result_array();
	}
	
 

}