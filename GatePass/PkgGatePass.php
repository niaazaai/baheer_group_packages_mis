 
<?php

use Mpdf\Tag\I;

 require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';

$ListType = '' ; 
$SQL='';

if(isset($_POST['save']) && !empty($_POST['save']))
{
    $GidPkg=$_POST['GidPkg'];
 
    $update=$Controller->QueryData("UPDATE gatepasspkg SET GatepassStatus=?,ApprovedBy=? WHERE GidPkg=?",['Approve By Leadership',$_SESSION['user'],$GidPkg]);
}
elseif(isset($_POST['CheckOut']) && !empty($_POST['CheckOut']))
{
    $GidPkg=$_POST['GidPkg'];
    $update=$Controller->QueryData("UPDATE gatepasspkg SET GatepassStatus=?,ApprovedBy=? WHERE GidPkg=?",['Carton Out',$_SESSION['user'],$GidPkg]);
}


 

$SQL=$Controller->QueryData("SELECT `GidPkg`, `IdStockOutPkg`,CtnoutId,OutDateTime, gatepasspkg.`EmpId`, `OutTime`,GidPkg , `GatepassStatus`,carton.JobNo,CTNQTY,ppcustomer.CustName, carton.ProductName, cartonproduction.ProSize, 
cartonstockout.CtnOutQty,cartonstockout.CtnDriverName, cartonstockout.CtnCarName, cartonstockout.CtnDriverMobileNo, cartonstockout.CtnCarNo, OutTime FROM `gatepasspkg` 
INNER JOIN employeet ON employeet.EId=gatepasspkg.EmpId
INNER JOIN cartonstockout ON cartonstockout.CtnoutId=gatepasspkg.IdStockOutPkg INNER JOIN carton ON carton.CTNId=cartonstockout.CtnJobNo INNER JOIN ppcustomer ON ppcustomer.CustId=cartonstockout.CtnCustomerId 
INNER JOIN cartonproduction ON cartonproduction.ProId=cartonstockout.PrStockId WHERE GatepassStatus='Apply by warehouse' OR GatepassStatus='Approve By Leadership' ",[]);
 
 
 
?>  
 
 
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) { ?>
        <div class="alert alert-<?=$_GET['class']?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>


<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <svg id = "marketing-svg"  width="50" height="50" viewBox="0 0 464 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M224 0V32.652C218.713 33.486 213.385 35.1 208 37.282V16H192V45.16C190.302 46.12 188.598 47.113 186.885 48.14C183.287 50.3 179.655 52.62 176 55.045V32H160V66.19C154.676 70.04 149.336 74.016 144 78.012V64H128V89.965C122.598 93.973 117.25 97.865 112 101.557V80H96V112.213C94.96 112.86 93.91 113.525 92.885 114.141C88.437 116.811 84.119 119.144 80 121.103V112H64V126.973C61.11 127.643 58.425 128 56 128H48V96H0V400H48V144H56C58.658 144 61.324 143.77 64 143.348V400H80V138.717C85.272 136.579 90.6 133.897 96 130.84V400H112V120.955C117.294 117.443 122.637 113.691 128 109.811V400H144V256H160V400H176V74.443C181.462 70.605 186.81 67.016 192 63.787V208H208V54.898C213.793 52.144 219.188 50.143 224 49.028V208H240V49.027C244.812 50.143 250.207 52.144 256 54.897V208H272V63.787C277.19 67.017 282.538 70.605 288 74.443V400H304V256H320V400H336V109.81C341.363 113.69 346.706 117.443 352 120.955V400H368V130.84C373.4 133.896 378.728 136.58 384 138.717V400H400V143.348C402.676 143.77 405.342 144 408 144H416V400H464V96H416V128H408C405.575 128 402.89 127.643 400 126.973V112H384V121.102C379.88 119.142 375.563 116.81 371.115 114.142C370.089 113.525 369.04 112.86 368 112.212V80H352V101.557C346.748 97.867 341.402 93.973 336 89.965V64H320V78.012C314.664 74.016 309.324 70.042 304 66.189V32H288V55.045C284.346 52.621 280.713 50.299 277.115 48.141C275.402 47.114 273.698 46.121 272 45.161V16H256V37.283C250.615 35.1 245.287 33.486 240 32.653V0H224ZM24 32C10.65 32 0 42.65 0 56C0 69.35 10.65 80 24 80C37.35 80 48 69.35 48 56C48 42.65 37.35 32 24 32ZM440 32C426.65 32 416 42.65 416 56C416 69.35 426.65 80 440 80C453.35 80 464 69.35 464 56C464 42.65 453.35 32 440 32ZM160 86.035V240H144V97.988C145.6 96.79 147.203 95.598 148.8 94.4C152.55 91.59 156.284 88.792 160 86.035ZM304 86.035C307.716 88.792 311.45 91.59 315.2 94.4C316.797 95.6 318.4 96.79 320 97.988V240H304V86.035ZM192 224V256H272V224H192ZM192 272V400H208V272H192ZM224 272V400H240V272H224ZM256 272V400H272V272H256Z" fill="#2D707C"/>
            </svg>
            PKG Gate Pass 
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>

            <a href="PkgGatePassReport.php" class="btn btn-outline-primary">Gate Pass Report</a>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 




<!-- <div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between "> 
    <div class = "d-flex justify-content-between ">
        <div class = "my-2">
            <svg id = "marketing-svg"  width="50" height="50" viewBox="0 0 464 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M224 0V32.652C218.713 33.486 213.385 35.1 208 37.282V16H192V45.16C190.302 46.12 188.598 47.113 186.885 48.14C183.287 50.3 179.655 52.62 176 55.045V32H160V66.19C154.676 70.04 149.336 74.016 144 78.012V64H128V89.965C122.598 93.973 117.25 97.865 112 101.557V80H96V112.213C94.96 112.86 93.91 113.525 92.885 114.141C88.437 116.811 84.119 119.144 80 121.103V112H64V126.973C61.11 127.643 58.425 128 56 128H48V96H0V400H48V144H56C58.658 144 61.324 143.77 64 143.348V400H80V138.717C85.272 136.579 90.6 133.897 96 130.84V400H112V120.955C117.294 117.443 122.637 113.691 128 109.811V400H144V256H160V400H176V74.443C181.462 70.605 186.81 67.016 192 63.787V208H208V54.898C213.793 52.144 219.188 50.143 224 49.028V208H240V49.027C244.812 50.143 250.207 52.144 256 54.897V208H272V63.787C277.19 67.017 282.538 70.605 288 74.443V400H304V256H320V400H336V109.81C341.363 113.69 346.706 117.443 352 120.955V400H368V130.84C373.4 133.896 378.728 136.58 384 138.717V400H400V143.348C402.676 143.77 405.342 144 408 144H416V400H464V96H416V128H408C405.575 128 402.89 127.643 400 126.973V112H384V121.102C379.88 119.142 375.563 116.81 371.115 114.142C370.089 113.525 369.04 112.86 368 112.212V80H352V101.557C346.748 97.867 341.402 93.973 336 89.965V64H320V78.012C314.664 74.016 309.324 70.042 304 66.189V32H288V55.045C284.346 52.621 280.713 50.299 277.115 48.141C275.402 47.114 273.698 46.121 272 45.161V16H256V37.283C250.615 35.1 245.287 33.486 240 32.653V0H224ZM24 32C10.65 32 0 42.65 0 56C0 69.35 10.65 80 24 80C37.35 80 48 69.35 48 56C48 42.65 37.35 32 24 32ZM440 32C426.65 32 416 42.65 416 56C416 69.35 426.65 80 440 80C453.35 80 464 69.35 464 56C464 42.65 453.35 32 440 32ZM160 86.035V240H144V97.988C145.6 96.79 147.203 95.598 148.8 94.4C152.55 91.59 156.284 88.792 160 86.035ZM304 86.035C307.716 88.792 311.45 91.59 315.2 94.4C316.797 95.6 318.4 96.79 320 97.988V240H304V86.035ZM192 224V256H272V224H192ZM192 272V400H208V272H192ZM224 272V400H240V272H224ZM256 272V400H272V272H256Z" fill="#2D707C"/>
            </svg>
        </div>
     
      <div class="mt-3">  <span class = "fs-bold fs-4  ps-2 " >PKG Gate Pass</span></div>
  
   
 
    </div>

     
    <div class= "d-flex justify-content-center   my-3">
          <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
            </svg>
          </a>

           <a href="PkgGatePassReport.php" class="btn btn-outline-primary">Gate Pass Report</a>
    </div>

  </div>
</div> -->


 <div class="card m-3 shadow">
    <div class="card-body">
        <form action="" method="POST"> 
            <div class="row"> 
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="search ">
                  <i class="fa-search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                  </i>
                  <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
                </div>
              </div>
            </div>
        </form>
    </div>                
 </div>
   

 


 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">

      <table class= "table " id = "JobTable" >
          <thead>
                <tr class="table-info">
                    <th class="text-center">GDN</th>
                    <th class="text-center">JobNo</th>
                    <th class="text-center">Date</th> 
                    <th class="text-center">Company Name</th>
                    <th class="text-center">Product Name</th>
                    <th class="text-center">QTY</th>
                    <th class="text-center">Driver Name</th>
                    <th class="text-center">Vehicle</th>
                    <th class="text-center">Plate No</th> 
                    <th class="text-center">OPS</th>
                </tr>
          </thead>
          <tbody>
            <?php
                  while($Rows=$SQL->fetch_assoc())
                  {?>
                      <tr>
                        <td class="text-center"><?=$Rows['CtnoutId']?></td>
                        <td class="text-center"><?=$Rows['JobNo']?></td>
                        <td class="text-center"><?=$Rows['OutDateTime']?></td>
                        <td class="text-center"><?=$Rows['CustName']?></td>
                        <td class="text-center"><?=$Rows['ProductName']?></td>
                        <td class="text-center"><?=$Rows['CTNQTY']?></td>
                        <td class="text-center"><?=$Rows['CtnDriverName']?></td>
                        <td class="text-center"><?=$Rows['CtnCarName']?></td>
                        <td class="text-center"><?=$Rows['CtnCarNo']?></td>
                        <td class="text-center ">
                          <form action="" method="POST">
                            <?php
                                if($Rows['GatepassStatus']=='Approve By Leadership')
                                {?>
                                    <input type="submit" name="CheckOut" value="Check Out" class="btn btn-outline-primary btn-sm"> 
                                    <input type="hidden" name="GidPkg"   value="<?=$Rows['GidPkg']?>">
                                <?php
                                } 
                                else
                                {?>
                                    <input type="submit" name="save" value="Approve" class="btn btn-outline-primary btn-sm"> 
                                    <input type="hidden" name="GidPkg" value="<?=$Rows['GidPkg']?>">
                                <?php
                                }
                            ?>
                           
                          </form>
                        </td> 
                      </tr>

                  <?php
                  } 
            ?>
                <tr>
                    
                </tr>
          </tbody>
      </table>



  </div>
</div>


<script>

function search(InputId ,tableId ) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(InputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
      td = tr[i];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
}
 

function PutValueToAnchor(value , jobNo) {
    value = value.trim(); 
    if(value.length != 0 ) {
        let anchor = document.getElementById("Anchor_"+jobNo).href = 'PrintingUpdate.php?&ListType<?=$ListType?>&JobNoPP='+ value +'&JobNo=' + jobNo;
    }
    else {
      alert('Please Write Proper Code for the Job!');
    }
}



var fruits = document.getElementById("ListType");
[].slice.call(fruits.options)
  .map(function(a){
    if(this[a.value]){ 
      fruits.removeChild(a); 
    } else { 
      this[a.value]=1; 
    } 
  },{});

</script>

<?php  require_once '../App/partials/Footer.inc'; ?>





          