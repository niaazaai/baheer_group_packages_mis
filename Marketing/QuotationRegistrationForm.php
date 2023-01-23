<?php    require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc'; error_reporting(0);  ?>  
<div class="m-3">

  <?php
 
$sql1="select * FROM `employeet` where `EUserName` = '". $_SESSION['user'] ."'";
         $res=mysqli_query($con, $sql1);
         $r1=mysqli_fetch_row($res);
         if ($r1[0]>5 && $r1[14]!='Marketing' && $r1[0]!=92 && $r1[0]!=63 && $r1[0]==85 && $r1[0]==20) 
         {
           echo "<script>window.location.replace('PkgDashboard.php');</script>";
         }
  $Com=$_POST['Stout'];
  if ($Com=='') 
  {
     $Com=$GET['Stout'];
  }
  $qr1="SELECT `CustId`, `CustName`, `CustName`, `CustContactPerson`, `CustMobile`, `CustEmail`, `CustAddress`, `CustWebsite`, `CustCatagory` FROM `ppcustomer` where `CustId`= '$Com' ";
    $row1=mysqli_query($con, $qr1);
    $no=1;
    $row31=mysqli_fetch_row($row1);
 ?>
  
 
 
 <style type="text/css">
 .overlay 
 {
  height: 0%;
  width: 100%;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0, 0.9);
  overflow-y: hidden;
  transition: 0.5s;
}

.overlay-content {
  position: relative;
  top: 25%;
  width: 100%;
  text-align: center;
  margin-top: 30px;
}

.overlay a {
  padding: 8px;
  text-decoration: none;
  font-size: 36px;
  color: #818181;
  display: block;
  transition: 0.3s;
}

.overlay a:hover, .overlay a:focus {
  color: #f1f1f1;
}

.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
}

@media screen and (max-height: 450px) {
  .overlay {overflow-y: auto;}
  .overlay a {font-size: 20px}
  .overlay .closebtn {
  font-size: 40px;
  top: 15px;
  right: 35px;
  }
}
  .container 
  {
  display: block;
  position: relative;
  padding-left: 50px;

  margin-bottom: 20px;
  height: 40px;
  width: 230px;
  cursor: pointer;
  font-size: 18px;
  
  -webkit-user-select:dropdown-content;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;

}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  object-position: 23px;
  top: 12;
  left: 0;
  height: 35px;
  width: 35px;
  border-color: #fff;
  border:2px;
  background-color: #ddd;
  border-width: 2px;
  border-radius:25px;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #3df007;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #3df007;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 15px;
  top: 1px;
  width: 10px;
  height: 25px;
  border: solid white;
  border-width: 0 4px 4px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}
 .form-control
   {
    height: 25px;
   }
   .form-control1
   {
    width: 150px;
    height: 30px;
    padding-left: 5px;
    margin-top: 5px;
    background-color: #fff;
     border-radius: 2%;

   }
     .form-control12
   {
    width: 150px;
    height: 30px;
    padding-left: 5px;
    margin-top: 5px;
    background-color: #fff;
     border-radius: 2%;
     background-color: #73AD21;
   }
   .form-control12:focus
 {
    width: 100px;
    height: 30px;
    padding-left: 5px;
    margin-top: 5px;
    background-color: #c6eb94;
    border-color: #33cccc;
}
  .form-control123
 {
    width: 150px;
    height: 30px;
    padding-left: 5px;
    margin-top: 5px;
    background-color: #e6e6e6;
    border-color: #33cccc;
}
.form-control1:focus
 {
    width: 150px;
    height: 30px;
    padding-left: 5px;
    margin-top: 5px;
    background-color: #73AD21;
    border-color: #33cccc;
}
 
  ::placeholder 
  {
  color:#ddd;
  opacity: 1;
    }
 </style>
 <script>
function openNav() {
  document.getElementById("myNav").style.height = "60%";
 
}

function closeNav() 
{
   document.getElementById("myNav").style.height = "0%";
   document.getElementById("PWeight").value='';
   document.getElementById("PWeight1").value='';
   document.getElementById("PWeight2").value='';
}
</script>


<div id="myNav" class="overlay" align="center">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <div class="overlay-content" align="center">
  <center> 
  <div class="col-lg-12">
    <table style="width:400px; " border="1">
    <tr style="background-color: #1a4a5a; font-weight: bold; font-size:14px; color: white;">
      <td  >Dieckle Size (cm)</td>
      <td>
        <select name="dickleno" id="dickleno" class="form-control12" style="width: 40px;" onchange="diklesize();">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>

        </select>
      </td>
      <td><input type="text"   name='Dickle' id="Dickle" readonly class="form-control123"></td>
<script type="text/javascript">
  function diklesize()
  { 
    CallAll();
   var n=document.getElementById("dickleno").value;
   var n1=document.getElementById("Dickle").value;
   var total5=n*n1;
   document.getElementById("Dickle").value=total5;
  }
</script>
    </tr>
  </table> 
</div>


<div class="col-sm-12" >
 <table style="width:400px; background-color: #fff;" border="1">
      <tr style="background-color: #1a4a5a; font-weight: bold; font-size:12px; color: white;" align="center">
        <td>Paper Name</td>
        <td>Paper Weight (Ton)</td>
         <td>Paper Name</td>
        <td>Total Weight (Ton)</td>
      </tr>
      <tr style="background-color:#999999;">
        <td>
        <input type="text"   name='PName1' id="PName1" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight' id="PWeight" readonly class="form-control"></td>
        <td><input type="text"   name='TotPaper' id="TotPaper" readonly class="form-control"></td>
        <td><input type="text" style="font-weight:bold; color:#000;"  name='totpaperw' id="totpaperw" readonly class="form-control"></td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName12' id="PName12" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight1' id="PWeight1" readonly class="form-control"></td>
        <td><input type="text"   name='TotPaper1' id="TotPaper1" readonly class="form-control"></td>
        <td><input type="text" style="font-weight:bold; color:#000;"  name='totpaperw1' id="totpaperw1" readonly class="form-control"></td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName13' id="PName13" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight2' id="PWeight2" readonly class="form-control"> </td>
           <td><input type="text"   name='TotPaper2' id="TotPaper2" readonly class="form-control"></td>
        <td><input type="text"  style="font-weight:bold; color:#000;" name='totpaperw2' id="totpaperw2" readonly class="form-control"></td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName14' id="PName14" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight3' id="PWeight3" readonly class="form-control"> </td>
         <td><input type="text"   name='TotPaper3' id="TotPaper3" readonly class="form-control"></td>
        <td><input type="text" style="font-weight:bold; color:#000;"  name='totpaperw3' id="totpaperw3" readonly class="form-control"></td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName15' id="PName15" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight4' id="PWeight4" readonly class="form-control"> </td>
         <td><input type="text"   name='TotPaper4' id="TotPaper4" readonly class="form-control"></td>
        <td><input type="text" style="font-weight:bold; color:#000;"  name='totpaperw4' id="totpaperw4" readonly class="form-control"></td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName16' id="PName16" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight5' id="PWeight5" readonly class="form-control"> </td>
      </tr>
        <tr style="background-color:#999999;">
        <td><input type="text"   name='PName71' id="PName71" readonly class="form-control"></td>
        <td><input type="text"   name='PWeight6' id="PWeight6" readonly class="form-control"></td>
      </tr>
       <tr style="background-color:#999999;">
        <td style="font-weight: bold; font-size:16px; color:#1a4a5a;" align="center" colspan="3"> Total</td>
        <td><input type="text" style="font-weight:bold; color:#000;"  name='PWeight7' id="PWeight7" readonly class="form-control"></td>
      </tr>
    </table>
  </div>
  </center>
    </div>
  </div>





