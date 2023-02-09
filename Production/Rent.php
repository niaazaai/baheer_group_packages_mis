<?php 
    ob_start();
    require_once '../App/partials/Header.inc'; 
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_RENTED_CARTON_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized to access this page!" );
    }
    require_once '../App/partials/Menu/MarketingMenu.inc';  

    $rentouts  = $Controller->QueryData("SELECT *  FROM carton_rentout  
    INNER JOIN carton ON carton_rentout.CTNId = carton.CTNId" , []);
?>

<div class="card m-3">
    <div class="card-body d-flex justify-content-between">
        <h4 class = "p-0 m-0" >
            <svg width="45" height="45" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M211.772 239.087C215.569 237.065 218.795 234.539 221.423 231.509C226.125 226.133 228.497 219.733 228.497 212.522C228.497 207.65 227.371 203.195 225.195 199.338C223.045 195.549 220.092 192.392 216.397 189.9C212.949 187.579 208.896 185.804 204.399 184.635C200.124 183.526 195.396 182.962 190.421 182.962H162.696V277.827H186.845V245.24L213.247 277.829H243.822L211.772 239.087ZM203.375 216.9C202.65 218.129 201.626 219.11 200.226 219.963C198.673 220.91 196.727 221.661 194.423 222.173C192.051 222.685 189.525 222.958 186.845 223.009V204.876H190.292C192.494 204.876 194.67 205.098 196.692 205.524C198.467 205.908 200.046 206.497 201.343 207.273C202.29 207.819 203.041 208.562 203.596 209.475C204.099 210.303 204.347 211.412 204.347 212.777C204.348 214.494 204.023 215.825 203.375 216.9Z" fill="#C69666"/>
                <path d="M270.899 255.787V240.486H303.795V218.453H270.899V205.005H305.271V182.963H246.741V277.828H305.647V255.787H270.899Z" fill="#C69666"/>
                <path d="M370.466 182.963V233.805L334.217 182.963H313.668V277.828H337.323V226.987L373.572 277.828H394.121V182.963H370.466Z" fill="#C69666"/>
                <path d="M401.041 182.963V205.005H425.199V277.828H449.348V205.005H473.498V182.963H401.041Z" fill="#C69666"/>
                <path d="M512 64V38.4H64V0H38.4V38.4H0V64H38.4V486.4H12.8C5.726 486.4 0 492.126 0 499.2C0 506.274 5.726 512 12.8 512H89.6C96.674 512 102.4 506.274 102.4 499.2C102.4 492.126 96.674 486.4 89.6 486.4H64V64H153.591V102.4H128C113.86 102.4 102.4 113.86 102.4 128V332.8C102.4 346.94 113.86 358.4 128 358.4H486.4C500.54 358.4 512 346.94 512 332.8V128C512 113.86 500.54 102.4 486.4 102.4H460.8V64H512ZM179.191 64H435.2V102.4H179.191V64ZM486.4 128V332.8H128V128H486.4Z" fill="#C69666"/>
            </svg>
            Rented Cartons 
        </h4>

    </div>
</div>

<div class="card m-3 shadow ">
    <div class="card-body">
        <table class="table " id="JobTable">
            <thead>
                <tr class="table-info">
                    <th>#</th>
                    <th title="Job No">Job No</th>
                    <th>Product Name</th>
                    <th>Employees</th>
                    <th>Machines</th>
                    <th>Rent Amount</th>
                    <th>Rent Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Type</th>
                    <th>Payment</th>
                </tr>
            </thead>
            <tbody>
                <?php $counter = 1 ; if($rentouts->num_rows > 0 ){  ?>
                    <?php while ($rent = $rentouts->fetch_assoc()) { ?>
                        <tr>
                            <td><?=$counter++; ?></td>
                            <td><?= $rent['JobNo'] ?></td>
                            <td><?= $rent['ProductName'] ?></td>
                            <td>
                                <ul>
                                    <?php 
                                        $string = $rent['employee_id'];
                                        $array = explode(',', $string);  
                                        foreach($array as $value)  
                                        {
                                            $ename = $Controller->QueryData("SELECT EmpName , EmpIdNo  FROM employees WHERE EmpIdNo = ?" , [$value]);
                                            $Employee = $ename->fetch_assoc();
                                            echo '<li>'; 
                                            echo $Employee['EmpName'] . " - " . $Employee['EmpIdNo'] ; 
                                            echo '</li>'; 
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    <?php 
                                        $string = $rent['machine_id'];
                                        $array = explode(',', $string);  
                                        foreach($array as $value)  
                                        {
                                            $mn = $Controller->QueryData("SELECT machine_name FROM machine WHERE machine_id = ? AND machine_type='Manual' " , [$value])->fetch_assoc()['machine_name'];
                                            echo '<li>'; 
                                            echo $mn; 
                                            echo '</li>'; 
                                        }
                                    ?>
                                </ul>
                            </td>
                            <td><?= $rent['rentout_amount'];  ?></td>
                            <td><?= $rent['rent_date'];  ?></td>
                            <td><?= $rent['start_time'] ?></td>
                            <td><?= $rent['end_time'] ?></td>
                            <td><?= $rent['rent_type'] ?></td>
                            <td><?= $rent['rentout_payment'] ?></td>
                        </tr>
                    <?php } // END OF NUMROWS FIRST LOOP  ?>
                <?php } // END OF NUMROWS FIRST LOOP  ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog model-xl ">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel">لطف نموده ماشین مورد نظر خود را انتخاب نمایید</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <form action="StoreUsedMachine.php" id = "machine_form" method = "post" >
            <div class="modal-body">
                <div class="list-group">
                    <input type="hidden" id = "CYCLE_ID_" name="CYCLE_ID"  >
                    <input type="hidden" name="Manual"  value = "Manual">
                    <?php if ($machine_db_list->num_rows > 0) {  while($MACHINE = $machine_db_list->fetch_assoc()){    ?> 
                        <label class="list-group-item">
                            <input class="form-check-input me-1" name = "machine_<?=$MACHINE['machine_id'];?>"   value = "<?=$MACHINE['machine_id'] ?>"  type="checkbox"  >
                            <?= $MACHINE['machine_name'] . " ( ". $MACHINE['machine_name_pashto'] ."222 )"; ?> 
                        </label>  
                    <?php  } } else echo "Machine query has errors!"; ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    </div>
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

    function AddCycleId(cycle_id  ){
        document.getElementById('CYCLE_ID_').value = cycle_id; 
    }

    function AddCycleForCProduction(cycle_id){
        document.getElementById('CYCLE_ID_Pro').value = cycle_id; 
    }


    let total = {}; 
    function InputValue(name , value)   {
        total[name] = value; 
        CalculatePlates(); 
    }
    
    function CalculatePlates(){
    
        console.log(total) ;

        let TotalPacks = 0 ; 
        let FinalTotal = 0 ; 

        TotalPacks = ( Number(total.Plate) * Number(total.Line) * Number(total.Pack) ) + Number(total.ExtraPack)  ;
        FinalTotal = (Number(total['Carton']) * Number(TotalPacks) ) + Number(total.ExtraCarton)

        document.getElementById('TotalPacks').value =  TotalPacks; 
        document.getElementById('Total').value =  FinalTotal; 
    }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>