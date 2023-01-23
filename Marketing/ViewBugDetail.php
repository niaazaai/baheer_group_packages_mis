
<?php require_once '../App/partials/Header.inc'; require_once 'Controller.php'; ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?> 

<?php
    $ID=$_GET['id'];
    if(isset($_POST['update']))
    {
        $Priority=$_POST['Priority']; $Status=$_POST['Status']; $Severity=$_POST['Severity'];

        $Update=$Controller->QueryData("UPDATE bugs SET priority='$Priority', 	bug_status='$Status' ,	serverity='$Severity' WHERE id=? ",[$ID]);
        if($Update)
        {
            echo"<script> alert('Data updated successfully'); </script>";
        }
        else
        {
            echo"<script> alert('Data didn't  updated successfully'); </script>";
        }
    }
?>
<?php
    if(isset($_GET['id']))
    {
        $ID=$_GET['id'];
        $DataRows=$Controller->QueryData("SELECT title,what_happend,suggestion,screenshot,bug_status,serverity,priority FROM bugs WHERE id=?",[$ID]);
        $Rows=$DataRows->fetch_assoc();
    }
?>
<div class="card m-3">
    <div class="card-body  d-flex justify-content-between">
        <div class="d-flex justify-content-start">
            <a class= "btn btn-outline-primary  " href="BugReportList.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a> 
            <h3 class="ps-1 pt-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-bug " viewBox="0 0 16 16">
                    <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
                </svg>
                Bug Detail
            </h3>
        </div>
        <div class="pt-2">
            <span class="badge bg-warning fs-5" title="Priority"><?php echo $Rows['priority']; ?></span>
            <span class="badge bg-warning fs-5" title="Status"><?php echo $Rows['bug_status']; ?></span>
            <span class="badge bg-warning fs-5" title="Severity"><?php echo $Rows['serverity']; ?></span>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <form action="" method="POST">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <select class="form-select" name="Priority" id="Priority">
                        <option>Select priority</option>
                        <option value="urgent">Urgent</option>
                        <option value="important">Important</option>
                        <option value="normal">Normal</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <select class="form-select" name="Status" id="Status">
                        <option>Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="not_fixed">Not Fixed</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <select class="form-select" name="Severity" id="Severity">
                        <option>Select Severity</option>
                        <option value="critical">Critical</option>
                        <option value="major">Major</option>
                        <option value="small">Small</option>
                        <option value="medium">Medium</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                    <input class="btn btn-outline-primary" type="submit" name="update" id="update" value="Save"> 
                </div>
            </div>
        </form>
    </div>
</div>


<div class="card m-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12 my-1">
                <h3><?php echo $Rows['title']; ?></h3>
                <p><?php echo $Rows['what_happend']; ?></p>
                <h3>Suggestion</h3>
                <p><?php echo $Rows['suggestion']; ?></p>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12 my-1">
                <img src="<?php echo $Rows['screenshot']; ?>" alt="ERROR IMG" width="830px" height="600px">
            </div>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>PlatForm: </th>&nbsp;&nbsp;<td>OPen</td> 
                    <th>Operating System: </th>&nbsp;&nbsp;<td>Microsoft</td>
                </tr>
                <tr>
                    <th>Browser: </th>&nbsp;&nbsp; <td>Chorom</td>
                    <th>steps to repro: </th>&nbsp;&nbsp; <td>12</td>
                </tr>                   
                <tr>
                    <th>Expected Result: </th>&nbsp;&nbsp; <td>Excellent</td>
                    <th>Actual result: </th>&nbsp;&nbsp; <td>Out</td>
                </tr>
                <tr>
                    <th>Assigned To: </th>&nbsp;&nbsp; <td>Furqan</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php  require_once '../App/partials/Footer.inc'; ?>