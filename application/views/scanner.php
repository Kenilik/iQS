<div id="container">
	<h1>Welcome to iQuickScan!</h1>

	<div id="body">
		<p>
			<a href="../site/equipinuse">Equipment Signed Out</a>
			<?php 
				if($this->session->userdata('is_logged_in') === TRUE){
					echo '<a href="../admin">Site Administration</a>' ; 
				}
			?>
		</p>
		<p>
			<?php 
				$attrib = array('name' => 'BCScanner', 'id' =>'BCScanner' );
				echo form_open('main/scanner',$attrib);
				$input_type = 'hidden';
				 
				$value = ($ScannerStatus == FALSE) ? iQS_ScannerStatus_Default : $ScannerStatus ;
				$attrib = array('type'=>$input_type, 'name' => 'ScannerStatus', 'id' =>'ScannerStatus', 'value'=>$value);
				echo form_input($attrib);
				
				$value = ($WaitingUserID == FALSE) ? '' : $WaitingUserID ;
				$attrib = array('type'=>$input_type, 'name' => 'WaitingUserID', 'id' =>'WaitingUserID', 'value'=>$value);
				echo form_input($attrib);

				$value = ($StartCDTimer == FALSE) ? '' : $StartCDTimer ;
				$attrib = array('type'=>$input_type, 'name' => 'StartCDTimer', 'id' =>'StartCDTimer', 'value'=>$value);
				echo form_input($attrib);
				
				$attrib = array('type'=>$input_type, 'name' => 'Barcode', 'id' =>'Barcode');
				echo form_input($attrib);
				
				echo form_close();
				
			?>
			<table>
			<tr><td><h2><div id="UserFeedback"><?php echo $UserFeedback;?></td><td></h2><span id="CDTimer"></span></td></tr>
			<tr><td><input type="text" name="UserInput" id="UserInput" onkeydown="keyPressed()"> </div></td></tr>
			</table>
		</p>
		
		<?php 
			// check to see if a barcode was submitted and needs to be displayed
			if( ! is_null($Barcode)) {
				if( ! $Barcode==FALSE){
					echo '<p>';
					if(is_string($Barcode)){
						echo $Barcode;
					} else {
						echo $this->table->generate($Barcode);
						
						$bc_row=$Barcode->row();
						
						switch(true){	
							case $bc_row->barcode_type=="user":
								if ($bc_row->status_id==0) { // if the member status is active
									if ( ! $EquipInUse==false) {
										echo $this->table->generate($EquipInUse);
									} else {
										echo "No equipment currently signed out.";
									}
									
									
								}
									
								break;
								
							case $bc_row->barcode_type=="equip_item":
									
								break;
											
			}
												
					}				
					echo '</p>';
				}
			}
		?>

	</div>
	
	<script type="text/javascript">
	
		var myVar;
		var myBC;
		
		//var kc;
		var kpc;
		var ui;
		var isScanning;
		
		$(document).ready(function() {docReady()});

		/*
		 * keyPressed is required for browser compatibility as
		 * the event handling is different between browsers
		 */

		function keyPressed() {
			if(window.event) // IE8 and earlier
			{
				x=event.keyCode;
			} else if(event.which) /*IE9/Firefox/Chrome/Opera/Safari*/ {
				x=event.which;
			}
			kc=String.fromCharCode(x);
			
			if ( ! checkKeyPress(kc)){
				event.preventDefault();
				event.cancelBubble = true;
			}
		}

		function checkKeyPress(kc) {		
			if(kpc==undefined || kpc==0){
				kpc=1;
			} else {
				kpc=kpc+1;
			}

			if(isScanning==undefined){
				isScanning=false;
			}
			
			isFirstNum=(kpc==1 && isNumeric(kc));
			isSubsNumberWithinTime=(kpc>0) && (kpc<8) && isNumeric(kc) && isScanning;
			isBCSuffixWithinTime=((kpc==8 || kpc==6) && kc.charCodeAt(0)==13);
		
			kpc_result = true;
			
			switch(true)
			{
			case kc==' ':
				location.reload();
				break;
				
			case isSubsNumberWithinTime:
			//do nothing wait for next key
				ui=ui+kc;
				break;
				
			case isFirstNum:
			//this is the first key press - start the timer
				isScanning=true;
				ui=kc;
				myVar=setTimeout(function(){resetTimer()},50000);
				break;
				
			case isBCSuffixWithinTime:
				document.getElementById("Barcode").value = ui;
				document.getElementById("UserInput").value = "";
				//document.getElementById("UserFeedback").innerHTML="Successful read for barcode "+myBC;
				//setTimeout(function(){document.getElementById("UserFeedback").innerHTML="";},2000);
				resetTimer();
				document.getElementById("BCScanner").submit();
				
				break;
			
			default:
				resetTimer();
				kpc_result = false;
				break;
			}
			
			return kpc_result;
		}
		
		
		function resetTimer(){
			document.getElementById("UserInput").value = "";
			isScanning=false;
			kpc=0;
			ui="";
			clearTimeout(myVar);
		}			

		function setCDTimer(secs){
			ex = new Date();
			ex.AddSeconds(parseInt(secs));
			
			$('#CDTimer').countdown({until: ex, format: 'S', expiryUrl: '../main/scanner'}); 
		}

						
		function isNumeric(val) {
			return isNaN(parseFloat(val)) ? false : true;
			/*
			if (isNaN(parseFloat(val))) {
				return false;
			} else {
				return true;
			}
			*/
		}

		function docReady(){
			//start the countdown timer to the value of the STartCDTimer hidden field
			secs = document.getElementById("StartCDTimer").value;
			if( ! secs == '') {setCDTimer(secs);}
			
			//set the cursor focus to the user input field for the barcode scanner 
			setBCFocus();
		}

		function setBCFocus(){
			document.getElementById("UserInput").focus();	
		}
	</script>
</div>
