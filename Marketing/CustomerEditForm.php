<?php 

	ob_start(); 
	require_once '../App/partials/Header.inc'; 
  	require_once '../App/partials/Menu/MarketingMenu.inc';  
	
	$Gate = require_once  $ROOT_DIR . '/Auth/Gates/CUSTOMER_PROFILE';
	if(!in_array( $Gate['VIEW_CUSTOMER_EDIT_FORM'] , $_SESSION['ACCESS_LIST']  )) {
		header("Location:index.php?msg=You are not authorized to access this page!" );
	}

	  
if (filter_has_var(INPUT_GET, 'message') ) {
	$message = $_GET['message'];
	$message =  explode(',' ,$message); 
	$state = $_GET['success'];
	$className   = ($state == 1 ) ? 'alert-success' : 'alert-danger'; 
	echo '<div class="alert m-4 '.$className.' ">'; 
	foreach ($message as $key => $Message) {
		echo <<<HEREDOC
				<li><strong>$Message </strong></li>
		HEREDOC;
	} 
	echo '</div>';
}  
	 
if ( filter_has_var(INPUT_GET, 'id') ) {
		$CustomerData = $Controller->QueryData("SELECT * FROM ppcustomer WHERE CustId = ? ", [$_GET['id']] );
		$Data = $CustomerData->fetch_assoc(); 
}
else {
?> 

<div class="alert alert-danger m-3 d-flex align-items-center" role="alert">
  <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
  <div>
  Customer ID was not Found!
  </div>
</div>
<?php
die(); 
}


?>
<div class="m-3">








<div class="card my-4">
	<div class="card-header ">
		
		<h3  class = "d-flex justify-content-start ">
		<div class = "me-3 my-1" >
			<a class= "btn btn-outline-primary  " href="CustomerProfile.php?id=<?=$_GET['id'] ?>&tab=active">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>  
		</div>
		<div class = "my-1" >
			<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
				<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
				<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
				</svg>
				Customer Edit Form
			</div>
		</h3>

	</div>
	<div class="card-body">
	<div class="fs-2">
		<p>Company Details</p>
	</div>