<center>
                
                  <form class="form-validate form-horizontal" enctype="multipart/form-data" id="feedback_form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <?php 
                    $q="SELECT `Id`,  `PaperGSM`,`ExchangeRate`,`PolimerPrice` FROM `paperprice` ";
                    $r11=mysqli_query($con, $q);
                    $r1=mysqli_fetch_row($r11);
                    echo "<input type='hidden' name='op' value=$r1[1] id='op'>";
                    echo "<input type='hidden' name='op1' value=$r1[2] id='op1'>";
                    echo "<input type='hidden' name='op2' value=$r1[3] id='op2'>";
                    ?>
                    <br><br>
                    <p class="ppp4" style="width: 400px;">PKG Costing Form to <spane ><?php echo"<font style='color:yellow;'><input type='text' name='cmpname1' readonly style='background-color: #999999; color:white;' class='form-control' value='$row31[1]'></font>";?></spane></p>
                      <div class="row" style="width: 1300px;" >
                        
                        <a href="javascript:poptastic('PolySearch.php');"  title="Find Exist Polymer & Die " ><input type="button" name="BtnSearch"  value="Find Polymer" class="btn btn-default" style="height: 50px; width: 200px; font-size: 14px; font-weight: bold;"></a>
                        <a href="javascript:poptastic('DieSearch.php');" title="Record New Polymer & Die"><input type="button" name="BtnSearch"  value="Search Die" class="btn btn-default" style="height: 50px; width: 200px; font-size: 14px; font-weight: bold;"></a>
                          <a href="javascript:poptastic('../PaperStock/BalanceSheetPaper.php');"  title="Find Paper In Stock " ><input type="button" name="BtnSearch"  value="Check Stock" class="btn btn-default" style="height: 50px; width: 200px; font-size: 14px; font-weight: bold;"></a>
                           <input type="button"  onclick="openNav()" name="BtnSearch"  value="Paper Weight" class="btn btn-default" style="height: 50px; width: 200px; font-size: 14px; font-weight: bold;"> 
                          <a href="Customerlist2.php"  title="Find and select customer"><input type="button" name="BtnSearch" onclick="Customerlist2.php" value="Find Customer" class="btn btn-default" style="height: 50px; width: 200px; font-size: 14px; font-weight: bold;"></a>
                           <fieldset class="fieldset1">
                         <legend class="legend1">
                           <select name="jobType1"  style="width: 240px;" required >
                            <option value="" >Quotation Type</option>
                            <option value="Normal">New Quote</option>
                          </select>
                         </legend>
                      
                    <table border="0"  align="left" class="table1 table-hover1" style="border-radius: 25px;  border: 1px solid #f2f2f2;width: 100%; " onmouseover="CallAll()" >
                      <tr style="background-color:#606160; font-weight: bold; color: white;"><td><img scr='' height="0.2px;">customer info</td></tr>
                      <tr>
                        <?php
                          $q="SELECT `CTNId`, `CTNType`, `CustId1`, `JobNo`, `EmpId`, `CTNWidth`, `CTNHeight`, `CTNLength`, `CTNPrice`, `CTNTotalPrice`, `CTNOrderDate`, `CTNFinishDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`, `CTNColor`, `CTNPaper`, `CTNPolimarPrice`, `CTNDiePrice` , ppcustomer.CustName, ppcustomer.CustAddress, CtnCurrency, MarketingNote FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where JobNo!='NULL' ORDER BY carton.`CTNId` DESC ";
                          $q1=mysqli_query($con, $q);
                          $q2=mysqli_fetch_row($q1);
                        ?>
                        <td style="align:left; width:100px;"align="left">
                         Last Job No<span class="required">*</span> 
                      </td>
                      <td><input  class="form-control123" readonly <?php echo "value='$q2[3]'";?>  id="CustomerName"  name="CustomerName1" minlength="1" type="text" required  />
                        <input  class="form-control123" readonly <?php echo "value='$row31[0]'";?> id="CustomerName"  name="CustomerName" minlength="1" type="text" required style='display: none;' /></td>
                       <td  style=" width:100px;" align="right"> Job No<span class="required">*</span>   </td>
                       <td colspan=""><input class="form-control1"  id="PrJobNo" required name="PrJobNo" value="NULL" type="text"  placeholder="Job No" /></td>
                      <td style="width:100px;" align="right">Product Name</td>
                       <td  >
                         <input class="form-control1" id="DeName" placeholder="Product Name"  name="DeName" minlength="1" type="text" required  /></td>

                     
                       <td  style="  width:100px;" align="right"> Alert Date<span class="required">*</span>  </td>
                        
                       <td  ><input type="Date" class="form-control1" id="FinishDate"  name="FinishDate" minlength="1" type="text" required  /></td>
                        <td  style="width:100px;" align="right"> Grade<span class="required">*</span> </td>
              <td  >
                <input   class="form-control1" id="PaperGrade"  name="PaperGrade" minlength="1" type="text" required  />
          <!--  <select class="form-control1" name="PaperGrade" id="PaperGrade"   >
                      
if (isset($_POST['PaperGrade']))
 {
  $c=$_POST['PaperGrade'];
  echo "<option value='$c'>$c</option>";
}
?>
  <option>Paper Grade</option>
 
 

  $qq="SELECT `GName`, `GPrice` FROM `gradeprovince` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>$rr[0]</option>";
   }
 
                      </select> -->
                     </td> 
                     </tr>
<tr><td><img scr='' height="0.2px;"></td></tr>
                   </table>
                   
                      <table border="0" align="left" class="table1 table-hover1" style="  border: 1px solid #f2f2f2; width: 100%;" onmouseover="CallAll()" >
                        <tr style="background-color:#606160; font-weight: bold; color: white;"><td><img scr='' height="0.2px;">Size Info</td></tr>
                      <tr>
                        <td  align="left" style="width:100px;"> Unit<span class="required">*</span> </td>
                      <td   style="width: 100px;">
                      <select class="form-control1" id="CartonUnit"  name="CartonUnit"  >
                        <option >Select Unit</option>
                        <option value="Box">Box</option>
                        <option value="Sheet">Sheet</option>
                        <option value="Tray">Tray</option>
                        <option value="Separator">Separator</option>
                        <option value="Belt">Belt</option>
                      </select>
                      </td>
                      <td   style="width: 100px;" align="right">  QTY<span class="required">*</span> </td>
                      <td  ><input class="form-control1" id="CartonQTY"  placeholder="Quantity"    name="CartonQTY" minlength="1" type="text" required  /></td>
                      
              
                      <td style="width: 100px;" align="right"> Length<span class="required">*</span></label></td>
                      <td ><input class="form-control1"    id="PaperLength" placeholder="Lenght mm"  name="PaperLength" minlength="1" type="text" required  /></td>
                      
 
                      <td  style="width: 100px;" align="right"> Width<span class="required">*</span> </td>
                      <td  ><input class="form-control" style=" width:150px;"   id="PaperWidth" placeholder="Width mm" name="PaperWidth" minlength="1" type="text"  value=""  /></td>

                       <td  style="width: 100px;" align="right"> Height<span class="required">*</span> </td>
                      <td  ><input class="form-control1"   id="PaperHeight" placeholder="Height mm" name="PaperHeight" minlength="1" type="text" required  /></td>
                      </tr>
                      <tr  ><td><img scr='' height="0.2px;"> </td></tr>
                    </table>
                    <table border="0" align="left" class="table1 table-hover1" style="  border: 0px solid #f2f2f2;" onmouseover="CallAll()" >
                      <tr style="background-color:#606160; font-weight: bold; color: white;"><td><img scr='' height="0.2px;">Ply Info</td></tr>
                    <tr>
               
                      <td  style="border-top:0px; width: 100px;">
                        <select class="form-control12" onchange="fn3();" name="CartonType" id="CartonType" style="width: 100px;">
                        <option> Ply Type</option>
                        <option value="3">3-Ply</option>
                        <option value="5">5-Ply</option>
                        <option value="7">7-Ply</option>
                      </select>
                      <input type='text' name='cmpname1' readonly style='background-color: #999999; color:white; display: none;' class='form-control' <?php echo"value='$row31[1]'";?>>
                    </td>
                      <!--  <td style="width: 5px;border-top:0px;"> 
                       <input type="text" readonly value="L1" style="width: 40px;" class="form-control"> 
                      </td> -->

                      <td  style="border-top:0px; width: 100px;">
<select class="form-control1" onchange="" name="P0" id="p0" style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
   <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L1- $rr[0]</option>";
   }
  ?>
</select>
                      </td>
                     
                        <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P1" id="p1"  style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
  <!-- <option>Select L2</option> -->
  <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L2- $rr[0]</option>";
   }
  ?>
</select>
                      </td>
                     

                     

                   
                      
                        <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P2" id="p2" style="  display: none;">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
  <!-- <option>Select L3</option> -->
   <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L3- $rr[0]</option>";
   }
  ?>
</select>
                      </td>
                    
                        <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P3" id="p3" style="  display: none;">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
  <!-- <option>Select L4</option> -->
  <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L4- $rr[0]</option>";
   }
  ?>
</select>

                      <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P4" id="p4" style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
 
  <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L5- $rr[0]</option>";
   }
  ?>
</select>
                      </td>
                     
                   
                    
                      <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P5" id="p5" style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
  <!-- <option>Select L6</option> -->
   <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L6- $rr[0]</option>";
   }
  ?>
</select>
                      </td>
                     

                       <td  style="border-top:0px;">

                       <select class="form-control1" onchange="" name="P6" id="p6" style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
 
  <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L7- $rr[0]</option>";
   }
  ?>
</select>
                      
                   <td style="border-top:0px;"><!-- <button type="submit"  id="BtnSave" class="btn btn-primary" name="BtnSave" style="width: 120px;background-color: #73AD21;">Save</button> --></td>
                      </tr>
                      <tr>
                <td  style="border-top:0px;width: 100px;">
                </td>
                <td  style="border-top:0px;">
                      <input class="form-control12"  style=" display: none; " name="g0" id="g0" value="125"  minlength="0" type="text"   placeholder="GSM" /></td>

                       <td  style="border-top:0px;">
                      <input class="form-control12" style=" display: none; " value="125" name="g1" id="g1" name="" minlength="0" type="text"  placeholder="GSM"  /></td>
                         <td  style="border-top:0px;">
                      <input class="form-control12" style=" display: none; " name="g2" id="g2" minlength="0" type="text" value="125"  placeholder="GSM" /></td>
                       </td>
                     <td  style="border-top:0px;"><input placeholder="GSM" name="g3" id="g3" class="form-control12" style=" display: none;  " value="125" name="" minlength="0" type="text"/></td>
                     <td  style="border-top:0px;"><input class="form-control12" style=" display: none; " value="125" name="g4" id="g4" minlength="0" type="text" placeholder="GSM"   /></td>
                     <td  style="border-top:0px;"><input class="form-control12" value="125" style=" display: none; " name="g5" id="g5" minlength="0" type="text" placeholder="GSM" value="125"  /></td>
                     </td>
                     <td  style="border-top:0px;"><input class="form-control12" style=" display: none; " name="g6" id="g6" minlength="0" type="text" placeholder="GSM" value="125"  /></td>
                     <td  style="border-top:0px;"><input class="form-control12"  style=" display: none;" name="g7" id="g7" minlength="0" type="text" placeholder="GSM" value="125"  /></td>
                      <td  style="border-top:0px;"><input class="form-control1" style=" display: none;"  name="g8" id="g8" minlength="0" type="text" placeholder="GSM"   /></td>      
                      </tr>
                      <tr>

                    
                     
                      <td  style="border-top:0px;">

<select class="form-control1" onchange="" name="P7" id="p7" style=" display: none; ">
   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
  <option>Select L8</option>
  <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L8- $rr[0]</option>";
   }
  ?>
</select>
                      </td>

                      <td  style="border-top:0px;">

  <select class="form-control1" onchange="" name="P8" id="p8" style=" display: none; ">

   <?php
if (isset($_POST['catagorized']))
 {
  $c=$_POST['catagorized'];
  echo "<option value='$c'>$c</option>";
}
?>
 
   <?php
  $qq="SELECT DISTINCT `Name`,`Price` FROM `paperprice` ";
  $r=mysqli_query($con, $qq);
  while ($rr=mysqli_fetch_row($r))
   {
    echo "<option value='$rr[1]'>L9- $rr[0]</option>";
   }
  ?>
