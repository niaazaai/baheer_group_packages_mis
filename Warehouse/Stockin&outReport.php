<?php 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc';
require '../Assets/Carbon/autoload.php';
use Carbon\Carbon;
 
$ListType='';

$ListType="Stock In Report"; 
$DEFAULT_COLUMNS = 'StockInDate ,JobNo ,CustName, CONCAT(ProductName," (",FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1),")  ",CTNType," Ply ",CTNColor," Color - ",CTNUnit) AS Description,TotalQTY,Ename'; 
$DEFAULT_TABLE_HEADING = "<th>Receive Date</th> <th>JobNo</th> <th>Company</th> <th>Description</th> <th>Receive QTY</th> <th>Received By</th> ";

$SQL="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId 
                                INNER JOIN employeet ON employeet.EId=cartonproduction.ReceivedBy";
                                
$DataRows=$Controller->QueryData($SQL,[]);
 
if(isset($_REQUEST['ListType']) && !empty($_REQUEST['ListType']))
{
    $ListType=$_REQUEST['ListType'];
    if($ListType=="Stock In Report")
    {  
        $DEFAULT_COLUMNS = 'StockInDate , JobNo ,CustName, CONCAT(ProductName," ",FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)," ",CTNType,"Ply",CTNColor," Color-",CTNUnit) AS Description,TotalQTY,Ename'; 
        $DEFAULT_TABLE_HEADING = " <th>Receive Date</th> <th>JobNo</th> <th>Company</th> <th>Description</th> <th>Receive QTY</th> <th>Received By</th> ";

        $SQL="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN cartonproduction ON cartonproduction.CtnId1=carton.CTNId 
        INNER JOIN employeet ON employeet.EId=cartonproduction.ReceivedBy";
        $DataRows=$Controller->QueryData($SQL,[]);

    } 
    elseif($ListType=="Stock Out Report")
    {
        $DEFAULT_COLUMNS = 'OutDateTime ,CtnoutId,JobNo ,CustName, CONCAT(ProductName," ",FORMAT(CTNLength/10,1),"x",FORMAT(CTNWidth/10,1),"x",FORMAT(CTNHeight/ 10,1)," ",CTNType,"Ply",CTNColor," Color-",CTNUnit) AS Description,CtnOutQty,Ename'; 
        $DEFAULT_TABLE_HEADING = "  <th>Receive Date</th> <th>GRN</th> <th>JobNo</th> <th>Company</th> <th>Description</th> <th>Out QTY</th> <th>Loaded By</th> ";

        $SQL="SELECT $DEFAULT_COLUMNS FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 INNER JOIN cartonstockout ON cartonstockout.CtnJobNo=carton.CTNId 
        INNER JOIN employeet ON employeet.EId=cartonstockout.UserId1";
        $DataRows=$Controller->QueryData($SQL,[]);

    }
  
}
 
 
 
?>
 
<?php
      if(isset($_GET['MSG']) && !empty($_GET['MSG'])) 
      {
          $MSG=$_GET['MSG'];
          if($_GET['State']==1)
          {
              echo' <div class="alert alert-success alert-dismissible fade show m-3" role="alert"  id = "message">
                      <strong>Well Done!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
          }
          elseif($_GET['State']==0)
          {
              echo' <div class="alert alert-warning alert-dismissible fade show m-3" role="alert" id = "message">
                      <strong>OPPS!</strong>'.$MSG.' 
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick = "remove_msg(`message`)" ></button>
                    </div>';
          }
      }
?>
 
 
<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between    ">
<!--  style = "border-bottom:4px dotted black ;" -->
    <div class = "d-flex justify-content-between  " >

        <div class = "my-1">
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
            <div> <span class = "fs-bold fs-2  ps-2 " >Warehouse Stock Report Center</span> </div>    
                <div  class = "fs-bold  ps-3" > <span class = 'badge bg-danger' > <?php if(isset( $_REQUEST['ListType'])){ echo  $_REQUEST['ListType']; }else{echo $ListType;} ?> </span> </div>
            </div>
        </div>

        <div class= "d-flex justify-content-end mt-3">
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:4px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>

            <form action="" method = "post">
                <select class = "form-select" name="ListType" id="ListType" style = "border:3px solid green; " onchange = "this.form.submit();" >  
                    <option value="<?=$ListType;?>"><?=$ListType;?></option>
                    <option value="Stock In Report">Stock In Report</option>
                    <option value="Stock Out Report">Stock Out Report</option> 
                </select>
            </form>
        </div>

    </div>
