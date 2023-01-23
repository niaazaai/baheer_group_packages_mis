<?php require_once 'partials/Header.inc'; ?>
<?php require_once 'partials/Menu/MarketingMenu.inc';
$SQL="SELECT carton.CTNId, carton.ProductName,carton.JobNo,carton.ProductQTY, ppcustomer.CustName FROM carton INNER JOIN ppcustomer ON carton.CustId1=ppcustomer.CustId limit 10";
$out=$Controller->QueryData($SQL,[]);

if(isset($_POST['SetColumns']))
{
    $CTNID=$_POST['CTNID'];
    $QTY=$_POST['QTY'];
    $minus=$_POST['minus'];
    $remain=$QTY-$minus;
    $Update=$Controller->QueryData("UPDATE carton SET ProductQTY = $remain WHERE CTNId = ?",[$CTNID]);
    if($Update)
    {
        echo "<div class='alert alert-success alert-dismissible fade show ms-3 mt-3 me-3' role='alert'>".$minus." carton out
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>";
        // echo "<span class='alert alert-success ms-3 mt-3' role='alert'> Updated </span>";
    }
    else
    {
        echo "<div class='alert alert-warning' role='alert'> not updated </div>";
    }
}
else
{
    echo "<div class='alert alert-danger' role='alert'>Data not catched</div>";
}

$out=$Controller->QueryData($SQL,[]);

?>
<div class="card m-3">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Carton ID</th>
                    <th scope="col">company name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Job No</th>
                    <th scope="col">Product QTY</th>
                    <th scope="col">Stock Out</th>
                </tr>
            </thead>
            <tbody>
            <form action="" method="POST">
                <?php while($go=$out->fetch_assoc())
                    {$count=1;?>
                        <tr>
                            <td><?=$go['CTNId']?></td>
                            <td><?=$go['CustName']?></td>
                            <td><?=$go['ProductName']?></td>
                            <td><?=$go['JobNo']?></td>
                            <td><?=$go['ProductQTY']?></td>
                            <td>
                                <button type="button" class="btn btn-outline-primary" onclick = "PutQTYToModal(<?=$go['ProductQTY']?>,'<?=$go['CTNId']?>')" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                                    <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                                    <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
                                </svg>
                                OUT
                                </button>
                            </td>
                        </tr>
                <?php } ?>
            </form>
            </table>
    </div>
</div>  



<script>

    function PutQTYToModal(QTY = 0,CTNId)
    {
        document.getElementById("QTY").value = QTY;        
        document.getElementById("CTNID").value = CTNId; 
    }
</script>


<?php  require_once 'partials/Footer.inc'; ?>