</select>
                      </td>                    
                    </tr>
                    <?php
                    if (isset($_POST['BtnSave']))
                     {
                      
                      $cp1=$_POST['cp1'];;
                      $cp2=$_POST['cp2'];
                      $cp3=$_POST['cp3'];
                      $cp4=$_POST['cp4'];
                      $cp5=$_POST['cp5'];
                      $cp6=$_POST['cp6'];
                      $cp7=$_POST['cp7'];
                      $cppr1=$_POST['P0'];
                      $cppr2=$_POST['P1'];
                      $cppr3=$_POST['P2'];
                      $cppr4=$_POST['P3'];
                      $cppr5=$_POST['P4'];
                      $cppr6=$_POST['P5'];
                      $cppr7=$_POST['P6'];
                      $exchangeUsd=$_POST['op1'];
                      $Emp=$_SESSION['user'];
                      $E="SELECT `EId`,`EUserName` FROM `employeet` where `EUserName`='$Emp'";
                      $Em= mysqli_query($con, $E);
                      $Empi=mysqli_fetch_row($Em);   
                      $CtnCurrency1=$_POST['CtnCurrency1'];                   
                      $CType=$_POST['CartonType'];
                      $CusId=$_POST['CustomerName'];
                      $Jobno=$_POST['PrJobNo'];
                      $CTwidth=$_POST['PaperWidth'];
                      $CTHeight=$_POST['PaperHeight'];
                      $CTLength=$_POST['PaperLength'];
                      if ($CtnCurrency1=='AFN')
                       {
                        $CTPrice=$_POST['PaperPriceAFN'];
                        $CTFinalPrice=$_POST['TotalPrice'];
                        $CTTotalPrice=$_POST['TotalPriceAfn'];
                        
                       }
                       else
                       {
                        
                        $chrate=$_POST['op1'];
                        $CTPrice=$_POST['PricePercarton'];
                        $CTFinalPrice=$_POST['TotalPriceD'];
                        $CTTotalPrice=$_POST['TotalPriceAfn']/$chrate;
                       }
                      
                      $CTOrderDate=$_POST['OrderDate'];
                      $CTFinishDate=$_POST['FinishDate'];
                      $CTStatus='New';
                      $CTQN=$_POST['CartonQTY'];
                      $CTNUnit1=$_POST['CartonUnit'];
                      $CTNColor1=$_POST['NoColor1'];  
                      $CTNPaper1=$_POST['txt_holderPaper'];
                      $CTNPolimar=$_POST['PolymerPrice'];
                      $CTNDie=$_POST['DiePrice'];
                      $PrName=$_POST['DeName'];
                      $Slott=$_POST['Slot'];
                      $DieCt=$_POST['DieCut'];
                      $Past1=$_POST['Pasting1'];
                      $Stich33=$_POST['Stich'];
                      $flexoprint=$_POST['flexoprint'];
                      $offesetprint=$_POST['offesetprint'];
                      $Flute33=$_POST['Flute'];
                      $PolymerId=$_POST['PlmerNo1'];
                      $DieNo=$_POST['DieNo'];
                      $jobType2=$_POST['jobType1'];
                      $Note1=$_POST['Note1'];
                      $Notemarket=$_POST['Notemarket'];
                      $PaperGrade=$_POST['PaperGrade'];
                      $qr="INSERT INTO `carton`(`CTNType`, `CustId1`, `JobNo`, `EmpId`, `CTNWidth`, `CTNHeight`, `CTNLength`, `CTNPrice`, `CTNTotalPrice`, `CTNOrderDate`, `CTNFinishDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,`CTNColor`, `CTNPaper`, `CTNPolimarPrice`, `CTNDiePrice`,`ProductName`,`FinalTotal`, `CSlotted`, `CDieCut`, `CPasting`, `CStitching`, flexop, offesetp, `CFluteType`, JobType , Note, CtnCurrency, GrdPrice, MarketingNote, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`, `Ctnp5`, `Ctnp6`, `Ctnp7`, `PaperP1`, `PaperP2`, `PaperP3`, `PaperP4`, `PaperP5`, `PaperP6`, `PaperP7`, `PexchangeUSD`) VALUES ('$CType', $CusId, '$Jobno', $Empi[0],  $CTwidth, $CTHeight, $CTLength , $CTPrice, $CTTotalPrice, '$CTOrderDate', '$CTFinishDate', '$CTStatus', $CTQN, '$CTNUnit1', '$CTNColor1', '$CTNPaper1', $CTNPolimar,$CTNDie, '$PrName',$CTFinalPrice, '$Slott', '$DieCt', '$Past1' , '$Stich33','$flexoprint', '$offesetprint', '$Flute33', '$jobType2', '$Note1', '$CtnCurrency1', '$PaperGrade', '$Notemarket', '$cp1', '$cp2', '$cp3', '$cp4', '$cp5', '$cp6', '$cp7', $cppr1, $cppr2, $cppr3, $cppr4, $cppr5, $cppr6, $cppr7, '$exchangeUsd')";

                       if (mysqli_query($con, $qr))
                            {
                               echo " <script>alert('New Order Saved!');</script>";
                               $SQ="SELECT Max(`CTNId`) FROM `carton`";
                               $res12=mysqli_query($con,$SQ);
                               $r10=mysqli_fetch_row($res12);
                               $Orderno=$r10[0];
                               $QuC="INSERT INTO `productionreport`(`RepCartonId`) VALUES ($Orderno)";
                               if (mysqli_query($con, $QuC))
                                  {
                                        
                                  }
       $sql1="select * FROM `employeet` where `EUserName` = '".$_SESSION['user']."'";
      $res=mysqli_query($con, $sql1);
      $r1=mysqli_fetch_row($res);
       if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
      {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } 
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } 
     else 
     {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
     $cmpname=$_POST['cmpname1'];
       $ins="INSERT INTO `notification1`(`NotDepartment`, `NotTitle`, `NotComment`, `NotUser`, `NotStatus`, `PCIP`, `NotUnit`) VALUES ('$r1[14]', 'New Quotation Given By $r1[1] to $cmpname', 'total amount of packages are $CTQN and total amount is $CTTotalPrice ', $r1[0], 'NotRead', '$ip', 'Sales & Marketing')";
       if($qr56=mysqli_query($con, $ins))
     {
         echo "<script type='text/javascript'> 
            window.location.replace('Quotation1.php');
                  </script>";
     }


                             
                           }
                            else
                            {
                              echo "$qr";
                            }
                     }
                    ?>
                    <?php
                    if (isset($_POST['BtnSavePrint']))
                     {
                       
                      $cp1=$_POST['cp1'];;
                      $cp2=$_POST['cp2'];
                      $cp3=$_POST['cp3'];
                      $cp4=$_POST['cp4'];
                      $cp5=$_POST['cp5'];
                      $cp6=$_POST['cp6'];
                      $cp7=$_POST['cp7'];
                      $cppr1=$_POST['P0'];
                      $cppr2=$_POST['P1'];
                      $cppr3=$_POST['P2'];
                      $cppr4=$_POST['P3'];
                      $cppr5=$_POST['P4'];
                      $cppr6=$_POST['P5'];
                      $cppr7=$_POST['P6'];
                      $exchangeUsd=$_POST['op1'];
                      $Emp=$_SESSION['user'];
                      $E="SELECT `EId`,`EUserName` FROM `employeet` where `EUserName`='$Emp'";
                      $Em= mysqli_query($con, $E);
                      $Empi=mysqli_fetch_row($Em);   
                      $CtnCurrency1=$_POST['CtnCurrency1'];                   
                      $CType=$_POST['CartonType'];
                      $CusId=$_POST['CustomerName'];
                      $Jobno=$_POST['PrJobNo'];
                      $CTwidth=$_POST['PaperWidth'];
                      $CTHeight=$_POST['PaperHeight'];
                      $CTLength=$_POST['PaperLength'];
                      if ($CtnCurrency1=='AFN')
                       {
                        $CTPrice=$_POST['PaperPriceAFN'];
                        $CTFinalPrice=$_POST['TotalPrice'];
                        $CTTotalPrice=$_POST['TotalPriceAfn'];
                        
                       }
                       else
                       {
                        
                        $chrate=$_POST['op1'];
                        $CTPrice=$_POST['PricePercarton'];
                        $CTFinalPrice=$_POST['TotalPriceD'];
                        $CTTotalPrice=$_POST['TotalPriceAfn']/$chrate;
                       }
                      

                      $CTOrderDate=$_POST['OrderDate'];
                      $CTFinishDate=$_POST['FinishDate'];
                      $CTStatus='New';
                      $CTQN=$_POST['CartonQTY'];
                      $CTNUnit1=$_POST['CartonUnit'];
                      $CTNColor1=$_POST['NoColor1'];  
                      $CTNPaper1=$_POST['txt_holderPaper'];
                      $CTNPolimar=$_POST['PolymerPrice'];
                      $CTNDie=$_POST['DiePrice'];
                      $PrName=$_POST['DeName'];
                      $Slott=$_POST['Slot'];
                      $DieCt=$_POST['DieCut'];
                      $Past1=$_POST['Pasting1'];
                      $Stich33=$_POST['Stich'];
                      $flexoprint=$_POST['flexoprint'];
                      $offesetprint=$_POST['offesetprint'];
                      $Flute33=$_POST['Flute'];
                      $PolymerId=$_POST['PlmerNo1'];
                      $DieNo=$_POST['DieNo'];
                      $jobType2=$_POST['jobType1'];
                      $Note1=$_POST['Note1'];
                      $Notemarket=$_POST['Notemarket'];
                      $PaperGrade=$_POST['PaperGrade'];
                      $qr="INSERT INTO `carton`(`CTNType`, `CustId1`, `JobNo`, `EmpId`, `CTNWidth`, `CTNHeight`, `CTNLength`, `CTNPrice`, `CTNTotalPrice`, `CTNOrderDate`, `CTNFinishDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,`CTNColor`, `CTNPaper`, `CTNPolimarPrice`, `CTNDiePrice`,`ProductName`,`FinalTotal`, `CSlotted`, `CDieCut`, `CPasting`, `CStitching`, flexop, offesetp, `CFluteType`, JobType , Note, CtnCurrency, GrdPrice, MarketingNote, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`, `Ctnp5`, `Ctnp6`, `Ctnp7`, `PaperP1`, `PaperP2`, `PaperP3`, `PaperP4`, `PaperP5`, `PaperP6`, `PaperP7`, `PexchangeUSD`) VALUES ('$CType', $CusId, '$Jobno', $Empi[0],  $CTwidth, $CTHeight, $CTLength , $CTPrice, $CTTotalPrice, '$CTOrderDate', '$CTFinishDate', '$CTStatus', $CTQN, '$CTNUnit1', '$CTNColor1', '$CTNPaper1', $CTNPolimar,$CTNDie, '$PrName',$CTFinalPrice, '$Slott', '$DieCt', '$Past1' , '$Stich33','$flexoprint', '$offesetprint', '$Flute33', '$jobType2', '$Note1', '$CtnCurrency1', '$PaperGrade', '$Notemarket', '$cp1', '$cp2', '$cp3', '$cp4', '$cp5', '$cp6', '$cp7', $cppr1, $cppr2, $cppr3, $cppr4, $cppr5, $cppr6, $cppr7, '$exchangeUsd')";

                       if (mysqli_query($con, $qr))
                            {
                               echo " <script>alert('New Order Saved!');</script>";
                               $SQ="SELECT Max(`CTNId`) FROM `carton`";
                               $res12=mysqli_query($con,$SQ);
                               $r10=mysqli_fetch_row($res12);
                               $Orderno=$r10[0];
                               $QuC="INSERT INTO `productionreport`(`RepCartonId`) VALUES ($Orderno)";
                               if (mysqli_query($con, $QuC))
                                  {
                                        
                                  }
      $sql1="select * FROM `employeet` where `EUserName` = '".$_SESSION['user']."'";
      $res=mysqli_query($con, $sql1);
      $r1=mysqli_fetch_row($res);
       if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
      {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
      } 
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
    {
       $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } 
     else 
     {
       $ip = $_SERVER['REMOTE_ADDR'];
     }
     $cmpname=$_POST['cmpname1'];
       $ins="INSERT INTO `notification1`(`NotDepartment`, `NotTitle`, `NotComment`, `NotUser`, `NotStatus`, `PCIP`, `NotUnit`) VALUES ('$r1[14]', 'New Quotation Given By $r1[1] to $cmpname', 'total amount of packages are $CTQN and total amount is $CTTotalPrice ', $r1[0], 'NotRead', '$ip', 'Sales & Marketing')";
       if($qr56=mysqli_query($con, $ins))
     {
         echo "<script type='text/javascript'> 
                             window.location.replace('Quotation1.php');
                  </script>";
     }
                               echo "<script type='text/javascript'> 
                             window.location.replace('Quo.php');
                                         </script>";
                           }
                            else
                            {
                              echo "$qr";
                            }
                     }
                    ?>
                    <tr style=" font-weight: bold; color: white;"><td><img scr='' height="0.2px;"></td></tr>
                    </table>
                    <br>
                      <table border="0" class="table1 table-hover1" align="left" style="width:fixed;border: 1px solid #f2f2f2; width: 100%; " onmouseover="CallAll()" >
                        <tr style="background-color:#606160; font-weight: bold; color: white;"><td><img scr='' height="0.2px;">Printing Info</td></tr>
            <tr>
             <td style="width:100px;">Slotted</td>
              <td style="width:100px;"> 
                <select class="form-control1" name="Slot"  >
                   <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
              <td style="width:100px;" align="right">Die Cut</td>
               <td align="right"> 
                <select class="form-control1" name="DieCut"  >
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
               <td style="width:100px;" align="right">Pasting</td>
               <td> 
                <select class="form-control1" name="Pasting1" >
                  <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
                <td style="width:100px;" align="right">Stitching</td>
                 <td> 
                <select class="form-control1" name="Stich"  >
                   <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
              
             <td style="width: 100px;" align="right">Flute Type</td>
               <td> 
                <select name="Flute" class="form-control1" required>
                  <option value="">Flute Type</option>
                  <option value="C">C</option>
                  <option value="B">B</option>
                  <option value="E">E</option>
                  <option value="BC">BC</option>
                  <option value="CE">CE</option>
                  <option value="BCB">BCB</option>
                </select>
              
              </td>
              
            </tr>
             <tr>
             <td style="width:100px;">Flexo Print</td>
              <td style="width:100px;"> 
                <select class="form-control1" name="flexoprint"  >
                   <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
               <td style="width:100px;" align="right">Offeset Print</td>
              <td style="width:100px;"> 
                <select class="form-control1" name="offesetprint"  >
                   <option value="No">No</option>
                  <option value="Yes">Yes</option>
                  
                </select> 
              </td>
            </tr>
            <tr ><td><img scr='' height="0.2px;"> </td></tr>
          </table>
                        <table border="0" class="table1 table-hover1" align="left" style=" padding-right: 10px; border: 1px solid #f2f2f2; width: 100%;" onmouseover="CallAll()" >
