<?php 

class Dashboard extends Admin_Controller 
{
	public function __construct()
	{
		parent::__construct();

		$this->not_logged_in();

		$this->data['page_title'] = 'Dashboard';
	 
		$this->load->model('model_users');
		$this->load->model('model_stores');
	 	$this->load->model('model_registration');
	 	$this->load->model('model_labreports');
	 	$this->load->model('model_dailyexpenses');
	}

	/* 
	* It only redirects to the manage category page
	* It passes the total product, total paid orders, total users, and total stores information
	into the frontend.
	*/
	public function index()
	{ 
	    
	     
	    
	    $this->data['updatedata'] = $this->model_registration->fetchbillingDatabyupdateuid();
		
	    $this->data['totalreg'] = $this->model_registration->totalreg();
	    $this->data['totalreports'] = $this->model_registration->totalreports();
	     $this->data['totalpendingreport'] = $this->model_labreports->totalpendingreport();
	    
        $total = $this->model_registration->totalamount();
	    $this->data['totalamount'] = $total[0]['total_payment'];
	    
	    $totalcashamountrecived1 = $this->model_registration->totalcashamountrecived(); 
	    
	    
	     $totalcashamount1 = $this->model_registration->totalcashamount();
	    $this->data['totalcashamount'] = $totalcashamount1[0]['total_cashpayment']+$totalcashamountrecived1[0]['total_cashpaymentrecived'];
	    
	     
	    $totalrecive = $this->model_registration->totalreciveamount();
	    $this->data['totalreciveamount'] = $totalrecive[0]['total_recivepayment']+$totalcashamount1[0]['total_cashpayment']+$totalcashamountrecived1[0]['total_cashpaymentrecived'];
	    
	    
	    
	   
	    
	    $totaltodaycashamount1 = $this->model_registration->totaltodaycashamount();
	    $this->data['totaltodaycashamount'] = $totaltodaycashamount1[0]['total_todaycashpayment'];
	    
	    
	    $totalbalance = $this->model_registration->totalbalanceamount();
	    $this->data['totalbalanceamount'] = $totalbalance[0]['total_balancepayment'];
	    
	    
	    
	    $this->data['todaytotalreg'] = $this->model_registration->todaytotalreg();
	    $this->data['todaytotalreports'] = $this->model_labreports->todaytotalreports();
        $todaytotal = $this->model_registration->todaytotalamount();
	    $this->data['todaytotalamount'] = $todaytotal[0]['total_payment'];
	     $todaytotalrecive = $this->model_registration->todaytotalreciveamount();
	    $this->data['todaytotalreciveamount'] = $todaytotalrecive[0]['total_recivepayment']+$totaltodaycashamount1[0]['total_todaycashpayment'];
	   
	    $todaytotalbalance = $this->model_registration->todaytotalbalanceamount();
	    $this->data['todaytotalbalanceamount'] = $todaytotalbalance[0]['total_balancepayment'];
	    
	  
	    $newdaterecived = 0;
$newdatebalance = 0;
$daysInMonth = date('t');
for($i=1;$i<=$daysInMonth;$i++)
{
   $day = $i;
   $month = date('m');
   $year = date('Y');
   $newdate = $year.'-'.$month.'-'.str_pad($day, 2, '0', STR_PAD_LEFT);
   $newdata = $this->model_registration->daywisetotalamount($newdate);
   $newdatarecived = $this->model_registration->daywisetotalrecivedamount($newdate);
   $newdatabalance = $this->model_registration->daywisetotalbalanceamount($newdate);
  
   if(!empty($newdata[0]['total_payment']))
   {
    $this->data['newdate'.$i] = $newdata[0]['total_payment'];
   }
   else
   {
     $this->data['newdate'.$i] = 0;  
   }
    
   if(!empty($newdatarecived[0]['total_recived_payment']))
   {
   $this->data['newdaterecived'.$i] = $newdatarecived[0]['total_recived_payment'];
   }
   else
   {
     $this->data['newdaterecived'.$i] = 0;  
   }
   
   if(!empty($newdatabalance[0]['total_balance_payment']))
   {
        $this->data['newdatebalance'.$i] = $newdatabalance[0]['total_balance_payment'];
   }
   else
   {
        $this->data['newdatebalance'.$i] = 0;  
   }   
}
	 
	 
        $first_day_this_month = date('Y-m-01');
        $last_day_this_month  = date('Y-m-t'); 
         
                        
        $SiteExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Site Exp');
        $CorierandSpeedPost = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Corier and Speed Post');
        $ConvenceandTransportation = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Convence and Transportation');
        $SurveyExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Survey Exp');
        $DDandtendorExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'DD and tendor Exp');
        $OmendraGuptaCurrentac = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Omendra Gupta Current ac');
        $OfficeMaintenance = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Office Maintenance');
        $Refreshment = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Refreshment');
        $stationary = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'stationary');
        $MachineandCarRepairing = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Machine and Car Repairing');
        $LabTestingExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Lab Testing Exp');
        $AuditExpenses = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Audit Expenses');
        $TelephoneWaterElectricityExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Telephone/Water/Electricity Exp');
        $PrintorandComputerRepairingexp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Printor and Computer Repairing exp');
        $PrintingExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Printing Exp'); 
        $Cashadvance = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Cash advance');
        $Salary = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Salary');
        $OtherExp = $this->model_dailyexpenses->getAllCategoryCount($first_day_this_month,$last_day_this_month,'Other Exp');

        $this->data['SiteExp'] = $SiteExp[0]['total_payment'];
        $this->data['CorierandSpeedPost'] = $CorierandSpeedPost[0]['total_payment'];
        $this->data['ConvenceandTransportation'] = $ConvenceandTransportation[0]['total_payment'];
        $this->data['SurveyExp'] = $SurveyExp[0]['total_payment'];
        $this->data['DDandtendorExp'] = $DDandtendorExp[0]['total_payment'];
        $this->data['OmendraGuptaCurrentac'] = $OmendraGuptaCurrentac[0]['total_payment'];
        $this->data['OfficeMaintenance'] = $OfficeMaintenance[0]['total_payment'];
        $this->data['Refreshment'] = $Refreshment[0]['total_payment'];
        $this->data['stationary'] = $stationary[0]['total_payment'];
        $this->data['MachineandCarRepairing'] = $MachineandCarRepairing[0]['total_payment'];
        $this->data['LabTestingExp'] = $LabTestingExp[0]['total_payment'];
        $this->data['AuditExpenses'] = $AuditExpenses[0]['total_payment'];
        $this->data['TelephoneWaterElectricityExp'] = $TelephoneWaterElectricityExp[0]['total_payment'];
        $this->data['PrintorandComputerRepairingexp'] = $PrintorandComputerRepairingexp[0]['total_payment'];
        $this->data['PrintingExp'] = $PrintingExp[0]['total_payment'];
        $this->data['Cashadvance'] = $Cashadvance[0]['total_payment'];
        $this->data['Salary'] = $Salary[0]['total_payment'];
        $this->data['OtherExp'] = $OtherExp[0]['total_payment'];
	    
		$user_id = $this->session->userdata('id');
		$is_admin = ($user_id == 1) ? true :false;

		$this->data['is_admin'] = $is_admin;
	 
		
		$this->render_template('dashboard', $this->data);
	}
	
	 
	
}