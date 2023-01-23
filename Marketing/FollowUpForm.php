 <?php 
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';   
    require_once '../Assets/Zebra/Zebra_Pagination.php';
    $pagination = new Zebra_Pagination();
 

    if (isset($_GET['id']) && !empty($_GET['id'])) { 
        $CartonId=$_GET['id']; 
         $PageAddress = (isset($_GET['Address']) && !empty($_GET['Address'])) ? $_GET['Address']  : 'index' ;  

    }
    elseif (isset($_POST['CTNId']) && !empty($_POST['CTNId'])) { 
        $CartonId=$_POST['CTNId'];
        $PageAddress = (isset($_POST['Address']) && !empty($_POST['Address'])) ? $_POST['Address']  : '' ;  
        if(isset($_POST['FollowUpForm']))
        {
            $CtnId =$_POST['CTNId'];
            $ContactVia=$_POST['ContactVia'];
            $NewPrice=$_POST['NewPrice'];
            $NewGR =$_POST['NewGR'];
            $CompetitorPrice=$_POST['CompetitorPrice'];
            $CompetitorName=$_POST['CompetitorName'];
            $Result=$_POST['Result'];
            $AlarmDate=$_POST['AlarmDate'];
            $Comment=$_POST['Comment'] ;

            if($Result=='InActive')   $Update=$Controller->QueryData("UPDATE ppcustomer SET CTNStatus='InActive' WHERE CustId=$CtnId");
            elseif($Result=='Achieved')  $Update=$Controller->QueryData("UPDATE ppcustomer SET CTNStatus='Active' WHERE CustId=$CtnId");
        
            $query=$Controller->QueryData("INSERT INTO ctnfollowup 
            (
                CtnIdFollow,
                FollowVia,
                OtherPrice,
                FollowPriceGrade,
                PriceFollow,	
                CompitatorName,
                FollowResult,
                AlarmDate,
                FollowComment
            )
            Values(?,?,?,?,?,?,?,?,?)",
            [
                $CtnId,
                $ContactVia,
                $NewPrice,
                $NewGR ,
                $CompetitorPrice,
                $CompetitorName,
                $Result,
                $AlarmDate,
                $Comment
            ]);
            if($query)
            {
                // header('Location:CustomerFollowUpForm.php?id=' . $Id); 
                echo    '<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                            <strong>Info</strong> Follow Up Saved!.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
            else {
                echo ' <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                            <strong>Info</strong> Follow Up Does Not Saved!.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
            }
        }

        
    }
    else die('No ID : This Incident Will be Reported'); 


    $Query="SELECT CTNId, CTNOrderDate,ProductName,CTNPrice,GrdPrice FROM carton WHERE CTNId=?";
    $Excute=$Controller->QueryData($Query,[$CartonId]);
    $out=$Excute->fetch_assoc();


  

?>

 
<div class="card m-3 ">
  <div class="card-body d-flex justify-content-between">
        <div class = "d-flex justify-content-start " >
                <h5 class = "my-1" > 
                <a class= "btn btn-outline-primary   me-3" href="<?=$PageAddress?>.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </a>   
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                        <path fill-rule="evenodd" d="M5.216 14A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216z"/>
                        <path d="M4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z"/>
                    </svg>  (P & Q)Follow Up Form   <span style= "color:#FA8b09;" > <?php echo isset($out['ProductName']) ? " - ( " . $out['ProductName'] . " )"  : '';   ?> </span>  
                    
                    <span    style= " font-size:12px;   ">
                        <strong>Grade: </strong>  <?php echo $out['GrdPrice']; ?>  | 
                        <strong>Order-Price:  </strong> <?php echo $out['CTNPrice']; ?> | 
                        <strong>Order Date:  </strong> <?=$out['CTNOrderDate']; ?>
                    </span>
                </span>
                </h5>
        </div>
        
        <div class = "py-1" >
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
    <div class="card-body table-responsive">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Followed-By</th>
                <th scope="col">Contact-Via</th>
                <th scope="col">New-Price</th>
                <th scope="col">New-GR</th>
                <th scope="col">Comp-Price</th>
                <th scope="col">Comp-Name</th>
                <th scope="col">Alarm-Date</th>
                <th scope="col">Result</th>
                <th scope="col">Comment</th>
                </tr>
            </thead>
            <tbody>
            <?php
                
                $i=1;
                $RECORD_PER_PAGE = 5;
                    
                $Query="SELECT FollowDate,EmpIdFollow,Ename,FollowVia,PriceFollow,FollowPriceGrade,OtherPrice,CompitatorName,AlarmDate,FollowResult,FollowComment , ProductName 
                FROM carton LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
                LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
                LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow 
                WHERE JobNo = 'NULL' AND  CTNStatus='Pending'   AND  CTNId = ?"; 
                $Query .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
                $DataRows  = $Controller->QueryData($Query, [$CartonId]);


                $PaginateQuery="  SELECT COUNT(ctnfollowup.CtnIdFollow) AS RowCount FROM carton LEFT JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
                LEFT JOIN ctnfollowup ON carton.CTNId=ctnfollowup.CtnIdFollow
                LEFT JOIN employeet ON employeet.EId=ctnfollowup.EmpIdFollow 
                WHERE JobNo = 'NULL' AND  CTNStatus='Pending'   AND  CTNId = ?"; 
                $RowCount =  $Controller->QueryData(   $PaginateQuery ,[$CartonId]  );
                $row = $RowCount->fetch_assoc(); 
                $pagination->records($row['RowCount']);
                $pagination->records_per_page($RECORD_PER_PAGE);
                                        
                if (is_array($DataRows) || is_object($DataRows))
                {
                    foreach ($DataRows as $RowsKey => $Rows) 
                    {
                        echo"<tr>";
                        echo"<td>".$i."</td>";
                        echo"<td>".$Rows['FollowDate']."</td>";
                        echo"<td>".$Rows['Ename']."</td>";
                        echo"<td>".$Rows['FollowVia']."</td>";
                        echo"<td>".$Rows['PriceFollow']."</td>";
                        echo"<td>".$Rows['FollowPriceGrade']."</td>";
                        echo"<td>".$Rows['OtherPrice']."</td>";
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


 
<div class="card m-3 ">
    <div class="card-body d-flex justify-content-center">
        <?php     $pagination->render(); ?>
    </div>
</div>


<?php  require_once '../App/partials/Footer.inc'; ?>




<!-- Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Follow Up Form <span style= "color:#FA8b09; font-size:12px;  text-transform: uppercase;" >
         <?php echo isset($out['ProductName']) ? "  - ( " . $out['ProductName'] . " )"  : '';   ?></span>  
         <span    style= " font-size:12px;   ">
                        <strong>Grade: </strong>  <?php echo $out['GrdPrice']; ?>  | 
                        <strong>Order-Price:  </strong> <?php echo $out['CTNPrice']; ?> | 
                        <strong>Order Date:  </strong> <?=$out['CTNOrderDate']; ?>
                    </span>
        </h5> 
  
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     
      <div class="modal-body ">
         <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
         <div class="card-body"> <!-- card body start div -->
                <input type="hidden" name="Address" value = "<?=$PageAddress ?>" >
                <input type="hidden" name="CTNId" value = "<?=$CartonId?>">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12   mt-2">
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
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12   mt-2">
                    <label class="form-label" for="NewPrice">New Price</label>
                    <input type="text" name="NewPrice" id="NewPrice" class="form-control  ">
                    <span id="NewPriceError" class="text-danger" style="font-size: 16px;"></span>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12   mt-2">
                    <label class="form-label" for="NewGR">New GR</label>
                    <input type="text" name="NewGR" id="NewGR" class="form-control ">
                    <span id="NewGRError" class="text-danger" style="font-size: 16px;"></span>
                </div> 
                  <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12   mt-2">
                    <label class="form-label" for="CompetitorPrice">Competitor price</label>
                    <input type="text" name="CompetitorPrice" id="CompetitorPrice" class="form-control ">
                    <span id="CompetitorPriceError" class="text-danger" style="font-size: 16px;"></span>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12  mt-2">
                    <label class="form-label" for="CompetitorName">Competitor Name  </label>
                    <input type="text" name="CompetitorName" id="CompetitorName" class="form-control  ">
                    <span id="CompetitorNameError" class="text-danger" style="font-size: 16px;"></span>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12   mt-2">
                    <label class="form-label" for="Result">Result</label>
                    <select class="form-control  " name="Result">
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
                        <option value="InActive">In-Active</option>
                        <option value="On-going Communication">On-going Communication</option>
                        <option value="Completed">Completed</option>
                        <option value="Season">Season</option>
                        <option value="Stopped">Stopped</option>
                    </select>                    
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12  mt-2">
                    <label class="form-label" for="AlarmDate">Alarm Date</label>
                    <input type="datetime-local" name="AlarmDate" id="AlarmDate" class="form-control ">              
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12   mt-2">
                    <label class="form-label" for="Comment">Comment</label>
                    <textarea class="form-control  " style="height:10px;" name="Comment" id="Comment"></textarea>
                    <span id="CommentError" class="text-danger" style="font-size: 16px;"></span>
                </div>               
            </div>
            <div class="row">
                <div class="d-flex justify-content-end">
                    <input class="btn btn-outline-primary  mx-1 mt-5" type="submit" name="FollowUpForm" value="Save" title="It will save data into database">
                    <input class="btn btn-outline-secondary  mt-5 " type="reset" value="Clear" title="It will clear the filled data in form">
                </div>
            </div>
        </div>     
    </div> <!-- card body end div -->
      </form>
    </div>
  </div>
</div>