<tr style="background-color:#606160; font-weight: bold; color: white;"><td><img scr='' height="0.2px;">Price Info</td></tr>
            <tr>
               <td style="align:left; width: 100px;" align="left">Color  </td>
                      <td  align="left">
                        <select class="form-control1" name="NoColor1" id="NoColor1">
                        <option value="0" >No Color</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        
                      </select>
                    </td> 
               <td style="align:left; width: 100px;" align="left"> Polymer </td>
                      <td  align="left">
                        <select class="form-control1" name="NoColor" id="NoColor" onchange="PersonalPolymer()">
                        <option value="0" >Polymer Exist</option>
                        <option value="00" >Personal Polymer</option>
                        <option value="00" >Free Polymer </option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        
                      </select>
                    </td> 
                    <script type="text/javascript">
                      function PersonalPolymer()
                      {
                        var polymerno1= document.getElementById('NoColor').value;
                        if (polymerno1=='00')
                         {
                          var x='NULL';
                          document.getElementById('PlmerNo').value=x;
                         }
                         else if(polymerno1=='0')
                         {
                           document.getElementById('PlmerNo').value='';
                         }
                         else
                         {
                          var x='NULL';
                          document.getElementById('PlmerNo').value=x;
                         }
                      }
                    </script>
              <td  style="width:100px;" align="right"> Polymer Price  </td>
                       <td colspan=""><input class="form-control123" id="PolymerPrice"   name="PolymerPrice" minlength="1" type="text" required   /></td>
                       <td  style="width:100px;" align="right"> Die Price  </td>
                       <td  ><input class="form-control" id="DiePrice" placeholder="Die Price" style="width:150px;" name="DiePrice" minlength="1" type="text"   /></td>
                       <td  style="width:100px;" align="right">Manual:<input type="Checkbox" name="halfpolymer" id="halfpolymer" onclick="CallAll();"></td>
                       <td  >
                <input class="form-control1" id="polymerheight" placeholder="Height"  name="polymerheight" minlength="1" type="text"  style="width:75px;" />
                <input class="form-control1" id="polymerwidth" placeholder="Width"  name="polymerwidth" minlength="1" type="text"  style="width:70px; " />
                      <input class="form-control1" id="PlmerNo1" value='NULL' placeholder="Polymer Id No"  name="PlmerNo1" minlength="1" type="text"  style="width:75px;display: none;" />
                     <input class="form-control1" id="DieNo" placeholder="Die No"  name="DieNo" minlength="1" type="text"  style="width:70px;display: none;" /></td>
                        
            </tr>
            <tr style="  font-weight: bold; color: white;"><td><img scr='' height="0.2px;"> </td></tr>
          
                  <tr>
                     
                      <input class="form-control1" id="TotalPriceAfn" readonly name="TotalPriceAfn" minlength="1" type="text" required  style="display: none;"> 
                     <td style="width:100px; font-weight: bold;" align="right">U. Price AFN </td>
                       <td colspan=""><input class="form-control123" id="PaperPriceAFN" style="font-weight: bold;" readonly name="PaperPriceAFN" minlength="1" type="text" required  /></td>
                        <td  style="width:100px; font-weight: bold;" align="left"> Total AFN </td>
                       <td >

                        <input class="form-control123" id="TotalPrice" readonly  name="TotalPrice" minlength="1" type="text"  style="font-weight:bold;" /> 
                      </td>
                       <td  ><label class="control-label  " style="width:100px;">U Price USD<span class="required">*</span></label></td>
                      <td  ><input class="form-control123" id="PricePercarton" readonly  name="PricePercarton" minlength="1" type="text" required  /></td>
                      <td  ><label class="control-label  " style="width:100px;">Total USD<span class="required">*</span></label></td>
                       <td> <input class="form-control123" id="TotalPriceD"  readonly name="TotalPriceD" minlength="1" type="text"   /></td>
                       <td  ><label class="control-label  " style="width:100px;">Currency<span class="required">*</span></label></td>
                       <td>
                        <select class="form-control123" name="CtnCurrency1" id="CtnCurrency1" required>
                         <option value="">Select Currency</option>
                         <option value="AFN">AFN</option>
                         <option value="USD">USD</option>
                       </select>
                     </td>
                   </tr>
                   <tr>
                      
                       <td> <input class="form-control1" id="SubTotalPriceD"  readonly name="SubTotalPriceD" minlength="1" type="text" style="display:none;"></td>
                      
                    </tr>
          </table>
     <br><br><br>
                    
                    <table border="0" align="left" class="table1 table-hover1" style="  border: 1px solid #f2f2f2; width:100%;" onmouseover="CallAll()">
                      <tr style="  font-weight: bold; color: white;"><td colspan="6"><img scr='' height="0.2px;"></td></tr>
                      <tr align="left">
                        <td style="width:100px;">Note For Order Card:</td>
                        <td><textarea name="Note1"  style="height: 50px; width:925px;"></textarea> </td>
                        <td style="width:60px;"><button type="submit"  id="BtnSave"  name="BtnSave" class="btn btn-primary" style="height: 50px; width: 150px; font-size: 14px; font-weight: bold;">Save & Print</button> </td>
                      
                      </tr>
                      <tr>
                         <td style="width:100px;"> Note For Quotation:</td>
                        <td><textarea name="Notemarket"  style="height: 50px; width:925px;"></textarea> </td>
                          <td>
                            <button type="submit"  id="BtnSavePrint"  name="BtnSavePrint" class="btn btn-primary" style="height: 50px; width: 150px; font-size: 14px; font-weight: bold;">Save</button> 
                        </td>
                      </tr>
                    <tr style="  font-weight: bold; color: white;"><td colspan="6"><img scr='' height="0.2px;"></td></tr>
                    </table>
                      </fieldset>
                    </div>
                   
                      </div>

         <input type="hidden" name="txt_holderPaper" id="txt_holderPaper">
        <br>     
