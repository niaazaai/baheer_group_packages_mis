
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
        ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  where CTNStatus="Design" OR CTNStatus="Film" order by CTNOrderDate DESC';
      
    }
    else if($ListType=='JobUnderProcess')
    {
        $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit,  CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
        ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` ,Note, offesetp,	 designinfo.Alarmdatetime,designinfo.DesignStatus,  CURRENT_TIMESTAMP,
        designinfo.DesignCode1,designinfo.DesignImage,designinfo.DesignerName1 ,designinfo.DesignStartTime FROM `carton` INNER JOIN ppcustomer 
        ON ppcustomer.CustId=carton.CustId1 INNER JOIN designinfo ON designinfo.CaId=carton.CTNId  where CTNStatus="DesignProcess" OR CTNStatus="Film" order by CTNOrderDate DESC';
 
    } 
}
else
{
    $ListType = 'NewJob'; 
    $SQL='SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , " x " , FORMAT ( CTNWidth / 10 , 1 ), " x ", FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
    ppcustomer.CustMobile, ppcustomer.CustAddress, CTNPaper, CTNColor, JobNo, Note, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` ,offesetp,	 designinfo.Alarmdatetime,designinfo.DesignStatus, designinfo.DesignImage,CURRENT_TIMESTAMP,
    designinfo.DesignCode1 ,designinfo.DesignerName1 ,designinfo.DesignStartTime FROM `carton` INNER JOIN ppcustomer 
    ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId  where CTNStatus="Design" OR CTNStatus="Film"  order by CTNOrderDate DESC';
 

}

