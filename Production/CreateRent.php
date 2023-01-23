<?php 
ob_start();
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';

if(isset($_GET['CTNId']) && !empty($_GET['CTNId']) && isset($_GET['cycle_id']) && !empty($_GET['cycle_id'])) {
    $CTNId = $Controller->CleanInput($_GET['CTNId']); 
    $cycle_id = $Controller->CleanInput($_GET['cycle_id']); 
    $Machines = $Controller->QueryData("SELECT machine_id , machine_name FROM machine WHERE machine_type = 'Manual'", []);
    // 
}
else header('Location:ManualCycle.php?msg=No CTNId and Cycle ID &class=danger'); 

/*
|----------------------------------------------------------------------
| SAVE RENTOUT INFORMATION TO DATABASE 
|----------------------------------------------------------------------
*/

if( 
    isset($_POST['CTNId']) && !empty($_POST['CTNId']) && 
    isset($_POST['cycle_id']) && !empty($_POST['cycle_id']) &&  
    isset($_POST['machine_id']) && !empty($_POST['machine_id']) &&  
    isset($_POST['employee_id']) && !empty($_POST['employee_id']) &&  
    isset($_POST['rentout_amount']) && !empty($_POST['rentout_amount']) &&  
    isset($_POST['rent_date']) && !empty($_POST['rent_date']) &&  
    isset($_POST['start_time']) && !empty($_POST['start_time']) &&  
    isset($_POST['end_time']) && !empty($_POST['end_time']) &&  
    isset($_POST['rent_reason']) && !empty($_POST['rent_reason'])  

  ) {


    foreach ($_POST as $key => $value) {
        if($key == 'machine_id' || $key == 'employee_id') continue; 
        $_POST[$key] = $Controller->CleanInput($_POST[$key]); 
    }
    
    $machine_id = ''; 
    $employee_id = ''; 

    // this will gather upp all machine id in a single string to store in machine id to avoid long table relationship 
    $i = 0;
    $numItems = count($_POST['machine_id']);
    foreach ($_POST['machine_id'] as $key => $value) {
        $machine_id .= $value; 
        if(++$i !== $numItems) $machine_id .= ','; 
    }

    // this will gather upp all employee id in a single string to store in employee_id to avoid long table relationship 
    $i = 0;
    $numItems = count($_POST['employee_id']);
    foreach ($_POST['employee_id'] as $key => $value) {
        $employee_id .= $value; 
        if(++$i !== $numItems) $employee_id .= ','; 
    }

    $rent_outs = $Controller->QueryData(
        "INSERT INTO carton_rentout ( employee_id,CTNId, cycle_id, machine_id, rentout_amount,rent_date,start_time,end_time,rent_reason,rent_type) 
        VALUES ( ?,?,?,?,?,?,?,?,?,?)", 
    [ $employee_id , $_POST['CTNId'],$_POST['cycle_id'],$machine_id,$_POST['rentout_amount'],$_POST['rent_date'],$_POST['start_time'],$_POST['end_time'],$_POST['rent_reason'],$_POST['rent_type']]);

    header('Location:Rent.php?msg=No CTNId and Cycle ID &class=danger'); 
    
}// end of if 

?>

<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h4 class = "p-0 m-0" >
            Renout Cartons From
        </h4>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.27.1/slimselect.min.css" rel="stylesheet"></link>



<div class="card m-3 shadow">
    <div class="card-body">
        <form action="" method="post">
            <input type="hidden" name="CTNId" value = "<?=$CTNId?>" >
            <input type="hidden" name="cycle_id" value = "<?=$cycle_id?>" >

            <div class="row">
                 
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                   <label for="">Rent out to who </label>
                   <select name="employee_id[]" id="multiple" multiple ></select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <label for="machine_id">Select Machines </label>
                    <select  id="machine_id" name = "machine_id[]" aria-label="Machines" multiple  >
                        <?php if($Machines->num_rows > 0 ){   ?>
                            <?php while ($machine = $Machines->fetch_assoc()) { ?>
                                <option value="<?=$machine['machine_id']?>"><?=$machine['machine_name']?></option>
                            <?php } // END OF NUMROWS FIRST LOOP  ?>
                            <option value="کاردستی">کار دستی</option>
                        <?php } // END OF IF   ?>
                    </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 my-1">
                    <label for="rent_type">Rent Type </label>
                    <select  id="rent_type" name = "rent_type" aria-label="Rent Type" >
                        <option value="اضافه کاری">اضافه کاری</option>
                        <option value="حساب نقدی">حساب نقدی</option>
                        <option value="روز رسمی">روز رسمی</option>
                        <option value="روز رسمی و اضافه کاری">روز رسمی و اضافه کاری</option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="rentout_amount" name="rentout_amount" >
                        <label for="">Carton Amount</label>
                    </div>
                </div>
               
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="date" class="form-control" id="rent_date" name="rent_date" >
                        <label for=""> Date</label>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="start_time" name="start_time" >
                        <label for="">Start Time</label>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <input type="time" class="form-control" id="end_time" name="end_time" >
                        <label for="">End Time</label>
                    </div>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 my-1">
                    <div class="form-floating">
                        <textarea class="form-control" name = "rent_reason" placeholder="Leave a comment here" id="rent_reason"></textarea>
                        <label for="rent_reason">Rent Reason</label>
                    </div>

                </div>

            </div>

            <div class = "mt-2 text-end">
                <button type="submit" class="btn btn-primary" >Save changes</button>
            </div>

        </form>
    </div>
</div>




<script>

    new SlimSelect({
        select: '#multiple', 
        searchingText: 'Searching...', // Optional - Will show during ajax request
        ajax: function (search, callback) {
        // Check search value. If you dont like it callback(false) or callback('Message String')
        if (search.length < 2) {
            callback('Need 2 characters')
            return
        }

        const url = "FindEmployee.php?name=" + search;
        
        // Perform your own ajax request here
        fetch(url)
        .then(function (response) {
            return response.json()
        })
        .then(function (json) {
            let data = []
            for (let i = 0; i < json.length; i++) {
                data.push({text: json[i].Ename, value:json[i].EId })
            }
        //    console.log(json);
        //    console.log(data);

            callback(data)
        })
        .catch(function(error) {
            // If any erros happened send false back through the callback
            callback(false)
        })
        }
    });

    new SlimSelect({
        select: '#machine_id'
    }); 

    new SlimSelect({
        select: '#rent_type'
    }); 

</script>
   