<br>
   <!--      <fieldset class="fieldset1">
            <legend class="legend1"  align='left'>Machine Info</legend>
            <table border="0" class=" table-hover" align="left" style="width:fixed;  " onmouseover="CallAll()" >
            <tr>
              <td style="width: 150px;" align="left"></td>
              <td style="width: 150px;" align="left" ><label class="container">Select Machines:</label></td>
         
            <td style="width: 150px;" >
              <label class="container">Plant
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
             <td style="width: 150px;" >
              <label class="container">New Flexo
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
             <td style="width: 150px;" >
              <label class="container">Old Flexo
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
             <td style="width: 150px;" >
              <label class="container">Glue Folder
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
             <td style="width: 150px;" >
              <label class="container">Other
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
             <td style="width: 150px;" >
              <label class="container">Glue Folder
  <input type="checkbox"  >
  <span class="checkmark"></span>
</label>
            </td>
         </tr>
         <tr>
            <td  align="center" colspan="8"><button type="submit"  id="BtnSave" class="btn btn-primary" name="BtnSave" style="width: 120px;">Save</button></td>
         </tr>
       </table>
     </fieldset> -->

</div>
 <?php
 
                      $s="select CURDATE()";
                      $d=mysqli_query($con, $s);
                      $dd=mysqli_fetch_row($d);
                      $da=$dd[0];
                      ?>
                       <td ><input class="form-control1" style="display: none;" type="Date" id="OrderDate" <?php echo"value='$da'";?> name="OrderDate" minlength="1" required  /></td>
 
                <input type="hidden" name="cp1" id="cp1">
                <input type="hidden" name="cp2" id="cp2">
                <input type="hidden" name="cp3" id="cp3">
                <input type="hidden" name="cp4" id="cp4">
                <input type="hidden" name="cp5" id="cp5">
                <input type="hidden" name="cp6" id="cp6">
                <input type="hidden" name="cp7" id="cp7">
                   
                  </form>
                  
 </div>

<script type="text/javascript">  
  function getText3() 
  {
  var textHolder = p0.options[p0.selectedIndex].text.slice(3);
  document.getElementById("cp1").value=textHolder;
  var textHolder1 = p1.options[p1.selectedIndex].text.slice(3);
  document.getElementById("cp2").value=textHolder1;
  var textHolder2 = p2.options[p2.selectedIndex].text.slice(3);
  document.getElementById("cp3").value=textHolder2;
  var Allpaper=textHolder+','+textHolder1+','+textHolder2;
  document.getElementById("txt_holderPaper").value = Allpaper;
  }
    function getText5() 
  {
  var textHolder = p0.options[p0.selectedIndex].text.slice(3);
  var textHolder1 = p1.options[p1.selectedIndex].text.slice(3);
  var textHolder2 = p2.options[p2.selectedIndex].text.slice(3);
  var textHolder3 = p3.options[p3.selectedIndex].text.slice(3);
  var textHolder4 = p4.options[p4.selectedIndex].text.slice(3);
  document.getElementById("cp1").value=textHolder;
  document.getElementById("cp2").value=textHolder1;
  document.getElementById("cp3").value=textHolder2;
  document.getElementById("cp4").value=textHolder3;
  document.getElementById("cp5").value=textHolder4;
  var Allpaper=textHolder+','+textHolder1+','+textHolder2+','+textHolder3+','+textHolder4;
  document.getElementById("txt_holderPaper").value = Allpaper;
  }
   function getText7() 
  {
  var textHolder = p0.options[p0.selectedIndex].text.slice(3);
  var textHolder1 = p1.options[p1.selectedIndex].text.slice(3);
  var textHolder2 = p2.options[p2.selectedIndex].text.slice(3);
  var textHolder3 = p3.options[p3.selectedIndex].text.slice(3);
  var textHolder4 = p4.options[p4.selectedIndex].text.slice(3);
  var textHolder5 = p5.options[p5.selectedIndex].text.slice(3);
  var textHolder6 = p6.options[p6.selectedIndex].text.slice(3);
  document.getElementById("cp1").value=textHolder;
  document.getElementById("cp2").value=textHolder1;
  document.getElementById("cp3").value=textHolder2;
  document.getElementById("cp4").value=textHolder3;
  document.getElementById("cp5").value=textHolder4;
  document.getElementById("cp6").value=textHolder5;
  document.getElementById("cp7").value=textHolder6;
  var Allpaper=textHolder+','+textHolder1+','+textHolder2+','+textHolder3+','+textHolder4+','+textHolder5+','+textHolder6;
  document.getElementById("txt_holderPaper").value = Allpaper;
  }

   function getText9() 
  {
  var textHolder = p0.options[p0.selectedIndex].text;
  var textHolder1 = p1.options[p1.selectedIndex].text;
  var textHolder2 = p2.options[p2.selectedIndex].text;
  var textHolder3 = p3.options[p3.selectedIndex].text;
  var textHolder4 = p4.options[p4.selectedIndex].text;
  var textHolder5 = p5.options[p5.selectedIndex].text;
  var textHolder6 = p6.options[p6.selectedIndex].text;
  var textHolder7 = p7.options[p7.selectedIndex].text;
  var textHolder8 = p8.options[p8.selectedIndex].text;
  var Allpaper=textHolder+','+textHolder1+','+textHolder2+','+textHolder3+','+textHolder4;
  document.getElementById("txt_holderPaper").value = Allpaper;
  }
