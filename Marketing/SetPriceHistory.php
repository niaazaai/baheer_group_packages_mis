<?php ob_start();
    require_once '../App/partials/header.inc';    
    require_once '../App/partials/Menu/MarketingMenu.inc';

    
$Gate = require_once  $ROOT_DIR . '/Auth/Gates/HOMEPAGE';
if(!in_array( $Gate['VIEW_PRICE_HISTORY'] , $_SESSION['ACCESS_LIST']  )) {
    // header("Location:index.php?msg=You are not authorized to access this page!" );
    echo "hjfjksfhdks";
  }

    require_once '../Assets/Zebra/Zebra_Pagination.php';
    $pagination = new Zebra_Pagination();

    $RECORD_PER_PAGE = 15;

    $Query = "SELECT * FROM set_price_history ORDER BY id DESC "; 
    $PagQuery = ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
    $Query .=   $PagQuery;
    $DR =  $Controller->QueryData($Query,[]);


    $RowCount =  $Controller->QueryData('SELECT COUNT(id) AS RowCount FROM set_price_history ORDER BY id DESC' , [] );
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($row['RowCount']);
    $pagination->records_per_page($RECORD_PER_PAGE);

    if (isset($_POST) && !empty($_POST)) {
        $From= $Controller->CleanInput($_POST['From']);
        $To=$Controller->CleanInput($_POST['To']);

        if(!empty($From) && !empty($To)){ 
             $Query = "SELECT * FROM set_price_history WHERE  DATE(updated_at)    BETWEEN ? AND ? ORDER BY updated_at DESC"; 
             $DR =  $Controller->QueryData($Query,[  $From  , $To ]);
        }
    }


?>

 


<div class="m-3">



 




    <div class="card mb-3 ">
    <div class="card-body d-flex justify-content-between ">
        <h4 class = "my-2" > 
            <a class= "btn btn-outline-primary  " href="SetPrice.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>    

            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
                <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
            </svg>
            Price Setting History   
        </h4>
        <div class = "my-2" >
        <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide" >
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
            </svg>
        </a>
        
        </div>
    </div>
    </div>


        

    <div class="card mb-3">
        <div class="card-body  ">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" > 
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <label class="form-label">From</label>
                    <input type="date" class="form-control" name="From">
                </div>
                <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12">
                    <label class="form-label">To</label>
                    <input type="date" class="form-control" name="To" onchange="this.form.submit();">
                </div> 


            </div>
            </form>
        </div>
    </div>



    <div class="card">
        <div class ="text-center my-3" >
            <h3 style = "padding:0px;margin:0px;" >Price Setting History</h3>
        </div>
        <hr style = "padding:0px; margin:0px;" >
        <div class="card-body  table-responsive   ">
            <table class="table " id = ""  >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>New Price</th>
                    <th>Old Price</th>
                    <th>Timestamp</th>
                    <th>By Who</th>
                </tr>
            </thead>
            <tbody>

            <?php  $count = 1; 
            while($DataRows = $DR->fetch_assoc()):
            ?>
                <tr>
                    <td><?=$count++; ?></td>
                    <td><?=$DataRows['name']; ?></td>
                    <td><?=$DataRows['new_value']; ?></td>
                    <td><?=$DataRows['old_value']; ?></td>
                    <td><?=$DataRows['updated_at']; ?></td>
                    <td><?=$DataRows['by_who']; ?></td>
                </tr>
            <?php endwhile;  ?>
            </tbody>
            </table>
        </div>
    </div>

    <div class = "d-flex justify-content-center mx-auto my-3" >
        <?php // render the pagination links
                $pagination->render();
            ?>
        </div>

</div><!-- END OF M-3  -->

    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <?php if(isset( $_SESSION['msg'])) {    ?>
            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
                <strong>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>  Information</strong> <?= $_SESSION['msg'] ?>
                                
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
    </div>

<?php require_once '../App/partials/footer.inc'; ?>
