<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_FINISHED_JOBS_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized to access this page!" );
    }
    require_once '../App/partials/Menu/MarketingMenu.inc';

    if(isset($_POST['Update']) && !empty($_POST['Update']))
    {
        $ProId=$_POST['ProId'];
        $Plate=$_POST['Plate'];
        $Line=$_POST['Line'];
        $Pack=$_POST['Pack'];
        $ExtraPack=$_POST['ExtraPack']; 
        $Carton=$_POST['Carton'];
        $ExtraCarton=$_POST['ExtraCarton']; 

        $Select=$Controller->QueryData("SELECT Plate , `Line`, Pack  , ExtraPack , Carton , ExtraCarton WHERE ProId=?",[$ProId]);
        $Data=$Select->fetch_assoc();
       
        $Update=$Controller->QueryData("UPDATE cartonproduction SET Plate = ?, `Line` = ?, Pack = ? , ExtraPack = ?, Carton = ? , ExtraCarton = ? WHERE ProId = ? ",[$Plate,$Line,$Pack,$ExtraPack,$Carton,$ExtraCarton,$ProId]);
        if($Update) 
        { 
            // this block will get the carton produced qty and update it with new value. 
            $Produced_QTY =  $Controller->QueryData("SELECT ProductQTY , CTNId  FROM carton WHERE CTNId = ? ",[$_REQUEST['CTNId']]);

            $PQTY  = $Produced_QTY->fetch_assoc()['ProductQTY'] ;  
            $PQTY += $_REQUEST['Total'];

            $Update_produced = $Controller->QueryData("UPDATE carton SET ProductQTY = ? WHERE CTNId = ? ",[ $PQTY , $_REQUEST['CTNId'] ]);
            if($Update_produced && $pro_cycle && $Produced_QTY) header('Location:FinishList.php?msg=Data Saved Successfully&class=success'); 
            
        }
        

      

    }

    $DataRows=$Controller->QueryData("SELECT  carton.JobNo , carton.CTNId , carton.CTNQTY , carton.ProductName , ppcustomer.CustName , cartonproduction.ProId ,cartonproduction.CtnId1 ,cartonproduction.CompId 
                                              ,cartonproduction.ProQty,cartonproduction.ProId ,ProOutQty,ProStatus,Plate,`Line`,Pack,ExtraPack,Carton,ExtraCarton  ,DesignImage,CustId1
      FROM cartonproduction INNER JOIN carton ON carton.CTNId=cartonproduction.CtnId1 INNER JOIN ppcustomer ON  cartonproduction.CompId = ppcustomer.CustId INNER JOIN designinfo ON carton.CTNId = designinfo.CaId 
      WHERE ProStatus='Pending'",[]) ;



?>
<style>
    .blink_me {  animation: blinker 2s linear infinite; }
    @keyframes blinker {  50%  {  opacity: 0; } }
</style>

<?php  if(isset($_GET['msg'])) {  ?>
    <div class="alert  alert-dismissible fade show m-3 alert-<?php if(isset($_GET['class'])) echo $_GET['class'];  ?>" role="alert">
        <strong>Message: </strong> <?=$_GET['msg']?>! 
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php } ?>
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between    ">
    <div class = "mt-2" > 
        <a class="btn btn-outline-primary   me-1" href="FinishList.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
        
        <span class = "fs-bold fs-4 ps-2" > WhareHouse Jobs Reject List   </span> 
    </div>    
    <div class = "d-flex justify-content-between align-middle ">
        
        <div class="form-floating">
            <input type="text" class="form-control"  id = "Search_input"  style = "width:500px;" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
            <label for="Reel">Search Anything</label>
        </div>
    </div>
    </div>
</div>

<div class="card shadow m-3   mt-0 " >
    <div class="card-body">
        <table class = "table" id = "JobTable">
            <tr class = "table-info" >
                <th>#</th>
                <th>JobNo</th>
                <th>Description</th>
                <th>Customer</th>
                <th>Order Qty</th>
                <th>Produced Qty</th>
                <th>Status</th>
                <th class="text-center">OPS</th>
            </tr>

            <tr>
                <?php $counter = 1;  while($Rows=$DataRows->fetch_assoc())  { ?>
                        <tr class ="p-0" >
                        <td><?=$counter++; ?></td>
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['ProductName']?></td>
                            <td><?=$Rows['CustName']?></td>
                            <td><?=$Rows['CTNQTY']?></td>
                            <td><?=$Rows['ProQty']?></td>
                            <td><?php if($Rows['ProStatus']=='Pending') echo '<span class="badge bg-danger blink_me">Rejected</span>';?></td>
                            </td>
                            <td> 
                            
                                                                                                                                                          
                                <a type="button"  onclick = "AddCycleForCProduction(<?=$Rows['ProId']?>,<?=$Rows['CustId1']?> ,<?=$Rows['CTNId']?>,<?=$Rows['JobNo']?>,`<?=$Rows['ProductName']?>`,<?=$Rows['CTNQTY']?>,<?=$Rows['Plate']?>,<?=$Rows['Line']?>,<?=$Rows['Pack']?>,<?=$Rows['ExtraPack']?>,<?=$Rows['Carton']?>,<?=$Rows['ExtraCarton']?>)" data-bs-toggle="modal" data-bs-target="#exampleModal1" class="btn btn-outline-success btn-sm ">   
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                                    </svg> Register
                                </a> 
                             

                            <a class = "btn btn-outline-dark btn-sm" style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                href="../Design/ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >  View Image
                            </a>

                            </td>
                        <tr class ="p-0" > 
                <?php } ?>
            </tr>
             
    
        </table>
    </div>
</div>

 
<!-- Modal : for registering cycle production -->
<div class="modal fade " id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel"> Cycle Finish Goods Form</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method = "post" >
        <input type="hidden" name="CustId" id = "FJL_cust_id"  >
        <input type="hidden" name="CYCLE_ID" id = "FJL_cycle_id" >
        <input type="hidden" name="CTNId" id = "FJL_ctn_id" >
        <input type="hidden" name="ProId" id="ProId" value="">

        <div class="modal-body">
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="form-floating ">
                        <input type="text" name = "JobNo" class="form-control "  id = "FJL_job_no"  placeholder  = "Job No"    readonly>
                        <label for="floatingInput">Job No </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-floating ">
                        <input type="text" name = "OrderQTY"   id = "FJL_order_qty" class="form-control " readonly  placeholder  = "Order QTY"   >
                        <label for="floatingInput">Order QTY</label>
                    </div>
                </div>
            
            </div>
            
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-12">
                    <div class="form-floating ">
                        <input type="text"  class="form-control " readonly placeholder  = "Product Name" id = "FJL_product_name"  >
                        <label for="floatingInput">Product Name </label>
                    </div>
                </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Plate" id = "Plate"  class="form-control " onchange = "InputValue(this.name , this.value)" placeholder  = "Plate" >
                        <label for="floatingInput">Plate </label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Line" id="Line" class="form-control"   onchange = "InputValue(this.name , this.value)"placeholder  = "Line" >
                        <label for="floatingInput">Line</label>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="form-floating ">
                        <input type="text" name = "Pack"  id="Pack" class="form-control "  onchange = "InputValue(this.name , this.value)" placeholder  = "Pack" >
                        <label for="floatingInput">Pack</label>
                    </div>
                </div>
                <div class="col-lg-3">

                <div class="form-floating ">
                        <input type="text" name = "ExtraPack" id="ExtraPack" class="form-control" placeholder  = "Ex Packs"     onchange = "InputValue(this.name , this.value)"  >
                        <label for="floatingInput">Ex Packs</label>
                    </div> 
                </div>
            </div>

            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "TotalPacks" id = "TotalPacks"  class="form-control " disabled placeholder  = "Carton" >
                        <label for="TotalPacks">Total Packs</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "Carton"  id = "Carton" class="form-control "  placeholder  = "Per Packs" onchange = "InputValue(this.name , this.value)" >
                        <label for="floatingInput">Per Packs</label>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="form-floating ">
                        <input type="text" name = "ExtraCarton"   class="form-control " id = "ExtraCarton"   placeholder  = "Extra Carton" onchange = "InputValue(this.name , this.value)"  >
                        <label for="floatingInput">Extra Carton  </label>
                    </div>
                </div>
            </div>

            
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="form-floating ">
                        <input type="text" name = "Total" class="form-control " id = "Total"   placeholder  = "Total QTY" >
                        <label for="floatingInput">Total </label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-floating">
                        <select class="form-select" name = "Unit" id="Unit" aria-label="Select Unit">
                            <option selected>Select Unit</option>
                            <option value="Production">Production</option>
                            <option value="Manual">Manual</option>
                        </select>
                        <label for="Unit">Unit</label>
                    </div>
                </div>
            </div>
                
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-outline-primary" name="Update" value="Update">
        </div>
      </form>
    </div>
  </div>
</div>




<script>
    function search(InputId ,tableId ) 
    {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(InputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (i = 1; i < tr.length; i++) 
        {
            td = tr[i];
            if (td) 
            {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) 
                {
                    tr[i].style.display = "";
                } 
                else 
                {
                    tr[i].style.display = "none";
                }
            }
        }
    }

   
    
    function AddCycleForCProduction(proid ,CustId , CTNId , JobNo , ProductName , CTNQTY, Plate, Line, Pack, ExtraPack, Carton, ExtraCarton)
    {
       
        document.getElementById('FJL_cust_id').value = CustId; 
        document.getElementById('FJL_ctn_id').value = CTNId; 
        document.getElementById('FJL_job_no').value = JobNo; 
        document.getElementById('FJL_product_name').value = ProductName; 
        document.getElementById('FJL_order_qty').value = CTNQTY;  
        document.getElementById('Plate').value = Plate; 
        document.getElementById('Line').value = Line; 
        document.getElementById('Pack').value = Pack; 
        document.getElementById('ExtraPack').value = ExtraPack; 
        document.getElementById('Carton').value = Carton; 
        document.getElementById('ExtraCarton').value = ExtraCarton; 
        document.getElementById('ProId').value=proid;

    }

    let total = {}; 
    function InputValue(name , value)   
    {
        total[name] = value; 
        CalculatePlates(); 
    }
    
    function CalculatePlates()
    {
        let TotalPacks = 0 ; 
        let FinalTotal = 0 ; 
        TotalPacks = ( Number(total.Plate) * Number(total.Line) * Number(total.Pack) ) + Number(total.ExtraPack)  ;
        FinalTotal = (Number(total['Carton']) * Number(TotalPacks) ) + Number(total.ExtraCarton)
        document.getElementById('TotalPacks').value =  TotalPacks; 
        document.getElementById('Total').value =  FinalTotal; 
    }

</script>
<?php  require_once '../App/partials/Footer.inc'; ?>