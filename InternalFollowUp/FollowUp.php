<?php
    require_once '../App/partials/Header.inc'; 
    require_once '../App/partials/Menu/MarketingMenu.inc';   
    require_once 'InternalFollowUpController.php';
    require_once '../Assets/Carbon/autoload.php'; 
    use Carbon\Carbon;

    if (isset($_GET) && !empty($_GET)) {
        $CustId = $_GET['CustId'];
        $CTNId = $_GET['CTNId'];
        
    } 
    else  header("InternalFollowUp.php");

    $Data  = $Controller->QueryData("SELECT  JobNo , ProductName , CustName , ppcustomer.CustWorkPhone ,ppcustomer.CustMobile , ppcustomer.CmpWhatsApp  FROM  carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE ppcustomer.CustId = ? AND carton.CTNId = ? ", [$CustId , $CTNId] );
    $IFCData = $Data->fetch_assoc();

    $cylc  = $Controller->QueryData( "SELECT  *  FROM production_cycle  WHERE cycle_status = 'Completed' AND CTNId = ?  ", [$CTNId] );
    $PAGE_SWITCH = 'NOT WAREHOUSE'; 
    if($cylc->num_rows > 0 ) {
        $PAGE_SWITCH = 'WAREHOUSE';
        // while ($cycle = $cylc->fetch_assoc()) {
        //     echo $cycle['status']; 
        // }
    }
    $PAGE_SWITCH = 'WAREHOUSE';
?>  

<style>
    .strong-text {
        font-weight:bold; 
        font-size:20px;
    }
</style>