$DataRows=$Controller->QueryData($SQL,[]);

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
          <svg width="50" height="50" viewBox="0 0 505 505" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M482.743 160.797L417.551 191.665C443.652 248.064 435.629 316.332 393.262 365.359L357.747 329.843V453.419H481.323L444.541 416.637C508.969 345.468 521.634 243.996 482.743 160.797Z" fill="#F31919"/>
            <path d="M343.938 482.719L313.042 417.555C256.667 443.68 188.371 435.633 139.349 393.267L174.864 357.751H51.2881V481.327L88.0701 444.545C159.244 508.968 260.717 521.633 343.938 482.719Z" fill="#FA05FF"/>
            <path d="M111.451 139.348L146.966 174.863V51.2874H23.3853L60.1623 88.0644C-4.23167 159.267 -16.8977 260.739 21.9933 343.939L87.1613 313.043C61.0373 256.666 69.0843 188.371 111.451 139.348Z" fill="#48FFD3"/>
            <path d="M453.425 146.96V23.3844L416.648 60.1614C345.445 -4.23162 243.973 -16.8976 160.774 21.9934L191.666 87.1574C248.066 61.0564 316.337 69.0794 365.359 111.446L329.844 146.961H453.425V146.96Z" fill="#25B6D2"/>
            <path d="M252.354 351.081C306.88 351.081 351.082 306.879 351.082 252.353C351.082 197.827 306.88 153.625 252.354 153.625C197.828 153.625 153.626 197.827 153.626 252.353C153.626 306.879 197.828 351.081 252.354 351.081Z" fill="black"/>
            <path d="M205.181 268.009C205.181 270.606 204.793 272.862 204.019 274.776C203.267 276.713 202.173 278.308 200.737 279.562C199.325 280.838 197.616 281.783 195.61 282.398C193.628 283.036 191.406 283.355 188.945 283.355C186.94 283.355 185.072 283.185 183.34 282.843C181.608 282.501 180.184 282.091 179.067 281.612V273.956C179.705 274.298 180.423 274.628 181.221 274.947C182.041 275.289 182.884 275.585 183.75 275.836C184.639 276.109 185.539 276.314 186.45 276.451C187.362 276.611 188.262 276.69 189.15 276.69C191.68 276.69 193.571 275.961 194.824 274.503C196.077 273.045 196.704 270.903 196.704 268.077V240.768H180.195V234.273H205.181V268.009ZM205.864 224.771C205.864 225.523 205.728 226.23 205.454 226.891C205.181 227.551 204.793 228.132 204.292 228.634C203.813 229.112 203.232 229.5 202.549 229.796C201.888 230.069 201.17 230.206 200.396 230.206C199.621 230.206 198.903 230.069 198.242 229.796C197.581 229.5 197 229.112 196.499 228.634C196.021 228.132 195.645 227.551 195.371 226.891C195.098 226.23 194.961 225.523 194.961 224.771C194.961 224.02 195.098 223.313 195.371 222.652C195.645 221.992 196.021 221.41 196.499 220.909C197 220.408 197.581 220.021 198.242 219.747C198.903 219.451 199.621 219.303 200.396 219.303C201.17 219.303 201.888 219.451 202.549 219.747C203.232 220.021 203.813 220.408 204.292 220.909C204.793 221.41 205.181 221.992 205.454 222.652C205.728 223.313 205.864 224.02 205.864 224.771ZM249.512 251.363C249.512 254.098 249.124 256.604 248.35 258.883C247.575 261.139 246.458 263.076 245 264.693C243.542 266.311 241.753 267.564 239.634 268.453C237.515 269.342 235.099 269.786 232.388 269.786C229.813 269.786 227.511 269.41 225.483 268.658C223.455 267.906 221.735 266.79 220.322 265.309C218.91 263.805 217.827 261.936 217.075 259.703C216.323 257.447 215.947 254.827 215.947 251.842C215.947 249.085 216.335 246.578 217.109 244.322C217.907 242.066 219.035 240.141 220.493 238.546C221.974 236.951 223.774 235.72 225.894 234.854C228.013 233.966 230.405 233.521 233.071 233.521C235.669 233.521 237.982 233.909 240.01 234.684C242.038 235.436 243.758 236.563 245.171 238.067C246.584 239.571 247.655 241.44 248.384 243.673C249.136 245.883 249.512 248.447 249.512 251.363ZM240.83 251.568C240.83 247.968 240.146 245.268 238.779 243.468C237.435 241.645 235.441 240.733 232.798 240.733C231.34 240.733 230.098 241.018 229.072 241.588C228.047 242.158 227.204 242.944 226.543 243.946C225.882 244.926 225.392 246.077 225.073 247.398C224.777 248.72 224.629 250.133 224.629 251.637C224.629 255.26 225.358 257.994 226.816 259.84C228.275 261.663 230.269 262.574 232.798 262.574C234.188 262.574 235.396 262.301 236.421 261.754C237.446 261.184 238.278 260.41 238.916 259.43C239.554 258.427 240.033 257.254 240.352 255.909C240.671 254.565 240.83 253.118 240.83 251.568ZM287.964 251.021C287.964 254.212 287.508 256.969 286.597 259.293C285.708 261.617 284.455 263.554 282.837 265.104C281.242 266.63 279.351 267.77 277.163 268.521C274.976 269.251 272.594 269.615 270.02 269.615C267.49 269.615 265.132 269.422 262.944 269.034C260.78 268.67 258.706 268.168 256.724 267.53V220.704H265.063V232.052L264.722 238.888C265.975 237.27 267.433 235.971 269.097 234.991C270.783 234.011 272.799 233.521 275.146 233.521C277.197 233.521 279.02 233.932 280.615 234.752C282.21 235.572 283.543 236.746 284.614 238.272C285.708 239.776 286.54 241.611 287.109 243.775C287.679 245.917 287.964 248.333 287.964 251.021ZM279.214 251.363C279.214 249.449 279.077 247.82 278.804 246.476C278.53 245.131 278.132 244.026 277.607 243.16C277.106 242.294 276.479 241.668 275.728 241.28C274.998 240.87 274.155 240.665 273.198 240.665C271.785 240.665 270.43 241.235 269.131 242.374C267.855 243.513 266.499 245.063 265.063 247.022V262.198C265.724 262.449 266.533 262.654 267.49 262.813C268.47 262.973 269.461 263.053 270.464 263.053C271.785 263.053 272.982 262.779 274.053 262.232C275.146 261.686 276.069 260.911 276.821 259.908C277.596 258.906 278.188 257.687 278.599 256.251C279.009 254.793 279.214 253.163 279.214 251.363ZM323.853 258.78C323.853 260.763 323.408 262.46 322.52 263.873C321.654 265.263 320.492 266.402 319.033 267.291C317.598 268.157 315.957 268.784 314.111 269.171C312.288 269.581 310.42 269.786 308.506 269.786C305.954 269.786 303.652 269.661 301.602 269.41C299.551 269.182 297.614 268.84 295.791 268.385V260.865C297.933 261.754 300.063 262.403 302.183 262.813C304.325 263.201 306.341 263.395 308.232 263.395C310.42 263.395 312.049 263.053 313.12 262.369C314.214 261.663 314.761 260.751 314.761 259.635C314.761 259.111 314.647 258.632 314.419 258.199C314.191 257.766 313.758 257.356 313.12 256.969C312.505 256.559 311.628 256.148 310.488 255.738C309.349 255.305 307.856 254.827 306.011 254.303C304.302 253.824 302.798 253.289 301.499 252.696C300.223 252.081 299.163 251.363 298.32 250.543C297.477 249.723 296.839 248.777 296.406 247.706C295.996 246.612 295.791 245.336 295.791 243.878C295.791 242.465 296.11 241.132 296.748 239.879C297.386 238.626 298.332 237.532 299.585 236.598C300.861 235.641 302.445 234.889 304.336 234.342C306.227 233.795 308.438 233.521 310.967 233.521C313.154 233.521 315.091 233.635 316.777 233.863C318.464 234.091 319.956 234.342 321.255 234.615V241.417C319.272 240.779 317.404 240.335 315.649 240.084C313.918 239.811 312.197 239.674 310.488 239.674C308.779 239.674 307.401 239.981 306.353 240.597C305.327 241.212 304.814 242.066 304.814 243.16C304.814 243.684 304.917 244.151 305.122 244.562C305.327 244.972 305.726 245.37 306.318 245.758C306.934 246.145 307.777 246.555 308.848 246.988C309.941 247.398 311.377 247.854 313.154 248.355C315.16 248.925 316.846 249.54 318.213 250.201C319.58 250.839 320.674 251.568 321.494 252.389C322.337 253.209 322.941 254.143 323.306 255.191C323.67 256.24 323.853 257.436 323.853 258.78Z" fill="#F8F2F2"/>
          </svg>   Job Center
      </h3>

      <div class= "d-flex justify-content-center  ">
        <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
            <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
          </svg>
        </a>

        <form action=""  method = "post" class = "m-0 p-0 "  >
            <select class = "form-select" name="ListType" id="ListType" style = "border:3px solid black; " onchange = "this.form.submit();" > 
              <option value="<?=$ListType;?>"><?=$ListType;?></option>
              <option value="NewJob">New Job</option>
              <option value="JobUnderProcess">Job Under Process</option>
            </select>
        </form>
      </div>
      
    </div>
