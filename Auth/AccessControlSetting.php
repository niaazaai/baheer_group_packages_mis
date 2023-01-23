 
 
<?php require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  

<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
        <h5 class="fw-bold">Access Control Setting</h5>
        <div class="d-flex justify-content-end">
            <a href="#" class="btn btn-outline-primary">Create Rule</a>
        </div>

    </div>
</div> 




<div class="card m-3 shadow">
    <div class="card-body">
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
    </div>                
</div>
   

 


 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">

      <table class= "table " id = "JobTable" >
          <thead>
                <tr class="table-info">
                    <th >Employee ID</th>
                    <th >Name</th>
                    <th >Position</th> 
                    <th >Department</th>
                    <th >Unit</th>
                    <th >OPS</th> 
                </tr>
          </thead>
          <tbody>
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





          