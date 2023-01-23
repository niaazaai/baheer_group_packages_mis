<?php
session_start();
require_once 'Controller.php'; 
class CustomerController   
{


	public function CreateCustomer($Request , $Controller1)
	{		

			$CompanyName =  $Controller1->CleanInput($Request['companyName']); 
			$Catagory= $Controller1->CleanInput($Request['Catagory']); 
			$BusinessType= $Controller1->CleanInput($Request['businessType']); 
			$BusinessNature= $Controller1->CleanInput($Request['businessNature']); 
			$Specification= $Controller1->CleanInput($Request['Specification']); 
			$TimeLimit= $Controller1->CleanInput($Request['TimeLimit']); 
			$Province= $Controller1->CleanInput($Request['Province']); 
			$Region= $Controller1->CleanInput($Request['Region']); 
			$POC= $Controller1->CleanInput($Request['POC']); 
			$Branch= $Controller1->CleanInput($Request['Branch']); 
			$Name = $Controller1->CleanInput($Request['CPName']);
			$Whatsup = $Controller1->CleanInput($Request['whatsup']);
			$WorkPhone = $Controller1->CleanInput($Request['workphone']);
			$Email = $Controller1->CleanInput($Request['Email']);
			$Address = $Controller1->CleanInput($Request['Address']);
			$website = $Controller1->CleanInput($Request['website']);
			$Position = $Controller1->CleanInput($Request['Position']);
			$Mobile= $Controller1->CleanInput($Request['Mobile']);

		 
		 
			$message = []; 
			foreach ($Request as $Post => $value) if(empty($value)) array_push($message, " $Post Is Empty" );

			if(empty($message)) {

				$CUSTOMER = $Controller1->QueryData("INSERT INTO ppcustomer  ( 
						CustName, Custcatagory, BusinessType,
	 				 	BusinessNature, CusSpecification,
	 				 	Timelimit, CustWorkPhone, CustEmail, CustWebsite, CusProvince, CmpZone, 
	 				 	CustAddress,  CustContactPerson, CustPostion, CustMobile, CmpWhatsApp,
	 				 	CusReference, AgencyName,CusStatus ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,'Prospect') ",
	 				 [
	 				 	$CompanyName,
	 				 	$Catagory,
	 				 	$BusinessType,
	 				 	$BusinessNature,
	 				 	$Specification,
	 				 	$TimeLimit,
	 				 	$WorkPhone,
	 				 	$Email,
	 				 	$website,
	 				 	$Province,
	 				 	$Region, 
	 				 	$Address, 
	 				 	$Name,
	 				 	$Position,
	 				 	$Mobile,
	 				 	$Whatsup,
	 				 	$POC,
	 				 	$Branch
	 				 ]); 

			 	if($CUSTOMER) 
			 	{
					$message = ['User Added Successfully'];
				
					$message = implode(",",$message);  
			 	 	header("Location:CustomerList.php?message=$message&success=1"); 
			 	}
			 	else
			 	{
					$message = ['User Did Not Registered'];
					$message = implode(",",$message);
					header("Location:CustomerRegistrationForm.php?message=$message&success=0");
			 	} 
			 }
			 else 
			 {
				$message = implode(",",$message);
				$fields = implode(",",$Request);
			 	header("Location:CustomerRegistrationForm.php?message=$message&fields=$fields&success=0");
			 }
 	}


	
 	public function EditCustomer($Request,$Controller2  )
 	{
 		
			$CustId = $Controller2->CleanInput($Request['CustId']); 

			$CompanyName =  $Controller2->CleanInput($Request['companyName']); 
			$Catagory= $Controller2->CleanInput($Request['Catagory']); 
			$BusinessType= $Controller2->CleanInput($Request['businessType']); 
			$BusinessNature= $Controller2->CleanInput($Request['businessNature']); 
			$Specification= $Controller2->CleanInput($Request['Specification']); 
			$TimeLimit= $Controller2->CleanInput($Request['TimeLimit']); 
			$Province= $Controller2->CleanInput($Request['Province']); 
			$Region= $Controller2->CleanInput($Request['Region']); 
			$POC= $Controller2->CleanInput($Request['POC']); 
			$Branch= $Controller2->CleanInput($Request['Branch']); 
			$Name = $Controller2->CleanInput($Request['CPName']);
			$Whatsup = $Controller2->CleanInput($Request['whatsup']);
			$WorkPhone = $Controller2->CleanInput($Request['workphone']);
			$Email = $Controller2->CleanInput($Request['Email']);
			$Address = $Controller2->CleanInput($Request['Address']);
			$website = $Controller2->CleanInput($Request['website']);
			$Position = $Controller2->CleanInput($Request['Position']);
			$Mobile= $Controller2->CleanInput($Request['Mobile']);
			$Status=$Controller2->CleanInput($Request['Status']);
			$FollowupResponsible=$Controller2->CleanInput($Request['FollowupResponsible']);
			$Condition=$Controller2->CleanInput($Request['Condition']);	

		
			$message = []; 

			foreach ($Request as $Post => $value)
			{
				if(empty($value)) array_push($message, " $Post Is Empty" );
			}

   			if(strlen($CompanyName) < 3 || strlen($CompanyName) > 160) array_push($message, 'Comapnay name text size is bigger'); 

   			if(strlen($Name)<3 || strlen($Name)>120) array_push($message, 'Name range is bigger than database size');

			if(!filter_var((int)$Whatsup,FILTER_VALIDATE_INT))
			{
				array_push($message, 'Please Enter numeric value for whatsup');
			}
			

			if(!filter_var((int)$WorkPhone,FILTER_VALIDATE_INT))
			{
				array_push($message, 'Please Enter numeric value for workphone');
			}
			if(!filter_var((int)$Mobile,FILTER_VALIDATE_INT))
			{
				array_push($message, 'Please Enter numeric value for Mobile');
			}
			
			if(strlen($Email)<2 || strlen($Email)>70)
			{	
				array_push($message, 'Email letters size is biigger than DB');
			}
			
  		    if(strlen($Address)<2 || strlen($Address)>80)
  			{
  				array_push($message, 'Address text size is bigger than database size');
  			}

  			if(strlen($Position)<2 || strlen($Position)>150)
  			{
  			   array_push($message, 'The Position text  size is bigger than the database size');
  			}

  			if(strlen($website)<2 || strlen($website)>90)
  			{
  				array_push($message, 'websit text size bigger than the database size');
  			}
			 
			 if(empty($message))
			{
				$fur = (int)$FollowupResponsible; 
				$CUSTOMEREDIT = $Controller2->QueryData("UPDATE ppcustomer SET 
					CustName=?,
					Custcatagory=?,
					BusinessType=?,
					BusinessNature=?,
					CusSpecification=?,
					Timelimit=?,
					CustWorkPhone=?,
					CustEmail=?,
					CustWebsite=?, CusProvince=?, CmpZone=?, CustAddress=?, CustContactPerson=?, CustPostion=?, 
					CustMobile=?, CmpWhatsApp=?, CusReference=?, AgencyName=?, CusStatus=?,   FollowupResponsible=?,PPCondition = ?
					 WHERE CustId=?",
	 				 [
	 				 	$CompanyName,
	 				 	$Catagory,
	 				 	$BusinessType,
	 				 	$BusinessNature,
	 				 	$Specification,
	 				 	$TimeLimit,
	 				 	$WorkPhone,
	 				 	$Email,
	 				 	$website,
	 				 	$Province,
	 				 	$Region, 
	 				 	$Address, 
	 				 	$Name,
	 				 	$Position,
	 				 	$Mobile,
	 				 	$Whatsup,
	 				 	$POC,
	 				 	$Branch,
	 				 	$Status,
						$fur, 
						$Condition,
	 				 	$CustId  

	 				 ] ); 
						if($CUSTOMEREDIT)  {
							$message = ['Customer Information Updated Successfully'];
							$message = implode(",",$message);  
							header("Location:CustomerList.php?message=$message&success=1"); 
						}
						else
						{
							$message = ['User Did Not Registered'];
							$message = implode(",",$message);
							header("Location: CustomerEditForm.php?id=$CustId&message=$message&success=0");
						} 
					}
					else 
					{
						$message = implode(",",$message);
						$fields = implode(",",$Request);
						header("Location:CustomerEditForm.php?id=$CustId&message=$message&fields=$fields&success=0");
					}

 	}

	

	//  public function ExportPdf($data){


	// 	$pdf=new PDF();
	// 	$pdf->AddPage('L' , 'A4'  );
	// 	$pdf->SetFont('Arial','',10);
	// 	$pdf->WriteHTML( $htmlTable );
	// 	ob_start();
	// 	$pdf->Output();


	//  }
}

$CustomerControler = new CustomerController();
if(isset($_POST) && !empty($_POST))
{
	if(isset($_POST['SaveNewCustomer'])) $CustomerControler->CreateCustomer($_POST , $Controller); 
	if(isset($_POST['EditCust'])) $CustomerControler->EditCustomer( $_POST, $Controller);
} 

// if (isset($_GET) && !empty($_GET)) { 
//     if (isset($_GET['CustPrintId'])) {
    
// 		// $data = $CustomerControler->PrintPDF($Controller);
// 		// var_dump($data);
// 		// $CustomerControler->ExportPdf($data);
// 			// reference the Dompdf namespace
// 			// reference the Dompdf namespace

// 	}

// 	// $id = $_GET['id']; 

//  }  




 

?>