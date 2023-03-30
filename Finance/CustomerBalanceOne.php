<?php
  ob_start(); require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php'; ?>
<?php 

if(isset($_REQUEST) && !empty($_REQUEST))
{
    $Currency=$_REQUEST['Currency'];  
    $SQL=$Controller->QueryData("SELECT CustId ,CTNId ,CustName, CtnCurrency, Sum(CTNTotalPrice) as total_price , Sum(ReceivedAmount) AS r_amount FROM `carton` 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1  WHERE  CtnCurrency = ?  Group by CustName",[$Currency]); 
}
?>

<div class="card m-3">
    <div class="card-body d-flex justify-content-between">
        <h4 class="font-bold p-0 m-0">
             Customer balance
        </h4>
        <div >
            <a href="CustomerCartonBalance.php" class="btn btn-outline-primary btn-sm">Stock Balance</a>  
             <a href="CustomerLoan.php" class="btn btn-outline-primary btn-sm">Job Balance</a>  
             <a href="CustomerBalanceDetail.php" class="btn btn-outline-primary btn-sm">Customer Balance</a>   
        </div>
    </div>
</div>

<form action="" method="POST">
    <div class="card m-3 shadow">
        <div class="card-body">
            <div class="row"> 
                <form action="" method="POST">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <select name="Currency" id="Currency" class="form-select" onchange="this.form.submit()">
                            <option selected>Select Currency</option>
                            <option value="AFN">AFN</option>
                            <option value="USD">USD</option>
                        </select>
                    </div> 
                </form>
                <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                    <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )"> 
                </div>
            </div>
        </div>                
    </div>
</form>

<div class="card m-3">
    <div class="card-body  ">
        <table class="table  " id="tableId" >
			<thead class="table-info">
				<tr style="background-color:#148d8d ;"> 
                    <th>Sr.No</th>
                    <th>Company</th>
                    <th>Balance</th>
				</tr>
			</thead>
            <tbody>
                <?php
                    $Count=1;
                    $Total=0;
                        if(isset($_REQUEST) && !empty($_REQUEST))
                        { 
                            while($rows=$SQL->fetch_assoc())
                            { 
                                $total = $rows['total_price'] -  $rows['r_amount'];
                                if($total > 0)  $color="badge bg-success";
                                elseif($total < 0) $color="badge bg-danger"; 

                                ?>
                                <tr> 
                                    <td> <?= $Count ?></td>
                                    <td><?=$rows['CustName']?></td>
                                    <td style="align-text:right;" > 
                                    <span class='<?=$color?>'>  <a href="CheckSpecificCustBalance.php?CustId=<?=$rows['CustId']?>&Currency=<?=$rows['CtnCurrency']?>"  style="color:white;  text-decoration:none;"><?=$total?></a> <?=$rows['CtnCurrency']?>  </span>
                                    </td>
                                </tr>
                            <?php
                                $Total+=$total;
                                $Count++;
                            }       
                        }
                            ?>
                    <tr>
                        <td colspan="2" class="fw-bold " style="padding-left: 500px;">Total</td>
                        <td><span class="badge bg-dark" ><?=$Total?></span> <span class="badge bg-warning"><?php if(isset($_REQUEST) && !empty($_REQUEST)) { echo $_REQUEST['Currency'];}else{}?></span></td>
                    </tr>
            </tbody>
        </table>
    </div>  
</div>

<script>
 
function search(Search_input ,JobTable)
 {
          var input, filter, table, tr, td, i, txtValue;
          input = document.getElementById('Search_input');
          filter = input.value.toUpperCase();
          table = document.getElementById('tableId');
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
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>