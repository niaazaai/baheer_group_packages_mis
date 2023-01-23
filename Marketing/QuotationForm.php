<?php    require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<?php
    // Authorization Code 
    $RowCount =  $Controller->QueryData("SELECT * FROM employeet WHERE EUserName = ?" , [$_SESSION['user']] );
    $r1 = $RowCount->fetch_row(); 
    if ($r1[0]>5 && $r1[14]!='Marketing' && $r1[0]!=92 && $r1[0]!=63  && $r1[0]==20 && $r1[0]==34) 
    {
      header("Location:index.php"); // MUST REDIRECT TO CUSTOMER DASHBOARD INSTEAD OF INDEX 
    }


    // CustId is Sout 
    if(isset($_POST['CustId']) && !empty($_POST['CustId'])){
      $CustId=$_POST['CustId'];
    }

    if(isset($_GET['CustId']) && !empty($_GET['CustId'])){
      $CustId=$_GET['CustId'];
    } else die('Customer ID is has not set correctly'); 


    $no=1;
    $Customer =  $Controller->QueryData("SELECT CustId, CustName,  CustContactPerson, CustMobile, CustEmail,  CustAddress, CustWebsite, CustCatagory FROM ppcustomer WHERE CustId=  ?" , [ $CustId ] );
    $r1 = $Customer->fetch_row(); 

    // var_dump($r1);

 ?>
 
</head>
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
  
  
 
 </style>
 <script>
function openNav() {
  document.getElementById("myNav").style.height = "60%";
 
}
function openNav1() {
  document.getElementById("myNav1").style.height = "20%";
  document.getElementById("myNav1").style.weight = "50%";
 
}

