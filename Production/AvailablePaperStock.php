<?php 

    ob_start(); 
    require_once '../App/partials/Header.inc'; 
    
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
    if(!in_array( $Gate['VIEW_AVAILABLE_PAPER_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:index.php?msg=You are not authorized to access Available Paper Stock !" );
    }

    require_once '../App/partials/Menu/MarketingMenu.inc';
    $DBRows = '';
    $PaperCatagory = '';
    $Ctnp = 'Ctnp1'; 

    if (filter_has_var(INPUT_GET, 'CTNId')  && !empty($_GET['CTNId'])  ) {
        $CartonID = $Controller->CleanInput($_GET['CTNId']);
        $Product = '';
        $ProductRows = $Controller->QueryData('SELECT CTNId,CTNType,ProductName,Ctnp1,Ctnp2,Ctnp3,Ctnp4,Ctnp5,Ctnp6,Ctnp7 FROM carton WHERE CTNId=?' , [$CartonID]);
            
        if ($ProductRows->num_rows > 0) {  
            $Product = $ProductRows->fetch_assoc();
        }

        $UP  = $Controller->QueryData('SELECT * FROM  used_paper WHERE carton_id = ?', [ $_GET['CTNId'] ] );
        if ($UP->num_rows > 0) {  
            $UsedPaper = $UP->fetch_assoc();
        }
    } // END OF FILTER VAR 
    // else header('Location:ProductionJobManagement.php'); 

    if(isset($_GET['PaperCatagory']) && !empty(trim($_GET['PaperCatagory']))) {
        
        $PaperCatagory = $Controller->CleanInput($_GET['PaperCatagory']);
        if($PaperCatagory == 'BB') $PaperCatagory = 'Duplex Boards'; 
        if($PaperCatagory == 'Flute') $PaperCatagory = 'Fluting';
        if($PaperCatagory == 'WTL') $PaperCatagory = 'White Test liner';
        if($PaperCatagory == 'WTKL') $PaperCatagory = 'White Kraft';
        if($PaperCatagory == 'KLB') $PaperCatagory = 'Duplex Board';
        if($PaperCatagory == 'Liner') $PaperCatagory = 'Liner';
        if($PaperCatagory == 'TL') $PaperCatagory = 'Test Liner';

    }
    else {
        $PaperCatagory = 'Fluting'; 
    } 
    
    if(isset($_GET['Ctnp']) && !empty($_GET['Ctnp']) ) {
        $Ctnp = $_GET['Ctnp']; 
    }


    $Query = 'SELECT * FROM  paperstock WHERE PCatagory = ? AND  PReel != PUsedReel';
    $DBRows  = $Controller->QueryData( $Query, [$PaperCatagory] );

?>
 
<style>

    .highlight {
        border:3px solid #27C82E;
        background-color:#27C82E; 
        color: white; 
    }

    .highlight:hover {
        border:3px solid #27C82E;
        background-color:white; 
        color: #27C82E; 
    }

    .de-highlight {
       
        border:3px solid red;
        background-color:red; 
        color: white; 

    }

    .de-highlight:hover {
        border:3px solid red;
        background-color:white; 
        color: red; 
    }

</style>




<div class="m-3">
    <div class="card mb-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h5 class = "mb-0" >
            <a class="btn btn-outline-primary   me-3" href="JobManagement.php?CTNId=<?=$CartonID;?>">
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
            </a>

            <svg version="1.1" id="Capa_1" width="40" height="40"  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                viewBox="0 0 197.318 197.318" style="enable-background:new 0 0 197.318 197.318;" xml:space="preserve">
            <path d="M106.802,197.318c-26.703,0-50.729-11.678-67.241-30.195c-3.053-1.714-31.036-18.512-37.839-61.192
                c-3.411-21.395-0.03-44.138,9.52-64.039C20.728,22.118,35.214,7.297,52.029,0.159c1.019-0.431,2.191,0.043,2.623,1.059
                c0.432,1.017-0.042,2.191-1.059,2.623C20.49,17.894-1.007,63.408,5.671,105.301c3.964,24.868,15.631,40.645,24.622,49.451
                c-8.606-13.804-13.582-30.094-13.582-47.524c0-49.676,40.414-90.09,90.09-90.09s90.09,40.414,90.09,90.09
                S156.477,197.318,106.802,197.318z M106.802,21.138c-47.47,0-86.09,38.62-86.09,86.09s38.62,86.09,86.09,86.09
                c47.47,0,86.09-38.62,86.09-86.09S154.271,21.138,106.802,21.138z M106.802,182.281c-7.631,0-14.449-3.548-18.891-9.08
                c-0.068-0.073-0.13-0.152-0.186-0.234c-3.22-4.112-5.141-9.288-5.141-14.903c0-13.354,10.864-24.218,24.218-24.218
                s24.218,10.864,24.218,24.218c0,5.606-1.915,10.774-5.125,14.882c-0.063,0.097-0.136,0.189-0.217,0.274
                C121.235,178.742,114.424,182.281,106.802,182.281z M96.163,175.25c3.092,1.922,6.739,3.032,10.639,3.032
                c3.086,0,6.012-0.695,8.631-1.936c-1.949,0.285-4.105,0.452-6.395,0.387C104.844,176.614,100.03,175.929,96.163,175.25z
                M90.533,170.054c2.56,0.567,11.666,2.484,18.619,2.681c6.701,0.175,12.249-1.878,13.798-2.518c0.822-1.09,1.538-2.267,2.129-3.512
                c-5.897,1.812-12.028,2.728-18.276,2.728s-12.379-0.917-18.276-2.728C89.087,167.888,89.761,169.01,90.533,170.054z M86.962,161.965
                c6.347,2.302,13.019,3.468,19.84,3.468c6.822,0,13.492-1.167,19.84-3.468c0.248-1.263,0.378-2.567,0.378-3.901
                c0-11.148-9.069-20.218-20.218-20.218c-11.148,0-20.218,9.07-20.218,20.218C86.584,159.398,86.714,160.702,86.962,161.965z
                M157.638,131.446c-13.354,0-24.219-10.864-24.219-24.218s10.864-24.218,24.219-24.218c13.354,0,24.218,10.864,24.218,24.218
                S170.991,131.446,157.638,131.446z M157.638,87.01c-11.148,0-20.219,9.07-20.219,20.218s9.07,20.218,20.219,20.218
                c1.334,0,2.639-0.13,3.901-0.378c2.302-6.348,3.468-13.018,3.468-19.84c0-6.821-1.167-13.492-3.468-19.84
                C160.276,87.14,158.972,87.01,157.638,87.01z M166.278,88.951c1.813,5.898,2.729,12.029,2.729,18.277s-0.916,12.379-2.728,18.277
                c6.837-3.246,11.576-10.219,11.576-18.277S173.116,92.197,166.278,88.951z M55.966,131.446c-13.354,0-24.218-10.864-24.218-24.218
                S42.613,83.01,55.966,83.01s24.218,10.864,24.218,24.218S69.32,131.446,55.966,131.446z M52.065,127.068
                c1.263,0.248,2.567,0.378,3.901,0.378c11.148,0,20.218-9.07,20.218-20.218S67.114,87.01,55.966,87.01
                c-1.334,0-2.639,0.13-3.901,0.378c-2.302,6.347-3.468,13.02-3.468,19.84C48.597,114.05,49.763,120.721,52.065,127.068z
                M47.325,88.952c-6.837,3.246-11.576,10.218-11.576,18.276s4.739,15.031,11.576,18.276c-1.812-5.897-2.728-12.028-2.728-18.276
                C44.597,100.981,45.513,94.85,47.325,88.952z M106.802,113.823c-3.637,0-6.595-2.958-6.595-6.595s2.958-6.595,6.595-6.595
                s6.595,2.958,6.595,6.595S110.438,113.823,106.802,113.823z M106.802,104.633c-1.431,0-2.595,1.164-2.595,2.595
                s1.164,2.595,2.595,2.595s2.595-1.164,2.595-2.595S108.232,104.633,106.802,104.633z M106.802,80.61
                c-13.354,0-24.218-10.864-24.218-24.218s10.864-24.218,24.218-24.218s24.218,10.864,24.218,24.218S120.155,80.61,106.802,80.61z
                M86.962,52.491c-0.248,1.263-0.378,2.567-0.378,3.902c0,11.148,9.07,20.218,20.218,20.218c11.148,0,20.218-9.07,20.218-20.218
                c0-1.334-0.13-2.639-0.378-3.902c-6.348-2.301-13.017-3.468-19.84-3.468C99.979,49.023,93.309,50.19,86.962,52.491z M106.802,36.175
                c-8.059,0-15.031,4.739-18.276,11.576c5.897-1.812,12.028-2.728,18.276-2.728c6.249,0,12.379,0.917,18.276,2.728
                C121.832,40.914,114.86,36.175,106.802,36.175z"/>
            </svg>  Available Paper    
        </h5>
        <div>

        <div class="d-flex justify-content-between ">
            <input type="text" style = "width:420px;"  class="form-control me-3" id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'Table' )">
            <form action="AvailablePaperStock.php" method="get">
                <input type="hidden" name="CTNId" value = "<?=$Product['CTNId'];?>" >
                <input type="hidden" name="Ctnp" value = "<?= isset($_REQUEST['Ctnp']) ? $_REQUEST['Ctnp'] : $Ctnp ;?>" >
                <select name="PaperCatagory" onclick = "this.form.submit()" class = "form-select" style = "width:220px;" >
                    <option selected disabled > Select Another Paper</option>
                    <option value="BB">BB</option>
                    <option value="Flute">Flute</option>
                    <option value="WTL">WTL</option>
                    <option value="WTKL">WTKL</option>
                    <option value="KLB">KLB</option>
                    <option value="Liner">Liner</option>
                    <option value="TL">TL</option>
                </select>
            </form>
        </div>

        </div>
    </div>
</div>


<!-- first button for selecting the paper from stock  -->
<div class="card mb-3 shadow">
    <div class="card-body d-flex justify-content-center p-1" >
        <div class="card-group">
            <?php  for ($index=1; $index <= $Product['CTNType'] ; $index++) {  ?>

              


                <a href="AvailablePaperStock.php?CTNId=<?=$Product['CTNId'].'&PaperCatagory='.$Product['Ctnp'.$index].'&Ctnp=Ctnp'.$index ?>"  style = "text-decoration:none;">
                    <div class="card shadow  m-2    <?php echo (isset($UsedPaper['RSC_'.$index]) && !empty($UsedPaper['RSC_'.$index]) ) ?  'highlight' : 'de-highlight';  ?>"   >
                        <div class="card-body  position-relative ">

                            <h5 class = "mb-0 fw-bold" >
                                <?= 'L'.$index .'-'. $Product['Ctnp'.$index];?>
                            </h5>

                            <?php  if( 'Ctnp'.$index == $Ctnp) {  ?>
                                <span class="position-absolute top-0 start-50 translate-middle">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z" fill = "#141614" />
                                    </svg>
                                </span>
                            <?php }?> 
                            
                        </div>
                    </div>
                </a> 
            <?php }?> 
        </div>    
    </div>
</div>
<!-- first button for selecting the paper from stock  -->
     
<!-- d-flex justify-content-center -->
<div class= "card p-3 my-3 shadow ">
    <div class = "card-body  d-flex justify-content-center  p-0" >
        <div class = "d-flex justify-content-between" style = "width:800px;" >

            <div class="me-2 p-0 text-end">
                <span class = "badge bg-info"  style = "border-radius:0px;" >Marketing Selection </span>
                <?php  for ($index=1; $index <= $Product['CTNType'] ; $index++) {  ?>
                        <span class = "badge"  style = "background-color:#AD8762" ><?=$Product['Ctnp'.$index];?></span>
                        <br >
                <?php } ?> 
            </div> 

            <div class="mx-1 text-center" >
                <span class = "badge bg-info mb-2"  style = "border-radius:0px;" >Paper Intersection </span>

                <?php  if($Product['CTNType'] == 3 ) { ?>
                    <svg width="400" height="56" viewBox="0 0 400 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.45399 3H400M0 52.6486H395.093" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 53.6248L16.5371 15.5477C18.7038 9.13093 23.4263 8.34697 26.1314 13.9549L40.7535 44.267C43.1841 49.3054 47.3312 49.2704 49.7389 44.1911L63.967 14.1713C66.3996 9.03886 70.6005 9.06555 73.0155 14.2287L86.6506 43.3805C89.2662 48.9721 93.8982 48.4601 96.1642 42.3289L106.058 15.558C108.571 8.75724 113.861 9.0231 116.187 16.067L124.623 41.6166C126.994 48.7996 132.42 48.9019 134.865 41.8097L143.864 15.6942C146.005 9.482 150.57 8.62507 153.293 13.9239L168.92 44.3245C171.474 49.2923 175.701 48.8997 177.994 43.4816L190.103 14.8752C192.431 9.37517 196.739 9.0682 199.272 14.222L213.426 43.0219C216.205 48.6763 221.019 47.6645 223.098 40.989L230.893 15.9717C232.918 9.46947 237.564 8.30446 240.387 13.5905L256.274 43.3355C259.086 48.6022 263.712 47.468 265.75 41.0118L273.489 16.4892C275.589 9.83523 280.407 8.87759 283.169 14.5653L297.06 43.1761C299.688 48.587 304.227 48.0294 306.475 42.0194L316.359 15.6084C318.903 8.80692 324.222 9.17115 326.509 16.3036L334.405 40.919C336.893 48.6824 342.829 48.2645 345.015 40.1717L351.229 17.2039C353.364 9.31014 359.101 8.66769 361.696 16.0319L370.771 41.774C373.11 48.4111 378.139 48.6894 380.67 42.3222L396.316 3" stroke="#AD8762" stroke-width="5"/>
                    </svg>
                <?php  } ?>

                <?php  if($Product['CTNType'] == 5 ) { ?>
                    <svg width="400" height="105" viewBox="0 0 400 105" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.45399 52.375H400M0 102.023H395.093" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 103L16.5371 64.9225C18.7038 58.506 23.4263 57.7219 26.1314 63.3298L40.7535 93.6418C43.1841 98.6805 47.3312 98.6452 49.7389 93.566L63.967 63.5461C66.3996 58.4139 70.6005 58.4405 73.0155 63.6037L86.6506 92.7552C89.2662 98.3472 93.8982 97.8351 96.1642 91.704L106.058 64.9331C108.571 58.1322 113.861 58.3981 116.187 65.4422L124.623 90.9914C126.994 98.1749 132.42 98.2766 134.865 91.1848L143.864 65.0689C146.005 58.8573 150.57 58 153.293 63.2986L168.92 93.6995C171.474 98.6676 175.701 98.2748 177.994 92.8563L190.103 64.2505C192.431 58.7503 196.739 58.4432 199.272 63.5973L213.426 92.3972C216.205 98.0514 221.019 97.0396 223.098 90.364L230.893 65.3464C232.918 58.8443 237.564 57.6795 240.387 62.9652L256.274 92.7105C259.086 97.9773 263.712 96.8432 265.75 90.387L273.489 65.8644C275.589 59.21 280.407 58.2526 283.169 63.94L297.06 92.5512C299.688 97.962 304.227 97.4041 306.475 91.3947L316.359 64.9836C318.903 58.1819 324.222 58.5462 326.509 65.6786L334.405 90.2941C336.893 98.0573 342.829 97.6393 345.015 89.5468L351.229 66.5787C353.364 58.685 359.101 58.0427 361.696 65.407L370.771 91.1489C373.11 97.7863 378.139 98.0644 380.67 91.6969L396.316 52.375" stroke="#AD8762" stroke-width="5"/>
                        <path d="M2.45399 3H400M0 52.6486H395.093" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 53.6248L16.5371 15.5477C18.7038 9.13093 23.4263 8.34697 26.1314 13.9549L40.7535 44.267C43.1841 49.3054 47.3312 49.2704 49.7389 44.1911L63.967 14.1713C66.3996 9.03886 70.6005 9.06555 73.0155 14.2287L86.6506 43.3805C89.2662 48.9721 93.8982 48.4601 96.1642 42.3289L106.058 15.558C108.571 8.75724 113.861 9.0231 116.187 16.067L124.623 41.6166C126.994 48.7996 132.42 48.9019 134.865 41.8097L143.864 15.6942C146.005 9.482 150.57 8.62507 153.293 13.9239L168.92 44.3245C171.474 49.2923 175.701 48.8997 177.994 43.4816L190.103 14.8752C192.431 9.37517 196.739 9.0682 199.272 14.222L213.426 43.0219C216.205 48.6763 221.019 47.6645 223.098 40.989L230.893 15.9717C232.918 9.46947 237.564 8.30446 240.387 13.5905L256.274 43.3355C259.086 48.6022 263.712 47.468 265.75 41.0118L273.489 16.4892C275.589 9.83523 280.407 8.87759 283.169 14.5653L297.06 43.1761C299.688 48.587 304.227 48.0294 306.475 42.0194L316.359 15.6084C318.903 8.80692 324.222 9.17115 326.509 16.3036L334.405 40.919C336.893 48.6824 342.829 48.2645 345.015 40.1717L351.229 17.2039C353.364 9.31014 359.101 8.66769 361.696 16.0319L370.771 41.774C373.11 48.4111 378.139 48.6894 380.67 42.3222L396.316 3" stroke="#AD8762" stroke-width="5"/>
                    </svg>
                <?php  } ?>

                <?php  if($Product['CTNType'] == 7 ) { ?>
                    <svg width="400" height="155" viewBox="0 0 400 155" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.45399 100.52H400M0 151.986H395.093" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 152.998L16.5371 113.526C18.7038 106.875 23.4262 106.062 26.1314 111.875L40.7535 143.297C43.1841 148.521 47.3312 148.484 49.7389 143.219L63.967 112.1C66.3996 106.779 70.6005 106.807 73.0155 112.159L86.6506 142.378C89.2662 148.175 93.8982 147.644 96.1642 141.289L106.058 113.537C108.571 106.488 113.861 106.763 116.187 114.065L124.623 140.55C126.994 147.996 132.42 148.102 134.865 140.75L143.864 113.678C146.005 107.238 150.57 106.35 153.293 111.843L168.92 143.357C171.474 148.507 175.701 148.1 177.994 142.483L190.103 112.829C192.431 107.128 196.739 106.81 199.272 112.152L213.426 142.007C216.205 147.868 221.019 146.82 223.098 139.9L230.893 113.966C232.918 107.226 237.564 106.018 240.387 111.497L256.274 142.332C259.086 147.792 263.712 146.615 265.75 139.923L273.489 114.503C275.589 107.605 280.407 106.612 283.169 112.508L297.06 142.167C299.688 147.776 304.227 147.197 306.476 140.967L316.359 113.589C318.903 106.539 324.222 106.917 326.509 114.31L334.405 139.827C336.893 147.875 342.829 147.441 345.015 139.052L351.229 115.243C353.364 107.06 359.101 106.394 361.696 114.029L370.771 140.713C373.11 147.593 378.139 147.882 380.67 141.281L396.316 100.52" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 104.236L16.5371 64.7649C18.7039 58.1131 23.4262 57.3006 26.1314 63.1138L40.7536 94.5359C43.1841 99.7591 47.3313 99.7226 49.7386 94.4573L63.967 63.3381C66.3997 58.018 70.6006 58.0454 73.0155 63.3978L86.6507 93.6168C89.2662 99.4135 93.8983 98.8827 96.1642 92.5271L106.058 64.7758C108.571 57.726 113.861 58.0015 116.187 65.3036L124.623 91.7884C126.994 99.2344 132.42 99.3404 134.865 91.9889L143.864 64.9166C146.005 58.4769 150.569 57.5889 153.293 63.0815L168.92 94.5956C171.474 99.7451 175.701 99.3386 177.994 93.7217L190.103 64.0676C192.431 58.3666 196.74 58.0485 199.272 63.3905L213.426 93.2457C216.205 99.107 221.019 98.0581 223.098 91.1381L230.893 65.2043C232.918 58.4641 237.564 57.2567 240.387 62.7359L256.274 93.5705C259.086 99.0302 263.712 97.8539 265.75 91.1613L273.489 65.7413C275.589 58.8432 280.407 57.8504 283.169 63.7464L297.06 93.4053C299.688 99.0144 304.227 98.436 306.476 92.2059L316.359 64.8276C318.903 57.7772 324.222 58.1551 326.509 65.5487L334.405 91.0656C336.893 99.1131 342.826 98.6797 345.016 90.2909L351.229 66.4818C353.364 58.2989 359.101 57.6328 361.696 65.2671L370.771 91.9517C373.11 98.8315 378.139 99.1204 380.671 92.5198L396.316 51.7578" stroke="#AD8762" stroke-width="5"/>
                        <path d="M2.45399 3H400M0 54.4668H395.093" stroke="#AD8762" stroke-width="5"/>
                        <path d="M3.67969 55.4785L16.5371 16.0072C18.7038 9.35543 23.4262 8.54275 26.1314 14.3561L40.7535 45.7782C43.1841 51.0011 47.3312 50.9648 49.7389 45.6995L63.967 14.5804C66.3996 9.25998 70.6005 9.28765 73.0155 14.6399L86.6506 44.8592C89.2662 50.6556 93.8982 50.1248 96.1642 43.7691L106.058 16.0178C108.571 8.96804 113.861 9.24365 116.187 16.5455L124.623 43.0307C126.994 50.4768 132.42 50.5828 134.865 43.2309L143.864 16.159C146.005 9.71935 150.57 8.83104 153.293 14.3239L168.92 45.8378C171.474 50.9875 175.701 50.5805 177.994 44.964L190.103 15.3101C192.431 9.6086 196.739 9.2904 199.272 14.6329L213.426 44.4875C216.205 50.3489 221.019 49.3001 223.098 42.3801L230.893 16.4467C232.918 9.70636 237.564 8.49869 240.387 13.9783L256.274 44.8126C259.086 50.2722 263.712 49.0964 265.75 42.4037L273.489 16.9832C275.589 10.0855 280.407 9.0928 283.169 14.9888L297.06 44.6473C299.688 50.2564 304.227 49.6783 306.476 43.4483L316.359 16.0701C318.903 9.01955 324.222 9.39712 326.509 16.7907L334.405 42.3076C336.893 50.3553 342.829 49.9221 345.015 41.5329L351.229 17.7241C353.364 9.5412 359.101 8.87522 361.696 16.5091L370.771 43.1939C373.11 50.074 378.139 50.3626 380.67 43.7621L396.316 3" stroke="#AD8762" stroke-width="5"/>
                    </svg>
                <?php  } ?>



            </div> 

            <div class="ms-2 p-0 text-start" >
                <span class = "badge bg-info"  style = "border-radius:0px;" >Production   </span>
                <?php if(isset($UsedPaper) && !empty($UsedPaper)) {  for ($index=1; $index <= $Product['CTNType'] ; $index++) { ?>
                    <span class = "badge"  style = "background-color:#AD8762" ><?= $UsedPaper['PSPN_'.$index];?></span>
                    <br >
                <?php  } }  ?>
            </div> 

            <div class = " ms-2 p-0">
                <span class = "badge bg-info"  style = "border-radius:0px;" >Reel Size & Country </span>
                <?php for ($index=1; $index <= $Product['CTNType'] ; $index++) { 
                        if(isset($UsedPaper['RSC_'.$index]) && !empty(trim($UsedPaper['RSC_'.$index])) ) {  ?>
                        <span class = "badge"  style = "background-color:#AD8762" >
                            <?=(trim($Product['Ctnp'.$index]) == 'BB') ? '- Printing Press -': $UsedPaper['RSC_'.$index]  ;?> 
                        </span>  
                        <br >     
                <?php } } ?> 
            </div>

        </div>



    </div>
</div>

<!-- 
    <div>sssssssssssssssss</div>


   

    <div>sssssssssssssssss</div>


    <svg width="400" height="34" viewBox="0 0 400 34" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M2.45399 2H400M0 31.4216H395.093" stroke="#AD8762" stroke-width="4"/>
        <path d="M3.67969 32L16.5371 9.43571C18.7038 5.63316 23.4263 5.16859 26.1314 8.49182L40.7535 26.4546C43.1841 29.4404 47.3312 29.4196 49.7389 26.4096L63.967 8.62008C66.3996 5.5786 70.6005 5.59442 73.0155 8.65408L86.6506 25.9293C89.2662 29.2429 93.8982 28.9394 96.1642 25.3061L106.058 9.44181C108.571 5.41171 113.861 5.56926 116.187 9.74346L124.623 24.884C126.994 29.1406 132.42 29.2013 134.865 24.9984L143.864 9.5225C146.005 5.8412 150.57 5.33339 153.293 8.47343L168.92 26.4887C171.474 29.4326 175.701 29.1999 177.994 25.9892L190.103 9.0372C192.431 5.77789 196.739 5.59599 199.272 8.65011L213.426 25.7168C216.205 29.0675 221.019 28.468 223.098 24.5121L230.893 9.68695C232.918 5.83378 237.564 5.1434 240.387 8.27588L256.274 25.9026C259.086 29.0237 263.712 28.3515 265.75 24.5256L273.489 9.99366C275.589 6.05053 280.407 5.48303 283.169 8.85355L297.06 25.8082C299.688 29.0147 304.227 28.6842 306.475 25.1227L316.359 9.47167C318.903 5.44115 324.222 5.65699 326.509 9.88363L334.405 24.4707C336.893 29.0712 342.829 28.8236 345.015 24.0277L351.229 10.4172C353.364 5.73936 359.101 5.35865 361.696 9.72263L370.771 24.9773C373.11 28.9104 378.139 29.0753 380.67 25.3021L396.316 2" stroke="#AD8762" stroke-width="4"/>
    </svg> -->




































<!-- 

 <div class="card mb-3"  >
        <div class="card-body">
            <div class="row">
                <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12  ">
                    <input type="text" class="form-control border-3 " id = "Search_input"  placeholder="Search Anything " onkeyup="search( this.id , 'Table' )">
                </div>
                <div class = "col-lg-2 col-md-2 col-sm-6 col-xs-12   ">
                    <form action="AvailablePaperStock.php" method="get">
                        <input type="hidden" name="CTNId" value = "<?=$Product['CTNId'];?>" >
                        <input type="hidden" name="Ctnp" value = "<?= isset($_REQUEST['Ctnp']) ? $_REQUEST['Ctnp'] : $Ctnp ;?>" >
                        <select name="PaperCatagory" onclick = "this.form.submit()" class = "form-select" style = "max-width:220px;" >
                            <option selected disabled > Select Another Paper</option>
                            <option value="BB">BB</option>
                            <option value="Flute">Flute</option>
                            <option value="WTL">WTL</option>
                            <option value="WTKL">WTKL</option>
                            <option value="KLB">KLB</option>
                            <option value="Liner">Liner</option>
                            <option value="TL">TL</option>
                        </select>

                    </form>
                </div>
            </div>
        </div>
    </div> -->



    <div class="card">
        <div class="card-body pt-1 table-responsive" >
            <table class="table " id = "Table"  >
            <thead>
                <tr>
                    <th>#</th>
                    <th>Paper Name</th>
                    <th>Size(cm)</th>
                    <th>GSM</th>
                    <th>Qty Ton</th>
                    <th>Qty Reel</th>
                    <th>Made</th>
                    <th>Comment</th>
                    <th>Ops</th>
                </tr>
            </thead>
            <tbody>

            <?php $counter = 1 ; while( $DataRows=$DBRows->fetch_assoc() ) : ?>
                <tr>
                    <td><?=$counter; ?></td>
                    <td><?=$DataRows['PName'] ?></td>
                    <td><?=$DataRows['PSize'] ?></td>
                    <td><?=number_format($DataRows['PGSM'])?></td>
                    <td><?=$DataRows['PQuantity'] - $DataRows['PUsedQuantity']?></td>
                    <td><?=$DataRows['PReel'] - $DataRows['PUsedReel'] ?></td>
                    <td><?=$DataRows['PMade'] ?></td>
                    <td><?=$DataRows['PComment'] ?></td>
                    <td class = "d-flex justify-content-center">
                        <form action="AddPaperToJob.php" method = "post" >
                            <div class="form-check">
                                <input class="form-check-input fs-3" style = "border-radius:0px; border:2px solid black;" 
                                    type="checkbox"  id ="check_<?=$counter;?>" 
                                    name = "PaperStockId" onclick = "this.form.submit()" value="<?=$DataRows['PId']?>"    >


                                <input type="hidden" name="CTNId" value = "<?=$Product['CTNId'];?>" >
                                <input type="hidden" name="PaperCatagory" value = "<?= isset($_REQUEST['PaperCatagory']) ? $_REQUEST['PaperCatagory'] : 'Flute' ;?>" >
                                <input type="hidden" name="Ctnp" value = "<?= isset($_REQUEST['Ctnp']) ? $_REQUEST['Ctnp'] : $Ctnp ;?>" >
                                 
                                

                            </div>
                        </form>
                         
                    </td>
                </tr>
                <?php $counter++; ?>
                <?php endwhile; ?>
            </tbody>
            </table>
        </div>
    </div>

</div><!-- END OF M-3  -->


<script>
    function search(InputId ,tableId )  {
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
</script>
<?php require_once '../App/partials/Footer.inc'; ?>


