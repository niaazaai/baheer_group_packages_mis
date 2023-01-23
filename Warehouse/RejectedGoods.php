<?php 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;
 
 

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
 
 
<div class="card m-3 shadow ">
    <div class="card-body d-flex justify-content-between ">
        <div>
            <h4> 
                Warehouse Department Rejected Goods Available Stock
            </h4>
        </div>
        <div class= "d-flex justify-content-center ">
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:2px;"  title="Click to Read the User Guide ">
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
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <label class="fw-bold my-1" for="SelectFluteType">Select Company </label>
                <form action="" method = "post"  >
                    <select class="form-select" name="NewJobSelectFlute" id="NewJobSelectFlute"  onchange="this.form.submit();"> 
                        <option value=""></option>
                        <option value="">pamir</option> 
                    </select>
                    <input type="hidden" name="ListType" value = "Available Stock" > 
                </form>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12  mt-4 pt-1 my-1 "> 
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
                    <th>Rejected Date</th>
                    <th>JobNo</th>
                    <th title="Company Name">C.Name</th>
                    <th >Product Name</th>
                    <th>Ply</th>
                    <th>Type</th>
                    <th title="Order QTY">O.QTY</th>
                    <th title="Produced QTY">P.QTY</th>
                    <th title="Delivery QTY">D.QTY</th>
                    <th title="Remaining QTY">R.QTY</th>
                    <th>Rejected By</th>
                    <th>OPS</th> 
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>3</td>
                    <td>
                        <a href="RejectedGoodsResaleForm.php" class="btn btn-outline-primary">Resale</a>
                    </td>
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

 
 
</script>
 
<?php  require_once '../App/partials/Footer.inc'; ?>