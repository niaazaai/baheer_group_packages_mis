
<?php require_once 'Controller.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BGC MIS Department">
    <title>BGIS</title>
    <link rel="stylesheet" href="../Public/Css/bootstrap.min.css">
    <style>
        .bgColor
        {
            background-color: gray;
        }
    </style>

 </head>
 <body class="bg-light">
 
 
<nav class="navbar navbar-expand-lg navbar-light bg-light ">
    <div class="container">
        <div class="d-flex justify-content-end">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active btn btn-outline-info text-white" aria-current="page" href="#">Bug Report Guidlines</a>
                        </li>
                    </ul>
                </div>
        </div>
  </div>
</nav>





<?php

if(isset($_POST ) && !empty($_POST) )
{
    $Key = '';
    $Value = "";     
    if(isset($_POST['priority'] )) 
    {
        $Value = $_POST['priority']; 
        $key = 'priority';
    }
    if(isset($_POST['bug_status']))
    {
        $Value = $_POST['bug_status']; 
        $key = 'bug_status';
    }
    if(isset($_POST['serverity']))
    {
        $Value = $_POST['serverity']; 
        $key = 'serverity';
    }

    $Query = "SELECT id, bug_type, title, bug_status,serverity,priority FROM bugs WHERE $key = ?"; 
    $Excute=$Controller->QueryData($Query,[$Value]);
}
else
{
    $Excute=$Controller->QueryData("SELECT id, bug_type, title, bug_status,serverity,priority FROM bugs ",[]);

}


            
                
?>


<div class="container bg-light ">

<div class="card m-3">
    <div class="card-body d-flex justify-content-between ">
        <div class = "d-flex justify-content-start " >
            <a class= "btn btn-outline-primary  pe-2 me-1" href="index.php">
				<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
						<path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"/>
				</svg>
			</a>  

            <h5 class = "m-0  py-2 " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-bug" viewBox="0 0 16 16">
                <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
            </svg>
                Bug Report
            </h5>
        </div>
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 my-1">
                    <form action="" method="POST">
                    <select class="form-select" name="priority" id="Priority" onchange="this.form.submit()">
                        <option disabled >Select Priority</option>
                        <option value=""></option>
                        <option value="urgent">Urgent</option>
                        <option value="important">Important</option>
                        <option value="normal">Normal</option>
                    </select>
                </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 my-1">
                    <form action="" method="POST">
                    <select class="form-select" name="bug_status" id="Status" onchange="this.form.submit()">
                        <option disabled >Select Status</option>
                        <option value=""></option>
                        <option value="pending">Pending</option>
                        <option value="not_fixed">Not Fixed</option>
                        <option value="fixed">Fixed</option>
                    </select>
                </form>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12 my-1">
                    <form action="" method="POST">
                    <select class="form-select" name="serverity" id="Severity" onchange="this.form.submit()">
                        <option disabled >Select Severity</option>
                        <option value=""></option>
                        <option value="critical">Critical</option>
                        <option value="major">Major</option>
                        <option value="small">Small<z/option>
                        <option value="medium">Medium</option>
                    </select>
                </form>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 my-1">
                    <input class="form-control" type="search" name="Search" id="Search" onkeyup="SearchFunction(this.id, 'myTable')" placeholder="SEARCH HERE...!">
                </div>
            </div>
         
    </div>
</div>

<div class="card m-3">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="myTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Bug Type</th>    
                        <th>Title</th>
                        <th>Reporter</th>
                        <th>Department</th>
                        <th>Submit Date</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Severity</th>
                        <th>OPS</th>  
                        <th></th>  
                    </tr>
                </thead>
                <tbody>
            <?php
               
                    foreach($Excute AS $key => $Rows)
                    {
                        echo"<tr>";
                        echo "<td>".$Rows['id']."</td>";
                        echo "<td>".$Rows['bug_type']."</td>";
                        echo "<td>".$Rows['title']."</td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td></td>";
                        echo "<td>".$Rows['priority']."</td>";
                        echo "<td>".$Rows['bug_status']."</td>";
                        echo "<td>".$Rows['serverity']."</td>";

            ?>
                        <td>
                            <a class="btn btn-outline-primary " href="ViewBugDetail.php?id=<?= $Rows['id']?>">View</a>
                            <a class="btn btn-outline-success " href="BugStatechanger.php?id=<?= $Rows['id']?>">Done</a>
                        </td>
            <?php
                        echo"<tr>";
                    }
               
            ?> 
                   
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>



<script>
    function SearchFunction(InputId ,tableId ) 
    {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById(InputId);
        filter = input.value.toUpperCase();
        table = document.getElementById(tableId);
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

<script   src="../Public/Js/bootstrap.min.js"></script>  

 </body>
 </html>
 