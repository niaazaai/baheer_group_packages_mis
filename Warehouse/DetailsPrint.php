<?php  ob_start();
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

if(isset($_GET['PROId']) &&  !empty($_GET['PROId']))
{
    $PROId=$_GET['PROId'];
    $SQL=$Controller->QueryData('SELECT carton.CTNId,cartonproduction.CtnId1,cartonproduction.ProQty,cartonproduction.financeAllowquantity,cartonproduction.ProOutQty,cartonproduction.ProId,
                                 CtnDriverMobileNo,CtnDriverName,CtnCarName,CoutComment,CtnOutQty ,CtnCarNo,CtnoutId
                                 FROM cartonproduction INNER JOIN cartonstockout ON cartonstockout.PrStockId=cartonproduction.ProId INNER JOIN carton ON cartonproduction.CtnId1=carton.CTNId  WHERE PrStockId=? ', [$PROId]);

}
   
    
?>
 
<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert"  id = "message">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert" id = "message">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick = "remove_msg(`message`)" ></button>
                    </div>';
          }
      }
?>
 
 
 <div class="card m-3 ">
  <div class="card-body d-flex justify-content-between">
        <h3 class="my-1  ">  
            <a class="btn btn-outline-primary   me-1" href="JobCenter.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
 
          Driver & Loaded Jobs Printing Page<span>  </span>
        </h3>

        <div>
            <a href="Manual/ProductList_Manual.php" class="text-primary" title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a> 
        </div>
  </div>
</div>


 

 
<div class="card m-3 shadow">
    <div class="card-body">
      <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )"> 
            </div>
      </div>
    </div>                
 </div>

<div class="card m-3 shadow">
    <div class="card-body">
        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th>#</th> 
                    <th>Driver Name</th>
                    <th>Plate No </th> 
                    <th>Vechile Type</th>  
                    <th>Finance Approval QTY</th>
                    <th>Stock Out QTY</th> 
                    <th>Print</th>
                </tr>
            </thead>
            <tbody>
              <?php 
                  $COUNTER=1;$Count=1;
                  while($Rows=$SQL->fetch_assoc())
                  { 
                    ?>
                   
                        <tr>
                            <td><?=$Count?></td> 
                            <td><?=$Rows['CtnDriverName']?></td>
                            <td><?=$Rows['CtnCarNo']?></td> 
                            <td><?=$Rows['CtnCarName']?></td> 
                            <td><?=$Rows['financeAllowquantity']?></td>
                            <td><?=$Rows['CtnOutQty']?></td> 
                            <td>
                                <a href="GatePassPrint.php?PROId=<?=$Rows['ProId']?>&CTNId=<?=$Rows['CTNId']?>&CtnoutId=<?=$Rows['CtnoutId']?>" class="btn btn-outline-primary btn-sm m-1 border-3 fw-bold" target="_blank">
                                    Print
                                </a>  
                            </td>
                        </tr>
                  <?php
                    $Count++;
                  }
              ?>
               
            </tbody>
        </table>  
    </div>
</div>
 

<script>
      function search(InputId ,tableId)
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

      var fruits = document.getElementById("ListType");
      [].slice.call(fruits.options)
        .map(function(a){
          if(this[a.value]){ 
            fruits.removeChild(a); 
          } else { 
            this[a.value]=1; 
          } 
        },{}); 

      function PutQTYToModal(CTNId)
      {
          document.getElementById("CTNID").value = CTNId; 
      }


      function submit_reel(id){

          let reel = document.getElementById(id); 
          console.log(reel.value);
          if(reel.value > 180 || reel.value < 80) {
              alert('your are not allowed'); 
              reel.value = 80; 
              return ; 
          }

          reel.form.submit();

      }

      function add_reel_size(id) 
      {
          document.getElementById('reel_size_1').value = document.getElementById(id) ; 
      }

</script>
 
<?php  require_once '../App/partials/Footer.inc'; ?>

