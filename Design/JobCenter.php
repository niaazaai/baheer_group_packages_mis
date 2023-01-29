
<?php 

require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php'; 
use Carbon\Carbon;

if(isset($_REQUEST['ListType']) && !empty($_REQUEST['ListType']))
{
    $ListType= $_REQUEST['ListType'];
    if($ListType=='NewJob')
    {
        $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
        ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7`,offesetp,designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignStatus  FROM `carton` INNER JOIN ppcustomer 
        ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  where CTNStatus="Design"   order by CTNOrderDate DESC';
    }
    else if($ListType=='JobUnderProcess')
    {
        $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
        ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` ,Note, offesetp,	 designinfo.Alarmdatetime,CURRENT_TIMESTAMP,
        designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignerName1 ,designinfo.DesignStartTime FROM `carton` INNER JOIN ppcustomer 
        ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId  
        where CTNStatus="DesignProcess" order by CTNOrderDate DESC';
    } 
}
else
{
    $ListType = 'NewJob'; 
    $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
    ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` ,offesetp,	 designinfo.Alarmdatetime,designinfo.DesignStatus, designinfo.DesignImage,CURRENT_TIMESTAMP,
    designinfo.DesignCode1 ,designinfo.DesignerName1 ,designinfo.DesignStartTime FROM `carton` INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  where CTNStatus="Design" order by CTNOrderDate DESC';
}
$DataRows=$Controller->QueryData($SQL,[]);
$number_of_films =$Controller->QueryData('SELECT COUNT(`CTNId`) AS film FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE CTNStatus="Film" order by CTNOrderDate DESC',[])->fetch_assoc()['film'];

?>  
  
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) { ?>
        <div class="alert alert-<?=$_GET['class']?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>
<div class="card m-3" >
  <div class="card-body d-flex justify-content-between shadow">
      <h3 class="m-0 p-0"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-circle-square" viewBox="0 0 16 16">
            <path d="M0 6a6 6 0 1 1 12 0A6 6 0 0 1 0 6z"></path>
            <path d="M12.93 5h1.57a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1.57a6.953 6.953 0 0 1-1-.22v1.79A1.5 1.5 0 0 0 5.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 4h-1.79c.097.324.17.658.22 1z"></path>
        </svg>  Job Center
      </h3>

      <div class= "d-flex justify-content-center  ">
        <div class = "mx-2 " >
          <a class="btn btn-outline-danger " data-bs-toggle="collapse" href="#colapse1" role="button" aria-expanded="false"  > 
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
              <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
            </svg> Search   
          </a>
        </div>
        <div class = "me-2  " >
          <a class="btn btn-outline-success " id = "design-button"  onclick = "SwitchTableData(); "  >
              <svg xmlns="http://www.w3.org/2000/svg" style = "display:none;"  width="20" height="20" fill="currentColor" id = "design-logo-red" class="bi bi-x-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
              </svg>
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"  id = "design-logo-green" class="bi bi-check-circle" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                  <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
              </svg>
            Jobs 
          </a>
        </div>

        <div class = "me-2  " >
          <a  href="Film.php" class="btn btn-outline-dark  ">
              Films <span class="badge  bg-danger"><?=$number_of_films;?></span> 
          </a>  
        </div>

          
        <form action=""  method = "post" class = "m-0 p-0 "  >
            <select class = "form-select" name="ListType" id="ListType"  onchange = "this.form.submit();" > 
              <option value="<?=$ListType;?>"><?=$ListType;?></option>
              <option value="NewJob">New Job</option>
              <option value="JobUnderProcess">Job Under Process</option>
            </select>
        </form>
      </div>
    </div>
</div>


<div class="collapse shadow" style="position: absolute; z-index: 1000; width: 60%; left: 39%; margin-top:-21px; " id="colapse1">
    <div class="card card-body border shadow">
        <div class="form-floating">
            <input type="text" class="form-control"  id = "Search_input" placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
            <label for="Reel">Search Anything</label>
        </div>
    </div>
</div>
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">
    <table class= "table " id = "JobTable" >
          <thead>
              <tr class="table-info">
                  <th>#</th>
                  <th title="Quotation No">Q.No</th>
                  <th>JobNo</th>
                  <!-- <th title="Order Date">O.Date</th> -->
                  <th title="Company Name">C.Name</th> 
                  <th title="Product Name">P.Name</th>
                  <th>Size (LxWxH) cm</th>
                  <!-- <th>Papers</th> -->
                  <th>Color</th>
                  <th>Offset</th>
                  <th title="Product Type">P.Type</th>
                  <!-- <th title="Order QTY">O.QTY</th> -->
                  <?php if(isset($_REQUEST['ListType']))  { 
                            if($_REQUEST['ListType']=='NewJob') {?>                           
                              <th title="Design Code">Design</th>
                              <th title="Mobile No">Mobile No</th>
                              <th>Comment</th>
                            <?php }
                            else if($_REQUEST['ListType']=='JobUnderProcess')  { ?>
                                <th title="Design Code">Design</th>
                                <th title="Design By">D.By</th>
                                <th title="Remain Time">R.Time</th>
                            <?php  }  
                        }
                        else
                        {?>
                              <th title="Design Code">Design</th>
                              <th title="Mobile No">Mobile No</th>
                              <th>Comment</th>
                   <?php  }  ?>
                  <th>OPS</th>
              </tr>
          </thead>
          <tbody>
          <?php 
          
          function isPast( $date ){ 
            return  Carbon::now()->startOfDay()->gte($date);
          }

          $class = '#20c997'; 
          $COUNTER=0;
          $Count = 1; 
            while($Rows=$DataRows->fetch_assoc()) {    ?>
                <tr>
                  <td><?=$Count?> </td>
                  <td><?=$Rows['CTNId']?></td>
                  <td><?=$Rows['JobNo']?></td>
                  <!-- <td><?=$Rows['CTNOrderDate']?></td> -->
                  <td><?=$Rows['CustName']?></td>
                  <td><?=$Rows['ProductName']?></td>
                  <!-- <td><?=$SIZE?></td> -->
                  <td><?=$Rows['Size']?></td>
                  <!-- <td >
                    <?php 
                         $arr = []; 
                         for ($index=1; $index <= 7 ; $index++) 
                         { 
                           if(empty($Rows['Ctnp'.$index])) continue; 
                           $arr[] = $Rows['Ctnp'.$index];   
                         } 
                         $arr = array_count_values($arr);
                         foreach ($arr as $key => $value) {
                             if(trim($key) === 'Flute') echo $value . " " . $key ;
                             else  echo $key ; 
                             if ($key === array_key_last($arr)) continue ; 
                             echo " x ";  
                         }
                    ?>
                  </td> -->
                  <td><?=$Rows['CTNColor']?></td>
                  <td><?=$Rows['offesetp']?></td>
                  <td><?=$Rows['CTNUnit']?></td>
                  <!-- <td><?=number_format($Rows['CTNQTY'])?></td> -->
                <?php   
                      if(isset($_REQUEST['ListType'])) 
                      { 
                          if($_REQUEST['ListType']=='NewJob')
                          {?>                           
                              <td class = " align-item-center    " >        
                                  <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                        href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                  <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                    </a>
                                  <?php }  else {
                                      echo '<span class = "text-danger" >N/A</span>';
                                  } ?>
                              </td>
                              <td><?=$Rows['CustMobile']?></td>
                              <td><?=$Rows['Note']?></td>
                          <?php      
                          }
                          else if($_REQUEST['ListType']=='JobUnderProcess')
                          { ?>
                                <td class = " align-item-center " >        
                                  <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                        href="ShowDesignImage.php?Url=<?=$Rows['DesignImage']?>&ProductName=<?=$Rows['ProductName']?>" >
                                    <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                    </a>
                                    <?php }  else {
                                      echo '<span class = "text-danger" >N/A</span>';
                                    } ?>
                                </td>
                                <td><?=$Rows['DesignerName1']?></td>
                                <td>
                                    <?php 
                                          $a =  Carbon::create($Rows['Alarmdatetime'] , 'Asia/Kabul')->diffForHumans(); 
                                          if(isPast( $Rows['Alarmdatetime'] ))  $class = '#dc3545';
                                              echo "<span class = 'badge' style = 'background-color: " . $class . " '>" . $a . "</span>";
                                    ?>
                                </td>
                          <?php
                          }
                          
                      }
                      else
                      {?>
                              <td class = " align-item-center    " >        
                                  <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                    <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                        href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                  <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                    </a>
                                  <?php }  else {
                                      echo '<span class = "text-danger" >N/A</span>';
                                  } ?>
                              </td>
                              <td><?=$Rows['CustMobile']?></td>
                              <td><?=$Rows['Note']?></td>
                      <?php
                      }
                ?>
                      <td> 
                        <a  href="DesignManage.php?CTNId=<?=$Rows['CTNId']?>&ListType=<?=$ListType?>" class="btn btn-outline-primary btn-sm ">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-fill" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.004-.001.274-.11a.75.75 0 0 1 .558 0l.274.11.004.001 6.971 2.789Zm-1.374.527L8 5.962 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339Z"></path>
                            </svg> Manage
                        </a> 
                      </td>
                </tr>
          <?php
              $Count++;
            }        
          ?>
          </tbody>
      </table>

  </div>
</div>

<script>

function search(InputId ,tableId ) {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById(InputId);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableId);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 1; i < tr.length; i++) {
      td = tr[i];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }
    }
}

function SwitchTableData( ){
  let List1 = document.getElementById('design-button').classList; 
  if( List1  == 'btn btn-outline-success '){
    console.log(List1);
      document.getElementById('Search_input').value = 'NULL'; 
      search( 'Search_input' , 'JobTable' )
      document.getElementById('design-logo-red').style.display = ''
      document.getElementById('design-logo-green').style.display = 'none'    
      document.getElementById('design-button').classList  = 'btn btn-outline-danger ';
  }
  else {
    console.log('else');
      document.getElementById('Search_input').value = ''; 
      search( 'Search_input' , 'JobTable' )
      document.getElementById('design-logo-red').style.display = 'none'
      document.getElementById('design-logo-green').style.display = ''    
      document.getElementById('design-button').classList  = 'btn btn-outline-success ';
    
  }
}
 



var fruits = document.getElementById("ListType");
[].slice.call(fruits.options)
  .map(function(a){
    if(this[a.value]){ 
      fruits.removeChild(a); 
    } else { 
      this[a.value]=1; 
    } 
  },{});



</script>

<?php  require_once '../App/partials/Footer.inc'; ?>





          