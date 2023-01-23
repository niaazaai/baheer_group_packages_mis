 <?php require_once '../App/partials/Header.inc';   ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<?php
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 5;


  function FindCurrentStatus( $StartTime , $EndTime , $label ){
    $Start = new DateTime($StartTime); 
    $End = new DateTime($EndTime); 
    $dteDiff  = $Start ->diff($End );
    $days = $dteDiff->format('%a');
    $start_date = new DateTime();
    $end_date = (new $start_date)->add(new DateInterval("P{$days}D") );
    $dd = date_diff($start_date,$end_date);
    return  $dd->y." years ".$dd->m." months ".$dd->d." days";


}


if (filter_has_var(INPUT_GET, 'Type') ) {
  $Type = $Controller->CleanInput($_GET['Type']); 
} 
if (filter_has_var(INPUT_POST, 'Type') ) {
  $Type = $Controller->CleanInput($_POST['Type']); 
} 



if(isset($_GET['id']) && !empty($_GET['id'])){
    $id= $_GET['id']; 


    $PageAddress = (isset($_GET['Address']) && !empty($_GET['Address'])) ? $_GET['Address']  : 'index' ;  



  

}elseif(isset($_POST['CustId']) && !empty($_POST['CustId'])){
    $id=$_POST['CustId'];
    $PageAddress = (isset($_POST['Address']) && !empty($_POST['Address'])) ? $_POST['Address']  : '' ;  
    if(isset($_POST['CustomerFollowUpForm']))
    {
        $Id=$_POST['CustId'];
        $ContactVia=$_POST['ContactVia'];
        $CompetitorName=$_POST['CompetitorName'];
        $Result=$_POST['Result'];
        $AlarmDate=$_POST['AlarmDate'];
        $Comment=$_POST['Comment'];

        // echo "ID : " . $id . "<br>"; 
        // echo "Contact Via : " . $ContactVia . "<br>"; 
        // echo "CompetitorName : " . $CompetitorName . "<br>"; 
        // echo "Result : " . $Result . "<br>"; 
        // echo "AlarmDate : " . $AlarmDate . "<br>"; 
        // echo "Comment : " . $Comment . "<br>"; 

        if($Result=='InActive') $Update=$Controller->QueryData("UPDATE ppcustomer SET CusStatus='InActive' WHERE CustId=$Id");
        elseif($Result=='Achieved')  $Update=$Controller->QueryData("UPDATE ppcustomer SET CusStatus='Active' WHERE CustId=$Id");

        $query=$Controller->QueryData("INSERT INTO ctnfollowup 
        (
            CustIdFollow,
            FollowVia,
            CompitatorName,
            FollowResult,
            AlarmDate,
            FollowComment
        )
        Values(?,?,?,?,?,?)",
        [
            $Id,
            $ContactVia,
            $CompetitorName,
            $Result,
            $AlarmDate,
            $Comment
        ]);
        if($query)
        {
            // header('Location:CustomerFollowUpForm.php?id=' . $Id); 
            echo '<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
            <strong>Info</strong> Follow Up Saved!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
        else {
            echo '<div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
            <strong>Info</strong> Follow Up Does Not Saved!.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }

} else die("No ID , This incident will be reported!");

  $Customer  = $Controller->QueryData("SELECT CustName ,CustId,  CusRegistrationDate, CusSpecification FROM ppcustomer WHERE CustId = ? " , [$id]) ;
  $Customer = $Customer->fetch_assoc();   
  $CustomerAge =  FindCurrentStatus($Customer['CusRegistrationDate'] , date('Y-m-d')  , 'Customer Date' ); 

?>

 
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between ">
        <div class = "d-flex justify-content-start " >
            <h5 class = "my-1" > 
              <a class= "btn btn-outline-primary   me-3" href="<?=$PageAddress?>.php?Type=<?=$Type?>">
                  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                  </svg>
              </a>   
              <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                  <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                  <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
              </svg>
               Customer Follow Up Form    <span style= "color:#FA8b09;" > <?php echo isset($Customer['CustName']) ? " - ( " . $Customer['CustName'] . " )"  : '';   ?> </span> 
               <span style = "font-size:12px; " ><?= "Work Duration: ". $CustomerAge;  ?></span>
            </h5>
        </div>
  
        <div class = "py-1" >
            <a href = "CustomerProfile.php?id=<?=$id ?>" class="btn btn-outline-primary  my-1 "  >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                      </svg>
                Profile
            </a>

            <button type="button" class="btn btn-outline-primary  my-1 " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Click to setup Columns  ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                    <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                    <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                </svg>
              Follow Up
          </button>
        </div> 

    </div>
</div> 





<!-- The Below code is written down for displaying the inserted data in tabel which was sent from above form to backend part. -->
<div class="card m-3">
<div class=" card-body table-responsive  ">
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Date</th>
      <th scope="col">Followed-By</th>
      <th scope="col">Contact-Via</th>
      <th scope="col">Comp-Name</th>
      <th scope="col">Alarm-Date</th>
      <th scope="col">Result</th>
      <th scope="col">Comment</th>
    </tr>
  </thead>
  <tbody>
 <?php 
    $i=1;
    
    if( isset($_POST['sub']) && !empty($_POST['sub']))
    {
        $FollowUpQuery=" SELECT  CustId,  ctnfollowup.AlarmDate ,ppcustomer.CustName, employeet.Ename,CusStatus,ctnfollowup.FollowResult, ctnfollowup.CompitatorName , ctnfollowup.FollowComment, 
        ctnfollowup.FollowVia , ctnfollowup.FollowDate  
        FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE CustId = ? AND CusStatus= 'Pending'";
        $FollowUpQuery .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';


        $PaginateQuery=" SELECT COUNT(CustId) AS RowCount   
        FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        LEFT JOIN employeet ON employeet.EId=carton.EmpId 
        LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow 
        WHERE CustId = ? AND CusStatus= 'Pending'";

        $RowCount =  $Controller->QueryData( $PaginateQuery ,[]  );
        $row = $RowCount->fetch_assoc(); 

        $pagination->records($row['RowCount']);
        $pagination->records_per_page($RECORD_PER_PAGE);
    }
    else {
      $FollowUpQuery = "SELECT CustId,  ctnfollowup.AlarmDate ,ppcustomer.CustName, employeet.Ename,CusStatus,ctnfollowup.FollowResult, ctnfollowup.CompitatorName , ctnfollowup.FollowComment, 
      ctnfollowup.FollowVia , ctnfollowup.FollowDate FROM  ppcustomer 
        LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow
        LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow
      WHERE CusStatus= 'Pending' AND CustId=?"; 
      $FollowUpQuery .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';

    $DataRows  = $Controller->QueryData($FollowUpQuery, [$id]);
      
      $PaginateQuery= "SELECT COUNT(CustId) AS RowCount  FROM  ppcustomer 
        LEFT JOIN ctnfollowup ON ppcustomer.CustId=ctnfollowup.CustIdFollow
        LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow
      WHERE CusStatus= 'Pending' AND CustId=?"; 
          $RowCount =  $Controller->QueryData( $PaginateQuery ,[$id]  );
          $row = $RowCount->fetch_assoc(); 
  
          $pagination->records($row['RowCount']);
          $pagination->records_per_page($RECORD_PER_PAGE);
    }

    if (is_array($DataRows) || is_object($DataRows))
    {
        foreach ($DataRows as $RowsKey => $Rows) 
        {
             echo"<tr>";
             echo"<td>".$i."</td>";
             echo"<td>".$Rows['FollowDate']."</td>";
             echo"<td>".$Rows['Ename']."</td>";
             echo"<td>".$Rows['FollowVia']."</td>";
             echo"<td>".$Rows['CompitatorName']."</td>";
             echo"<td>".$Rows['AlarmDate']."</td>";
             echo"<td>".$Rows['FollowResult']."</td>";
             echo"<td>".$Rows['FollowComment']."</td>";
             echo"</tr>";
             $i++;
        }   
    } 
?>
  </tbody>
</table>
</div>
</div>

<div class="card  ms-3 me-3 mb-3 p-0">
  <div class="card-body d-flex justify-content-center  ">
      <span class="pt-4"><?php $pagination->render(); ?></span>
  </div>
</div>

<?php  require_once 'partials/Footer.inc'; ?>

<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Customer Follow Up Form
        <span style= "color:#FA8b09;" > <?php echo isset($Customer['CustName']) ? " - ( " . $Customer['CustName'] . " )"  : '';   ?> </span> 
               <span style = "font-size:12px; " ><?= "Work Duration: ". $CustomerAge;  ?></span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body ">
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?Type=<?= $Type?>" method = "post" >
            <div class="modal-body">
                <input type="hidden" name="CustId" value="<?=$id?>"> 
                <input type="hidden" name="Address" value = "<?=$PageAddress ?>" >
                    <div class="card-body"> <!-- card body start div -->
                        <div class="row">                        
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12  mt-2">
                                <label class="form-label" for="ContactVia">Contact via</label>
                                <select class="form-control  " name="ContactVia">
                                    <option>Select Contact Type</option>
                                    <option value="Mobile">Mobile</option>
                                    <option value="Whatsup">Whatsup</option>
                                    <option value="Email">Email</option>
                                    <option value="Visit">Visit</option>
                                    <option value="Meeting">Meeting</option>
                                </select>                    
                            </div> 
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label class="form-label" for="CompetitorName">Competitor Name  </label>
                                <input type="text" name="CompetitorName" id="CompetitorName" class="form-control fs-5">
                                <span id="CompetitorNameError" class="text-danger" style="font-size: 16px;"></span>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label class="form-label" for="Result">Result</label>
                                <select class="form-control " name="Result">
                                    <option>Select Result Type</option>
                                    <option value="Change Product">Change Product</option>
                                    <option value="Wrong Details">Wrong Details</option>
                                    <option value="High Price">High Price</option>
                                    <option value="Copy Right Issue">Copy Right Issue</option>
                                    <option value="Below Minimum QTY">Below Minimum QTY</option>
                                    <option value="Wrong Print">Wrong Print</option>
                                    <option value="Time Limit">Time Limit</option>
                                    <option value="Behavior Issue">Behavior Issue</option>
                                    <option value="Late Print">Late Print</option>
                                    <option value="Not Running business">Not Running business</option>
                                    <option value="Low Quality">Low Quality</option>
                                    <option value="Achieved">Achieved</option>
                                    <option value="InActive">In Active</option>
                                    <option value="On_going Communication">On-going Communication</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Season">Season</option>
                                    <option value="Stopped">Stopped</option>
                                </select>                    
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label class="form-label" for="AlarmDate">Alarm Date</label>
                                <input type="datetime-local" name="AlarmDate" id="AlarmDate" class="form-control ">              
                            </div>
                            <div class="col-lg-8 col-md-6 col-sm-12 col-xs-12 mt-2">
                                <label class="form-label" for="Comment">Comment</label>
                                <textarea class="form-control fs-5" style="height:10px;" name="Comment" id="Comment"></textarea>
                                <span id="CommentError" class="text-danger" style="font-size: 16px;"></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex justify-content-end"  >
                                <input class="btn btn-outline-primary my-3 me-1  " type="submit" name="CustomerFollowUpForm" value="Save" title="It will save data into database">
                                <input class="btn btn-outline-secondary my-3 " type="reset" value="Clear" title="It will clear the filled data in form">
                            </div>    
                        </div>

                    </div>     
            </div> <!-- card body end div -->  
      </form>
    </div>
  </div>
</div>


