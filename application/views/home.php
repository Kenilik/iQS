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
				echo form_open('site/home',$attrib);
				
				$name = "ScannerStatus";					
				if ($ScannerStatus == FALSE) {
					$value = iQS_ScannerStatus_Default; 
				} else {
					$value = $ScannerStatus;
				}
				echo form_input($name,$value);
							
				$name = "WaitingQID";
				if ($WaitingQID == FALSE) {
					$value = ""; 
				} else {
					$value = $WaitingQID;
				}
				echo form_input($name, $value);
				
				echo '<input type="input" name="Barcode" id="Barcode" />';
				
			?>
			<br><br>
			<div id="UserFeedback"><?php echo $UserFeedback;?></div>
			
			<input type="text" name="UserInput" id="UserInput" onkeypress="keyPressed()">
			
		</p>
		
		<h1><p id="FeedbackMsg"></p></h1>
		<?php 
			// check to see if a barcode was submitted and needs to be displayed
			if( ! is_null($barcode)) {
				if( ! $barcode===FALSE){
					echo '<p>';
					if(is_string($barcode)){
						echo $barcode;
					} else {
						echo $this->table->generate($barcode);
						
						$bc_row=$barcode->row();
						
						switch(true){
								
							case $bc_row->BarcodeType=="Member":								
								if ($bc_row->StatusID==0) { // if the member status is active
									if ( ! $EquipInUse==false) {
										echo $this->table->generate($EquipInUse);
									} else {
										echo "No equipment currently signed out.";
									}
									
									
								}
									
								break;
								
							case $bc_row->BarcodeType=="Equipment":
									
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
				document.getElementsByName("FeedbackMsg").innerHTML="Successful read for barcode "+myBC;
				setTimeout(function(){document.getElementById("FeedbackMsg").innerHTML="";},2000);
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

		
		function setCDTimer($secs){
			$('#timer').countdown(
				{
					image: '/iQS/img/digits.png',
					startTime: '05',
					timerEnd: function(){ alert('end!'); },
					format: 'ss'
				}
			);
		}
		
		function isNumeric(val) {
	    if (isNaN(parseFloat(val))) {
	    	return false;
	    }
     		return true;
		}

		function docReady(){
			setBCFocus();
		}

		function setBCFocus(){
			document.getElementById("UserInput").focus();	
		}
	</script>
</div>
