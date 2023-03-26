<?php  ob_start(); require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php'; ?>
<?php 
if(isset($_POST['SearchTearm']) && !empty($_POST['SearchTearm']))
{

    $Field=$_POST['Field'];
    $SearchTearm=$_POST['SearchTearm'];
    $SQL=$Controller->QueryData("SELECT carton.CTNId,carton.JobNo,carton.CTNOrderDate,carton.ProductName,carton.UsedQty,
                                       CONCAT (carton.CTNLength,' x ',carton.CTNWidth,' x ',carton.CTNHeight) AS Size ,carton.CTNQTY,
                                       carton.ProductQTY,carton.CTNStatus,ppcustomer.CustName 
                                       FROM carton INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId WHERE {$Field} = ?",[$SearchTearm]);
 

}

if(isset($_POST['status']) && !empty($_POST['status']))
{
    $Status=$_POST['status'];
    $ID=$_POST['CTNId'];
    

    $Update=$Controller->QueryData("UPDATE carton SET CTNStatus = ? WHERE CTNId=?",[$Status,$ID]);
    if($Update)
    {

      echo '<div class="m-3 alert alert-success alert-dismissible fade show " role="alert">
                <strong> </strong> Qoutation | Job Successfully Updated.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
              

    }
    else {
        
            echo '<div class="m-3 alert alert-warning alert-dismissible fade show " role="alert">
            <strong> !</strong> Data didnt Updated.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>'; 

        
    }


    $Field=$_POST['Field'];
    $SearchTearm=$_POST['SearchTearm'];
    $SQL=$Controller->QueryData("SELECT carton.CTNId,carton.JobNo,carton.CTNOrderDate,carton.ProductName,carton.UsedQty,
                                       CONCAT (carton.CTNLength,' x ',carton.CTNWidth,' x ',carton.CTNHeight) AS Size ,carton.CTNQTY,
                                       carton.ProductQTY,carton.CTNStatus,ppcustomer.CustName 
                                       FROM carton INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId WHERE {$Field} = ?",[$SearchTearm]);
}

?>


<div class="card m-3">
    <div class="card-body">
        <h4 class="font-bold"> Job Edit Status Changer </h4>
    </div>
</div>


<form action="" method="POST">
    <div class="card m-3 shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                    <select name="Field" id="Field" class='form-select'>
                        <option value='CTNId'>Quotation No</option>
                        <option value='JobNo'>Job No</option>
                    </select> 
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12"  style="z-index: 11;">
                    <input type="text" name = "SearchTearm" id = "SearchTearm" class="form-control " value = "<?php if(isset($CustomerName)) echo $CustomerName ; ?>" placeholder = "Search By Quotation | JobNo" onchange="this.form.submit()"> 
                </div>
            </div>
        </div>                
    </div>
</form>


<div class="card m-3">
    <div class="card-body">
        <table class="table table-responsive   table-striped table-hover" id="MyTable">
			<thead class="table-info">
				<tr style="background-color:#148d8d ;">
					<th >Q.No</th>
					<th >Job No</th>
					<th >Order Date</th>
					<th >Company Name</th>
					<th >Description</th>
					<th >Size</th>
					<th >Order QTY</th>
					<th >Prod QTY</th>
					<th >Delivered QTY</th>
                    <th >Available QTY</th>
                    <th >Status</th>
                    <th >State Changer</th>
				</tr>
			</thead>
            <tbody>
                <?php
                    if(isset($_POST['SearchTearm']) && !empty($_POST['SearchTearm']))
                    { 
                        while($Rows=$SQL->fetch_assoc()) 
                        {
                            $AvlQTY=$Rows['ProductQTY']-$Rows['UsedQty'];
                            ?>
                                
                                    <td><?=$Rows['CTNId']?></td> 
                                    <td><?=$Rows['JobNo']?></td> 
                                    <td><?=$Rows['CTNOrderDate']?></td> 
                                    <td><?=$Rows['CustName']?></td> 
                                    <td><?=$Rows['ProductName']?></td> 
                                    <td><?=$Rows['Size']?></td> 
                                    <td><?=$Rows['CTNQTY']?></td> 
                                    <td><?=$Rows['ProductQTY']?></td> 
                                    <td><?=$Rows['UsedQty']?></td> 
                                    <td><?=$AvlQTY?></td> 
                                    <td><?=$Rows['CTNStatus']?></td> 
                                    <td> 
                                        <form action="" method="POST">
                                                <input type='hidden' name='CTNId' value='<?=$Rows['CTNId'] ?>'>
                                                <input type="hidden" name="Field" value='<?php if(isset($_POST['Field'])) echo $_POST['Field']; ?>'>
                                                <input type="hidden" name="SearchTearm" value='<?php if(isset($_POST['SearchTearm'])) echo $_POST['SearchTearm'];?>' >
                                        
                                                <select name='status' id='status' class='form-select' onchange='this.form.submit();'>
                                                    <option disabled>Status</option>
                                                    <option value="New">MarketingQ</option>
                                                    <option value='FNew'>Finance</option>
                                                    <option value='Design'>Design</option>
                                                    <option value="Film">Film</option>
                                                    <option value='Archive'>Archive</option>
                                                    <option value='Production'>Production</option>
                                                    <option value='Production Process'>Under Production</option>
                                                    <option value='Printing'>Printing</option>
                                                    <option value='Completed'>Completed</option> 
                                                </select> 
                                        </form>
                                    </td>
                        <?php
                        }
                    }

                ?>
            </tbody>
        </table>
    </div>  
</div>

 

<?php  require_once '../App/partials/Footer.inc'; ?>