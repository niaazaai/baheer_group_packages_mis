<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!------ Include the above in your HEAD tag ---------->
<!DOCTYPE html>
<html>
<head>
    <title>Baheer Group</title>
</head>
<script type="text/javascript">
function f()
{
    window.print();
}
</script>
<body class="container register"  >
 
<style type="text/css">
.register
{
    background: -webkit-linear-gradient(left, #fff, #fff);
    margin-top: 1%;
    padding: 1%;
}

.register-left
{
    text-align: center;
    color: #fff;
    margin-top: 4%;
}

.register-left input
{
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    width: 60%;
    background: #f8f9fa;
    font-weight: bold;
    color: #383d41;
    margin-top: 30%;
    margin-bottom: 3%;
    cursor: pointer;
}

.register-right
{
    background: #fff;
     
    border-top-right-radius: 10% 10%;
    border-bottom-left-radius: 10% 10%;
}

.register-left img
{
    margin-top: 15%;
    margin-bottom: 5%;
    width: 25%;
    -webkit-animation: mover 2s infinite  alternate;
    animation: mover 1s infinite  alternate;
}

@-webkit-keyframes mover 
{
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}

@keyframes mover 
{
    0% { transform: translateY(0); }
    100% { transform: translateY(-20px); }
}

.register-left p
{
    font-weight: lighter;
    padding: 1%;
    margin-top: -9%;
}
.register .register-form
{
    padding: 4%;
    margin-top: 0%;
}

.btnRegister
{
    float: right;
    margin-top: 10%;
    border: none;
    border-radius: 1.5rem;
    padding: 2%;
    background: #0062cc;
    color: #fff;
    font-weight: 600;
    width: 50%;
    cursor: pointer;
}

.register .nav-tabs
{
    margin-top: 3%;
    border: none;
    background: #0062cc;
    border-radius: 1.5rem;
    width: 28%;
    float: right;
}

.register .nav-tabs .nav-link
{
    padding: 2%;
    height: 34px;
    font-weight: 600;
    color: #fff;
    border-top-right-radius: 1.5rem;
    border-bottom-right-radius: 1.5rem;
}

.register .nav-tabs .nav-link:hover
{
    border: none;
}

.register .nav-tabs .nav-link.active
{
    width: 100px;
    color: #0062cc;
    border: 2px solid #0062cc;
    border-top-left-radius: 1.5rem;
    border-bottom-left-radius: 1.5rem;
}

.register-heading
{
    text-align: center;
    margin-top: 8%;
    margin-bottom: -15%;
    color: #495057;
}

</style>
<?php
$con=mysqli_connect('localhost','root','','baheer');
if(!$con)
{
	die("Can't cannect with Database..!".mysqli_connect_error());
}

$Id=$_GET['id'];
$q="SELECT `SaleId`, `SaleCustomerId`, `SaleCartonId`, `SaleQty`, `SaleCurrency`, `SalePrice`, `SaleTotalPrice`, `SaleComment`, `SaleUserId`, `SaleDate`, carton.JobNo, ppcustomer.CustName,
 carton.ProductName, carton.CTNType, carton.CTNUnit, employeet.Ename FROM `cartonsales` INNER JOIN carton ON carton.CTNId=cartonsales.SaleCartonId INNER JOIN ppcustomer 
 ON ppcustomer.CustId=cartonsales.SaleCustomerId INNER JOIN employeet ON employeet.EId=cartonsales.SaleUserId WHERE SaleId = $Id ORDER BY SaleId DESC";
$q1=mysqli_query($con, $q);
$q2=mysqli_fetch_row($q1);
?>
                <div class="row">
                    <div class="col-md-12 register-right">
                        <div class="tab-content" id="myTabContent"  style="width:900px;" >
                            <form class="form-validate form-horizontal" enctype="multipart/form-data" id="feedback_form" method="post" action="NewCustomer.php">
                             <script type="text/javascript">
                                 function frr()
                                 {
                                      //window.location.replace('SearchOrder.php');
                                 }
                             </script>
                                <img src="../img/logo.png" height="100px" width="180px" align="center" style="padding-top: 10px; padding-bottom: 10px;" onmouseover="frr()"></img> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<font style=" font-size: 30px; color: #0505f2"><b><i>Baheer Printing & Packaging Co. Ltd  </i></b></font> 
                                <div align="left" class="row" style="display: flex; padding-left: 10px; padding-right: 10px;">
                                     <br>
                                     <div>
                                          <font style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                            <b> Invoice No:</b> &nbsp<span align="right"><?php echo $q2['JobNo'].'-'.$q2['SaleId'];?></span><br>
                                            <b> Company Name:</b> &nbsp<span align="right"><?php echo $q2['CustName'];?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   </span><br>
                                        
   
                                        </font>
         
                                </div>
                                <div style="width: 200px;"></div>
                                <div align="left"  >
                                <font style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                               
                                 <b>  Date: </b>&nbsp <span align="right"><?php echo $q2['SaleDate'];?></span><br>
                                  
                                 
                                 </font>
                             </div>
                                <div style="  width:100%;">
                                    <center><font style="font-size: 30px; font-weight: bolder; ">PKG finish goods sales Form </font></center>
                                   <!-- <center> <img src="../img/QuLogo.png" style="width: 250px; height: 40px;"></center> -->
                                 
                             <hr style="width: 100%; background-color: #32a8a4; height: 1px; padding-top: -3;">
                                </div>
                     <table id="myTable91" border="1"  onmouseover="fn121()" class="table1 table-hover1" style="  border-collapse: collapse;
                                   width: 100%; font-family: Arial, Helvetica, sans-serif; font-size: 15px; border: 1px; border-color: #f1f1f1f1">
                <tr  style="text-align: center; color:black; border-bottom-color: black; background: -webkit-linear-gradient(left, #000, #0505f2); height: 40px; " align='center'>
                                <th style="text-align: center; border-right-color: white; width:40px;"><font style="color: white; font-weight: bolder; ">#</font></th>
                                <th style="text-align: center; border-right-color: white;width:150px;"><font style="color: white; font-weight: bolder; ">Product Name</font></th>
                                <th style="text-align: center;border-right-color: white; width:150px;"><font style="color: white; font-weight: bolder; ">Unit</font></th>
                                <th style="text-align: center;border-right-color: white; width:120px;"><font style="color: white; font-weight: bolder; ">Quantity</font></th>
                                <th style="text-align: center;border-right-color: white; width:100px;"><font style="color: white; font-weight: bolder; ">Unit Price</font></th>
                                <th style="text-align: center;border-right-color: white; width:80px;"><font style="color: white; font-weight: bolder; ">Total Amount</font></th>
                                
                </tr>
                    <tr  style="text-align: center;   border-bottom-color: #f1f1f1f1;  height: 30px;" align='center'>
                      <td style="text-align: center; border-color:#000 ">1</td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['ProductName'].','. $q2['CTNType'].'Ply';?> </td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['CTNUnit'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SaleQty'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SalePrice'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SaleTotalPrice'].'-'.$q2['SaleCurrency'];?></td>
                        
                    </tr>
                     
                 
                     
                    <tr style="height:80px;">
                        <td colspan="9" style="border-color:#fff;"></td>
                    </tr>
                     <tr align="center"  style="margin-right: 10px;">
                         
                         <td colspan="2"  style="border-color:#fff; height: 20px; font-size: 20px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;">Prepared By:<?php echo $q2['Ename'];?></td>
                         <td style="border-color:#fff; height: 20px; font-size: 14px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;"></td>
                         <td colspan="3" style="border-color:#fff; height: 20px; font-size: 20px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;">Customer Signature</td>
                         
                    
                    </tr>
                     <tr>
                         <td colspan="9" style="border-color:#fff; height: 150px;"></td>
                     </tr>
                      <tr>
                         <td colspan="9" style="border-color:#fff; height: 60px;"><mark style=" background-color: yellow;color: black; font-weight:bolder;">Note:</mark> <?php echo $q2['SaleComment'];?></td>
                     </tr>
                
                   </table>
                   <p><font style="color: white;">........ <br>    </font></p>
                                       <!--  <input type="submit" class="btnRegister" onclick="fn();" required name="BtnSupplyer" value="Pdf"/> -->
                                    </div>


                                </div>
                            </div>

                           </form>
                        </div>
                    </div>
 
                     <div class="row">
                    <div class="col-md-12 register-right">
                        <div class="tab-content" id="myTabContent"  style="width:900px;" >
                            <form class="form-validate form-horizontal" enctype="multipart/form-data" id="feedback_form" method="post" action="NewCustomer.php">
                             <script type="text/javascript">
                                 function frr()
                                 {
                                      //window.location.replace('SearchOrder.php');
                                 }
                             </script>
                                <img src="../img/logo.png" height="100px" width="180px" align="center" style="padding-top: 10px; padding-bottom: 10px;" onmouseover="frr()"></img> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<font style=" font-size: 30px; color: #0505f2"><b><i>Baheer Printing & Packaging Co. Ltd  </i></b></font> 
                               <div align="left" class="row" style="display: flex; padding-left: 10px; padding-right: 10px;">
                                     <br>
                                     <div>
                                          <font style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                                          <b> Invoice No:</b> &nbsp<span align="right"><?php echo $q2['JobNo'].'-'.$q2['SaleId'];?></span><br>
                                        <b> Company Name:</b> &nbsp<span align="right"><?php echo $q2['CustName'];?> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp   </span><br>
                                        
   
                                        </font>
         
                                </div>
                                <div style="width: 200px;"></div>
                                <div align="left"  >
                                <font style="font-size: 14px; font-family: Arial, Helvetica, sans-serif;">
                               
                                <b>  Date: </b>&nbsp <span align="right"><?php echo $q2['SaleDate'];?></span><br>
                                  
                                 
                                 </font>
                             </div>
                                <div style="  width:100%;">
                                    <center><font style="font-size: 30px; font-weight: bolder; ">PKG finish goods sales Form </font></center>
                                   <!-- <center> <img src="../img/QuLogo.png" style="width: 250px; height: 40px;"></center> -->
                                 
                             <hr style="width: 100%; background-color: #32a8a4; height: 1px; padding-top: -3;">
                                </div>
                     <table id="myTable91" border="1"  onmouseover="fn121()" class="table1 table-hover1" style="  border-collapse: collapse;
                                   width: 100%; font-family: Arial, Helvetica, sans-serif; font-size: 15px; border: 1px; border-color: #f1f1f1f1">
                            <tr  style="text-align: center; color:black; border-bottom-color: black; background: -webkit-linear-gradient(left, #000, #0505f2); height: 40px; " align='center'>
                                <th style="text-align: center; border-right-color: white; width:40px;"><font style="color: white; font-weight: bolder; ">#</font></th>
                                <th style="text-align: center; border-right-color: white;width:150px;"><font style="color: white; font-weight: bolder; ">Product Name</font></th>
                                <th style="text-align: center;border-right-color: white; width:150px;"><font style="color: white; font-weight: bolder; ">Unit</font></th>
                                <th style="text-align: center;border-right-color: white; width:120px;"><font style="color: white; font-weight: bolder; ">Quantity</font></th>
                                <th style="text-align: center;border-right-color: white; width:100px;"><font style="color: white; font-weight: bolder; ">Unit Price</font></th>
                                <th style="text-align: center;border-right-color: white; width:80px;"> <font style="color: white; font-weight: bolder; ">Total Amount</font></th>
                                
                </tr>
                    <tr  style="text-align:   center; border-bottom-color: #f1f1f1f1; height: 30px;" align='center'>
                       <td style="text-align: center; border-color:#000 ">1</td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['ProductName'].','. $q2['CTNType'].'Ply';?> </td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['CTNUnit'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SaleQty'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SalePrice'];?></td>
                       <td style="text-align: center; border-color:#000 "><?php echo $q2['SaleTotalPrice'].'-'.$q2['SaleCurrency'];?></td>
                        
                    </tr>
                     

                     
                    <tr style="height:80px;">
                        <td colspan="9" style="border-color:#fff;"></td>
                    </tr>
                     <tr align="center"  style="margin-right: 10px;">
                         
                         <td colspan="2"  style="border-color:#fff; height: 20px; font-size: 20px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;">Prepared By:<?php echo $q2['Ename'];?></td>
                         <td style="border-color:#fff; height: 20px; font-size: 14px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;"></td>
                         <td colspan="3" style="border-color:#fff; height: 20px; font-size: 20px; text-align: center; font-family:Microsoft Uighur; margin-left: 5px;">Customer Signature</td>
                         
                    
                    </tr>
                     <tr>
                         <td colspan="9" style="border-color:#fff; height: 120px;"></td> 
                     </tr>
                      <tr>
                         <td colspan="9" style="border-color:#fff; height: 60px;"><mark style=" background-color: yellow;color: black; font-weight:bolder;">Note:</mark> <?php echo $q2['SaleComment'];?></td>
                     </tr>
                
                   </table>
                   <p><font style="color: white;">.......</font></p>
                                       <!--  <input type="submit" class="btnRegister" onclick="fn();" required name="BtnSupplyer" value="Pdf"/> -->
                                    </div>


                                </div>
                            </div>

                           </form>
                        </div>
                    </div>
                </div>

            </div>
            </body>
            <script type="text/javascript">
                function fn()
                {
                    window.print();
                }
            </script>
</html>