</div>

 <div class="card m-3 shadow">
    <div class="card-body">
      <div class="row d-flex justify-content-between">

            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
              <div class="search ">
                <i class="fa-search">
                  <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                  </svg>
                </i>
                <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )">
              </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2  d-flex justify-content-end">
                <a class="btn btn-outline-success " id = "design-button"  style = "padding:10px;" onclick = "SwitchTableData(); "  >
                    <svg xmlns="http://www.w3.org/2000/svg" style = "display:none;"  width="30" height="30" fill="currentColor" id = "design-logo-red" class="bi bi-x-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"  id = "design-logo-green" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                  JOBS 
                </a>
          </div>  

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
                                <th title="Design Status">D.Status</th>
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
     
          // function CountAndMerge($string){
          //   // $pieces = explode(" ", $string);
          //   // $vals = array_count_values($pieces);
          //   // unset($vals['']);
          //   // foreach ($vals as $key => $value) {
          //   //   echo ' '. $value .' '. $key  . ' ';
          //   //   if ($key !== array_key_last($vals)) echo ',';
              
          //   // }
                               
          // }
            // $x = '100.10'; 
            // $x = preg_replace("/\.?0*$/",'',$x); 
            // echo $x; $SIZE = preg_replace("/\.?0*$/",'',$Rows['Size'])

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
                                <td><?php if($Rows['DesignStatus']=='Done'){echo '<span class="badge" style = "background-color:#14C38E;">'.$Rows['DesignStatus'].'</span>';}else{echo $Rows['DesignStatus'];}?></td>
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

                                      // echo Carbon::now();

                                      // echo Carbon::create($Rows['Alarmdatetime'])->diffForHumans($Rows['Alarmdatetime']);


                                      // echo Carbon::create($Rows['Alarmdatetime'])->longRelativeDiffForHumans('2018');

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





          