</div>

 
<div class="card m-3">
    <div class="card-body shadow d-flex justify-content-end">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 "> 
                <a class="btn btn-outline-success   my-1" title="Click to Send it via what's up to Customer ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">
                            <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"></path>
                        </svg> 
                        Share
                </a>
                <a href="#" type="button" onclick="export_data()" class="btn btn-outline-success   my-1" title="New Customer">  
                    <svg width="25" height="25" viewBox="0 0 111 108" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M57.55 0H64.975V10C77.488 10 90 10.025 102.512 9.962C104.625 10.049 106.95 9.9 108.787 11.162C110.074 13.012 109.925 15.362 110.012 17.487C109.95 39.187 109.975 60.875 109.988 82.562C109.926 86.2 110.325 89.912 109.563 93.5C109.063 96.1 105.938 96.162 103.85 96.25C90.9 96.287 77.938 96.225 64.975 96.25V107.5H57.212C38.162 104.037 19.074 100.838 0 97.5V10.013C19.188 6.675 38.375 3.388 57.55 0Z" fill="#207245"></path>
                        <path d="M64.9746 13.75H106.225V92.5H64.9746V85H74.9746V76.25H64.9746V71.25H74.9746V62.5H64.9746V57.5H74.9746V48.75H64.9746V43.75H74.9746V35H64.9746V30H74.9746V21.25H64.9746V13.75Z" fill="white"></path>
                        <path d="M79.9746 21.25H97.4746V30H79.9746V21.25Z" fill="#207245"></path>
                        <path d="M37.0251 32.962C39.8501 32.762 42.6881 32.587 45.5251 32.45C42.1927 39.2936 38.8303 46.1227 35.4381 52.937C38.8761 59.937 42.3871 66.887 45.8371 73.887C42.8279 73.7143 39.8198 73.5226 36.8131 73.3119C34.6881 68.0989 32.1001 63.0619 30.5751 57.6119C28.8761 62.6869 26.4501 67.4739 24.5011 72.4499C21.7631 72.4119 19.0251 72.2999 16.2881 72.1869C19.5001 65.8999 22.6001 59.562 25.9121 53.312C23.1001 46.874 20.0121 40.5619 17.1121 34.1619C19.8621 33.9989 22.6121 33.837 25.3621 33.687C27.2241 38.575 29.2611 43.3989 30.8001 48.4119C32.4491 43.0999 34.9121 38.1 37.0251 32.962Z" fill="white"></path>
                        <path d="M79.9746 35H97.4746V43.75H79.9746V35ZM79.9746 48.75H97.4746V57.5H79.9746V48.75ZM79.9746 62.5H97.4746V71.25H79.9746V62.5ZM79.9746 76.25H97.4746V85H79.9746V76.25Z" fill="#207245"></path>
                    </svg>
                    Excel
                </a>
                <a onclick="Print()" class="btn btn-outline-primary   my-1" title="Click to Print Customer List ">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"></path>
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"></path>
                        </svg>
                    Print
                </a> 
                <button type="button" class="btn btn-outline-primary  " data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                        <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"></path>
                        <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"></path>
                    </svg>
                    Setup
                </button>
            </div>
        </div>
    </div>
</div>  

