
<?php 

ob_start(); 
require_once '../App/partials/Header.inc'; 

$Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRESS_DEPT';
if(!in_array( $Gate['VIEW_JOB_CENTER'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
}

require_once '../App/partials/Menu/MarketingMenu.inc';

$ListType = '' ; 
$SQL='';
if(isset($_REQUEST['ListType']) && !empty(trim($_REQUEST['ListType'])))
{
    $ListType=$_REQUEST['ListType'];
    if($ListType=='NewJobPKG') {
        $SQL="SELECT CTNId,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,CTNOrderDate,CTNStatus, 
              CTNQTY,CTNUnit,ProductName,ppcustomer.CustMobile,ppcustomer.CustEmail,ppcustomer.CustAddress,CTNPaper, CTNColor, JobNo, Note,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7,offesetp,designinfo.DesignImage,
              designinfo.DesignCode1 FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
              WHERE CTNStatus = 'Printing' AND CTNStatus!='Production' AND JobNoPP is NULL OR JobNoPP='NULL' OR JobNoPP=''  order by CTNOrderDate DESC";

    }  else if($ListType=='NewJobPP') {
        $SQL="SELECT CTNId , ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size,`CTNOrderDate`, `CTNStatus`, `CTNQTY`, 
        `CTNUnit`,`ProductName`,ppcustomer.CustMobile, ppcustomer.CustEmail, ppcustomer.CustAddress,CTNPaper,CTNColor,JobNo,offesetp,Note,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7 ,
        designinfo.DesignCode1, designinfo.DesignImage, JobNoPP,CTNStatus FROM carton 
        INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId 
        WHERE CTNStatus='Printing' AND JobNoPP is NOT NULL OR JobNoPP!='' AND CTNStatus!='Production'  order by CTNOrderDate DESC";
    }
   
   
    $DataRows=$Controller->QueryData($SQL,[]);

}

else
{
  $ListType = "NewJobPKG"; 
  $SQL="SELECT CTNId,ppcustomer.CustName, CTNUnit,CONCAT( FORMAT(CTNLength / 10 ,1 ) , 'x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size, CTNOrderDate , CTNStatus, CTNQTY,CTNUnit,
  ProductName,ppcustomer.CustMobile, ppcustomer.CustEmail, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note,  `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`, `Ctnp5`, `Ctnp6`, `Ctnp7` ,offesetp,designinfo.DesignImage,designinfo.DesignCode1
  FROM `carton` 
  INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
  INNER JOIN designinfo on designinfo.CaId=carton.CTNId 
  WHERE CTNStatus='Printing' AND JobNoPP is NULL OR JobNoPP='NULL'  order by CTNOrderDate DESC";
  $DataRows=$Controller->QueryData($SQL,[]);
}

?>  

 

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset($_GET['msg']) && !empty($_GET['msg'])) { ?>
        <div class="alert alert-<?=(isset($_GET['class'])) ? $_GET['class'] : 'info' ?>  alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_GET['msg'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>


<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between    ">
    <div class = "d-flex justify-content-between  " >

    <div class = "my-2">
      <svg width="55" height="55" viewBox="0 0 505 505" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M482.743 160.797L417.551 191.665C443.652 248.064 435.629 316.332 393.262 365.359L357.747 329.843V453.419H481.323L444.541 416.637C508.969 345.468 521.634 243.996 482.743 160.797Z" fill="#F31919"/>
        <path d="M343.938 482.719L313.042 417.555C256.667 443.68 188.371 435.633 139.349 393.267L174.864 357.751H51.2881V481.327L88.0701 444.545C159.244 508.968 260.717 521.633 343.938 482.719Z" fill="#FA05FF"/>
        <path d="M111.451 139.348L146.966 174.863V51.2874H23.3853L60.1623 88.0644C-4.23167 159.267 -16.8977 260.739 21.9933 343.939L87.1613 313.043C61.0373 256.666 69.0843 188.371 111.451 139.348Z" fill="#48FFD3"/>
        <path d="M453.425 146.96V23.3844L416.648 60.1614C345.445 -4.23162 243.973 -16.8976 160.774 21.9934L191.666 87.1574C248.066 61.0564 316.337 69.0794 365.359 111.446L329.844 146.961H453.425V146.96Z" fill="#25B6D2"/>
        <path d="M252.354 351.081C306.88 351.081 351.082 306.879 351.082 252.353C351.082 197.827 306.88 153.625 252.354 153.625C197.828 153.625 153.626 197.827 153.626 252.353C153.626 306.879 197.828 351.081 252.354 351.081Z" fill="black"/>
        <path d="M205.181 268.009C205.181 270.606 204.793 272.862 204.019 274.776C203.267 276.713 202.173 278.308 200.737 279.562C199.325 280.838 197.616 281.783 195.61 282.398C193.628 283.036 191.406 283.355 188.945 283.355C186.94 283.355 185.072 283.185 183.34 282.843C181.608 282.501 180.184 282.091 179.067 281.612V273.956C179.705 274.298 180.423 274.628 181.221 274.947C182.041 275.289 182.884 275.585 183.75 275.836C184.639 276.109 185.539 276.314 186.45 276.451C187.362 276.611 188.262 276.69 189.15 276.69C191.68 276.69 193.571 275.961 194.824 274.503C196.077 273.045 196.704 270.903 196.704 268.077V240.768H180.195V234.273H205.181V268.009ZM205.864 224.771C205.864 225.523 205.728 226.23 205.454 226.891C205.181 227.551 204.793 228.132 204.292 228.634C203.813 229.112 203.232 229.5 202.549 229.796C201.888 230.069 201.17 230.206 200.396 230.206C199.621 230.206 198.903 230.069 198.242 229.796C197.581 229.5 197 229.112 196.499 228.634C196.021 228.132 195.645 227.551 195.371 226.891C195.098 226.23 194.961 225.523 194.961 224.771C194.961 224.02 195.098 223.313 195.371 222.652C195.645 221.992 196.021 221.41 196.499 220.909C197 220.408 197.581 220.021 198.242 219.747C198.903 219.451 199.621 219.303 200.396 219.303C201.17 219.303 201.888 219.451 202.549 219.747C203.232 220.021 203.813 220.408 204.292 220.909C204.793 221.41 205.181 221.992 205.454 222.652C205.728 223.313 205.864 224.02 205.864 224.771ZM249.512 251.363C249.512 254.098 249.124 256.604 248.35 258.883C247.575 261.139 246.458 263.076 245 264.693C243.542 266.311 241.753 267.564 239.634 268.453C237.515 269.342 235.099 269.786 232.388 269.786C229.813 269.786 227.511 269.41 225.483 268.658C223.455 267.906 221.735 266.79 220.322 265.309C218.91 263.805 217.827 261.936 217.075 259.703C216.323 257.447 215.947 254.827 215.947 251.842C215.947 249.085 216.335 246.578 217.109 244.322C217.907 242.066 219.035 240.141 220.493 238.546C221.974 236.951 223.774 235.72 225.894 234.854C228.013 233.966 230.405 233.521 233.071 233.521C235.669 233.521 237.982 233.909 240.01 234.684C242.038 235.436 243.758 236.563 245.171 238.067C246.584 239.571 247.655 241.44 248.384 243.673C249.136 245.883 249.512 248.447 249.512 251.363ZM240.83 251.568C240.83 247.968 240.146 245.268 238.779 243.468C237.435 241.645 235.441 240.733 232.798 240.733C231.34 240.733 230.098 241.018 229.072 241.588C228.047 242.158 227.204 242.944 226.543 243.946C225.882 244.926 225.392 246.077 225.073 247.398C224.777 248.72 224.629 250.133 224.629 251.637C224.629 255.26 225.358 257.994 226.816 259.84C228.275 261.663 230.269 262.574 232.798 262.574C234.188 262.574 235.396 262.301 236.421 261.754C237.446 261.184 238.278 260.41 238.916 259.43C239.554 258.427 240.033 257.254 240.352 255.909C240.671 254.565 240.83 253.118 240.83 251.568ZM287.964 251.021C287.964 254.212 287.508 256.969 286.597 259.293C285.708 261.617 284.455 263.554 282.837 265.104C281.242 266.63 279.351 267.77 277.163 268.521C274.976 269.251 272.594 269.615 270.02 269.615C267.49 269.615 265.132 269.422 262.944 269.034C260.78 268.67 258.706 268.168 256.724 267.53V220.704H265.063V232.052L264.722 238.888C265.975 237.27 267.433 235.971 269.097 234.991C270.783 234.011 272.799 233.521 275.146 233.521C277.197 233.521 279.02 233.932 280.615 234.752C282.21 235.572 283.543 236.746 284.614 238.272C285.708 239.776 286.54 241.611 287.109 243.775C287.679 245.917 287.964 248.333 287.964 251.021ZM279.214 251.363C279.214 249.449 279.077 247.82 278.804 246.476C278.53 245.131 278.132 244.026 277.607 243.16C277.106 242.294 276.479 241.668 275.728 241.28C274.998 240.87 274.155 240.665 273.198 240.665C271.785 240.665 270.43 241.235 269.131 242.374C267.855 243.513 266.499 245.063 265.063 247.022V262.198C265.724 262.449 266.533 262.654 267.49 262.813C268.47 262.973 269.461 263.053 270.464 263.053C271.785 263.053 272.982 262.779 274.053 262.232C275.146 261.686 276.069 260.911 276.821 259.908C277.596 258.906 278.188 257.687 278.599 256.251C279.009 254.793 279.214 253.163 279.214 251.363ZM323.853 258.78C323.853 260.763 323.408 262.46 322.52 263.873C321.654 265.263 320.492 266.402 319.033 267.291C317.598 268.157 315.957 268.784 314.111 269.171C312.288 269.581 310.42 269.786 308.506 269.786C305.954 269.786 303.652 269.661 301.602 269.41C299.551 269.182 297.614 268.84 295.791 268.385V260.865C297.933 261.754 300.063 262.403 302.183 262.813C304.325 263.201 306.341 263.395 308.232 263.395C310.42 263.395 312.049 263.053 313.12 262.369C314.214 261.663 314.761 260.751 314.761 259.635C314.761 259.111 314.647 258.632 314.419 258.199C314.191 257.766 313.758 257.356 313.12 256.969C312.505 256.559 311.628 256.148 310.488 255.738C309.349 255.305 307.856 254.827 306.011 254.303C304.302 253.824 302.798 253.289 301.499 252.696C300.223 252.081 299.163 251.363 298.32 250.543C297.477 249.723 296.839 248.777 296.406 247.706C295.996 246.612 295.791 245.336 295.791 243.878C295.791 242.465 296.11 241.132 296.748 239.879C297.386 238.626 298.332 237.532 299.585 236.598C300.861 235.641 302.445 234.889 304.336 234.342C306.227 233.795 308.438 233.521 310.967 233.521C313.154 233.521 315.091 233.635 316.777 233.863C318.464 234.091 319.956 234.342 321.255 234.615V241.417C319.272 240.779 317.404 240.335 315.649 240.084C313.918 239.811 312.197 239.674 310.488 239.674C308.779 239.674 307.401 239.981 306.353 240.597C305.327 241.212 304.814 242.066 304.814 243.16C304.814 243.684 304.917 244.151 305.122 244.562C305.327 244.972 305.726 245.37 306.318 245.758C306.934 246.145 307.777 246.555 308.848 246.988C309.941 247.398 311.377 247.854 313.154 248.355C315.16 248.925 316.846 249.54 318.213 250.201C319.58 250.839 320.674 251.568 321.494 252.389C322.337 253.209 322.941 254.143 323.306 255.191C323.67 256.24 323.853 257.436 323.853 258.78Z" fill="#F8F2F2"/>
      </svg>


    </div>
    <div>
    <div>  <span class = "fs-bold fs-4  ps-2 " >Printing Job Center</span></div>
      <div  class = "fs-bold  ps-3" > <span class = 'badge bg-danger' > <?php if(isset($_REQUEST['ListType'])){ echo $_REQUEST['ListType']; }else{ echo 'NewJobPKG';} ?> </span> </div>
    </div>
 
    </div>
     
    <div class= "d-flex justify-content-center   my-3">
          <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
            </svg>
          </a>

          <form action=""  method = "post"  >
              <select class = "form-select" name="ListType" id="ListType" style = "border:3px solid green; " onchange = "this.form.submit();" > 
                <option value="<?=(isset($_REQUEST['ListType'])) ? $_REQUEST['ListType']  :  ( (isset($ListType )) ? $ListType  : '')   ;  ?>">
                   <?=(isset($_REQUEST['ListType'])) ? $_REQUEST['ListType']  : ((isset($ListType )) ? $ListType : ''  ) ;  ?>
                </option>
                <?php  if(in_array( $Gate['VIEW_JC_PKG_OPTION'] , $_SESSION['ACCESS_LIST']  )) { ?> <option value="NewJobPKG">New Job PKG</option><?php } ?> 
                <?php  if(in_array( $Gate['VIEW_JC_PP_OPTION'] , $_SESSION['ACCESS_LIST']  )) { ?> <option value="NewJobPP">New Job PP</option><?php } ?> 
              </select>
          </form>
    </div>

  </div>
</div>


 <div class="card m-3 shadow">
    <div class="card-body">
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <div class="search ">
            <i class="fa-search">
              <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </i>
            <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
          </div>
        </div>
      </div>
    </div>                
 </div>
   

 


 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">

      <table class= "table " id = "JobTable" >
          <thead>
              <tr class="table-info">
                  <th>JobNo</th>       
                  <th title="Printing Press Job No">PP-JN</th>
                  <th title="Order Date">O.Date</th>
                  <th title="Company Name">C.Name</th> 
                  <th title="Product Name">P.Name</th>
                  <th>Size</th>
                  <!-- <th>Papers</th> -->
                  <th>Color</th>
                  <th>Image</th>
                  <th title="Product Type">P.Type</th>
                  <th title="Order QTY">O.QTY</th>
                  <th title="Mobile No">M.NO</th>
                  <th>Comment</th>
                  <th>OPS</th>
              </tr>
          </thead>
          <tbody>
          <?php $COUNTER = 0 ; 
            while($Rows=$DataRows->fetch_assoc())
            {
          ?>
                <tr>
                <td><?=$Rows['JobNo'];?></td>
                <?php $COUNddTER = $Rows['JobNo']; ?>
                <?php   
                      if($ListType=='NewJobPKG')  {?>                                   
                          <td><input type="text" name="JobNoPP" id = "PP__<?php echo $COUNTER++?>"  onfocusout = "PutValueToAnchor( this.value , <?= trim($Rows['JobNo']);?>); "  class="form-control" ></td>
                      <?php      
                      } elseif($ListType=='NewJobPP') {?>
                          <td><?=$Rows['JobNoPP']?></td>
                      <?php }   ?>
              
                <td><?=$Rows['CTNOrderDate']?></td>
                <td><?=$Rows['CustName']?></td>
                <td><?=$Rows['ProductName']?> </td>
                <td>( <?=$Rows['Size']?> ) cm</td>
                <!-- <td> 
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
                <td class = " align-item-center    " >

                  <?php
              
                  if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                  <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                  href="../Design/ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                      <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                  </a>
                  <?php }  else {
                      echo '<span class = "text-danger" >N/A</span>';
                  } ?>

                </td>
                <td><?=$Rows['CTNUnit']?></td>
                <td><?=number_format($Rows['CTNQTY'])?></td>
                <td><?=$Rows['CustMobile']?></td>
                <td><?=$Rows['Note']?> - <?=$Rows['CTNStatus'] ?></td>

               
                      <td>
                          <?php 
                            if(isset($_REQUEST['ListType']))
                            {
                              $ListType=$_REQUEST['ListType'];
                              if($ListType=='NewJobPKG')
                              {?>      
                                <?php  if(in_array( $Gate['VIEW_JC_NJPKG_PROCESS_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                                  <a id = "Anchor_<?=trim($Rows['JobNo'])?>"  class="btn btn-outline-primary btn-sm m-1 border-3 fw-bold" title = "Process" >
                                        <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                          <path d="M23.2569 18.25C23.2081 18.0768 23.0939 17.9293 22.9385 17.8386C22.783 17.7479 22.5984 17.7211 22.4236 17.7639L20.6944 18.2291C21.6407 16.8343 22.2144 15.2207 22.3611 13.5416C22.5029 11.9707 22.2733 10.3885 21.6906 8.92275C21.1079 7.45702 20.1886 6.14892 19.0069 5.10414C18.8703 4.99116 18.6957 4.9347 18.5188 4.94632C18.3419 4.95794 18.1762 5.03676 18.0556 5.16664C17.9342 5.30485 17.8726 5.48557 17.8843 5.66915C17.896 5.85273 17.9801 6.02415 18.1181 6.14581C19.1363 7.04458 19.9284 8.1706 20.4303 9.4326C20.9323 10.6946 21.1298 12.0571 21.0069 13.4097C20.888 14.8344 20.4102 16.2057 19.6181 17.3958L19.4444 15.6528C19.4575 15.5502 19.4476 15.446 19.4152 15.3477C19.3829 15.2495 19.329 15.1597 19.2576 15.085C19.1861 15.0102 19.0989 14.9524 19.0022 14.9156C18.9055 14.8789 18.8019 14.8643 18.6988 14.8727C18.5957 14.8812 18.4959 14.9125 18.4065 14.9645C18.3171 15.0165 18.2404 15.0878 18.1821 15.1732C18.1238 15.2586 18.0853 15.356 18.0694 15.4582C18.0535 15.5603 18.0606 15.6648 18.0903 15.7639L18.4375 20.2361L22.7778 19.0833C22.9497 19.033 23.0956 18.9182 23.1848 18.7629C23.2741 18.6077 23.3 18.4239 23.2569 18.25V18.25Z" fill="black"></path>
                                          <path d="M2.99307 11.8611C3.08537 11.9205 3.18977 11.9584 3.29863 11.9722C3.47986 11.996 3.66316 11.9474 3.80877 11.8369C3.95437 11.7264 4.05054 11.5629 4.0764 11.382C4.36335 9.26332 5.44006 7.33128 7.09092 5.97273C8.74178 4.61419 10.8449 3.92943 12.9792 4.05558L11.4236 5.11808C11.3136 5.201 11.2307 5.31479 11.1855 5.44496C11.1403 5.57514 11.1348 5.71582 11.1698 5.8491C11.2048 5.98239 11.2787 6.10225 11.382 6.19343C11.4853 6.28461 11.6134 6.34299 11.75 6.36114C11.9065 6.37544 12.0631 6.33627 12.1945 6.25003L15.8958 3.70836L12.7292 0.527804C12.6728 0.441458 12.598 0.368743 12.51 0.314939C12.4221 0.261135 12.3232 0.227592 12.2207 0.216744C12.1181 0.205897 12.0145 0.218018 11.9172 0.252227C11.82 0.286436 11.7315 0.341875 11.6584 0.414519C11.5852 0.487163 11.5291 0.575189 11.4942 0.672205C11.4593 0.769222 11.4464 0.872796 11.4565 0.975406C11.4666 1.07802 11.4995 1.17709 11.5526 1.26543C11.6058 1.35377 11.678 1.42916 11.7639 1.48614L12.9445 2.66669C10.4798 2.54884 8.06043 3.35931 6.1641 4.93809C4.26776 6.51687 3.03222 8.74923 2.7014 11.1945C2.6836 11.3217 2.70143 11.4514 2.75293 11.5691C2.80442 11.6868 2.88755 11.7879 2.99307 11.8611Z" fill="black"></path>
                                          <path d="M15.0903 20.7849C14.0059 21.1313 12.862 21.2518 11.7292 21.1391C10.3496 21.0038 9.02362 20.5349 7.86577 19.7726C6.70791 19.0104 5.75297 17.9778 5.08337 16.7641L6.81254 17.4099C6.97194 17.4375 7.13598 17.4087 7.27636 17.3283C7.41674 17.2479 7.52464 17.121 7.58145 16.9695C7.63825 16.818 7.64039 16.6515 7.58749 16.4986C7.53459 16.3457 7.42998 16.2161 7.29171 16.1321L4.10421 14.9516L3.08337 14.5835L2.31254 18.9932C2.28582 19.1694 2.32787 19.3492 2.42999 19.4952C2.53211 19.6413 2.68648 19.7425 2.86115 19.7779H2.97921C3.14265 19.7809 3.30191 19.7261 3.42893 19.6232C3.55596 19.5203 3.64262 19.3759 3.67365 19.2154L3.96532 17.5488C4.75075 18.9247 5.85398 20.0927 7.18287 20.9552C8.51176 21.8178 10.0277 22.3499 11.6042 22.5071C12.9222 22.6377 14.253 22.4959 15.5139 22.0904C15.6745 22.024 15.8043 21.8997 15.8777 21.7422C15.9511 21.5847 15.9628 21.4054 15.9105 21.2397C15.8581 21.074 15.7456 20.9339 15.595 20.8472C15.4445 20.7604 15.2669 20.7332 15.0973 20.771L15.0903 20.7849Z" fill="black"></path>
                                          <path d="M15.2778 9.02783H9.72222C9.53804 9.02783 9.3614 9.101 9.23117 9.23123C9.10094 9.36146 9.02777 9.5381 9.02777 9.72228V15.2778C9.02777 15.462 9.10094 15.6386 9.23117 15.7689C9.3614 15.8991 9.53804 15.9723 9.72222 15.9723H15.2778C15.4619 15.9723 15.6386 15.8991 15.7688 15.7689C15.8991 15.6386 15.9722 15.462 15.9722 15.2778V9.72228C15.9722 9.5381 15.8991 9.36146 15.7688 9.23123C15.6386 9.101 15.4619 9.02783 15.2778 9.02783ZM14.5833 14.5834H10.4167V10.4167H14.5833V14.5834Z" fill="black"></path>
                                        </svg>
                                  </a>
                                <?php } ?> 

                              <?php 
                              }   
                              elseif($ListType=='NewJobPP')  {?>  
                                      <?php  if(in_array( $Gate['VIEW_JC_NJPP_MANAGE_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?> 
                                        <a href="PrintingManage.php?CTNId=<?=$Rows['CTNId']?>&ListType=<?=$ListType?>" class="btn btn-outline-success btn-sm m-1 border-3 fw-bold"> Manage  </a>
                                      </a>
                                      <?php } ?> 
                           <?php
                              }
                             
                            } 
                            else
                            {?>
                                <a id = "Anchor_<?=trim($Rows['JobNo'])?>"  class="btn btn-outline-primary btn-sm m-1 border-3 fw-bold" title = "Process" >
                                      <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg" >
                                        <path d="M23.2569 18.25C23.2081 18.0768 23.0939 17.9293 22.9385 17.8386C22.783 17.7479 22.5984 17.7211 22.4236 17.7639L20.6944 18.2291C21.6407 16.8343 22.2144 15.2207 22.3611 13.5416C22.5029 11.9707 22.2733 10.3885 21.6906 8.92275C21.1079 7.45702 20.1886 6.14892 19.0069 5.10414C18.8703 4.99116 18.6957 4.9347 18.5188 4.94632C18.3419 4.95794 18.1762 5.03676 18.0556 5.16664C17.9342 5.30485 17.8726 5.48557 17.8843 5.66915C17.896 5.85273 17.9801 6.02415 18.1181 6.14581C19.1363 7.04458 19.9284 8.1706 20.4303 9.4326C20.9323 10.6946 21.1298 12.0571 21.0069 13.4097C20.888 14.8344 20.4102 16.2057 19.6181 17.3958L19.4444 15.6528C19.4575 15.5502 19.4476 15.446 19.4152 15.3477C19.3829 15.2495 19.329 15.1597 19.2576 15.085C19.1861 15.0102 19.0989 14.9524 19.0022 14.9156C18.9055 14.8789 18.8019 14.8643 18.6988 14.8727C18.5957 14.8812 18.4959 14.9125 18.4065 14.9645C18.3171 15.0165 18.2404 15.0878 18.1821 15.1732C18.1238 15.2586 18.0853 15.356 18.0694 15.4582C18.0535 15.5603 18.0606 15.6648 18.0903 15.7639L18.4375 20.2361L22.7778 19.0833C22.9497 19.033 23.0956 18.9182 23.1848 18.7629C23.2741 18.6077 23.3 18.4239 23.2569 18.25V18.25Z" fill="black"></path>
                                        <path d="M2.99307 11.8611C3.08537 11.9205 3.18977 11.9584 3.29863 11.9722C3.47986 11.996 3.66316 11.9474 3.80877 11.8369C3.95437 11.7264 4.05054 11.5629 4.0764 11.382C4.36335 9.26332 5.44006 7.33128 7.09092 5.97273C8.74178 4.61419 10.8449 3.92943 12.9792 4.05558L11.4236 5.11808C11.3136 5.201 11.2307 5.31479 11.1855 5.44496C11.1403 5.57514 11.1348 5.71582 11.1698 5.8491C11.2048 5.98239 11.2787 6.10225 11.382 6.19343C11.4853 6.28461 11.6134 6.34299 11.75 6.36114C11.9065 6.37544 12.0631 6.33627 12.1945 6.25003L15.8958 3.70836L12.7292 0.527804C12.6728 0.441458 12.598 0.368743 12.51 0.314939C12.4221 0.261135 12.3232 0.227592 12.2207 0.216744C12.1181 0.205897 12.0145 0.218018 11.9172 0.252227C11.82 0.286436 11.7315 0.341875 11.6584 0.414519C11.5852 0.487163 11.5291 0.575189 11.4942 0.672205C11.4593 0.769222 11.4464 0.872796 11.4565 0.975406C11.4666 1.07802 11.4995 1.17709 11.5526 1.26543C11.6058 1.35377 11.678 1.42916 11.7639 1.48614L12.9445 2.66669C10.4798 2.54884 8.06043 3.35931 6.1641 4.93809C4.26776 6.51687 3.03222 8.74923 2.7014 11.1945C2.6836 11.3217 2.70143 11.4514 2.75293 11.5691C2.80442 11.6868 2.88755 11.7879 2.99307 11.8611Z" fill="black"></path>
                                        <path d="M15.0903 20.7849C14.0059 21.1313 12.862 21.2518 11.7292 21.1391C10.3496 21.0038 9.02362 20.5349 7.86577 19.7726C6.70791 19.0104 5.75297 17.9778 5.08337 16.7641L6.81254 17.4099C6.97194 17.4375 7.13598 17.4087 7.27636 17.3283C7.41674 17.2479 7.52464 17.121 7.58145 16.9695C7.63825 16.818 7.64039 16.6515 7.58749 16.4986C7.53459 16.3457 7.42998 16.2161 7.29171 16.1321L4.10421 14.9516L3.08337 14.5835L2.31254 18.9932C2.28582 19.1694 2.32787 19.3492 2.42999 19.4952C2.53211 19.6413 2.68648 19.7425 2.86115 19.7779H2.97921C3.14265 19.7809 3.30191 19.7261 3.42893 19.6232C3.55596 19.5203 3.64262 19.3759 3.67365 19.2154L3.96532 17.5488C4.75075 18.9247 5.85398 20.0927 7.18287 20.9552C8.51176 21.8178 10.0277 22.3499 11.6042 22.5071C12.9222 22.6377 14.253 22.4959 15.5139 22.0904C15.6745 22.024 15.8043 21.8997 15.8777 21.7422C15.9511 21.5847 15.9628 21.4054 15.9105 21.2397C15.8581 21.074 15.7456 20.9339 15.595 20.8472C15.4445 20.7604 15.2669 20.7332 15.0973 20.771L15.0903 20.7849Z" fill="black"></path>
                                        <path d="M15.2778 9.02783H9.72222C9.53804 9.02783 9.3614 9.101 9.23117 9.23123C9.10094 9.36146 9.02777 9.5381 9.02777 9.72228V15.2778C9.02777 15.462 9.10094 15.6386 9.23117 15.7689C9.3614 15.8991 9.53804 15.9723 9.72222 15.9723H15.2778C15.4619 15.9723 15.6386 15.8991 15.7688 15.7689C15.8991 15.6386 15.9722 15.462 15.9722 15.2778V9.72228C15.9722 9.5381 15.8991 9.36146 15.7688 9.23123C15.6386 9.101 15.4619 9.02783 15.2778 9.02783ZM14.5833 14.5834H10.4167V10.4167H14.5833V14.5834Z" fill="black"></path>
                                      </svg>
                                </a>
                            <?php
                            }
                          ?>
                      </td>
                </tr>
          <?php
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
 

function PutValueToAnchor(value , jobNo) {
    value = value.trim(); 
    if(value.length != 0 ) {
        let anchor = document.getElementById("Anchor_"+jobNo).href = 'PrintingUpdate.php?&ListType<?=$ListType?>&JobNoPP='+ value +'&JobNo=' + jobNo;
    }
    else {
      alert('Please Write Proper Code for the Job!');
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





          