<?php  
	ob_start(); 	
	require_once '../App/partials/Header.inc';
	require_once '../App/partials/Menu/MarketingMenu.inc';

	$Gate = require_once  $ROOT_DIR . '/Auth/Gates/CUSTOMER_PROFILE';
	if(!in_array( $Gate['VIEW_CUSTOMER_REGISTER_FORM'] , $_SESSION['ACCESS_LIST']  )) {
		header("Location:index.php?msg=You are not authorized to access this page!" );
	}
?>

<div class="m-3">
<?php 
	if (filter_has_var(INPUT_GET, 'message') ) {
		$message = $_GET['message'];
		$message =  explode(',' ,$message); 
		$state = $_GET['success'];
		$className   = ($state == 1 ) ? 'alert-success' : 'alert-danger'; 
		echo '<div class="alert '.$className.' ">'; 
		foreach ($message as $key => $Message) {
			echo <<<HEREDOC
					<li><strong>$Message </strong></li>
			HEREDOC;
		} 
		echo '</div>';
	}  

  	if (filter_has_var(INPUT_GET, 'fields') ) {
		$fields = $_GET['fields'];
		$fields =  explode(',' ,$fields); 
 	}  

?>

<div class="card mt-4 mb-5 shadow ">
	<div class="card-header" style = "border-bottom:1px solid gray; d-flex  align-items-center justify-content-between "  >
		<div>
			<h3>
				<a class= "btn btn-outline-primary   me-3" href="CustomerList.php">
					<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
					</svg>
				</a>  
				<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
					<path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
					<path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
				</svg>
				Register New Customer
			</h3>	
		</div>
	</div>

	<div class="card-body">
		<form action="CustomerController.php" method="POST" onsubmit="return validateform()">
		<!-- <form action="" method="POST" >  --> 
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12  mt-2">
					<label class="form-label" for="cmpname">Company Name</label>
					<input type="text" class="form-control " name="companyName" id="cmpname" value = "<?php echo  isset($fields["0"]) ? $fields["0"]  : '' ?>"  >
					<span id="cmpnameError" class="text-danger" style="font-size: 16px;"></span>  

				</div>
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12   mt-2">
					<label class="form-label" for="select1">Catagory</label>
					<select class="form-select" name="Catagory" id="select1">
						<option value="Season">Season</option>
						<option value="Regular">Regular</option>
						<option value="Irregular">Irregular</option>
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-2">
					<label class="form-label" for="select2">Business Type</label>
					<input class="form-control " list="Type"  name="businessType" id="select2">
					<datalist id="Type">
						<?php
						$BusinessType = $Controller->QueryData('SELECT DISTINCT BusinessType FROM ppcustomer' , []);
						foreach ($BusinessType as $key => $value) : ?>
							<option value="<?=$value['BusinessType']; ?>"> <?= $value['BusinessType']; ?> </option>
						<?php endforeach;  ?>
					</datalist>	
				</div>
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12  mt-2">
					<label class="form-label" for="select3">Business Nature</label>
					<select class="form-control" name="businessNature" id="select3">
						<option value="Manufacturer">Manufacturer</option>
						<option value="Whole Seller">Whole Seller</option>
						<option value="Ordinary">Ordinary</option>
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12  mt-2">
					<label class="form-label" for="select4">Specification</label>
					<select class="form-control" name="Specification" id="select4">
						<option value="VVIP">VVIP</option>
						<option value="VIP">VIP</option>
						<option value="Medium">Medium</option>
						<option value="Low">Low</option>
						<option value="Idle">Idle</option>
					</select>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-2">
					<label class="form-label" for="select5">Time Limit</label>
					<select class="form-control" name="TimeLimit" id="select5">
						<option value="1 Month">1 Month</option>
						<option value="2 Month">2 Month</option>
						<option value="3 Month">3 Month</option>
						<option value="4 Month">4 Month</option>
						<option value="5 Month">5 Month</option>
						<option value="6 Month">6 Month</option>
						<option value="7 Month">7 Month</option>
						<option value="8 Month">8 Month</option>
						<option value="9 Month">9 Month</option>
						<option value="10 Month">10 Month</option>
						<option value="11 Month">11 Month</option>
						<option value="12 Month">12 Month</option>
					</select>
				</div>
		</div><!-- END OF FIRST ROW IN THE PAGE  -->

	
		<p class = "fs-4 mt-3" >Contact Details</p>
		<hr style= "margin-top:-10px;">

		
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12  mt-1">
				<label class="form-label" for="workphone">workphone</label>
				<input type="text" class="form-control" name="workphone" id="workphone" value = "<?php echo  isset($fields[6]) ? $fields[6]  : '' ?>" >
				<span id="workphoneError" class="text-danger" style="font-size: 16px;"></span>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-1">
				<label class="form-label" for="Email">Email  <?php echo  isset($fields[7]) ? $fields[7]  : '' ?> </label>
				<input type="email" class="form-control " name="Email" id="Email" value = "<?php echo  isset($fields[7]) ? $fields[7]  : '' ?>">
				<span id="EmailError" class="text-danger" style="font-size: 16px;"></span>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12  mt-1">
				<label class="form-label" for="website">website   <?php echo  isset($fields[8]) ? $fields[8]  : '' ?>   </label>
				<input type="text" class="form-control " name="website" id="website" value = "<?php echo  isset($fields[8]) ? $fields[8]  : '' ?>">
				<span id="websiteError" class="text-danger" style="font-size: 16px;"></span>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-1">
				<label class="form-label" for="Address">Address</label>
				<input type="text" class="form-control" name="Address" id="Address" value = "<?php echo  isset($fields[9]) ? $fields[9]  : '' ?>">
				<span id="AddressError" class="text-danger" style="font-size: 16px;"></span>
			</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-1">
			<label class="form-label" for="Province">Province</label>
			<select class="form-control" name="Province" id="Province" onchange="findregion();">
				<option>Select Province</option>
 				<option value="Kabul">kabul</option>
		        <option value="Baghlan">Baghlan</option>
		        <option value="Kunduz">Kunduz</option>
		        <option value="Takhar">Takhar</option>
		        <option value="Balkh">Balkh</option>
				<option value="Mazar">Mazar</option>
		        <option value="Faryab">Faryab</option>
		        <option value="Jowzjan">Jowzjan</option>
		        <option value="Samangan">Samangan</option>
		        <option value="Sar-e-Pol">Sar-e-Pol</option>
		        <option value="Bamyan">Bamyan</option>
		        <option value="Badakhshan">Badakhshan</option>
		        <option value="Kapisa">Kapisa</option>
		        <option value="Logar">Logar</option>
		        <option value="Panjshir">Panjshir</option>
		        <option value="Parwan">Parwan</option>
		        <option value="Wardak">Wardak</option>
		        <option value="Kunar">Kunar</option>
		        <option value="Laghman">Laghman</option>
		        <option value="Nangarhar">Nangarhar</option>
		        <option value="Nuristan">Nuristan</option>
		        <option value="Badghis">Badghis</option>
		        <option value="Farah">Farah</option>
		        <option value="Ghor">Ghor</option>
		        <option value="Herat">Herat</option>
		        <option value="Ghazni">Ghazni</option>
		        <option value="Khost">Khost</option>
		        <option value="Paktia">Paktia</option>
		        <option value="Paktika">Paktika</option>
		        <option value="Daykundi">Daykundi</option>
		        <option value="Helmand">Helmand</option>
		        <option value="Kandahar">Kandahar</option>
		        <option value="Nimruz">Nimruz</option>
		        <option value="Oruzgan">Oruzgan</option>
		        <option value="Zabul">Zabul</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 mt-1">
			<label class="form-label" for="RegionSelect">Region</label>
			<select class="form-control " name="Region" id="RegionSelect">
				<option value=""></option>
			</select>
		</div>
	</div>
	<p class = "fs-4 mt-3" >Contact Person</p>
		<hr style= "margin-top:-10px;">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12  mt-1">
			<label class="form-label" for="CPName">Name</label>
			<input type="text" class="form-control" name="CPName" id="CPName" value = "<?php echo  isset($fields[12]) ? $fields[12]  : '' ?>" ><!--CPName = Contact Person name -->
			<span id="CPNameError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 mt-1">
			<label class="form-label" for="Position1">Position</label>
			<input type="text" class="form-control " name="Position" id="Position1" value = "<?php echo  isset($fields[13]) ? $fields[13]  : '' ?>">
			<span id="Position1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 mt-1">
			<label class="form-label" for="Mobile1">Mobile</label> 
			<input type="text" class="form-control " name="Mobile" id="Mobile1" value = "<?php echo  isset($fields[14]) ? $fields[14]  : '' ?>" >
			<span id="Mobile1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 mt-1">
			<label class="form-label" for="whatsup1">What's up</label>
			<input type="text" class="form-control " name="whatsup" id="whatsup1" value = "<?php echo  isset($fields[15]) ? $fields[15]  : '' ?>">
			<span id="whatsup1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
	</div>
	 

	<p class = "fs-4 mt-3" >User Details</p>
	<hr style= "margin-top:-10px;">
		
	<div class="row mb-5">

		

	<?php 
		$Logged_User = $Controller->QueryData('SELECT Branch FROM employeet WHERE EId = ? ' , [$_SESSION['EId'] ]); 
		$Branch = $Logged_User->fetch_assoc(); 
		// echo $Branch['Branch'];
	
	?>
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12 mt-1">
			<!-- <label class="form-label" for="select6">Branch</label>
			<select class="form-control" name="Branch" id="select6">
				<option value="Main Office">Main Office</option>
				<option value="Bagh Dawood">Bagh Dawood</option>
				<option value="Mazar">Mazar</option>
				<option value="Herat">Herat</option>
				<option value="Kandahar">Kandahar</option>
			</select> -->

			<label class="form-label" for="select6">Branch</label>
			<input type="text" class="form-control" name="Branch" id="select6"  value = "<?=$Branch['Branch']; ?>">

		</div>

		<input type="hidden" name="POC" id="" class= "form-control" value = "<?=$_SESSION['user'] ?>" >
		<div class="col-lg-6 col-md-6 col-sm-8 col-xs-12   d-flex justify-content-end">
			<div class="mt-5">
				<a  href= "CustomerList.php" class= "btn btn-outline-danger"  > Cancel  </a> 
				<input  type = "submit" class= "btn btn-outline-primary " name = "SaveNewCustomer" value="Save">
			</div>
		</div>
	</div>
	 
