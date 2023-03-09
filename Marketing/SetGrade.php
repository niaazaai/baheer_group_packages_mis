<?php ob_start();
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; 

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/HOMEPAGE';
if(!in_array( $Gate['VIEW_GRADE_LIMIT_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
  }


if (isset($_POST["grade_limit"]) && !empty($_POST["grade_limit"])) 
{
    
    foreach ($_POST as $key => $value) 
    {
        if($key == 'form_token' || $key ==  'grade_limit') continue; 
        $EId = (int) filter_var($key, FILTER_SANITIZE_NUMBER_INT);  
    
        if(empty($value)) $value = 40;
        elseif($value < 1 || $value > 100) $value = 40 ; 
         
        
        $IfRecordExist =  $Controller->QueryData("SELECT id FROM set_grade WHERE employeet_id = ?  ", [$EId]);

        if($IfRecordExist->num_rows == 0 ) 
        {
            $InsertRecord =  $Controller->QueryData("INSERT INTO  set_grade(grade_limit,employeet_id) VALUES( ? , ? )",  [$value , $EId] );
            if($InsertRecord)
            {
                $_SESSION['msg'] = "Grade Limit Added";
            }
        }
        else 
        {
            // set grade limit  
            $SGLimit =  $Controller->QueryData("UPDATE set_grade  SET grade_limit = ? WHERE employeet_id = ?  ", [ $value  , $EId]);
            $_SESSION['msg'] = 'Grade Limits Changed Successfully !';
        }
    }

}

    $Query = "SELECT EDepartment , grade_limit , EId , Ename , EJob FROM employeet LEFT outer JOIN set_grade ON employeet.EId = set_grade.employeet_id where EDepartment = 'Marketing' ORDER BY id DESC LIMIT 10";
    $DR =  $Controller->QueryData($Query,[]);

    // Kill msg session after 20 sec  
    $inactive = 20; 
    if (isset($_SESSION['msg_time']) && (time() - $_SESSION['msg_time'] > $inactive))   unset($_SESSION['msg']);      
    $_SESSION['msg_time'] = time(); // Update session


?>

<div class="card m-3">
    <div class="card-body">
        <a class="btn btn-outline-primary me-3" href="SetPriceDashboard.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
    </div>
</div>


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


<div class="card m-3">
    <div class ="m-3" >
            <h3 style = "padding:0px;margin:0px;" > <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark-diff" viewBox="0 0 16 16">
                <path d="M8 5a.5.5 0 0 1 .5.5V7H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V8H6a.5.5 0 0 1 0-1h1.5V5.5A.5.5 0 0 1 8 5zm-2.5 6.5A.5.5 0 0 1 6 11h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
                Set Grade Limit 
            </h3>
    </div>
    <hr style = "padding:0px; margin:0px;" >
    <div class="card-body  table-responsive   ">
        <form action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  method="post">
            <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
            <table class="table " id = ""  >
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Postion</th>
                        <th>Grade Limit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php  $count = 1; 
                    while($DataRows = $DR->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?=$count++; ?></td>
                            <td><?=$DataRows['Ename']; ?></td>
                            <td><?=$DataRows['EJob']; ?></td>
                            <td>
                                <input type="text" name="GL_<?=$DataRows['EId']?>" value = "<?php echo isset($DataRows['grade_limit']) ? $DataRows['grade_limit'] : ''  ?>"  class = "form-control my-0 w-25" id="">
                            </td>
                        </tr>
                    <?php endwhile;  ?>  
                </tbody>
            </table>

            <div class="card">
                <div class="card-body text-end">
                    <button type="submit" class = "btn btn-primary" name = "grade_limit" value = '1' >Save</button>
                </div>
            </div>
        </form>
        </div>  
    </div>
</div>

<?php require_once '../App/partials/footer.inc'; ?>