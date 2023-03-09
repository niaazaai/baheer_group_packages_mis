<?php ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/HOMEPAGE';
if(!in_array( $Gate['VIEW_SET_PRICE_DASHBOARD'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
  }


?>

<style>

.NewJobs-bg { background-color:#FB7AFC;}

.circle {
        width: 90px;
        height: 90px;
        line-height: 90px;
        border-radius: 50%;
        font-size: 28px;
        color: #fff;
        text-align: center;
        margin:0px; 
        display:table-cell;
        vertical-align: middle; 
    }
.circle-jobs { background:#f2f7ff ;  color:#0d6efd ; }
.circle-done { background:#f2f7ff ;  color:#198754 ; }
 
</style>

<div class="card m-3">
    <div class="card-body">
        <h3>Pricing Dashboard</h3>
    </div>
</div>

<div class="row m-3"> <!-- Start of the row -->
<?php  if(in_array( $Gate['VIEW_PRICE_SETTING_CARD'] , $_SESSION['ACCESS_LIST']  )) {?>
    <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 ms-0 p-1 " >
        <a href="PriceSetting.php" style="text-decoration:none;">
            <div class="card shadow-lg py-2  "  style = "border:3px solid #0d6efd;"  >
                <div class="card-body   "> 
                    <div  class = "d-flex justify-content-start">
                        <div class="circle circle-jobs ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                                <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
                            </svg>
                        </div>
                        <div class ="ms-3 my-3 pt-2">
                            <strong class = "p-0 m-0 fw-bold" style = "font-size:20px;color:black;"> Price Setting </strong>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
<?php  if(in_array( $Gate['VIEW_GRADE_LIMIT_CARD'] , $_SESSION['ACCESS_LIST']  )) {?>
    <div class="col-lg-3 col-md-12 col-sm-12  col-xs-12  mt-1 pe-0" >
        <a href="SetGrade.php" style="text-decoration:none;">
            <div class="card shadow-lg py-2  "style = "border:3px solid #198754" >
                <div class="card-body   "> 
                    <div  class = "d-flex justify-content-start">
                        <div class="circle circle-done ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-file-earmark-diff" viewBox="0 0 16 16">
                                <path d="M8 5a.5.5 0 0 1 .5.5V7H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5zm-2.5 6.5A.5.5 0 0 1 6 11h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                            </svg>
                        </div>
                        <div class ="ms-3 my-3 pt-2 ">
                            <strong class = "p-0 m-0 fw-bold" style = "font-size:20px;color:black;"> Set Grade Limit  </strong>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
<?php } ?>
</div>

<?php require_once '../App/partials/footer.inc'; ?>