<form action="CustomerController.php" method="POST" onsubmit="return validateform()">
	<div class="row">
		<input type="hidden" name="CustId" value = "<?=$_GET['id'] ?> " >
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="cmpname">Company Name</label>
			<input type="text" class="form-control fs-5" name="companyName" id="cmpname" value = "<?=$Data['CustName'] ?>">
			<span id="cmpnameError" class="text-danger" style="font-size: 16px;"></span>  

		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="select1">Catagory</label>
			<select class="form-control fs-5" name="Catagory" id="select1">
				<option  value = "<?=$Data['CustCatagory'] ?>"> <?=$Data['CustCatagory'] ?> </option>
				<option value="Season">Season</option>
				<option value="Regular">Regular</option>
				<option value="Irregular">Irregular</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="select2">Business Type</label>
			<input class="form-control fs-5" list="Type"  name="businessType" id="select2"  value = "<?=$Data['BusinessType'] ?>"  >
			<datalist id="Type">
		<?php
		$DataRows = $Controller->QueryData("SELECT DISTINCT BusinessType FROM ppcustomer" , []);
            foreach ($DataRows as $RowsKey => $Rows) {  ?>
				<option value="<?php echo $Rows['BusinessType']; ?>">
					<?php echo $Rows['BusinessType']; ?>
				</option>
			<?php   }   ?>
			</datalist>	
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="select3">Business Nature</label>
			<select class="form-control fs-5" name="businessNature" id="select3">
				<option  value = "<?=$Data['BusinessNature'] ?>"> <?=$Data['BusinessNature'] ?> </option>
				<option value="Manufacturer">Manufacturer</option>
				<option value="Whole Seller">Whole Seller</option>
				<option value="Ordinary">Ordinary</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="select4">Specification</label>
			<select class="form-control fs-5" name="Specification" id="select4">
				<option  value = "<?=$Data['CusSpecification'] ?>"> <?=$Data['CusSpecification'] ?> </option>
				<option value="VVIP">VVIP</option>
				<option value="VIP">VIP</option>
				<option value="Medium">Medium</option>
				<option value="Low">Low</option>
				<option value="Idle">Idle</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="select5">Time Limit</label>
			<select class="form-control fs-5" name="TimeLimit" id="select5">
				<option  value = "<?=$Data['Timelimit'] ?>"> <?=$Data['Timelimit'] ?> </option>
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
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="Status">Status</label>
			<select class="form-control fs-5" name="Status" id="Status" onchange="findstatus();">
				<option  value = "<?=$Data['CusStatus'] ?>"> <?=$Data['CusStatus'] ?> </option>
				<option>Select Status</option>
				<option value="Active">Active</option>
				<option value="InActive">In-Active</option>
				<option value="Pending">Pending</option>
				<option value="Prospect">Prospect</option>
			</select>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-2">
			<label class="form-label" for="StatusCondition">Condition</label>
			<select class="form-control fs-5" name="Condition" id="StatusCondition" >
				<option value = "<?=$Data['PPCondition'] ?>" >  <?=$Data['PPCondition'] ?> </option>
			</select>
		</div>
	</div>
	<div class="ps-2 fs-2 card mt-5 border-top-0 border-start-0 border-end-0 border-1"></div>
	<div class="fs-2">
		<p>Contact Details</p>
	</div>
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="workphone">workphone</label>
			<input type="text" class="form-control fs-5" name="workphone" id="workphone"   value = "<?=$Data['CustWorkPhone'] ?>"> 
			<span id="workphoneError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="Email">Email</label>
			<input type="email" class="form-control fs-5" name="Email" id="Email"   value = "<?=$Data['CustEmail'] ?>">
			<span id="EmailError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="website">website</label>
			<input type="text" class="form-control fs-5" name="website" id="website" value = "<?=$Data['CustWebsite'] ?>" >
			<span id="websiteError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="Address">Address</label>
			<input type="text" class="form-control fs-5" name="Address" id="Address"  value = "<?=$Data['CustAddress'] ?>" >
			<span id="AddressError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="Province">Province</label>
			<select class="form-control fs-5" name="Province" id="Province" onchange="findregion();">
				<option disabled >Select Province</option>
				<option  value = "<?=$Data['CusProvince'] ?>"> <?=$Data['CusProvince'] ?> </option>
 				<option value="Kabul">kabul</option>
 				<option value="Mazar">Mazar</option>
		        <option value="Baghlan">Baghlan</option>
		        <option value="Kunduz">Kunduz</option>
		        <option value="Takhar">Takhar</option>
		        <option value="Balkh">Balkh</option>
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
		<div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="RegionSelect">Region</label>
			<select class="form-control fs-5" name="Region" id="RegionSelect">
				<option value=""></option>
			</select>
		</div>
	</div>
	<div class="ps-2 fs-2 card mt-5 border-top-0 border-start-0 border-end-0 border-1"></div>
	<div class="fs-2">
		<p>Contact Person</p>
	</div>
	<div class="row">
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="CPName">Name</label>
			<input type="text" class="form-control fs-5" name="CPName" id="CPName"  value = "<?=$Data['CustContactPerson'] ?>" ><!--CPName = Contact Person name -->
			<span id="CPNameError" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="Position1">Position</label>
			<input type="text" class="form-control fs-5" name="Position" id="Position1"  value = "<?=$Data['CustPostion'] ?>" >
			<span id="Position1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="Mobile1">Mobile</label>
			<input type="text" class="form-control fs-5" name="Mobile" id="Mobile1"  value = "<?=$Data['CustMobile'] ?>" >
			<span id="Mobile1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-8 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="whatsup1">What's up</label>
			<input type="text" class="form-control fs-5" name="whatsup" id="whatsup1"  value = "<?=$Data['CmpWhatsApp'] ?>">
			<span id="whatsup1Error" class="text-danger" style="font-size: 16px;"></span>
		</div>
	</div>
	<div class="ps-2 fs-2 card mt-5 border-top-0 border-start-0 border-end-0 border-1"></div>
	<div class="fs-2">
		<p>User Details</p>
	</div>
	<div class="row mb-5">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="POC">POC</label>
			 <input type="text" class= "form-control fs-5 "  name="POC" value = "<?=$Data['CusReference'] ?>" id="">
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 fs-5 mt-1">
			<label class="form-label" for="select6">Branch</label>
			<select class="form-control fs-5" name="Branch" id="select6">
				<option value="Main Office">Main Office</option>
				<option value="Bagh Dawood">Bagh Dawood</option>
				<option value="Mazar">Mazar</option>
				<option value="Herat">Herat</option>
				<option value="Kandahar">Kandahar</option>
			</select>
		</div> 


		<!-- //     -->
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 fs-5 mt-1">
			<?php $AssignedTo = $Controller->QueryData(" SELECT   employeet.Ename ,  employeet.EId FROM  employeet
			 LEFT OUTER JOIN ppcustomer ON employeet.EId =  ppcustomer.FollowupResponsible WHERE EDepartment ='Marketing' && ppcustomer.FollowupResponsible = ? ;  " , [$Data['FollowupResponsible']]);
				$AssignedTo = $AssignedTo->fetch_assoc();   ?>

			<label class="form-label" for="followup"> Assigned To :  
				<?php 
					if(isset($AssignedTo['Ename'])) 	echo $AssignedTo['Ename'] ;
					elseif(isset($Data['CusReference'])) echo $Data['CusReference']; 
					else echo '<span class="badge  bg-info"> No One</span>'; 
			   ?>
			</label>
			<select class="form-control fs-5" name="FollowupResponsible" id="followup" >
			<?php if(isset($AssignedTo['Ename']) && isset($AssignedTo['EId']) ) { ?>
				<option selected="selected" value='<?=$AssignedTo['EId']?>'>   <?=$AssignedTo['Ename'] ?>  </option> 
			<?php } ?>

			<?php 
			$ec = $Controller->QueryData("SELECT DISTINCT employeet.Ename , employeet.EId FROM  employeet WHERE EDepartment ='Marketing'" , []);
			while($dd = $ec->fetch_assoc()) :   ?>
				<option value="<?php echo $dd['EId']; ?>"> <?=$dd['Ename']; ?> </option>
			<?php endwhile; ?>	
			</select>
		</div>

	</div>
 
	
	<div class="d-flex justify-content-end  ">
			<a href= "CustomerList.php" class= "btn btn-outline-danger mx-1">Cancel</a> 
			<input type ="submit" class="btn btn-outline-primary" name ="EditCust" value="Update" >
	</div>

</form>

</div><!-- END OF Card-body --> 
</div><!-- END OF Card -->   

<script>
	function validateform() /* This function is used for validation of the form  */
	{
		var cmpname=document.getElementById("cmpname");     var workphone=document.getElementById("workphone");
		var Email1=document.getElementById("Email");        var website=document.getElementById("website");
		var Address=document.getElementById("Address");     var CPName=document.getElementById("CPName");
		var Position1=document.getElementById("Position1"); var Mobile1=document.getElementById("Mobile1");
		var whatsup1=document.getElementById("whatsup1");   var no=/^[0-9]\d{10}$/;
		var flag=1;
		if(cmpname.value=="")
		{
			document.getElementById("cmpnameError").innerHTML="Company Name is Empty";
			flag=0;
		}
		else if(cmpname.value<2)
		{
			document.getElementById("cmpnameError").innerHTML="Company Name require 2 character";
		}
		else if(cmpname.value>160)
		{
			document.getElementById("cmpnameError").innerHTML="Company Name should less than 160 character";
			flag=0;	
		}
		else
		{
			document.getElementById("cmpnameError").innerHTML="";
			flag=1;	
		}

	    if(workphone.value=="")
		{
			document.getElementById("workphoneError").innerHTML="Phone number is Empty";
			flag=0;	
		}
		else if(workphone.value==no)
		{
			document.getElementById("workphoneError").innerHTML="Phone number must be a valid phone number";
			flag=0;	
		}
		else
		{
			document.getElementById("workphoneError").innerHTML="";
			flag=1;	
		}
		if(Email1.value=="")
		{
			document.getElementById("EmailError").innerHTML="Email is Empty";
			flag=0;	
		}
		else if(Email1.value<10)
		{
			document.getElementById("EmailError").innerHTML="Please enter a valid email address";
			flag=0;	
		}
		else if(Email1.value>75)
		{
			document.getElementById("EmailError").innerHTML="Eamil characters are out of bond";
			flag=0;
		}
		else
		{
			document.getElementById("EmailError").innerHTML="";
			flag=1;	
		}

		if(Address.value=="")
		{
			document.getElementById("AddressError").innerHTML="Address is Empty";
			flag=0;
		}
		else if(Address.value<4)
		{
			document.getElementById("AddressError").innerHTML="Address require 4 character";
			flag=0;
		}
		else if(Address.value>80)
		{
			document.getElementById("AddressError").innerHTML="Address should be less than 80 character";
			flag=0;	
		}
		else
		{
			document.getElementById("AddressError").innerHTML="";
			flag=1;	
		}

		if(CPName.value=="")
		{
			document.getElementById("CPNameError").innerHTML="Cantact Person is Empty";
			flag=0;
		}
		else if(CPName.value<3)
		{
			document.getElementById("CPNameError").innerHTML="Cantact Person require 3 character";
		}
		else if(CPName.value>120)
		{
			document.getElementById("CPNameError").innerHTML="Cantact Person should be less than 120 character";
			flag=0;	
		}
		else
		{
			document.getElementById("CPNameError").innerHTML="";
			flag=1;	
		}

		if(Position1.value=="")
		{
			document.getElementById("Position1Error").innerHTML="Position is Empty";
			flag=0;
		}
		else if(Position1.value<4)
		{
			document.getElementById("Position1Error").innerHTML="Position require 4 character";
			flag=0;
		}
		else if(Position1.value>150)
		{
			document.getElementById("Position1Error").innerHTML="Position should be less than 150 character";
			flag=0;	
		}
		else
		{
			document.getElementById("Position1Error").innerHTML="";
			flag=1;	
		}
		if(Mobile1.value=="")
		{
			document.getElementById("Mobile1Error").innerHTML="Mobile number is Empty";
			flag=0;	
		}
		else if(Mobile1.value==no)
		{
			document.getElementById("Mobile1Error").innerHTML="Mobile number must be a valid phone number";
			flag=0;	
		}
		else
		{
			document.getElementById("Mobile1Error").innerHTML="";
			flag=1;	
		}

		if(whatsup1.value=="")
		{
			document.getElementById("whatsup1Error").innerHTML="Whatsup number is Empty";
			flag=0;	
		}
		else if(whatsup1.value==no)
		{
			document.getElementById("whatsup1Error").innerHTML="Whatsup number must be a valid phone number";
			flag=0;	
		}
		else
		{
			document.getElementById("whatsup1Error").innerHTML="";
			flag=1;	
		}

		if(website.value=="")
		{
			document.getElementById("websiteError").innerHTML="website Name is Empty";
			flag=0;
		}
		else if(website.value<2)
		{
			document.getElementById("websiteError").innerHTML="website Name require 2 character";
		}
		else if(website.value>90)
		{
			document.getElementById("websiteError").innerHTML="website Name should less than 90 character";
			flag=0;	
		}
		else
		{
			document.getElementById("websiteError").innerHTML="";
			flag=1;	
		}
		if(flag) return true;
		else return false;
	}/* END OF validation function body */

	function findstatus()
	{
		var select= document.getElementById("StatusCondition");
		var length= select.options.length;
		for(i=length-1; i>=0; i--)
		{
			select.options[i]=null;
		}
		var Active=["Working"];
		var InActive=["Not Working Business","Wrong Details","Copy Right Issue","High Price","Bellow Minimum QTY","             wrong Print","Late Print","Time Limit","Bahavior Issue","Low Quality","Ongoing Communication","Change Product"
			             ];
		var Pending=[ "Time Limit", "Wrong Details","Copy Right Issue","High Price","Bellow Minimum QTY","wrong Print","Late Print",           "Bahavior Issue","Low Quality","Ongoing Communication","Change Product"
			            ];
		var Prospect=[ "New" , "Wrong Details","Copy Right Issue","High Price","Bellow Minimum QTY","Time Limit","Ongoing Communication"];
		var St=document.getElementById('Status').value;
		if(St=="Active")        var array=Active;
		else if(St=="InActive") var array=InActive;
		else if(St=="Pending")  var array=Pending;
		else if(St=="Prospect") var array=Prospect;
		else{}
		for(var i=0; i < array.length; i++)
		{
			var option=document.createElement("option");
			option.value=array[i];
			
			option.text=array[i];
			StatusCondition.appendChild(option);
		}
	}
	findregion() ;
	function findregion() /* This function is used for finding the region of province  */
    {
            var select = document.getElementById("RegionSelect");
            var length = select.options.length;
            for (i = length-1; i >= 0; i--) 
            {
                select.options[i] = null;
            }
            var Wardak=["Central"];     var Badakhshan=["North East"]; var Zabul=["South West"];
            var Oruzgan=["South West"];  var Nimruz=["South West"];     var Kandahar=["South West"];
            var Helmand=["South West"];  var Daykundi=["South West"];   var Paktika=["South East"];
            var Paktia=["South East"];   var Khost=["South East"];      var Ghazni=["South East"];
            var Herat=["West"];         var Ghor=["West"];            var Baghlan=["North East"];
            var Kunduz=["North East"];   var Takhar=["North East"];     var Balkh=["North East"];
       		var Faryab=["North East"];   var Kapisa=["Central"];       var Logar=["Central"];
            var Panjshir=["Central"];   var Parwan=["Central"];       var Kunar=["East"];
            var Laghman=["East"];       var Nangarhar=["East"];       var Nuristan=["East"];
            var Badghis=["West"];       var Farah=["West"];           var Jowzjan=["North West"];
            var Samangan=["North West"]; var Bamyan=["West"];          var Kabul=["Central"];
            var SarePol=["North West"];  var Mazar=["North"];

			

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
                else if (pr== "Mazar")     var  array=Mazar;
               	else{}
				for (var i = 0; i < array.length; i++) 
                {
                   	var option = document.createElement("option");
                    option.value = array[i];
                    option.text = array[i];
                    RegionSelect.appendChild(option);
                }
  	}
	  var fruits = document.getElementById("Status"); [].slice.call(fruits.options).map(function(a){  if(this[a.value]){    fruits.removeChild(a);  } else {   this[a.value]=1;  }  } , {});

</script>

</div>
<?php  require_once '../App/partials/Footer.inc'; ?>
