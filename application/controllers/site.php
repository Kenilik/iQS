<?php 

class Site extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->__site_is_set_up();
	}

	function __site_is_set_up()	{
		$site_is_set_up = $this->input->cookie('current_siteid');
		
		if($site_is_set_up==FALSE)
		{
			$this->load->view('includes/header');
			$this->load->view('includes/loginbar');
			$this->load->view('includes/footer');
		}
			
	}

	function equipinuse(){
		$data['EquipInUse'] = $this->equipreg_model->getEquipIDInUse();

		$data['main_content'] = 'equipinuse' ;
		$data['header_title'] = "Equipment In Use" ;
		$this->load->view('includes/template', $data);				
	}


	function home() {
		//assign bc = the value of the posted user input
		//this value will be false if the form is being 
		//displayed for the first time and not submitted by the user	
		$bc = $this->input->post('Barcode');
		
		
		$ScannerStatus = $this->input->post('ScannerStatus');		
		if ($ScannerStatus===FALSE) {
			$data['ScannerStatus']=iQS_ScannerStatus_Default;
		} else {
			$data['ScannerStatus']=iQS_ScannerStatus_EquipmentScan;
		}
		
		$UserFeedback = $this->input->post('UserFeedback');
		if ($UserFeedback===FALSE) {
			$data['UserFeedback']="Ready to scan barcode.";
		} else {
			$data['UserFeedback']= $UserFeedback;
		}
		
		
		$WaitingQID = $this->input->post('WaitingQID');
		if ($WaitingQID===FALSE) {
			$data['WaitingQID']=FALSE;
		} else {
			$data['WaitingQID']= $WaitingQID;
		}

		
		$dt = date(iQS_MySQLDateFormat);
		
		
		//check if a barcode has been scanned in (if not the page is loading for the first time without a submit) 	
		if ($bc === FALSE) {
			$data['Barcode'] = FALSE;
		} else {
			//lookup in the db for that barcode
			/*
			 * NOTE I HAVE NOT HANDLED SITE/CLIENT ISSUES YET
			 */
			
			//returns db query results or error message
			$data['Barcode'] = $this->equipreg_model->lookupBarcodeByBCNo($bc); 

			// if is no bc in the system $data['Barcode'] will be a string error message 
			if ($data['Barcode']==FALSE){
				$data['UserFeedback'] = "There is no entry in the system for barcode number " . $bc . ". Please see your system administrator.";
				$data['ScannerStatus'] = iQS_ScannerStatus_Default;
				
			} else {
				//krumo($data);
				
				//this is where I need to do what happens if there is a succesful barcode read that returns data from the database
				$bc_row=$data['Barcode']->row();
				
				
				switch(true){
					case $bc_row->BarcodeType=="Member":
						// if the member status is active
						if ($bc_row->StatusID==0) {
							// get their list of equip in use 
							$data['EquipInUse'] = $this->equipreg_model->getMemberEquipInUse($bc_row->ID); 
							$data['UserFeedback'] = "Scan your equipment...";
							$data['WaitingQID'] = $bc_row->ID;							
							$data['ScannerStatus'] = iQS_ScannerStatus_EquipmentScan;
						} else {
							$data['UserFeedback'] = $bc_row->ID . " is not an active staff member.";
							$data['ScannerStatus'] = iQS_ScannerStatus_Default;
						}
						break;
						
					case $bc_row->BarcodeType=="Equipment":
						$data['EquipInUse'] = $this->equipreg_model->getEquipIDInUse($bc_row->ID); // returns false if equipment not signed out
						
						// if the equipment is signed out see who has it signed out
						if ( ! $data['EquipInUse']==false){
							$EqInUse_row=$data['EquipInUse']->row();								
						}
						
						// if the equipment is in service or tempOoS
						if ($bc_row->StatusID==0 || $bc_row->StatusID==1){
							// check if the page is waiting for equipment to be signed back in (i.e. the 'Default' state which is also waiting for a user to scan their bc)
							if ($ScannerStatus == iQS_ScannerStatus_Default) {
								// check if the equipment is signed out
								if ( ! $data['EquipInUse']==false) {
									// the user is trying to return equipment that is signed out so sign it in
									$q = $this->equipreg_model->signEquipIn($bc_row->ID, $dt);
									$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " signed in for " . $EqInUse_row->QID . " @ " . $dt;
									
								} else {
									// the item of equipment is not in use so cannot be signed out.
									// the user is probably trying to sign it out but has forgotten to scan their barcode first 
									$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " is not currently signed out to anyone. If you want to use it, scan your barcode first.";
									$EqInUse_row=FALSE;
								}
									
							// the scanner status is that the member has scanned their bc and is now trying to sign an item of equipment out
							// $ScannerStatus = iQS_ScannerStatus_EquipmentScan
							} else {	
								// get details of the waiting staff member
								$waitingMember_row = $this->member_model->getMember($WaitingQID)->row();
								
								// if the equipment is Temp OoS
								if ($bc_row->StatusID==1) {
									/*
									 * WILL NEED TO THINK HOW TO DEAL WITH PROMPTING THE USER WHETHER THEY WANT TO USE 
									 * EQUIPMENT THAT IS FLAGGED AS TEMP OOS
									 *
									 * In the meantime the system will just sign it out to them
									 * 
									 */
									
									//sign out
									$q = $this->equipreg_model->signEquipOut($waitingMember_row->QID, $bc_row->ID, $dt);
									$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " is now signed out to " . $WaitingQID;
									
								// the equipment is in service
								} else {
									
									if ($data['EquipInUse']==false) {
										$q = $this->equipreg_model->signEquipOut($waitingMember_row->QID, $bc_row->ID, $dt);
										$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " is now signed out to " . $WaitingQID;
									} else {
										if ($waitingMember_row->QID == $EqInUse_row->QID) {
											//signin
											$q = $this->equipreg_model->signEquipIn($bc_row->ID, $dt);
											$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " signed in for " . $EqInUse_row->QID . " @ " . $dt;
										} else {
											//signin
											$q = $this->equipreg_model->signEquipIn($bc_row->ID, $dt);
											//signout
											$q = $this->equipreg_model->signEquipOut($waitingMember_row->QID, $bc_row->ID, $dt);
											$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " is now signed out to " . $WaitingQID;
										}
									}
								}
							}
							// whenever there is an equipment scan we want the member signing that equipment in or out 
							// to be displayed on screen with a list of any equipment still out standing. 
							
							// Assign the waiting QID to a var
							$QID=$WaitingQID;
							
							//check if there is no waiting QID (i.e. $ScannerStatus == iQS_ScannerStatus_Default)
							//which means equipment is being signed back in
							if($QID==""){
								//Assign the QID of the member returning that equipment if there is one otherwise 
								//it means the equipment was not signed out so we $QID = FALSE meaning no barcode 
								//or equipment in use data will be displayed.
								$QID = ($EqInUse_row==FALSE) ? FALSE : $QID ;
							}
							
							if ($QID==FALSE) {
								$data['Barcode'] = FALSE;
								$data['EquipInUse'] = FALSE;
								$data['ScannerStatus'] = iQS_ScannerStatus_Default;
							} else {
								// change the barcode data of the read barcode equipment to the details of the QID of the waiting member
								// so when the home page form loads the details of the user are displayed. 
								
								$data['Barcode'] = $this->equipreg_model->lookupBarcodeByQID($QID);
								
								// get an updated list of equipment the user has.
								$data['EquipInUse'] = $this->equipreg_model->getMemberEquipInUse($QID); // returns false if equipment not in use
								if ( ! $data['EquipInUse']==false){ // equipment is in use
										$EqInUse_row=$data['EquipInUse']->row();								
								} 								
							}
						
						} else { // The equipment is flagged as permanently OoS
							$data['UserFeedback'] = $bc_row->EquipTypeDescr . " " . $bc_row->EquipNo . " is flagged as permanently out of service. See your system administrator about this equipment.";	
							$data['Barcode'] = FALSE;
							$data['EquipInUse'] = FALSE;
						} 
						break;			
					}				
				}
		}
		
		// if the system is now waiting for an equipment scan then set the countdown period
		$data['StartCDTimer'] = "";
		if ($data['ScannerStatus'] == iQS_ScannerStatus_EquipmentScan){
			$data['StartCDTimer'] = iQS_EquipScanCDSecs;
		}
		
		$data['main_content'] = 'home' ;
		$data['header_title'] = 'Home' ;		 
				
		$this->load->view('includes/template', $data);		
	}
		
}