</script>
 
  <script type="text/javascript"> 
    function CallAll()
    {

      var x=document.getElementById("CartonType").value;
      if (x=="3")
       {
        fn31();
        getText3();
       }
       else if (x=="5")
        {
          fn51();
          getText5();
        }
        else if (x=="7")
         {
          fn71();
          getText7();
         }
         else
         {
          fn91();
          getText9();
         }
    }
    function fn31()
    {
      var cur=document.getElementById("CtnCurrency1").value;
      var LenghtT1=document.getElementById("PaperLength").value-0;
      var widthT1=document.getElementById("PaperWidth").value-0;
      var height1=document.getElementById("PaperHeight").value-0;
      var gsm1=document.getElementById("g0").value-0;
      var gsm2=document.getElementById("g1").value-0;
      var gsm3=document.getElementById("g2").value-0;

      var un= document.getElementById("CartonUnit").value;

      if (un!='Box')
       {
          document.getElementById('PaperWidth').style.display='none';
          document.getElementById('PaperWidth').value='0';    
          var lenghtTo=document.getElementById('PaperLength').value-0;
          var heightTo=document.getElementById('PaperHeight').value-0;
          document.getElementById('DiePrice').style.display='';
       }
       else
       {
         document.getElementById('PaperWidth').style.display='';

         var lenghtTo=(LenghtT1*2+widthT1*2)+50;
         var heightTo=widthT1+height1; 
         document.getElementById('DiePrice').style.display='none';
         document.getElementById('DiePrice').value=0;
       }

      var colo=document.getElementById('NoColor').value-0;
      var changerate=document.getElementById("op1").value-0;
      var Area=lenghtTo*heightTo/100;
      var po=document.getElementById("op2").value-0;
      var checkboxvalue=document.getElementById("halfpolymer");
      var polymerheight=document.getElementById("polymerheight");
      var polymerwidth=document.getElementById("polymerwidth");
      if (checkboxvalue.checked ==true)
       {

        polymerheight.style.display='';
        polymerwidth.style.display='';
        var pheight=document.getElementById("polymerheight").value-0;
        var pwidth=document.getElementById("polymerwidth").value-0;
        var totalArea=pheight*pwidth/100;
        var polim1=colo*totalArea*po;
        var polim=polim1*changerate;
       }
     else
      {
        polymerwidth.style.display='none';
        polymerheight.style.display='none';
         var polim1=colo*Area*po;
         var polim=polim1*changerate;
      }
      var pprice1=polim.toLocaleString();
      if (cur=='USD')
       {
         document.getElementById("PolymerPrice").value=polim1.toFixed(2);
       }
       else
       {
         document.getElementById("PolymerPrice").value=polim.toFixed(0);
       }
      
      var Price1=(lenghtTo*heightTo*gsm1)/1000000;
      var Price2=(lenghtTo*heightTo*gsm2)/1000000;
      var Price3=(lenghtTo*heightTo*gsm3)/1000000;
      var TPrice=Price1+Price2+Price3;

      var percent0=Price1*10/100;
      var percent1=Price2*10/100;
      var percent2=Price3*10/100;
      //var percent=percent0+percent1+percent2;
      var paperprice1=document.getElementById("p0").value-0;
      var paperprice2=document.getElementById("p1").value-0;
      var paperprice3=document.getElementById("p2").value-0;
      var West0=percent0+Price1;
      var West1=percent1+Price2;
      var West2=percent2+Price3;
      var ext=document.getElementById("op").value-0;
      var finalp=paperprice1/1000000*West0;
      var finalp1=paperprice2/1000000*West1*ext;
      var finalp2=paperprice3/1000000*West2;
      var TotalFinal=finalp+finalp1+finalp2;
      var b=document.getElementById("PaperGrade").value-0;
      var ben=TotalFinal*b/100;
      var PerCartonPrice=TotalFinal+ben;
      
      var tt=document.getElementById("PricePercarton").value=PerCartonPrice.toFixed(3);
      var ToAfn=tt*changerate;
    
      
      var n=document.getElementById("PaperPriceAFN").value=ToAfn.toFixed(2);
      var CTQTY=document.getElementById("CartonQTY").value;
      var AllCartonPrice=CTQTY*n;
      document.getElementById("TotalPriceAfn").value=AllCartonPrice.toFixed(3);
        if (cur=='USD')
       {
         var dii=document.getElementById("DiePrice").value-0;
         var di=dii*changerate.toFixed(1);
       }
       else
       {
        var di=document.getElementById("DiePrice").value-0;
       }
      
      var T=AllCartonPrice+polim+di;
      var t1= T.toLocaleString();
      var Td=document.getElementById("TotalPrice").value=T.toFixed(1);
      
      var usdtotal=Td/changerate;
      var usdtotal1=usdtotal.toLocaleString();
      document.getElementById("TotalPriceD").value=usdtotal.toFixed(1);
      var pname=p0.options[p0.selectedIndex].text;
      var Tlength=lenghtTo*0.1;
      var Thight=heightTo*0.1;
      var Tarea=Tlength*Thight*0.0001;
      var Clength=(Tarea*gsm1*CTQTY*0.001)/1000;
      document.getElementById("PWeight").value=Clength.toFixed(5);
      var paper1=p0.options[p0.selectedIndex].text;
      document.getElementById("PName1").value=paper1;

      var Tlength1=lenghtTo*0.1;
      var Thight1=heightTo*0.1;
      var Tarea1=Tlength*Thight*0.0001;
      var Clength1=(Tarea*gsm2*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight1").value=Clength1.toFixed(5);
      var paper12=p1.options[p1.selectedIndex].text;
      document.getElementById("PName12").value=paper12;

      var Tlength2=lenghtTo*0.1;
      var Thight2=heightTo*0.1;
      var Tarea2=Tlength*Thight*0.0001;
      var Clength2=(Tarea*gsm3*CTQTY*0.001)/1000;
      document.getElementById("PWeight2").value=Clength2.toFixed(5);
      var paper13=p2.options[p2.selectedIndex].text;
      document.getElementById("PName13").value=paper13;
      var dikle=(widthT1+height1)*0.1;
      document.getElementById("Dickle").value=dikle;
      var tota=Clength+Clength1+Clength2;
     document.getElementById("PWeight7").value=tota.toFixed(3);
       var no=0;
      var totflute=0;
     if (paper1=='L1- Flute') {no=no+1; totflute=Clength; } else {document.getElementById('TotPaper').value=paper1.slice(3); document.getElementById("totpaperw").value=Clength.toFixed(5);}
     if (paper13=='L3- Flute') {no=no+1; totflute=totflute+Clength2;} else {document.getElementById('TotPaper1').value=paper13.slice(3); document.getElementById("totpaperw1").value=Clength2.toFixed(5);}
      
     
     if (paper12=='L2- Flute') {no=no+1; totflute=totflute+Clength1;} 
     
     var no1=no;
     document.getElementById("TotPaper4").value=no+"F";
     document.getElementById("totpaperw4").value=totflute.toFixed(5);
    }
     function fn51()
    {
      var cur=document.getElementById("CtnCurrency1").value;
      var LenghtT1=document.getElementById("PaperLength").value-0;
      var widthT1=document.getElementById("PaperWidth").value-0;
      var height1=document.getElementById("PaperHeight").value-0;
      var gsm1=document.getElementById("g0").value-0;
      var gsm2=document.getElementById("g1").value-0;
      var gsm3=document.getElementById("g2").value-0;
      var gsm4=document.getElementById("g3").value-0;
      var gsm5=document.getElementById("g4").value-0;
      var un= document.getElementById("CartonUnit").value;

      if (un!='Box')
       {
        document.getElementById('PaperWidth').style.display='none';
          document.getElementById('PaperWidth').value='0';    
          var lenghtTo=document.getElementById('PaperLength').value-0;
          var heightTo=document.getElementById('PaperHeight').value-0;
         document.getElementById('DiePrice').style.display='';
         
       }
       else
       {
         document.getElementById('PaperWidth').style.display='';
         var lenghtTo=(LenghtT1*2+widthT1*2)+50;
         var heightTo=widthT1+height1;
         document.getElementById('DiePrice').style.display='none';
         document.getElementById('DiePrice').value=0;
       }
      var colo=document.getElementById('NoColor').value-0;
      var changerate=document.getElementById("op1").value-0;
      var Area=lenghtTo*heightTo/100;
      var po=document.getElementById("op2").value-0;
      var checkboxvalue=document.getElementById("halfpolymer");
      var polymerheight=document.getElementById("polymerheight");
      var polymerwidth=document.getElementById("polymerwidth");
      if (checkboxvalue.checked ==true)
       {

        polymerheight.style.display='';
        polymerwidth.style.display='';
        var pheight=document.getElementById("polymerheight").value-0;
        var pwidth=document.getElementById("polymerwidth").value-0;
        var totalArea=pheight*pwidth/100;
        var polim1=colo*totalArea*po;
        var polim=polim1*changerate;
       }
     else
      {
        polymerwidth.style.display='none';
        polymerheight.style.display='none';
         var polim1=colo*Area*po;
         var polim=polim1*changerate;
      }
      var pprice1=polim.toLocaleString();
      if (cur=='USD')
       {
         document.getElementById("PolymerPrice").value=polim1.toFixed(2);
       }
       else
       {
         document.getElementById("PolymerPrice").value=polim.toFixed(0);
       }
      var Price1=(lenghtTo*heightTo*gsm1)/1000000;
      var Price2=(lenghtTo*heightTo*gsm2)/1000000;
      var Price3=(lenghtTo*heightTo*gsm3)/1000000;
      var Price4=(lenghtTo*heightTo*gsm4)/1000000;
      var Price5=(lenghtTo*heightTo*gsm5)/1000000;
      var TPrice=Price1+Price2+Price3+Price4+Price5;

      var percent0=Price1*10/100;
      var percent1=Price2*10/100;
      var percent2=Price3*10/100;
      var percent3=Price4*10/100;
      var percent4=Price5*10/100;
      //var percent=percent0+percent1+percent2;
      var paperprice1=document.getElementById("p0").value-0;
      var paperprice2=document.getElementById("p1").value-0;
      var paperprice3=document.getElementById("p2").value-0;
      var paperprice4=document.getElementById("p3").value-0;
      var paperprice5=document.getElementById("p4").value-0;
      var West0=percent0+Price1;
      var West1=percent1+Price2;
      var West2=percent2+Price3;
      var West3=percent3+Price4;
      var West4=percent4+Price5;
      var ext=document.getElementById("op").value-0;
      var finalp=paperprice1/1000000*West0;
      var finalp1=paperprice2/1000000*West1*ext;
      var finalp2=paperprice3/1000000*West2;
      var finalp3=paperprice4/1000000*West3*ext;
      var finalp4=paperprice5/1000000*West4;
      var TotalFinal=finalp+finalp1+finalp2+finalp3+finalp4;
      var b=document.getElementById("PaperGrade").value-0;
      var ben=TotalFinal*b/100;
      var PerCartonPrice=TotalFinal+ben;
      
     var tt=document.getElementById("PricePercarton").value=PerCartonPrice.toFixed(3);
      var ToAfn=tt*changerate;
      var n=document.getElementById("PaperPriceAFN").value=ToAfn.toFixed(2);
      var CTQTY=document.getElementById("CartonQTY").value;
      var AllCartonPrice=CTQTY*n;
       document.getElementById("TotalPriceAfn").value=AllCartonPrice.toFixed(3);
        if (cur=='USD')
       {
         var dii=document.getElementById("DiePrice").value-0;
         var di=dii*changerate.toFixed(1);
       }
       else
       {
        var di=document.getElementById("DiePrice").value-0;
       }
      
      var T=AllCartonPrice+polim+di;
      var t1= T.toLocaleString();
      var Td=document.getElementById("TotalPrice").value=T.toFixed(1);
      
      var usdtotal=Td/changerate;
      var usdtotal1=usdtotal.toLocaleString();
      document.getElementById("TotalPriceD").value=usdtotal.toFixed(1);
       

     var Tlength=lenghtTo*0.1;
      var Thight=heightTo*0.1;
      var Tarea=Tlength*Thight*0.0001;
      var Clength=(Tarea*gsm1*CTQTY*0.001)/1000;
      document.getElementById("PWeight").value=Clength.toFixed(5);
      var paper1=p0.options[p0.selectedIndex].text;
      document.getElementById("PName1").value=paper1;

      var Tlength1=lenghtTo*0.1;
      var Thight1=heightTo*0.1;
      var Tarea1=Tlength*Thight*0.0001;
      var Clength1=(Tarea*gsm2*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight1").value=Clength1.toFixed(5);
      var paper12=p1.options[p1.selectedIndex].text;
      document.getElementById("PName12").value=paper12;

      var Tlength2=lenghtTo*0.1;
      var Thight2=heightTo*0.1;
      var Tarea2=Tlength*Thight*0.0001;
      var Clength2=(Tarea*gsm3*CTQTY*0.001)/1000;
      document.getElementById("PWeight2").value=Clength2.toFixed(5);
      var paper13=p2.options[p2.selectedIndex].text;
      document.getElementById("PName13").value=paper13;
      
      
      var Tlength3=lenghtTo*0.1;
      var Thight3=heightTo*0.1;
      var Tarea3=Tlength*Thight*0.0001;
      var Clength3=(Tarea3*gsm4*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight3").value=Clength3.toFixed(5);
      var paper14=p3.options[p3.selectedIndex].text;
      document.getElementById("PName14").value=paper14;

      var Tlength4=lenghtTo*0.1;
      var Thight4=heightTo*0.1;
      var Tarea4=Tlength*Thight*0.0001;
      var Clength4=(Tarea4*gsm5*CTQTY*0.001)/1000;
      document.getElementById("PWeight4").value=Clength4.toFixed(5);
      var paper15=p4.options[p4.selectedIndex].text;
      document.getElementById("PName15").value=paper15;
      
      var dikle=(widthT1+height1)*0.1;
      document.getElementById("Dickle").value=dikle;
       var tota=Clength+Clength1+Clength2+Clength3+Clength4;
     document.getElementById("PWeight7").value=tota.toFixed(3);

       var no=0;
      var totflute=0;
     if (paper1=='L1- Flute') {no=no+1; totflute=Clength; } else {document.getElementById('TotPaper').value=paper1.slice(3); document.getElementById("totpaperw").value=Clength.toFixed(5);}
     if (paper13=='L3- Flute') {no=no+1; totflute=totflute+Clength2;} else {document.getElementById('TotPaper1').value=paper13.slice(3); document.getElementById("totpaperw1").value=Clength2.toFixed(5);}
     if (paper15=='L5- Flute') {no=no+1; totflute=totflute+Clength4;} else {document.getElementById('TotPaper2').value=paper15.slice(3); document.getElementById("totpaperw2").value=Clength4.toFixed(5);}
      
     if (paper12=='L2- Flute') {no=no+1; totflute=totflute+Clength1;} 
     if (paper14=='L4- Flute') {no=no+1; totflute=totflute+Clength3;} 
     
     var no1=no;
     document.getElementById("TotPaper4").value=no+"F";
     document.getElementById("totpaperw4").value=totflute.toFixed(5);
    }
    function fn71()
    {
      var cur=document.getElementById("CtnCurrency1").value;
      var LenghtT1=document.getElementById("PaperLength").value-0;
      var widthT1=document.getElementById("PaperWidth").value-0;
      var height1=document.getElementById("PaperHeight").value-0;
      var gsm1=document.getElementById("g0").value-0;
      var gsm2=document.getElementById("g1").value-0;
      var gsm3=document.getElementById("g2").value-0;
      var gsm4=document.getElementById("g3").value-0;
      var gsm5=document.getElementById("g4").value-0;
      var gsm6=document.getElementById("g5").value-0;
      var gsm7=document.getElementById("g6").value-0;
          var un= document.getElementById("CartonUnit").value;

     if (un!='Box')
       {
        document.getElementById('PaperWidth').style.display='none';
          document.getElementById('PaperWidth').value='0';    
          var lenghtTo=document.getElementById('PaperLength').value-0;
          var heightTo=document.getElementById('PaperHeight').value-0;
          document.getElementById('DiePrice').style.display='';
         
       }
       else
       {
         document.getElementById('PaperWidth').style.display='';
         var lenghtTo=(LenghtT1*2+widthT1*2)+50;
         var heightTo=widthT1+height1;
         document.getElementById('DiePrice').style.display='none';
         document.getElementById('DiePrice').value=0;
         
       }
      var colo=document.getElementById('NoColor').value-0;
      var changerate=document.getElementById("op1").value-0;
      var Area=lenghtTo*heightTo/100;
      var po=document.getElementById("op2").value-0;
      var checkboxvalue=document.getElementById("halfpolymer");
      var polymerheight=document.getElementById("polymerheight");
      var polymerwidth=document.getElementById("polymerwidth");
      if (checkboxvalue.checked ==true)
       {

        polymerheight.style.display='';
        polymerwidth.style.display='';
        var pheight=document.getElementById("polymerheight").value-0;
        var pwidth=document.getElementById("polymerwidth").value-0;
        var totalArea=pheight*pwidth/100;
        var polim1=colo*totalArea*po;
        var polim=polim1*changerate;
       }
     else
      {
        polymerwidth.style.display='none';
        polymerheight.style.display='none';
         var polim1=colo*Area*po;
         var polim=polim1*changerate;
      }
      var pprice1=polim.toLocaleString();
      if (cur=='USD')
       {
         document.getElementById("PolymerPrice").value=polim1.toFixed(2);
       }
       else
       {
         document.getElementById("PolymerPrice").value=polim.toFixed(0);
       }
      var Price1=(lenghtTo*heightTo*gsm1)/1000000;
      var Price2=(lenghtTo*heightTo*gsm2)/1000000;
      var Price3=(lenghtTo*heightTo*gsm3)/1000000;
      var Price4=(lenghtTo*heightTo*gsm4)/1000000;
      var Price5=(lenghtTo*heightTo*gsm5)/1000000;
      var Price6=(lenghtTo*heightTo*gsm6)/1000000;
      var Price7=(lenghtTo*heightTo*gsm7)/1000000;
      var TPrice=Price1+Price2+Price3+Price4+Price5+Price6+Price7;

      var percent0=Price1*10/100;
      var percent1=Price2*10/100;
      var percent2=Price3*10/100;
      var percent3=Price4*10/100;
      var percent4=Price5*10/100;
      var percent5=Price6*10/100;
      var percent6=Price7*10/100;
      //var percent=percent0+percent1+percent2;
      var paperprice1=document.getElementById("p0").value-0;
      var paperprice2=document.getElementById("p1").value-0;
      var paperprice3=document.getElementById("p2").value-0;
      var paperprice4=document.getElementById("p3").value-0;
      var paperprice5=document.getElementById("p4").value-0;
      var paperprice6=document.getElementById("p5").value-0;
      var paperprice7=document.getElementById("p6").value-0;
      var West0=percent0+Price1;
      var West1=percent1+Price2;
      var West2=percent2+Price3;
      var West3=percent3+Price4;
      var West4=percent4+Price5;
      var West5=percent5+Price6;
      var West6=percent6+Price7;
      var ext=document.getElementById("op").value-0;
      var finalp=paperprice1/1000000*West0;
      var finalp1=paperprice2/1000000*West1*ext;
      var finalp2=paperprice3/1000000*West2;
      var finalp3=paperprice4/1000000*West3*ext;
      var finalp4=paperprice5/1000000*West4;
      var finalp5=paperprice6/1000000*West5*ext;
      var finalp6=paperprice7/1000000*West6;
      var TotalFinal=finalp+finalp1+finalp2+finalp3+finalp4+finalp5+finalp6;
      var b=document.getElementById("PaperGrade").value-0;
      var ben=TotalFinal*b/100;
      var PerCartonPrice=TotalFinal+ben;


     var tt=document.getElementById("PricePercarton").value=PerCartonPrice.toFixed(3);
      var ToAfn=tt*changerate;
      var n=document.getElementById("PaperPriceAFN").value=ToAfn.toFixed(3);
      var CTQTY=document.getElementById("CartonQTY").value;
      var AllCartonPrice=CTQTY*n;
    document.getElementById("TotalPriceAfn").value=AllCartonPrice.toFixed(3);
        if (cur=='USD')
       {
         var dii=document.getElementById("DiePrice").value-0;
         var di=dii*changerate.toFixed(1);
       }
       else
       {
        var di=document.getElementById("DiePrice").value-0;
       }
      
      var T=AllCartonPrice+polim+di;
      var t1= T.toLocaleString();
      var Td=document.getElementById("TotalPrice").value=T.toFixed(1);
      
      var usdtotal=Td/changerate;
      var usdtotal1=usdtotal.toLocaleString();
      document.getElementById("TotalPriceD").value=usdtotal.toFixed(1);
       var Tlength=lenghtTo*0.1;
      var Thight=heightTo*0.1;
      var Tarea=Tlength*Thight*0.0001;
      var Clength=(Tarea*gsm1*CTQTY*0.001)/1000;
      document.getElementById("PWeight").value=Clength.toFixed(5);
      var paper1=p0.options[p0.selectedIndex].text;
      document.getElementById("PName1").value=paper1;

      var Tlength1=lenghtTo*0.1;
      var Thight1=heightTo*0.1;
      var Tarea1=Tlength*Thight*0.0001;
      var Clength1=(Tarea*gsm2*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight1").value=Clength1.toFixed(5);
      var paper12=p1.options[p1.selectedIndex].text;
      document.getElementById("PName12").value=paper12;

      var Tlength2=lenghtTo*0.1;
      var Thight2=heightTo*0.1;
      var Tarea2=Tlength*Thight*0.0001;
      var Clength2=(Tarea*gsm3*CTQTY*0.001)/1000;
      document.getElementById("PWeight2").value=Clength2.toFixed(5);
      var paper13=p2.options[p2.selectedIndex].text;
      document.getElementById("PName13").value=paper13;
      
      
      var Tlength3=lenghtTo*0.1;
      var Thight3=heightTo*0.1;
      var Tarea3=Tlength*Thight*0.0001;
      var Clength3=(Tarea3*gsm4*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight3").value=Clength3.toFixed(5);
      var paper14=p3.options[p3.selectedIndex].text;
      document.getElementById("PName14").value=paper14;

      var Tlength4=lenghtTo*0.1;
      var Thight4=heightTo*0.1;
      var Tarea4=Tlength*Thight*0.0001;
      var Clength4=(Tarea4*gsm5*CTQTY*0.001)/1000;
      document.getElementById("PWeight4").value=Clength4.toFixed(5);
      var paper15=p4.options[p4.selectedIndex].text;
      document.getElementById("PName15").value=paper15;

      var Tlength5=lenghtTo*0.1;
      var Thight5=heightTo*0.1;
      var Tarea5=Tlength*Thight*0.0001;
      var Clength5=(Tarea5*gsm6*ext*CTQTY*0.001)/1000;
      document.getElementById("PWeight5").value=Clength5.toFixed(5);
      var paper16=p5.options[p5.selectedIndex].text;
      document.getElementById("PName16").value=paper16;

      var Tlength6=lenghtTo*0.1;
      var Thight6=heightTo*0.1;
      var Tarea6=Tlength*Thight*0.0001;
      var Clength6=(Tarea6*gsm7*CTQTY*0.001)/1000;
      document.getElementById("PWeight6").value=Clength6.toFixed(5);
      var paper17=p6.options[p6.selectedIndex].text;
      document.getElementById("PName71").value=paper17;
      
      var dikle=(widthT1+height1)*0.1;
      document.getElementById("Dickle").value=dikle;
      var tota=Clength+Clength1+Clength2+Clength3+Clength4+Clength5+Clength6;
     document.getElementById("PWeight7").value=tota.toFixed(3);
      var no=0;
      var totflute=0;
     if (paper1=='L1- Flute') {no=no+1; totflute=Clength; } else {document.getElementById('TotPaper').value=paper1.slice(3); document.getElementById("totpaperw").value=Clength.toFixed(5);}
     if (paper13=='L3- Flute') {no=no+1; totflute=totflute+Clength2;} else {document.getElementById('TotPaper1').value=paper13.slice(3); document.getElementById("totpaperw1").value=Clength2.toFixed(5);}
     if (paper15=='L5- Flute') {no=no+1; totflute=totflute+Clength4;} else {document.getElementById('TotPaper2').value=paper15.slice(3); document.getElementById("totpaperw2").value=Clength4.toFixed(5);}
     var papper1=paper1.slice(3); var papper7=paper17.slice(3);
     if (paper17=='L7- Flute') {no=no+1; totflute=totflute+Clength6;}   else if(papper1==papper7){document.getElementById('TotPaper').value=paper17.slice(3); var totall=Clength+Clength6; document.getElementById("totpaperw").value=totall.toFixed(5);} else {document.getElementById('TotPaper3').value=paper17.slice(3); document.getElementById("totpaperw3").value=Clength6.toFixed(5);}
     if (paper12=='L2- Flute') {no=no+1; totflute=totflute+Clength1;} 
     if (paper14=='L4- Flute') {no=no+1; totflute=totflute+Clength3;} 
     if (paper16=='L6- Flute') {no=no+1; totflute=totflute+Clength5;} 
     var no1=no;
     document.getElementById("TotPaper4").value=no+"F";
     document.getElementById("totpaperw4").value=totflute.toFixed(5);
    }
     function fn91()
    {
      var LenghtT1=document.getElementById("PaperLength").value-0;
      var widthT1=document.getElementById("PaperWidth").value-0;
      var height1=document.getElementById("PaperHeight").value-0;
      var gsm1=document.getElementById("g0").value-0;
      var gsm2=document.getElementById("g1").value-0;
      var gsm3=document.getElementById("g2").value-0;
      var gsm4=document.getElementById("g3").value-0;
      var gsm5=document.getElementById("g4").value-0;
      var gsm6=document.getElementById("g5").value-0;
      var gsm7=document.getElementById("g6").value-0;
      var gsm8=document.getElementById("g7").value-0;
      var gsm9=document.getElementById("g8").value-0;

      var un= document.getElementById("CartonUnit").value;
      if (un!='Box')
       {
        document.getElementById('PaperWidth').style.display='none'; 
          document.getElementById('PaperWidth').value='0';    
          var lenghtTo=document.getElementById('PaperLength').value-0;
          var heightTo=document.getElementById('PaperHeight').value-0;
       }
       else
       {
         document.getElementById('PaperWidth').style.display='';
         var lenghtTo=(LenghtT1*2+widthT1*2)+50;
         var heightTo=widthT1+height1;
         
       }
      var colo=document.getElementById('NoColor').value-0;
      var changerate=document.getElementById("op1").value-0;
      var Area=lenghtTo*heightTo/100;
      var po=document.getElementById("op2").value-0;
      var polim1=colo*Area*po;
       
      var polim=polim1*changerate;
      document.getElementById("PolymerPrice").value=polim.toFixed(0);

      
      var Price1=(lenghtTo*heightTo*gsm1)/1000000;
      var Price2=(lenghtTo*heightTo*gsm2)/1000000;
      var Price3=(lenghtTo*heightTo*gsm3)/1000000;
      var Price4=(lenghtTo*heightTo*gsm4)/1000000;
      var Price5=(lenghtTo*heightTo*gsm5)/1000000;
      var Price6=(lenghtTo*heightTo*gsm6)/1000000;
      var Price7=(lenghtTo*heightTo*gsm7)/1000000;
      var Price8=(lenghtTo*heightTo*gsm8)/1000000;
      var Price9=(lenghtTo*heightTo*gsm9)/1000000;
      var TPrice=Price1+Price2+Price3+Price4+Price5+Price6+Price7+Price8+Price9;

      var percent0=Price1*10/100;
      var percent1=Price2*10/100;
      var percent2=Price3*10/100;
      var percent3=Price4*10/100;
      var percent4=Price5*10/100;
      var percent5=Price6*10/100;
      var percent6=Price7*10/100;
      var percent7=Price8*10/100;
      var percent8=Price9*10/100;
      //var percent=percent0+percent1+percent2;
      var paperprice1=document.getElementById("p0").value-0;
      var paperprice2=document.getElementById("p1").value-0;
      var paperprice3=document.getElementById("p2").value-0;
      var paperprice4=document.getElementById("p3").value-0;
      var paperprice5=document.getElementById("p4").value-0;
      var paperprice6=document.getElementById("p5").value-0;
      var paperprice7=document.getElementById("p6").value-0;
      var paperprice8=document.getElementById("p7").value-0;
      var paperprice9=document.getElementById("p8").value-0;
      var West0=percent0+Price1;
      var West1=percent1+Price2;
      var West2=percent2+Price3;
      var West3=percent3+Price4;
      var West4=percent4+Price5;
      var West5=percent5+Price6;
      var West6=percent6+Price7;
      var West7=percent7+Price8;
      var West8=percent8+Price9;
      var finalp=paperprice1/1000000*West0;
      var finalp1=paperprice2/1000000*West1;
      var finalp2=paperprice3/1000000*West2;
      var finalp3=paperprice4/1000000*West3;
      var finalp4=paperprice5/1000000*West4;
      var finalp5=paperprice6/1000000*West5;
      var finalp6=paperprice7/1000000*West6;
      var finalp7=paperprice8/1000000*West7;
      var finalp8=paperprice9/1000000*West8;
      var TotalFinal=finalp+finalp1+finalp2+finalp3+finalp4+finalp5+finalp6+finalp7+finalp8;
      var b=document.getElementById("PaperGrade").value-0;
      var ben=TotalFinal*b/100;
      var PerCartonPrice=TotalFinal+ben;
      var changerate=document.getElementById("op1").value-0;

      var tt=document.getElementById("PricePercarton").value=PerCartonPrice.toFixed(3);
      var ToAfn=tt*changerate;
      var n=document.getElementById("PaperPriceAFN").value=ToAfn.toFixed(3);
      var CTQTY=document.getElementById("CartonQTY").value;
      var AllCartonPrice=CTQTY*tt*changerate;
      document.getElementById("TotalPriceAfn").value=AllCartonPrice.toFixed(3);
      var di=document.getElementById("DiePrice").value-0;
      var T=AllCartonPrice+polim+di.toFixed(1);
      document.getElementById("TotalPrice").value=T;
      document.getElementById("TotalPriceD").value=T/changerate;

    }
   function fn3()
   {
    var val = document.getElementById("CartonType").value;
    
    if (val=='3')
    {
      document.getElementById('p0').style.display = '';
      document.getElementById('g0').style.display = '';
      document.getElementById('p1').style.display = '';
      document.getElementById('g1').style.display = '';
      document.getElementById('p2').style.display = '';
      document.getElementById('g2').style.display = '';

      document.getElementById('p3').style.display = 'none';
      document.getElementById('g3').style.display = 'none';
      document.getElementById('p4').style.display = 'none';
      document.getElementById('g4').style.display = 'none';
      document.getElementById('p5').style.display = 'none';
      document.getElementById('g5').style.display = 'none';
      document.getElementById('p6').style.display = 'none';
      document.getElementById('g6').style.display = 'none';
      document.getElementById('p7').style.display = 'none';
      document.getElementById('g7').style.display = 'none';
      document.getElementById('p8').style.display = 'none';
      document.getElementById('g8').style.display = 'none';

      


    }
    else if (val=='5') 
    {
      document.getElementById('p0').style.display = '';
      document.getElementById('g0').style.display = '';
      document.getElementById('p1').style.display = '';
      document.getElementById('g1').style.display = '';
      document.getElementById('p2').style.display = '';
      document.getElementById('g2').style.display = '';
      document.getElementById('p3').style.display = '';
      document.getElementById('g3').style.display = '';
      document.getElementById('p4').style.display = '';
      document.getElementById('g4').style.display = '';

      document.getElementById('p5').style.display = 'none';
      document.getElementById('g5').style.display = 'none';
      document.getElementById('p6').style.display = 'none';
      document.getElementById('g6').style.display = 'none';
      document.getElementById('p7').style.display = 'none';
      document.getElementById('g7').style.display = 'none';
      document.getElementById('p8').style.display = 'none';
      document.getElementById('g8').style.display = 'none';



    }
    else if (val=='7') 
    { 
      document.getElementById('p0').style.display = '';
      document.getElementById('g0').style.display = '';
      document.getElementById('p1').style.display = '';
      document.getElementById('g1').style.display = '';
      document.getElementById('p2').style.display = '';
      document.getElementById('g2').style.display = '';
      document.getElementById('p3').style.display = '';
      document.getElementById('g3').style.display = '';
      document.getElementById('p4').style.display = '';
      document.getElementById('g4').style.display = '';
      document.getElementById('p5').style.display = '';
      document.getElementById('g5').style.display = '';
      document.getElementById('p6').style.display = '';
      document.getElementById('g6').style.display = '';
      document.getElementById('p7').style.display = 'none';
      document.getElementById('g7').style.display = 'none';
      document.getElementById('p8').style.display = 'none';
      document.getElementById('g8').style.display = 'none';
     
    }
    else if (val=='9') 
    {
      document.getElementById('p0').style.display = '';
      document.getElementById('g0').style.display = '';
      document.getElementById('p1').style.display = '';
      document.getElementById('g1').style.display = '';
      document.getElementById('p2').style.display = '';
      document.getElementById('g2').style.display = '';
      document.getElementById('p3').style.display = '';
      document.getElementById('g3').style.display = '';
      document.getElementById('p4').style.display = '';
      document.getElementById('g4').style.display = '';
      document.getElementById('p5').style.display = '';
      document.getElementById('g5').style.display = '';
      document.getElementById('p6').style.display = '';
      document.getElementById('g6').style.display = '';
      document.getElementById('p7').style.display = '';
      document.getElementById('g7').style.display = '';
      document.getElementById('p8').style.display = '';
      document.getElementById('g8').style.display = '';
    }
    else
    {


    }
  

   }
</script> 
 </center>
 


</div><!-- END OF FIRST DIV -->
<?php  require_once '../App/partials/Footer.inc'; ?>