<div class="m-3">
    
    <div class="card  mb-3">
        <div class="card-body d-flex justify-content-between ">
            <h3 class = "m-0 p-0 my-1"> 
                <a class= "btn btn-outline-primary  " href="index.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
                    </svg>
                </a>  
                <?php if($PAGE_SWITCH == 'WAREHOUSE') echo "Finished Goods Follow Up";  else  echo "Jobs Follow Up";    ?>
            </h3>
            <div>
                <a href="Manual/CustomerRegistrationForm_Manual.php" style  = "text-decoration:none;"  class = "text-primary" title = "Click to Read the User Guide " >
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                        <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                        <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                        <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
                    </svg>
                </a>

                <?php if(!isset($_GET['IFU']) && empty($_GET['IFU'])) { ?>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Follow Up Form" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                            <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                        </svg>
                        Follow Up
                    </button>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php if($PAGE_SWITCH == 'WAREHOUSE') { ?>
        <div class="card  mb-3">
            <div class="card-body  ">
                <div class="row"   >
                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="">
                            <div class="strong-text"> <?php echo  (isset($IFCData['CustName']) && !empty($IFCData['CustName']) )  ?  $IFCData['CustName'] : "N/A"; ?></div>
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                            <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                            </svg>
                                Customer Name
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-6">
                        <div class="">
                            <div class="strong-text ">  <?php echo  (isset($IFCData['ProductName']) && !empty($IFCData['ProductName']) )  ?  $IFCData['ProductName'] : "N/A"; ?> </div>
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                            <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            Product </div>
                        </div>
                    </div>


                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="">
                            <div class="strong-text ">  <?php echo  (isset($IFCData['CustWorkPhone']) && !empty($IFCData['CustWorkPhone']) )  ?  $IFCData['CustWorkPhone'] : "N/A"; ?>  </div>
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                            </svg>

                                Work Phone</div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="">
                            <div class="strong-text ">  <?php echo  (isset($IFCData['CustMobile']) && !empty($IFCData['CustMobile']) )  ?  $IFCData['CustMobile'] : "N/A"; ?> </div>
                            <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                            <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                            <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                            </svg>
                            Mobile</div>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-4 col-xs-6">
                        <div class="">
                            <div class="strong-text "><?php echo  (isset($IFCData['CmpWhatsApp']) && !empty($IFCData['CmpWhatsApp']) )  ?  $IFCData['CmpWhatsApp'] : "N/A"; ?> </div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"/>
                            </svg>
                            Whatsapp</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php } else {  ?>
        <div class="card  mb-3">
            <div class="card-body  ">
            <div class="row">
                <div class="col-lg-1 col-md-1 col-sm-12 col-xs-6">
                    <div class="">
                        <div class="strong-text ">  <?php echo  (isset($IFCData['JobNo']) && !empty($IFCData['JobNo']) )  ?  $IFCData['JobNo'] : "N/A"; ?>  </div>
                        <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                            <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                        </svg>
                        Job No</div>
                    </div>
                </div>

                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-6">
                    <div class="">
                        <div class="strong-text"> <?php echo  (isset($IFCData['CustName']) && !empty($IFCData['CustName']) )  ?  $IFCData['CustName'] : "N/A"; ?></div>
                        <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                        </svg>
                            Customer Name
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-6">
                    <div class="">
                        <div class="strong-text ">  <?php echo  (isset($IFCData['ProductName']) && !empty($IFCData['ProductName']) )  ?  $IFCData['ProductName'] : "N/A"; ?> </div>
                        <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                        <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                        <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                        </svg>
                        Product </div>
                    </div>
                </div>

            </div>
            </div>
        </div>
    <?php }   ?>


    <div class = "mx-3">
        <div class="card ">
            <div class="card-body table-responsive ">
                <table class="table" id = "main-table"  >
                    <thead>
                        <tr >
                            <th scope="col">Follow Up Date</th>
                            <th scope="col">Deadline</th>
                            <?php if($PAGE_SWITCH == 'WAREHOUSE') echo '<th scope="col" >Results</th>';  ?>
                            <th scope="col">Comment</th>
                        </tr>
                    </thead>
                    <?php
                        $FollowUpDB  = $Controller->QueryData("SELECT * FROM follow_up WHERE customer_id  = ? AND CTNId = ?   ", [$CustId , $CTNId] );
                        // $FollowUpDB  = $Controller->QueryData("SELECT * FROM (  SELECT * FROM follow_up ORDER BY current_date DESC LIMIT 5 )  ORDER BY current_date ASC", [$CustId] ); ORDER BY current_date DESC LIMIT 5
                        // SELECT * FROM (  SELECT * FROM follow_up ORDER BY current_date DESC LIMIT 5 ) sub ORDER BY current_date ASC

                        while($FollowUp = $FollowUpDB->fetch_assoc()): ?>
                        <tr> 	
                            <td>
                                <?php 
                                    if(isset($FollowUp['current_date']) && !empty($FollowUp['current_date'])) {
                                        $a =  Carbon::create($FollowUp['current_date'] , 'Asia/Kabul')->diffForHumans(); 
                                        echo "<span class = 'badge bg-success'>{$a}</span>";
                                    }
                                ?> 
                            </td>
                            <td><?=$FollowUp['deadline']?></td>
                            <?php if($PAGE_SWITCH == 'WAREHOUSE') { ?>
                                <td> <span class = "<?= ($FollowUp['follow_result'] == 'Rejected') ? 'fw-bold text-white bg-danger p-1' : '' ?>" ><?=$FollowUp['follow_result']?> </span> </td>
                            <?php } ?>
                            <td><?=$FollowUp['comment']?></td>
                        </tr>
                    <?php endwhile; ?>
                </table>
            </div>
        </div>
    </div>

</div>


    <!-- Modal -->
    <div class="modal fade"   id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true"><!-- Start of the model div -->
    <div class="modal-dialog modal-md"> <!-- Start of the model-dialog div -->
        <div class="modal-content">  <!-- Start of the model-content div -->
        <div class="modal-header">
            <h4 class="modal-title">Write your comment </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="InternalFollowUpController.php" method = "post" >
                <input type="hidden" name="customer_id"  value = "<?=$CustId; ?>" >
                <input type="hidden" name="CTNId"  value = "<?=$CTNId; ?>" >
                <div class="row mb-3">

                <?php   

                        $style = "width:463px;";   
                        $class = "col-lg-12 col-md-12 col-sm-12 col-xs-12"; 

                        if($PAGE_SWITCH == 'WAREHOUSE') {    
                            $class = "col-lg-6 col-md-6 col-sm-12 col-xs-12";  
                            $style = "";  
                ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label for="follow-result">Follow Up Results</label>
                            <select name="follow_result" id="follow-result" class = "form-control">
                                <option value="Will come Today">Today</option>
                                <option value="Will come Tommorw">Tommorw</option>
                                <option value="Will come After 2 Days">2 Days </option>
                                <option value="Will come After 3 Days">3 Days </option>
                                <option value="Will come After 4 Days ">Four Days </option>
                                <option value="Will come After 5 Days ">Five Days</option>
                                <option value="Will come After 6 Days ">Six Days </option>
                                <option value="Will come This Week">This Week </option>
                                <option value="Will come Next Week">Next Week</option>
                                <option value="Will come This Month">This Month</option>
                                <option value="Will come Next Month">Next Month</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                        </div>
                    </div>

                    <?php }    ?>

                    <div class="<?=$class?>">
                        <div class="form-group">
                            <label for="deadline">Deadline</label>
                            <input type="datetime-local" name="deadline" style="<?=$style?>"  class = "form-control" id = "deadline"    >
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <textarea name="comment" placeholder = "Comment" class = "form-control" id="" cols="30" rows="10" required ></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary"  type="submit" name = "SaveFollowUp" >Save </button>
                </div>
            </form>
        </div> <!-- End of the model-content div -->
    </div>  <!-- End of the model-dialog div -->
    </div><!-- End of the model div -->
    <!-- Modal -->

    <?php  require_once '../App/partials/Footer.inc'; ?>