</form>

</div><!-- END OF Card-body --> 
</div><!-- END OF Card -->
 
 
<script>
	 

	function findregion() /* This function is used for finding the region of province  */
    {
            var select = document.getElementById("RegionSelect");
            var length = select.options.length;
            for (i = length-1; i >= 0; i--) 
            {
                select.options[i] = null;
            }
            var Wardak=["Central"];     var Badakhshan=["NorthEast"]; var Zabul=["SouthWest"];
            var Oruzgan=["SouthWest"];  var Nimruz=["SouthWest"];     var Kandahar=["SouthWest"];
            var Helmand=["SouthWest"];  var Daykundi=["SouthWest"];   var Paktika=["SouthEast"];
            var Paktia=["SouthEast"];   var Khost=["SouthEast"];      var Ghazni=["SouthEast"];
            var Herat=["West"];         var Ghor=["West"];            var Baghlan=["NorthEast"];
            var Kunduz=["NorthEast"];   var Takhar=["NorthEast"];     var Balkh=["NorthEast"];
       		var Faryab=["NorthEast"];   var Kapisa=["Central"];       var Logar=["Central"];
            var Panjshir=["Central"];   var Parwan=["Central"];       var Kunar=["East"];
            var Laghman=["East"];       var Nangarhar=["East"];       var Nuristan=["East"];
            var Badghis=["West"];       var Farah=["West"];           var Jowzjan=["NorthWest"];
            var Samangan=["NorthWest"]; var Bamyan=["West"];          var Kabul=["Central"];
            var SarePol=["NorthWest"];  var Mazar=["North"];

                var pr= document.getElementById('Province').value;
				if (pr=="Wardak") var array=Wardak;
               	else if(pr== "Sar-e-Pol")  var  array=SarePol;
                else if(pr== "Badakhshan") var  array=Badakhshan;
                else if(pr== "Baghlan")    var  array=Baghlan;
               	else if (pr== "Kunduz")    var  array=Kunduz;
                else if (pr== "Takhar")    var  array=Takhar;
                else if (pr== "Balkh")     var  array=Balkh;
               	else if (pr== "Faryab")    var  array=Faryab;
                else if (pr== "Jowzjan")   var  array=Jowzjan;
                else if (pr== "Samangan")  var  array=Samangan;              
                else if (pr== "Bamyan")    var  array=Bamyan;
                else if (pr== "Kabul")     var  array=Kabul;
                else if (pr== "Kapisa")    var  array=Kapisa;                
                else if (pr== "Logar")     var  array=Logar;                
                else if (pr== "Panjshir")  var  array=Panjshir;
                else if (pr== "Parwan")    var  array=Parwan;
                else if (pr== "Kunar")     var  array=Kunar;                
                else if (pr== "Laghman")   var  array=Laghman;
                else if (pr== "Nangarhar") var  array=Nangarhar;                
                else if (pr== "Nuristan")  var  array=Nuristan;                
                else if (pr== "Badghis")   var  array=Badghis;                
                else if (pr== "Farah")     var  array=Farah;
                else if (pr== "Ghor")      var  array=Ghor;                
                else if (pr== "Herat")     var  array=Herat;                
                else if (pr== "Ghazni")    var  array=Ghazni;                
                else if (pr== "Khost")     var  array=Khost;                
                else if (pr== "Paktia")    var  array=Paktia;                
               	else if (pr== "Paktika")   var  array=Paktika;                
                else if (pr== "Daykundi")  var  array=Daykundi;
                else if (pr== "Helmand")   var  array=Helmand;                
               	else if (pr== "Kandahar")  var  array=Kandahar;                
                else if (pr== "Nimruz")    var  array=Nimruz;               
                else if (pr== "Oruzgan")   var  array=Oruzgan;                
                else if (pr== "Zabul")     var  array=Zabul;
				else if(pr== "Mazar")      var array=Mazar;
               	else{}
				for (var i = 0; i < array.length; i++) 
                {
                   	var option = document.createElement("option");
                    option.value = array[i];
                    option.text = array[i];
                    RegionSelect.appendChild(option);
                }
  	}
</script>

  </div>


<?php  require_once '../App/partials/Footer.inc'; ?>

