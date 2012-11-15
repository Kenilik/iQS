<?php 

class Main extends CI_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->__site_is_set_up();
	}

	function __site_is_set_up()
	{
		$site_is_set_up = $this->input->cookie('current_siteid');
		
		if($site_is_set_up==FALSE) {
			$this->load->view('includes/header');
			$this->load->view('includes/loginbar');
			$this->load->view('includes/footer');
		}		
	}

	function equipinuse()
	{
		$data['EquipInUse'] = $this->Equip_Register_model->getEquipIDInUse();

		$data['main_content'] = 'equipinuse' ;
		$data['header_title'] = "Equipment In Use" ;
		$this->load->view('includes/template', $data);				
	}

	function home() 
	{
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
		
		
		$WaitingUserID = $this->input->post('WaitingUserID');
		if ($WaitingUserID===FALSE) {
			$data['WaitingUserID']=FALSE;
		} else {
			$data['WaitingUserID']= $WaitingUserID;
		}

		// get current UTC date
		$dt = gmdate(iQS_MySQLDateFormat);
		
		//check if a barcode has been scanned in (if not the page is loading for the first time without a submit) 	
		if ($bc === FALSE) {
			$data['Barcode'] = FALSE;
		} else {
			//lookup in the db for that barcode
			/*
			 * NOTE I HAVE NOT HANDLED SITE/CLIENT ISSUES YET
			 */
			
			//returns db query results or error message
			$data['Barcode'] = $this->Equip_Register_model->getBarcodeNo($bc); 

			// if is no bc in the system $data['Barcode'] will be a string error message 
			if ($data['Barcode']==FALSE){
				$data['UserFeedback'] = "There is no entry in the system for barcode number " . $bc . ". Please see your system administrator.";
				$data['ScannerStatus'] = iQS_ScannerStatus_Default;
				$data['StartCDTimer'] = iQS_DisplayFeedbackSecs;
			} else {
				//this is where I need to do what happens if there is a succesful barcode read that returns data from the database
				$bc_row=$data['Barcode']->row();
				
				switch(true){
					case $bc_row->barcode_type=="user":
						// if the user status is active
						if ($bc_row->status_id==0) {
							// get their list of equip in use 
							$data['EquipInUse'] = $this->Equip_Register_model->getEquipInUseByUser($bc_row->id); 
							$data['UserFeedback'] = "Scan your equipment...";
							$data['WaitingUserID'] = $bc_row->id;							
							$data['ScannerStatus'] = iQS_ScannerStatus_EquipmentScan;
						} else {
							$data['UserFeedback'] = $bc_row->id . " is not an active staff user.";
							$data['ScannerStatus'] = iQS_ScannerStatus_Default;
						}
						break;
						
					case $bc_row->barcode_type=="equip_item":
						$data['EquipInUse'] = $this->Equip_Register_model->getEquipIDInUse($bc_row->id); // returns false if equipment not signed out
						// if the equipment is signed out see who has it signed out
						if ( ! $data['EquipInUse']==false){
							$EqInUse_row=$data['EquipInUse']->row();								
						}
						
						// if the equipment is in service or tempOoS
						if ($bc_row->status_id==0 || $bc_row->status_id==1){
							// check if the page is waiting for equipment to be signed back in (i.e. the 'Default' state which is also waiting for a user to scan their bc)
							if ($ScannerStatus == iQS_ScannerStatus_Default) {
								// check if the equipment is signed out
								if ( ! $data['EquipInUse']==false) {
									// the user is trying to return equipment that is signed out so sign it in
									$q = $this->Equip_Register_model->signEquipIn($bc_row->id, $dt);
									$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name. " signed in for " . $EqInUse_row->username . " @ " . $dt;
								} else {
									// the item of equipment is not in use so cannot be signed out.
									// the user is probably trying to sign it out but has forgotten to scan their barcode first 
									$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " is not currently signed out to anyone. If you want to use it, scan your barcode first.";
									$EqInUse_row=FALSE;
								}
									
							// the scanner status is that the user has scanned their bc and is now trying to sign an item of equipment out
							// $ScannerStatus = iQS_ScannerStatus_EquipmentScan
							} else {	
								// get details of the waiting staff user
								$waitingUser_row = $this->User_model->get($WaitingUserID)->row();
								
								// if the equipment is Temp OoS
								if ($bc_row->status_id==1) {
									/*
									 * WILL NEED TO THINK HOW TO DEAL WITH PROMPTING THE USER WHETHER THEY WANT TO USE 
									 * EQUIPMENT THAT IS FLAGGED AS TEMP OOS
									 *
									 * In the meantime the system will just sign it out to them
									 * 
									 */
									
									//sign out
									$q = $this->Equip_Register_model->signEquipOut($waitingUser_row->id, $bc_row->id, $dt);
									$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " is now signed out to " . $waitingUser_row->username;
									
								// the equipment is in service
								} else {
									if ($data['EquipInUse']==false) {
										$q = $this->Equip_Register_model->signEquipOut($waitingUser_row->id, $bc_row->id, $dt);
										$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " is now signed out to " . $waitingUser_row->username;
									} else {
										if ($waitingUser_row->id == $EqInUse_row->user_id) {
											//signin
											$q = $this->Equip_Register_model->signEquipIn($bc_row->id, $dt);
											$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " signed in for " . $EqInUse_row->username . " @ " . $dt;
										} else {
											//signin
											$q = $this->Equip_Register_model->signEquipIn($bc_row->id, $dt);
											//signout
											$q = $this->Equip_Register_model->signEquipOut($waitingUser_row->id, $bc_row->id, $dt);
											$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " is now signed out to " . $waitingUser_row->username;
										}
									}
								}
							}
							// whenever there is an equipment scan we want the User signing that equipment in or out 
							// to be displayed on screen with a list of any equipment still out standing. 
							
							// Assign the waiting UserID to a var
							$UserID=$WaitingUserID;
							
							//check if there is no waiting UserID (i.e. $ScannerStatus == iQS_ScannerStatus_Default)
							//which means equipment is being signed back in
							if($UserID==""){
								//Assign the UserID of the User returning that equipment if there is one otherwise 
								//it means the equipment was not signed out so $UserID = FALSE meaning no barcode 
								//or equipment in use data will be displayed.
								$UserID = ($EqInUse_row==FALSE) ? FALSE : $UserID ;
							}
							
							if ($UserID==FALSE) {
								$data['Barcode'] = FALSE;
								$data['EquipInUse'] = FALSE;
								$data['ScannerStatus'] = iQS_ScannerStatus_Default;
							} else {
								// change the barcode data of the read barcode equipment to the details of the UserID of the waiting User
								// so when the home page form loads the details of the user are displayed. 
								$data['Barcode'] = $this->Equip_Register_model->getBarcodeByUser($UserID);
								
								// get an updated list of equipment the user has.
								$data['EquipInUse'] = $this->Equip_Register_model->getEquipInUseByUser($UserID); 	// returns false if equipment not in use
								if ( ! $data['EquipInUse']==false){ // equipment is in use
										$EqInUse_row=$data['EquipInUse']->row();
								} 
							}
						
						} else { // The equipment is flagged as permanently OoS
							$data['UserFeedback'] = $bc_row->equip_type_name . " " . $bc_row->equip_item_name . " is flagged as permanently out of service. See your system administrator about this equipment.";	
							$data['Barcode'] = FALSE;
							$data['EquipInUse'] = FALSE;
						} 
						break;			
					}				
				}
		}
		
		// if the system is now waiting for an equipment scan then set the countdown period
		$data['StartCDTimer'] = (isset($data['StartCDTimer'])== FALSE) ? '' : $data['StartCDTimer'] ; 
		
		if ($data['ScannerStatus'] == iQS_ScannerStatus_EquipmentScan) {
			$data['StartCDTimer'] = iQS_EquipScanCDSecs;
		}
		
		$data['main_content'] = 'home' ;
		$data['header_title'] = 'Home' ;		 
				
		$this->load->view('includes/template', $data);		
	}
		
}