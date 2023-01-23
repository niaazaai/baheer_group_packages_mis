<?php 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
require_once '../Assets/Zebra/Zebra_Pagination.php';
$pagination = new Zebra_Pagination();
$RECORD_PER_PAGE = 20;
$active_class = 'polymer'; 

if(isset($_GET['Data']) && !empty($_GET['Data'])) if($_GET['Data'] == 'Die') $active_class = 'die'; // This Line of code is coming from polymer usage purpose of the code is to select the exactly tab which was gone thrugh.
 
if(isset($_POST['CustId']))
{
    $CustomerId=$_POST['CustId'];
    $CustomerName = $_POST['CustomerName'];
 

    $PolymerList=$Controller->QueryData("SELECT CPid,CPNumber,PStatus,PLocation,CompId,ProductName,PColor,Psize,PMade,CartSample,POwner,ppcustomer.CustName,MakeDate,`Type`,DesignCode 
    FROM `cpolymer` INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId WHERE CompId = ? ",[$CustomerId]);
 
 
    $DieList=$Controller->QueryData("SELECT CDieId,CDCompany,CDProductName,CDSize,CDMade,CDSampleNo,CDOwner,CDMadeDate,App,DieType,Scatch,DieCode,CDDesignCode,CDStatus,CDLocation, 
    ppcustomer.CustName FROM cdie INNER JOIN ppcustomer ON ppcustomer.CustId=cdie.CDCompany WHERE CDCompany = ? ",[$CustomerId]);
}
else
{


    $PolymerListQuery= "SELECT CPid, CPNumber,PStatus,PLocation,CompId,ProductName,PColor,Psize,PMade,CartSample,POwner, ppcustomer.CustName,MakeDate, `Type`,DesignCode 
    FROM cpolymer INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId order by CPid DESC"; 
    $PolymerListQuery .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';
    $PolymerList = $Controller->QueryData($PolymerListQuery,[]);

    $PaginateQuery2="SELECT   COUNT(CPid) AS RowCount  FROM cpolymer INNER JOIN ppcustomer ON ppcustomer.CustId=cpolymer.CompId order by CPid DESC";
    $RowCount =  $Controller->QueryData($PaginateQuery2,[]);
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($row['RowCount']);
    $pagination->records_per_page($RECORD_PER_PAGE);



    $DieListQuery = "SELECT CDieId,CDCompany,CDProductName,CDSize,CDMade,CDSampleNo,App,DieType,Scatch,CDOwner,CDMadeDate,DieCode,CDDesignCode,CDStatus,CDLocation, 
    ppcustomer.CustName FROM cdie INNER JOIN ppcustomer ON ppcustomer.CustId=cdie.CDCompany order by CDieId DESC "; 
    $DieListQuery .= ' LIMIT ' . (($pagination->get_page() - 1) * $RECORD_PER_PAGE) . ',' . $RECORD_PER_PAGE . ' ';  
    $DieList=$Controller->QueryData($DieListQuery,[]);
    
    $PaginateQuery1="SELECT COUNT(CDieId) AS RowCount  FROM  cdie INNER JOIN ppcustomer ON ppcustomer.CustId=cdie.CDCompany order by CDieId DESC";
    $RowCount =  $Controller->QueryData( $PaginateQuery1 ,[]  );
    $row = $RowCount->fetch_assoc(); 
    $pagination->records($row['RowCount']);
    $pagination->records_per_page($RECORD_PER_PAGE);

}

if (filter_has_var(INPUT_POST, 'FieldType')  && filter_has_var(INPUT_POST, 'SearchTerm')) 
{
    if(!empty($_POST['FieldType']) &&  !empty($_POST['SearchTerm'])) 
    {
        $Active=false;
       
        $Table=$_POST['Table'];
        $tableName = ''; 
        $DEFAULT_COLUMNS = ''; 
        $FieldType = $Controller->CleanInput($_POST['FieldType']);
        $SearchTerm = $Controller->CleanInput($_POST['SearchTerm']);
        if($Table == 'polymer') 
        {
            $tableName = 'cpolymer'; 
            $DEFAULT_COLUMNS = 'CPid,CPNumber,	PStatus,PLocation,ProductName,PColor,Psize,PMade, CartSample, POwner, MakeDate, Type,DesignCode '; 
            $PolymerList=$Controller->Search($tableName,$FieldType,$SearchTerm,$DEFAULT_COLUMNS);

            $active_class = 'polymer';

        }
        else if($Table == 'die') 
        {
            $tableName = 'cdie'; 
            $DEFAULT_COLUMNS = 'CDieId,CDCompany,CDProductName,CDSize,CDMade,CDSampleNo,CDOwner,CDMadeDate,App,DieType,Scatch,DieCode,CDDesignCode,CDStatus,CDLocation';
            $DieList= $Controller->Search($tableName,$FieldType,$SearchTerm,$DEFAULT_COLUMNS);
            $active_class = 'die';
        }
  
    }
}
else if( filter_has_var(INPUT_POST, 'FieldType')  || filter_has_var(INPUT_POST, 'SearchTerm')) 
{
    die('Incorrect Post Request!');
}

?>

<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
      }
?>

 

<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
       
        <h3  class = "m-0 p-0  " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
            </svg>
            Polymer & Die Center 
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            
	    </div><!-- Button trigger modal div end -->
    </div>
</div> 

 

<div class="card m-3">
    <div class="card-body shadow">

        <form action="" method="POST">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" style="z-index: 11">

                        <input type="text" name = "CustomerName" id = "customer" class="form-control " value = "<?php if(isset($CustomerName)) echo $CustomerName ;  ?>" 
                         onclick= "HideLiveSearch();" onkeyup="AJAXSearch(this.value);"   placeholder = "Search Company Names" >
                        <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "></div>
                        <input type="hidden" name="CustId" id = "CustId"   >
                        
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" >
                    <a href="CreateDie.php" class="btn btn-outline-primary ms-1" style="float:right;">Create Die</a> 
                    <a href="CreatePolymer.php" class="btn btn-outline-primary" style="float:right;">Create Polymer</a> 
                </div>
            </div>
        </form>

    </div>
</div>

<div class="card m-3 shadow">
    <div class="card-body">
 
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class=" nav-link    <?php  echo ($active_class == 'polymer') ? 'active': ''; ?> " id="PolymerList-tab" data-bs-toggle="tab" data-bs-target="#PolymerList" type="button" role="tab" aria-controls="PolymerList" aria-selected="true">Polymer List</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="   nav-link <?php   echo ($active_class == 'die') ? 'active': ''; ?>" id="DieList-tab" data-bs-toggle="tab" data-bs-target="#DieList" type="button" role="tab" aria-controls="DieList" aria-selected="false">Die List</button>
                    </li>
                </ul>
      

           
                <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade <?php   echo ($active_class == 'polymer') ? 'show active': ''; ?>  " id="PolymerList" role="tabpanel" aria-labelledby="PolymerList-tab">
                       
                        <div class="card mt-3 ms-0 me-0" >
                                <div class="card-body">
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                                        <div class="input-group my-1 mb-3">
                                            <select class="form-select d-block" name="FieldType"  style = "max-width: 30%;">
                                                <option disabled >Select a Field </option>  
                                                <!-- <option value="CPid"> Polymer Id </option> -->
                                                <option value="CPNumber"> Polymer No</option>
                                                <option value="ProductName"> Product Name</option>
                                            </select>
                                            <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                                            <button type="submit" class="btn btn-outline-primary">Find</button>
                                        </div>
                                        <input type="hidden" name="Table"  value = "polymer" >
                                    </form>
                                    <table class="table table-responsive ms-0 me-0" id = "JobTable">
                                        <thead>
                                                <tr class="table-info">
                                                    <!-- <th>Poly.Id</th> -->
                                                    <th>Poly.No</th>
                                                    <?php
                                                    if(isset($_POST['Table']))
                                                    {
                                                        $Table=$_POST['Table'];
                                                        if($_POST['Table']!='polymer')
                                                        {?>
                                                            <th title="Company Name">C.Name</th>
                                                        <?php
                                                        }
                                                    }else{ ?> <th title="Company Name">C.Name</th> <?php }
                                                     ?>
                                                    <th title="Product Name">P.Name</th>
                                                    <th>Size</th>
                                                    <th>Color</th>
                                                    <!-- <th>Made</th> -->
                                                    <th title="Porperty Of">P.OF</th>
                                                    <th title="Current Location">C.Location</th>
                                                    <th title="Sample Code">S.Code</th>
                                                    <th title="Design Code">Design</th>
                                                    <!-- <th title="Made Date">M.Date</th> -->
                                                    <th>Status</th>
                                                    <!-- <th title="Polymer Usage">Poly.U</th> -->
                                                    <th>OPS</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            
                                            if(!empty($PolymerList->num_rows) && ($PolymerList->num_rows > 0))
                                            {
                                                while($Rows=$PolymerList->fetch_assoc())
                                                {?>
                                                    <tr>
                                                        <!-- <td><?=$Rows['CPid'] ?></td> -->
                                                        <td><?=$Rows['CPNumber'] ?></td>
                                                            <?php if(isset($_POST['Table']))
                                                              {
                                                                    $Table=$_POST['Table'];
                                                                    if($_POST['Table']!='polymer')
                                                                    {?>
                                                                        <td><?=$Rows['CustName'] ?></td>
                                                                    <?php
                                                                    }
                                                              }else{ ?> <td><?=$Rows['CustName'] ?></td> <?php }
                                                            ?>
                                                        <td><?=$Rows['ProductName'] ?></td>
                                                        <td><?=$Rows['Psize'] ?></td>
                                                        <td><?=$Rows['PColor'] ?></td>
                                                        <!-- <td><?=$Rows['PMade'] ?></td> -->
                                                        <td><?=$Rows['POwner'] ?></td>
                                                        <td><?=$Rows['PLocation'] ?></td>
                                                        <td><?=$Rows['CartSample'] ?></td>
                                                        <td><?=$Rows['DesignCode'] ?></td>
                                                        <!-- <td><?=$Rows['MakeDate'] ?></td> -->
                                                        <td><?=$Rows['PStatus'] ?></td>
                                                        <td>
                                                            <a class="text-primary m-1" href="PolymerUsage.php?CPid=<?=$Rows['CPid']?>&Polymer=Polymer">  
                                                                <svg width="30" height="30" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"/>
                                                                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"/>
                                                                    <path d="M188 363V149H270.267C286.084 149 299.556 152.1 310.69 158.3C321.82 164.43 330.306 172.963 336.144 183.9C342.049 194.767 345 207.306 345 221.518C345 235.729 342.013 248.267 336.04 259.135C330.067 270.002 321.414 278.466 310.077 284.526C298.811 290.587 285.168 293.617 269.148 293.617H216.711V257.358H262.02C270.506 257.358 277.499 255.861 282.994 252.865C288.561 249.8 292.702 245.586 295.418 240.222C298.198 234.788 299.592 228.553 299.592 221.518C299.592 214.412 298.198 208.212 295.418 202.918C292.702 197.554 288.561 193.409 282.994 190.483C277.431 187.488 270.371 185.99 261.817 185.99H232.086V363H188Z" fill="#B3404A"/>
                                                                </svg>
                                                            </a>
                                                        <!-- </td>
                                                        <td> -->
                                                            <a class="text-primary m-1" href="CreatePolymer.php?Id=<?=$Rows['CPid']?>&Polymer=Polymer" title="Edit">  
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                                                </svg>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php 
                                                }
                                            }
                                            else 
                                            {
                                                echo "<tr><td colspan = '15' class ='text-center fw-bold text-danger'  >No Records Found Yet</td></tr>";
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                            <div class="tab-pane fade <?php echo ($active_class == 'die') ? 'show active': ''; ?>  " id="DieList" role="tabpanel" aria-labelledby="DieList-tab">
                                <div class="card mt-3 ms-0 me-0">
                                    <div class="card-body">
                                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                                            <div class="input-group my-1 mb-3 ">
                                                <select class="form-select d-block" name="FieldType"  style = "max-width: 30%;">
                                                    <option disabled >Select a Field </option>  
                                                    <!-- <option value="CDieId"> Die Id</option> -->
                                                    <option value="DieCode">Die Code</option>
                                                    <option value="CDProductName">Product Name</option>
                                                </select>
                                                <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                                                <button type="submit" class="btn btn-outline-primary">Find</button>
                                            </div>
                                            <input type="hidden" name="Table"  value = "die" >
                                        </form>
                                        <table class="table table-responsive ms-0 me-0" id = "JobTable">
                                            <thead >
                                                    <tr class="table-info">
                                                        <!-- <th>Die.Id</th> -->
                                                        <th>Die.No</th>
                                                        <?php 
                                                         if(isset($_POST['Table']))
                                                         {
                                                             $Table=$_POST['Table'];
                                                                if($_POST['Table']!='die')
                                                                {?>
                                                                    <th title="Company Name">C.Name</th>
                                                                <?php
                                                                }
                                                        }else{ ?> <th title="Company Name">C.Name</th> <?php }
                                                        ?>
                                                        <th title="Product Name">P.Name</th>
                                                        <th>Size</th>
                                                        <!-- <th>Made</th> -->
                                                        <th title="Porperty Of">P.OF</th>
                                                        <th title="Current Location">C.Location</th>
                                                        <th title="Sample Code">S.Code</th>
                                                        <!-- <th title="Design Code">D.Code</th> -->
                                                        <th title="Scatch">Scatch</th>
                                                        <th>App</th>
                                                        <th title="Die Type">Die.T</th>
                                                        <!-- <th title="Made Date">M.Date</th> -->
                                                        <th>Status</th>
                                                        <!-- <th title="Die Usage">Die.U</th> -->
                                                        <th>OPS</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                
                                                if(!empty($DieList->num_rows) && ($DieList->num_rows > 0))
                                                {
                                                    while($Row=$DieList->fetch_assoc())
                                                    {?>
                                                        <tr>
                                                            <!-- <td><?=$Row['CDieId'] ?></td> -->
                                                            <td><?=$Row['DieCode']?></td>
                                                            <?php 
                                                            if(isset($_POST['Table']))
                                                            {
                                                                $Table=$_POST['Table'];
                                                                if($_POST['Table']!='die')
                                                                {?>
                                                                    <td><?=$Row['CustName'] ?></td>
                                                                <?php
                                                                }
                                                            }else{ ?> <td><?=$Row['CustName'] ?></td> <?php }
                                                            ?>
                                                            <td><?=$Row['CDProductName'] ?></td>
                                                            <td><?=$Row['CDSize'] ?></td>
                                                            <!-- <td><?=$Row['CDMade'] ?></td> -->
                                                            <td><?=$Row['CDOwner'] ?></td>
                                                            <td><?=$Row['CDLocation'] ?></td>
                                                            <td><?=$Row['CDSampleNo'] ?></td>
                                                            <!-- <td><?=$Row['CDDesignCode'] ?></td> -->
                                                            <td class = " align-item-center    " >
                                                                <?php if(isset($Row['DieCode']) && !empty($Row['DieCode']) )  { ?>
                                                                <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                                                href="ShowDesignImage.php?Scatch=<?=$Row['Scatch']?>&ProductName=<?= $Row['CDProductName']?>" >
                                                                    <?php   echo '<span class = "text-success" >'. $Row['DieCode'] . '</span>';  ?>  
                                                                </a>
                                                                <?php }  else {
                                                                    echo '<span class = "text-danger" >N/A</span>';
                                                                } ?>
                                                            </td>
                                                            <td><?=$Row['App'] ?></td>
                                                            <td><?=$Row['DieType'] ?></td>
                                                            <!-- <td><?=$Row['CDMadeDate'] ?></td> -->
                                                            <td><?=$Row['CDStatus'] ?></td>
                                                            <td>
                                                                <a class="text-primary m-1" href="PolymerUsage.php?CDieId=<?=$Row['CDieId']?>&Die=Die" >  
                                                                    <svg width="30" height="30" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"/>
                                                                        <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"/>
                                                                        <path d="M242.307 366H164.963V147.818H242.946C264.892 147.818 283.784 152.186 299.622 160.922C315.46 169.587 327.641 182.051 336.163 198.315C344.757 214.58 349.054 234.04 349.054 256.696C349.054 279.423 344.757 298.955 336.163 315.29C327.641 331.625 315.389 344.161 299.409 352.896C283.5 361.632 264.466 366 242.307 366ZM211.092 326.476H240.389C254.026 326.476 265.496 324.061 274.8 319.232C284.175 314.331 291.206 306.767 295.893 296.54C300.652 286.241 303.031 272.96 303.031 256.696C303.031 240.574 300.652 227.399 295.893 217.172C291.206 206.945 284.21 199.416 274.906 194.587C265.602 189.757 254.132 187.342 240.496 187.342H211.092V326.476Z" fill="#B3404A"/>
                                                                    </svg>
                                                                </a>
                                                            <!-- </td>
                                                            <td> -->
                                                                <a class="text-primary m-1" href="CreateDie.php?Id=<?=$Row['CDieId']?>&Die=Die" title="Edit">  
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"></path>
                                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"></path>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php 
                                                    }
                                                }
                                                else 
                                                {
                                                    echo "<tr><td colspan = '15' class ='text-center fw-bold text-danger'  >No Records Found Yet</td></tr>";
                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4"> 
                            <?php  $pagination->render(); ?> 
                    </div>

    </div>
</div>

 
<script>
function HideLiveSearch()
{
    document.getElementById('livesearch').style.display = 'none';
}
function PutTheValueInTheBox(inner , id)
{
    let a = document.getElementById('customer').value = inner;
    document.getElementById('livesearch').style.display = 'none';
    document.getElementById('CustId').value = id;     
    console.log(document.getElementById('customer').form.submit());
}
function AJAXSearch(str) 
{

    document.getElementById('livesearch').style.display = '';
    if (str.length == 0)
    {
      return false;
    } 
    else 
    {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() 
      {
          if (this.readyState == 4 && this.status == 200)  
          {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response != '-1')
                    {
                        for(var count = 0; count < response.length; count++)
                        {
                                    html += '<a href="#" onclick = "PutTheValueInTheBox( `' + response[count].CustName + '`   , ' + response[count].CustId + ');"  class="list-group-item list-group-item-action" aria-current="true">' ; 
                                    html += response[count].CustName; 
                                    html += '   </a>';
                        }
                    }

                    else html += '<a href="#" class="list-group-item list-group-item-action " aria-current="true"> No Match Found</a> ';
                    document.getElementById('livesearch').innerHTML = html;  
          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
}






function search(InputId ,tableId ) 
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


<?php  require_once '../App/partials/Footer.inc'; ?>