function closeNav() 
{
  document.getElementById("myNav").style.height = "0%";
  
}
function closeNav1() 
{
  document.getElementById("myNav1").style.height = "0%";
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


  <!-- Paper Percentage calculation -->
  <div id="myNav1" class="overlay" align="right">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav1()">&times;</a>
  <div class="overlay-content" align="right">
  <center> 
  <div class="col-lg-12">
    <table style="width:400px; " border="1">
    <tr style="background-color: #1a4a5a; font-weight: bold; font-size:14px; color: white;">
      <td  colspan="2" align="center">Cost & Grade Calculation</td>
    </tr>
  </table> 
</div>
  <div class="col-sm-12" >
    <table style="width:400px; background-color: #fff;" border="1" onmouseover="GradeCalculation()">
          <tr style="background-color: #1a4a5a; font-weight: bold; font-size:12px; color: white;" align="center">
            <td>Unit Price</td>
            <td>Grade</td>
          </tr>
          <script type="text/javascript">
            function GradeCalculation() 
            {
              var totalv= document.getElementById('TotalFinal1').value-0;
              var benf=document.getElementById('UPrice').value-0;
              var diff4=benf;
              var Grdd=(diff4/100)*totalv;
              document.getElementById('Grd').value=Grdd;
            }
          </script>
          <tr style="background-color: #1a4a5a; font-weight: bold; font-size:14px; color: white;">
            <td><input type="text" name="UPrice" id="UPrice" placeholder="Unit Price" onkeydown="GradeCalculation()" onkeyup="GradeCalculation()" class="form-control"></td>
            <td><input type="text" name="Grd" id="Grd" placeholder="Grade" class="form-control"></td>
          </tr>
          <tr style="background-color: #1a4a5a; font-weight: bold; font-size:14px; color: white;">
            <td colspan="2" align="right">
              <input type="button" name="BtnSet" id="BtnSet" value="Set Grade" class="btn btn-primary" >
            </td>
          </tr>
    </table>
  </div>
  </center>
    </div>
  </div>
  <!-- end paper calculation-->

































 

 
  <div class="card m-3 ">
    <div class="card-body text-center m-0  my-3 p-0">
    <h4  >PKG Costing Calculation Form to   </h4>
    </div>
  </div>

  <?php 
    $Customer =  $Controller->QueryData("SELECT Id,PaperGSM,ExchangeRate,PolimerPrice FROM paperprice" , [] );
    $r1 = $Customer->fetch_row(); 
  ?>
 
    <form class=" " enctype="multipart/form-data" id="feedback_form" method="post" action="Quo.php">

      <input type='hidden' name='op' value=" <?=$r1[1] ?>"  id='op'>
      <input type='hidden' name='op1' value=" <?=$r1[2] ?>" id='op1'>
      <input type='hidden' name='op2' value=" <?=$r1[3] ?>" id='op2'>

      

      <div class="card m-3 ">
        <div class="card-body text-center m-0  my-3 p-0">
          <!-- BUTTONS OUTSIDE OF FORM -->
          <div class="btn-group" role="group" aria-label="Top Buttons for Quotations">
              <a href="javascript:poptastic('PolySearch.php');"  title="Find Exist Polymer & Die"  class="btn btn-danger fw-bold">Find Polymer</a>
              <a href="javascript:poptastic('DieSearch.php');"  title="Record New Polymer & Die" class="btn btn-warning" >Search Die</a>
              <a  href="javascript:poptastic('../PaperStock/BalanceSheetPaper.php');"title="Find Paper In Stock "   class="btn btn-success" >Check Stock</a>
              <a   title="Find and paper weight"  onclick="openNav()" class="btn btn-info" >Paper Weight</a>
              <a href="Customerlist2.php" title="Find and select customer"  class="btn btn-primary" >Find Customer </a>
              <a class="btn btn-dark" onclick="openNav1()" >Cost Calculation</a>
          </div>
          <!-- BUTTONS OUTSIDE OF FORM -->
        </div>
      </div>

      <?php
        $q =  $Controller->QueryData("SELECT CTNId,CTNType,CustId1,JobNo,EmpId,CTNWidth,CTNHeight,CTNLength,CTNPrice,CTNTotalPrice,
        CTNOrderDate,CTNFinishDate,CTNStatus,CTNQTY,CTNUnit,CTNColor,CTNPaper,CTNPolimarPrice,CTNDiePrice , ppcustomer.CustName, ppcustomer.CustAddress, CtnCurrency, MarketingNote 
        FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where JobNo!='NULL' ORDER BY carton.CTNId DESC " , [] );
        $q2 = $q->fetch_row(); 
      ?>



      <div class="row my-3">
        <div class="col-lg-12">
            <select name="jobType1"  class ="form-control " required >
              <option value="" >Quotation Type</option>
              <option value="Normal">New Quote</option>
            </select>
        </div>
      </div>
      
      <!-- FIRST ROW  -->
      <div class="row my-3 gy-2 gx-3 align-items-center " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong> Customer Details </strong>
        </div>
        <div class="col-auto">
          <label for="CustomerName" class="form-label">Last Job No <span class="text-danger"> * </span></label>
          <input type="text" class="form-control" value = "<?=$q2[3];?>" id="CustomerName"  name="CustomerName1" minlength="1"  required readonly  />
          <input  class="form-control" readonly <?php //echo "value='$row31[0]'";?> id="CustomerName"  name="CustomerName" minlength="1" type="text" required style='display: none;' />
        </div>

        <div class="col-auto">
          <label for="PrJobNo" class="form-label">Job No <span class="text-danger"> * </span> </label>
          <input class="form-control"  id="PrJobNo" required name="PrJobNo" value="NULL" type="text"  placeholder="Job No" />
        </div>

        <div class="col-auto">
          <label for="DeName" class="form-label"> Product Name <span class="text-danger"> * </span>  </label>
          <input class="form-control" id="DeName" placeholder="Write Product Name "  name="DeName"   type="text" required  />
        </div>

        <div class="col-auto">
          <label for="FinishDate" class="form-label">Alert Date <span class="text-danger"> * </span></label>
          <input type="Date" class="form-control" id="FinishDate" name="FinishDate" type="text" required  />
        </div>

        <div class="col-auto">
          <label for="PaperGrade" class="form-label">Grade <span class="text-danger"> * </span></label>
          <input   class="form-control" id="PaperGrade"  name="PaperGrade" type="text" required  /> 
        </div>
      </div>
      <!-- FIRST ROW  -->



      <!-- SECOND ROW  -->
      <div class="row my-3 gy-2 gx-3 align-items-center " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong> Size Details </strong>
        </div>
        <div class="col-auto">
            <label for="CartonUnit" class="form-label">Carton Type  <!-- AKA UNIT IN PREVIOUS FORM --> <span class="text-danger"> * </span></label>
            <select class="form-control" id="CartonUnit"  name="CartonUnit"  >
              <option disabled = "disabled"  > Select Unit</option>
              <option value="Carton">Carton</option>
              <option value="Box">Box</option>
              <option value="Sheet">Sheet</option>
              <option value="Tray">Tray</option>
              <option value="Separator">Separator</option>
              <option value="Belt">Belt</option>
            </select>
        </div>

        <div class="col-auto">
          <label for="CustomerName" class="form-label"> Quantity <span class="text-danger"> * </span> </label>
          <input class="form-control" id="CartonQTY" placeholder="Quantity" name="CartonQTY" type="text" required  />
        </div>

        <div class="col-auto">
          <label for="PaperLength" class="form-label" > L <span class="text-danger"> * </span></label>
           <input class="form-control" id="PaperLength" placeholder="Lenght mm" name="PaperLength" type="text" required  />
        </div>

        <div class="col-auto">
          <label for="PaperWidth" class="form-label"> W <span class="text-danger"> * </span></label>
          <input class="form-control" id="PaperWidth" placeholder="Width mm" name="PaperWidth" type="text"  value=""  />
        </div>

        <div class="col-auto">
          <label for="PaperHeight" class="form-label"> H <span class="text-danger"> * </span></label>
          <input class="form-control"   id="PaperHeight" placeholder="Height mm" name="PaperHeight"  type="text" required  />
        </div>
      </div>
      <!-- SECOND  ROW  -->

      


















      <!-- THIRD ROW  -->
      <div class="row my-3 gy-2 gx-3 align-items-center " onmouseover="CallAll()"  >
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong> Paper Details </strong>
        </div>

        <div class="col-1">
            <label for="CartonType" class="form-label">Carton Type <span class="text-danger"> * </span></label>
            <select class="form-control" onchange="fn3();" name="CartonType" id="CartonType" style="width: 100px;">
              <option> Select Ply Type</option>
              <option value="3">3-Ply</option>
              <option value="5">5-Ply</option>
              <option value="7">7-Ply</option>
            </select>
            <input type='text' name='cmpname1' readonly style='background-color: #999999; color:white; display: none;' class='form-control' <?php // echo"value='$row31[1]'";?>>
        </div>

        <!-- LAYER (L1) FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P0" id="p0" style="display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L1- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2"  style="display:none;" name="g0" id="g0" value="125" type="text" placeholder="GSM" />
        </div>

        <!-- LAYER (P1) & G1  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P1" id="p1"  style=" display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L2- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2" style=" display: none; " value="125" name="g1" id="g1" name="" type="text"  placeholder="GSM"  />
        </div>


        <!-- LAYER (P2) & G2  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P2" id="p2"  style="display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L3- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2" style="display: none; " name="g2" id="g2" type="text" value="125"  placeholder="GSM" />
        </div>

        <!-- LAYER (P3) & G3  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P3" id="p3"  style="display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L4- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2"  name="g3" id="g3" style=" display: none;" value="125" name="" type="text" placeholder="GSM" />
        </div>

        <!-- LAYER (P4) & G4  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P4" id="p4"  style=" display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L5- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2" style=" display: none;" value="125" name="g4" id="g4" type="text" placeholder="GSM"   />
        </div>

        <!-- LAYER (P5) & G5  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P5" id="p5"  style="display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L6- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2"  style=" display: none; " name="g5" id="g5"  type="text" placeholder="GSM" value="125"  />
        </div>
        
        <!-- LAYER (P6) & G6  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P6" id="p6"  style="display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L7- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2" style=" display: none; " name="g6" id="g6" type="text" placeholder="GSM" value="125"  />
        </div>

        <!-- LAYER (P7) & G7  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P7" id="P7"  style="  display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L8- $rr[0]</option>";
              ?>
              </select>
              <input class="form-control mt-2" style="  display: none;" name="g7" id="g7" type="text" placeholder="GSM" value="125"  />
        </div>

        <!-- LAYER (P7) & G7  FORM CONTROL  -->
        <div class="col-1">
            <select class="form-control " onchange="" name="P8" id="P8"  style="  display: none; ">
              <?php
                  if (isset($_POST['catagorized'])) {
                    $c=$_POST['catagorized'];  echo "<option value='$c'>$c</option>";
                  }
                  $qq =  $Controller->QueryData("SELECT DISTINCT `Name`,Price FROM paperprice" , [] );
                  while ($rr=$qq->fetch_row())   echo "<option value='$rr[1]'>L9- $rr[0]</option>";
              ?>
            </select>
            <input class="form-control mt-2" style=" display: none;" name="g8" id="g8" type="text" placeholder="GSM" />
        </div>
      
      </div>
      <!-- THIRD  ROW  -->
                   

































      <?php
                    if (isset($_POST['BtnSave']))
                     {
                      
                      $cp1=$_POST['cp1'];  $cp2=$_POST['cp2']; $cp3=$_POST['cp3']; $cp4=$_POST['cp4']; $cp5=$_POST['cp5']; $cp6=$_POST['cp6']; $cp7=$_POST['cp7'];
                      $cppr1=$_POST['P0']; $cppr2=$_POST['P1']; $cppr3=$_POST['P2']; $cppr4=$_POST['P3']; $cppr5=$_POST['P4']; $cppr6=$_POST['P5']; $cppr7=$_POST['P6'];
                      $exchangeUsd=$_POST['op1'];
                      $Emp=$_SESSION['user'];
                      
                      $Em =  $Controller->QueryData("SELECT EId,EUserName FROM `employeet` where `EUserName`=?" , [$Emp] );
                      $Empi = $Em->fetch_row(); 

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
                      $qr="INSERT INTO `carton`(`CTNType`, `CustId1`, `JobNo`, `EmpId`, `CTNWidth`, `CTNHeight`, `CTNLength`, `CTNPrice`, `CTNTotalPrice`, 
                      `CTNOrderDate`, `CTNFinishDate`, `CTNStatus`, `CTNQTY`, `CTNUnit`,`CTNColor`, `CTNPaper`, `CTNPolimarPrice`, `CTNDiePrice`,`ProductName`,
                      `FinalTotal`, `CSlotted`, `CDieCut`, `CPasting`, `CStitching`, flexop, offesetp, `CFluteType`, JobType , Note, CtnCurrency, GrdPrice, 
                      MarketingNote, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`, `Ctnp5`, `Ctnp6`, `Ctnp7`, `PaperP1`, `PaperP2`, `PaperP3`, `PaperP4`, `PaperP5`,
                       `PaperP6`, `PaperP7`, `PexchangeUSD`) VALUES ('$CType', $CusId, '$Jobno', $Empi[0],  $CTwidth,
                        $CTHeight, $CTLength , $CTPrice, $CTTotalPrice, '$CTOrderDate', '$CTFinishDate', '$CTStatus', $CTQN, '$CTNUnit1', 
                        '$CTNColor1', '$CTNPaper1', $CTNPolimar,$CTNDie, '$PrName',$CTFinalPrice, '$Slott', '$DieCt', '$Past1' , 
                        '$Stich33','$flexoprint', '$offesetprint', '$Flute33', '$jobType2', '$Note1', '$CtnCurrency1', '$PaperGrade',
                         '$Notemarket', '$cp1', '$cp2', '$cp3', '$cp4', '$cp5', '$cp6', '$cp7', $cppr1, $cppr2, $cppr3, $cppr4, $cppr5, $cppr6, $cppr7, '$exchangeUsd')";

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
































    <!-- Fourth ROW  -->
      <div class="row my-3 gy-2 gx-3 d-flex align-items-center  " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong> Size Details </strong>
        </div>
        <div class="col-auto">
            <!-- <label for="CartonUnit" class="form-label">Flute Type   <span class="text-danger"> * </span></label> -->
            <select name="Flute" class="form-control" required>
              <option value="">Flute Type</option>
              <option value="C">C</option>
              <option value="B">B</option>
              <option value="E">E</option>
              <option value="BC">BC</option>
              <option value="CE">CE</option>
              <option value="BCB">BCB</option>
            </select>
        </div>

        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="Slotted" name="Slot" value = "Yes"  >
            <label class="form-check-label" for="Slotted">Slotted</label>
          </div>
        </div>

        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="DieCut" name="DieCut" value = "Yes" >
            <label class="form-check-label" for="DieCut">Die Cut</label>
          </div>
        </div>

        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="Pasting1" name="Pasting1" value = "Yes" >
            <label class="form-check-label" for="Pasting1">Pasting</label>
          </div>
        </div>

        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="Stich" name="Stich" value = "Yes" >
            <label class="form-check-label" for="Stich">Stitching</label>
          </div>
        </div>


        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexoprint" name="flexoprint" value = "Yes" >
            <label class="form-check-label" for="flexoprint">Flexo Print</label>
          </div>
        </div>
        
        <div class="col-auto">
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="offesetprint" name="offesetprint" value = "Yes" >
            <label class="form-check-label" for="offesetprint">Offeset Print  </label>
          </div>
        </div>
      </div>
      <!-- Fourth  ROW  -->


       <!-- FIFTH ROW  -->
       <div class="row my-3 gy-2 gx-3 d-flex align-items-center  " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong> Cost Details </strong>
        </div>
        <div class="col-auto">
            <label for="NoColor" class="form-label">Select Polymer<span class="text-danger"> * </span></label>
            <select class="form-control" name="NoColor" id="NoColor" onchange="PersonalPolymer()">
              <option value="0" >Polymer Exist</option>
              <option value="0" >No Print</option>
              <option value="00" >Personal Polymer</option>
              <option value="00" >Free Polymer </option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
        </div>

        <div class="col-auto">
            <label for="DieExist" class="form-label">Select Die<span class="text-danger"> * </span></label>
            <select class="form-control" name="DieExist" id="DieExist"  >
              <option value="0" >Die Exist</option>
              <option value="0" >No Print</option>
              <option value="00" >Personal Die</option>
              <option value="00" >Free Die </option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
        </div>

        <div class="col-auto">
          <label for="NoColor1" class="form-label">Select Color<span class="text-danger"> * </span></label>
          <select class="form-control " name="NoColor1" id="NoColor1">
            <option value="0" >No Color</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>

        <div class="col-auto">
          <label for="PolymerPrice" class="form-label">Polymer Price  </label>
          <input class="form-control" id="PolymerPrice" name="PolymerPrice" type="text" required   />
        </div>

        <div class="col-auto">
          <label for="DiePrice" class="form-label">Die Price  </label>
          <input class="form-control" id="DiePrice" placeholder="Die Price" name="DiePrice" type="text" />
        </div>

        <div class="col-auto">
        <label   for="halfpolymer"> </label>
          <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="halfpolymer" name="halfpolymer" onclick="CallAll();polymerprice();">
            <label class="form-check-label" for="halfpolymer">Manual </label>
          </div>

        </div>
        <div class="col-auto">
        <label   for="halfpolymer"> </label>
                <div class="input-group">
                  <input class="form-control" id="polymerwidth" placeholder="Width"  name="polymerwidth" type="text"  style="width:75px; " />
                  <input class="form-control" id="polymerheight" placeholder="Height"  name="polymerheight" type="text"  style="width:75px;" />
                </div>
                <!-- 
                  <input class="form-control" id="PlmerNo1" value='NULL' placeholder="Polymer Id No"  name="PlmerNo1" minlength="1" type="text"  style="width:75px;display: none;" />
                  <input class="form-control" id="DieNo" placeholder="Die No"  name="DieNo" minlength="1" type="text"  style="width:70px;display: none;" /> 
                -->
        </div>
      </div>
      <!-- FIFTH  ROW  -->

      <script type="text/javascript">
          function PersonalPolymer()  {
            var polymerno1= document.getElementById('NoColor').value;
            if (polymerno1=='00') {
                var x='NULL';  document.getElementById('PlmerNo').value=x;
            }
            else if(polymerno1=='0') {
                document.getElementById('PlmerNo').value='';
            }
            else {
              var x='NULL'; document.getElementById('PlmerNo').value=x;
            }
          }
        </script>





    <!-- SIXTH ROW  -->
    <div class="row my-3 gy-2 gx-3 d-flex align-items-center  " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong>  TOBE DELETE Details </strong>
        </div>
        <div class="col-auto">
              <label for="TotalPriceAfn" class="form-label">U. Price AFN <span class="text-danger"> * </span></label>
              <input class="form-control" id="PaperPriceAFN" style="font-weight: bold;" readonly name="PaperPriceAFN"  type="text" required  />

              <input class="form-control " id="TotalPriceAfn" readonly name="TotalPriceAfn" minlength="1" type="text" required  style="display: none;"> 
        </div>

        <div class="col-auto">
              <label for="TotalPrice" class="form-label">Total AFN <span class="text-danger"> * </span></label>
              <input class="form-control" id="TotalPrice" readonly  name="TotalPrice" type="text"  style="font-weight:bold;" /> 
        </div>

        <div class="col-auto">
              <label for="PricePercarton" class="form-label">U Price USD <span class="text-danger"> * </span></label>
              <input class="form-control" id="PricePercarton" readonly  name="PricePercarton" type="text" required  />
        </div>

        <div class="col-auto">
              <label for="TotalPriceD" class="form-label">Total USD <span class="text-danger"> * </span></label>
              <input class="form-control" id="TotalPriceD"  readonly name="TotalPriceD" type="text"   />
        </div>

        <div class="col-auto">
              <label for="PricePercarton" class="form-label">Currency <span class="text-danger"> * </span></label>
              <select class="form-control" name="CtnCurrency1" id="CtnCurrency1" required onchange = "ChangeCurrencyType(this.name , this.value)" >
                <option value="">Select Currency</option>
                <option value="AFN">AFN</option>
                <option value="USD">USD</option>
              </select>
        </div>
        <input class="form-control1" id="SubTotalPriceD"  readonly name="SubTotalPriceD" minlength="1" type="text" style="display:none;">
      </div>
      <!-- SIXTH  ROW  -->


       <!-- SEVENTH ROW  -->
    <div class="row my-3 gy-2 gx-3 d-flex align-items-center  " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <strong>  Add Note </strong>
        </div>
        <div class="col-auto">
            <textarea name="Note1"  style="height: 50px; width:925px;" class = "form-control" placeholder = "Note For Order Card " ></textarea> 
        </div>
        <div class="col-auto">
          <button type="submit"  id="BtnSave"  name="BtnSave" class="btn btn-primary" style="height: 50px; width: 150px; font-size: 14px; font-weight: bold;">Save & Print</button>
        </div>
       
      </div>
      <!-- SEVENTH  ROW  -->


      <!-- 8th  ROW  -->
    <div class="row my-3 gy-2 gx-3 d-flex align-items-center  " onmouseover="CallAll()">
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12">  </div>
        <div class="col-auto">
            <textarea name="Notemarket"  style="height: 50px; width:925px;" class = "form-control" placeholder = "Note For Quotation" ></textarea> 
        </div>
        <div class="col-auto">
          <button type="submit"  id="BtnSavePrint"  name="BtnSavePrint" class="btn btn-primary" style="height: 50px; width: 150px; font-size: 14px; font-weight: bold;">Save</button>
        </div>
      </div>
      <!-- 8th  ROW  -->
      <input type="hidden" name="txt_holderPaper" id="txt_holderPaper">

<br><br><br><br><br><br><br><br><br><br><br><br><br>
                    
          
</div>
 <?php

  // ORIGNAL CODE 
   $dd =  $Controller->QueryData("SELECT CURDATE()" , [] );
   $da=$dd->fetch_row();
   var_dump($da[0]);
   // ALTERNATIVE 
   $CurrentDate = (string) date(" Y-m-d");
  ?>

<input class="form-control1" style="display: none;" type="Date" id="OrderDate" value = "<?=$CurrentDate ?>" name="OrderDate"  required  />
  <input type="hidden" name="cp1" id="cp1">
  <input type="hidden" name="cp2" id="cp2">
  <input type="hidden" name="cp3" id="cp3">
  <input type="hidden" name="cp4" id="cp4">
  <input type="hidden" name="cp5" id="cp5">
  <input type="hidden" name="cp6" id="cp6">
  <input type="hidden" name="cp7" id="cp7">
                   
                  </form>
   

































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
      console.log('Call All Called !'); 

polymerprice();
      var x=document.getElementById("CartonType").value;
      console.log('x value : ' + x );
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
    function polymerprice()
    {
       var LenghtT1=document.getElementById("PaperLength").value-0;
      var widthT1=document.getElementById("PaperWidth").value-0;
      var height1=document.getElementById("PaperHeight").value-0;
      document.getElementById('polymerheight').value=height1;
       var le=(LenghtT1+widthT1)*2+5;
       document.getElementById('polymerwidth').value=le;
       
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

      if (un!='Carton')
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
      document.getElementById('TotalFinal1').value=TotalFinal*changerate;
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

      if (un!='Carton')
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
      document.getElementById('TotalFinal1').value=TotalFinal*changerate;
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

     if (un!='Carton')
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
      document.getElementById('TotalFinal1').value=TotalFinal*changerate;
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
      if (un!='Carton')
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
    console.log(val); 
    
    
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

      console.log( document.getElementById('p0')); 
      console.log( document.getElementById('g0')); 
      console.log( document.getElementById('p1')); 
      console.log( document.getElementById('g1')); 

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
 



<?php  require_once '../App/partials/Footer.inc'; ?>
