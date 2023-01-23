<?php
 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;

// if(isset($_REQUEST['CTNId']))
// {
     
// }


if(isset($_POST['Save&submit']))
{
    $CTNId=$_REQUEST['CTNId'];
    $CustId=$_REQUEST['CustId'];
    $SalesQTY=$_POST['SalesQTY'];
    $SelectCurrency=$_POST['SelectCurrency'];
    $UnitPrice=$_POST['UnitPrice'];
    $TotalPrice=$_POST['TotalPrice'];
    $Date=$_POST['Date'];
    $Comment=$_POST['Comment'];
}
 
?>

<div class="card m-3">
    <div class="card-body">
        <h3>
            <a class="btn btn-outline-primary " href="RejectedGoods.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>
            Rejected Goods Resale Form
        </h3>
    </div>
</div>

<form action="" method="POST">
    <div class="card m-3">
        <div class="card-body">
                <div class="row">
                    <p class="fw-bold fs-5">Job Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="JobNo">Job No</label>
                        <input type="text" class="form-control" name="JobNo" id="JobNo" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['JobNo']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="">Company Name</label>
                        <input type="text" class="form-control" name="CompanyName" id="CompanyName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['CustName']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="ProductName">Product Name</label>
                        <input type="text" class="form-control" name="ProductName" id="ProductName" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProductName']; } ?>" readonly>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="RejectedQTY">Rejected QTY</label>
                        <input type="text" class="form-control" name="RejectedQTY" id="RejectedQTY" value="<?php if(isset($_REQUEST['CTNId'])){ echo $Rows['ProductName']; } ?>" readonly>
                    </div>

                   
                    <p class="fw-bold mt-4 fs-5">Driver Info:-</p>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="SalesQTY">Sales QTY</label>
                        <input type="text" class="form-control" name="SalesQTY" id="SalesQTY" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="SelectCurrency">Select Currency</label>
                        <select name="SelectCurrency" id="SelectCurrency" class="form-select">
                            <option value="AFN">AFN</option>
                            <option value="USD">USD</option>
                            <option value="PKR">PKR</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="UnitPrice">Unit Price</label>
                        <input type="text" class="form-control" name="UnitPrice" id="UnitPrice" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="TotalPrice">Total Price</label>
                        <input type="text" class="form-control" name="TotalPrice" id="TotalPrice" required>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Date">Date</label>
                        <input type="date" class="form-control" name="Date" id="Date" required>
                    </div>
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 my-1">
                        <label class="fw-bold" for="Comment">Comment</label>
                         <textarea name="Comment" id="Comment" cols="30" rows="2" class="form-control"></textarea>
                    </div> 
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-4 my-1 d-flex justify-content-end"> 
                    <input type="submit" name="Save&submit" class="btn btn-outline-primary" value="Save & submit">
                </div> 
        </div>
    </div>
</form>
 
<?php  require_once '../App/partials/Footer.inc'; ?>