<div class="card m-3">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12" style="z-index: 11">
                <label for="" class="fw-bold pb-2">Select Company Name</label>
                <form action="" method="POST"> 
        
                    <input type="text" name = "CustomerName" id = "customer" class="form-control " value = "<?php if(isset($CustomerName)) echo $CustomerName ;  ?>" 
                    onclick= "HideLiveSearch();" onkeyup="AJAXSearch(this.value);"   placeholder = "Search Company Names" autocomplete="off">
                    <div  id="livesearch" class="list-group shadow z-index-2  position-absolute mt-2  w-25 "></div>
                    <input type="hidden" name="CustId" id = "CustId">
                               
                </form>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                <label for="" class="fw-bold pb-1">Select Product Name</label>
                <select name="" id="" class="form-select">
                    <option value="">Kabul jan</option>
                    <option value="">Baheer</option>
                    <option value="">Laghman</option>
                </select>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                <label for="" class="fw-bold pb-1">Form</label>
                <input type="date" class="form-control" name="From" >
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 my-1">
                <label for="" class="fw-bold pb-1">To</label>
                <input type="date" class="form-control" name="To" >
            </div>
        </div>
    </div>
</div>

 

<div class="card m-3 shadow">
    <div class="card-body">
        <div class="Col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-2"> 
            <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'JobTable' )"> 
        </div>
        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                   <?php if($ListType=='Stock In Report'){ echo $DEFAULT_TABLE_HEADING;} elseif($ListType=='Stock Out Report'){ echo $DEFAULT_TABLE_HEADING; } ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($DataRows as $key => $value) {  ?> 
                        <tr>
                            <?php foreach ($value as $k=> $v) {  ?> 
                                 <?php echo "<td>" . $v . "</td>" ;?>
                            <?php } ?> 
                        </tr>
                <?php } ?>
            </tbody>
        </table>  
    </div>
</div>


<!-- STOCK OUT Modal -->
<div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Column Setup</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

       <div class="modal-body "> 
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method = "post" >
                <div class="modal-body">
                       
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        
                            <input type="hidden" name="SetColumns" value = "Okay">
                            
                            <h5>Plate info</h5>
                            <hr>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "TotalPlat"> Plate QTY  </label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "LineQTY"> Line QTY </label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "PacksInLine"> Packs in line</label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "ExtraPackes"> Extra Packs </label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "TotalPackes"> Total Packs </label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "PerPackes"> Per packs </label> </div>
                                <div class="checkbox"><label> <input type="checkbox" value="200" name = "Pieces"> Pieces QTY </label> </div>
 
                        </div><!-- END OF COL  -->
                        <?php 
                            if($_REQUEST['ListType']=='Stock Out Report')
                            {?>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        
                                    <input type="hidden" name="SetColumns" value = "Okay">
                                    
                                    <h5>Driver Info</h5>
                                    <hr>
                                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "TotalPlat"> Driver Name  </label> </div>
                                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "LineQTY"> Vehicle Type </label> </div>
                                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "PacksInLine"> Plate No</label> </div>
                                        <div class="checkbox"><label> <input type="checkbox" value="200" name = "ExtraPackes"> Driver Mobile No </label> </div> 
                                </div><!-- END OF COL  -->
                                
                            <?php    
                            }
                        ?>
  
                    </div><!-- END OF ROW  -->
                        <hr>
                        <div class="checkbox"><label> <input type="checkbox" value=" " name = "Default" >   Default Columns   </label> </div>
                        <hr>
                        <table class = "table "  id = "SetColumnTable"></table>

                    </div><!-- END OF MODAL BODY  -->
 
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-outline-danger " data-bs-dismiss="modal">Close</button> 
        <button   class="btn btn-outline-primary"  type="submit" >Set Columns</button>
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

var fruits = document.getElementById("ListType");
[].slice.call(fruits.options)
  .map(function(a){
    if(this[a.value]){ 
      fruits.removeChild(a); 
    } else { 
      this[a.value]=1; 
    } 
  },{}); 

function PutQTYToModal(CTNId)
{
    document.getElementById("CTNID").value = CTNId; 
}


function submit_reel(id){

    let reel = document.getElementById(id); 
    console.log(reel.value);
    if(reel.value > 180 || reel.value < 80) {
        alert('your are not allowed'); 
        reel.value = 80; 
        return ; 
    }

    reel.form.submit(); 




}

function add_reel_size(id) 
{
         document.getElementById('reel_size_1').value = document.getElementById(id) ; 
}

</script>
 
<?php  require_once '../App/partials/Footer.inc'; ?>

