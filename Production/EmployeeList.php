<?php
  ob_start();
  require_once '../App/partials/Header.inc'; 
  $Gate = require_once  $ROOT_DIR . '/Auth/Gates/PRODUCTION_DEPT';
  if(!in_array( $Gate['VIEW_PRODUCTION_STAFF_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
      header("Location:index.php?msg=You are not authorized to access this page!" );
  }
  require_once '../App/partials/Menu/MarketingMenu.inc';
 
  
if(isset($_POST['EMPID']) && !empty($_POST['EMPID']))
{
    $machine_id=$_POST['machine_id']; 
    $EMPID=$_POST['EMPID'];
    
    $update=$Controller->QueryData("UPDATE machine SET machine_opreator_id=? WHERE machine_id=? ",[$EMPID,$machine_id]);
    if($update)
    {
        echo'<div class="alert alert-success alert-dismissible fade show m-3" role="alert">
        <strong>!</strong> You have successfully assign machine to operator.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}

$SQL=$Controller->QueryData("SELECT EId,Ename,EJob,EDepartment , machine_name,EFName , machine_opreator_id  , EId  
FROM employeet 
LEFT OUTER JOIN machine ON employeet.EId = machine.machine_opreator_id  
WHERE EDepartment='Production' AND EJob='Machine Opreator' ",[]);

$Machine=$Controller->QueryData("SELECT machine_id ,machine_name, machine_name_pashto,machine_type FROM machine WHERE machine_type='Production'",[]);
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


<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between "> 
    <div class = "d-flex justify-content-between ">
        <h4 class="m-0 p-0">
          <a class="btn btn-outline-primary   me-1" href="index.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
              </svg>
          </a>
          <svg width="45" height="45" viewBox="0 0 395 485" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M107.5 364.8V437.5H67.5V381.9C77.4 376.7 89 371.9 102.5 367.5C102.5 367.5 104.4 366.5 107.5 364.8Z" fill="#31C0D8"/>
              <path d="M327.5 381.7V437.5H287.5V364.8C290.6 366.5 292.5 367.5 292.5 367.5C306 371.8 317.6 376.6 327.5 381.7Z" fill="#31C0D8"/>
              <path d="M52.5 467.5C52.5 473 57 477.5 62.5 477.5H7.5C7.5 463.5 7.5 452.5 7.5 452.5C7.5 452.5 8.2 412.4 67.5 381.9V437.5H62.5C57 437.5 52.5 442 52.5 447.5V467.5Z" fill="#AFB6BB"/>
              <path d="M387.5 452.5C387.5 452.5 387.5 463.5 387.5 477.5H332.5C338 477.5 342.5 473 342.5 467.5V447.5C342.5 442 338 437.5 332.5 437.5H327.5V381.7C387.3 412.1 387.5 452.5 387.5 452.5Z" fill="#AFB6BB"/>
              <path d="M287.5 364.8V437.5H107.5V364.8C117.3 359.4 139.2 346.8 147.5 337.5C147.5 337.5 168.1 362.5 197.5 362.5C226.9 362.5 247.5 337.5 247.5 337.5C255.8 346.8 277.7 359.4 287.5 364.8Z" fill="#AFB6BB"/>
              <path d="M342.5 447.5V467.5C342.5 473 338 477.5 332.5 477.5H62.5C57 477.5 52.5 473 52.5 467.5V447.5C52.5 442 57 437.5 62.5 437.5H67.5H107.5H287.5H327.5H332.5C338 437.5 342.5 442 342.5 447.5Z" fill="#31C0D8"/>
              <path d="M237.5 19V102.5H157.5V19V7.5H237.5V19Z" fill="#FFD147"/>
              <path d="M317.5 102.5H237.5V19C276 32 306.1 63.3 317.5 102.5Z" fill="#FBB246"/>
              <path d="M157.5 19V102.5H77.5V102.4C88.9 63.2 119 32 157.5 19Z" fill="#FBB246"/>
              <path d="M342.5 142.5H307.5H87.5H52.5C52.5 131.5 61.5 102.5 72.5 102.5H77.5H157.5H237.5H317.5H322.5C333.5 102.5 342.5 131.5 342.5 142.5Z" fill="#FFD248"/>
              <path d="M307.5 167.5C324.1 167.5 337.5 173.7 337.5 187.5C337.5 200.3 321.7 215.1 306.2 217.2C307.1 210.8 307.5 204.2 307.5 197.5V167.5Z" fill="#EADECA"/>
              <path d="M87.5 197.5C87.5 204.2 87.9 210.8 88.8 217.2C73.3 215.1 57.5 200.3 57.5 187.5C57.5 173.7 70.9 167.5 87.5 167.5V197.5Z" fill="#EADECA"/>
              <path d="M147.5 305.7C162.1 313.3 178.9 317.5 197.5 317.5C216.1 317.5 232.9 313.3 247.5 305.7V337.5C247.5 337.5 226.9 362.5 197.5 362.5C168.1 362.5 147.5 337.5 147.5 337.5V305.7Z" fill="#EADECA"/>
              <path d="M147.5 305.7C115.4 289.1 94.2 256.3 88.8 217.2C87.9 210.8 87.5 204.2 87.5 197.5V167.5V142.5H307.5V167.5V197.5C307.5 204.2 307.1 210.8 306.2 217.2C300.8 256.3 279.6 289.1 247.5 305.7C232.9 313.3 216.1 317.5 197.5 317.5C178.9 317.5 162.1 313.3 147.5 305.7Z" fill="#EADECA"/>
              <path d="M330.935 375.033C320.437 369.625 308.493 364.758 295.423 360.561C294.656 360.152 293.151 359.345 291.12 358.231C274.452 349.047 261.313 340.364 255 334.428V310.142C285.385 292.77 306.163 261.599 312.804 223.447C330.017 218.518 345 202.361 345 187.5C345 172.457 333.692 162.474 315 160.406V150H350V142.5C350 132.845 341.618 95.693 322.998 95.031C310.397 57.703 281.775 27.87 245 13.748V0H150V13.748C113.176 27.885 84.536 57.721 71.967 95.033C53.372 95.74 45 132.851 45 142.5V150H80V160.406C61.308 162.474 50 172.457 50 187.5C50 202.361 64.983 218.519 82.196 223.448C88.843 261.615 109.625 292.783 140 310.144V334.429C133.688 340.365 120.55 349.047 103.894 358.224C101.834 359.354 100.317 360.167 99.556 360.573C86.148 364.974 74.193 369.914 64.071 375.231C1.5 407.413 0.0339989 450.549 0.0019989 452.37L0 485H395V452.463C394.991 450.626 394.051 407.119 330.935 375.033ZM320 386.345V430H295V376.218C304.011 379.276 312.38 382.666 320 386.345ZM115 369.204C124.754 363.695 138.203 355.583 147.241 348.035C155.885 356.174 174.023 370 197.5 370C220.977 370 239.115 356.174 247.759 348.034C256.794 355.58 270.239 363.69 280 369.203V430H115V369.204ZM197.5 325C212.579 325 226.824 322.405 240 317.299V334.611C234.87 339.974 218.613 355 197.5 355C176.523 355 160.154 339.945 155 334.596V317.298C168.182 322.406 182.424 325 197.5 325ZM330 187.5C330 193.626 323.373 201.967 314.734 206.57C314.899 203.606 315 175.482 315 175.482C328.367 177.356 330 184.268 330 187.5ZM307.045 95H245V29.958C273.457 42.537 295.807 65.964 307.045 95ZM165 15H230V95H165V15ZM150 29.956V95H87.919C99.134 65.976 121.5 42.545 150 29.956ZM72.669 110H322.331C325.773 111.314 331.803 124.23 334.088 135H60.912C63.197 124.23 69.227 111.314 72.669 110ZM65 187.5C65 184.268 66.633 177.356 80 175.482C80 175.482 80.101 203.608 80.266 206.57C71.627 201.966 65 193.626 65 187.5ZM96.227 216.156C95.413 210.366 95 204.09 95 197.5V150H300V197.5C300 204.09 299.587 210.366 298.77 216.174C293.612 253.521 273.669 283.724 244.037 299.048C230.075 306.315 214.417 310 197.5 310C180.582 310 164.925 306.315 150.945 299.038C121.331 283.724 101.388 253.521 96.227 216.156ZM100 376.25V430H75V386.509C82.426 382.868 90.798 379.431 100 376.25ZM15 452.63C15.093 450.565 17.189 420.922 60 394.708V430.2C51.534 431.42 45 438.702 45 447.5V467.5C45 468.351 45.082 469.181 45.2 470H15V452.63ZM62.5 470C61.145 470 60 468.855 60 467.5V447.5C60 446.145 61.145 445 62.5 445H332.5C333.855 445 335 446.145 335 447.5V467.5C335 468.855 333.855 470 332.5 470H62.5ZM380 470H349.8C349.918 469.181 350 468.351 350 467.5V447.5C350 438.702 343.466 431.419 335 430.2V394.436C378.444 420.742 379.951 450.828 380 452.572V470Z" fill="#231F20"/>
              <path d="M197.5 255H217.5V240H205V207.5H190V247.5C190 251.642 193.358 255 197.5 255Z" fill="#231F20"/>
          </svg>
          <span class=" ">Assigning Machine To Operator </span>  
        </h4> 
    </div>

     
    <div class= "d-flex justify-content-center mt-1">
          <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:0px;"  title="Click to Read the User Guide ">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
            </svg>
          </a>
    </div>

  </div>
</div>

<div class="card m-3 shadow ">
  <div class="card-body d-flex justify-content-between ">
      <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th>ID No</th> 
                    <th>Name</th>
                    <th>F/Name</th>
                    <th>Position</th>
                    <th>Department</th>
                    <th>Assigned Machine</th> 
                    <th>OPS</th>
                </tr> 
          </thead>
          <tbody>
            <tr>
                <?php  while($Rows=$SQL->fetch_assoc())  {?>
                        <tr>
                            <td><?=$Rows['EId']?></td> 
                            <td><?=$Rows['Ename']?></td>
                            <td><?=$Rows['EFName']?></td>
                            <td><?=$Rows['EJob']?></td>
                            <td><?=$Rows['EDepartment']?></td>
                            <td><?=$Rows['machine_name']?></td> 
                            <td>
                              <?php if(isset($Rows['machine_opreator_id']) && !empty($Rows['machine_opreator_id']))  {   ?>
                                <!-- Must change the type of sending to the to post in next version -->
                                  <a href="OperatorIdRemoval.php?machine_opreator_id=<?=$Rows['machine_opreator_id']?>">
                                    <svg style="color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                      <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                      <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </a>
                              <?php  } else {   ?>
                                  <a type="button" data-bs-toggle="modal" style="color:yellow;" data-bs-target="#exampleModal" onclick="AddEId(<?=$Rows['EId']?>,`<?=$Rows['Ename']?>`)"> 
                                    <svg width="25" height="25" x="0px" y="0px" viewBox="0 0 297 297" style="enable-background:new 0 0 297 297;" xml:space="preserve">
                                        <path d="M253.782,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                                            S248.24,249.761,253.782,249.761z"></path>
                                        <path d="M225.808,249.761c5.542,0,10.051-4.509,10.051-10.051s-4.509-10.051-10.051-10.051c-5.542,0-10.051,4.509-10.051,10.051
                                            S220.267,249.761,225.808,249.761z"></path>
                                        <path d="M166.585,99.611c-3.431,3.438-3.429,9.03,0.005,12.465c1.72,1.719,3.977,2.578,6.236,2.578c2.258,0,4.516-0.86,6.236-2.578
                                            c3.434-3.435,3.436-9.027,0-12.471C175.621,96.168,170.028,96.166,166.585,99.611z"></path>
                                        <path d="M164.438,144.465c0,4.861,3.956,8.817,8.818,8.817c4.861,0,8.817-3.956,8.817-8.817c0-4.862-3.956-8.818-8.817-8.818
                                            C168.393,135.647,164.438,139.603,164.438,144.465z"></path>
                                        <path d="M39.499,117.945c9.311,0,16.885-7.574,16.885-16.885S48.81,84.175,39.499,84.175S22.614,91.75,22.614,101.06
                                            S30.189,117.945,39.499,117.945z M39.499,94.226c3.768,0,6.834,3.066,6.834,6.834c0,3.768-3.066,6.834-6.834,6.834
                                            c-3.768,0-6.834-3.066-6.834-6.834C32.665,97.292,35.731,94.226,39.499,94.226z"></path>
                                        <path d="M56.384,136.64c0-9.311-7.574-16.885-16.885-16.885s-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885
                                            S56.384,145.951,56.384,136.64z M32.665,136.64c0-3.768,3.066-6.834,6.834-6.834c3.768,0,6.834,3.066,6.834,6.834
                                            c0,3.768-3.066,6.834-6.834,6.834C35.731,143.475,32.665,140.408,32.665,136.64z"></path>
                                        <path d="M75.079,84.175c-9.311,0-16.885,7.574-16.885,16.885s7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                                            S84.39,84.175,75.079,84.175z M75.079,107.895c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                                            s6.834,3.066,6.834,6.834C81.914,104.828,78.847,107.895,75.079,107.895z"></path>
                                        <path d="M75.079,119.755c-9.311,0-16.885,7.574-16.885,16.885c0,9.311,7.574,16.885,16.885,16.885s16.885-7.574,16.885-16.885
                                            C91.964,127.33,84.39,119.755,75.079,119.755z M75.079,143.475c-3.768,0-6.834-3.066-6.834-6.834c0-3.768,3.066-6.834,6.834-6.834
                                            s6.834,3.066,6.834,6.834C81.914,140.408,78.847,143.475,75.079,143.475z"></path>
                                        <path d="M297,98.749c0-1.631-0.529-3.218-1.508-4.523l-49.751-66.335c-1.423-1.898-3.658-3.015-6.03-3.015h-33.168
                                            c-4.164,0-7.538,3.374-7.538,7.538v7.805c-7.863-0.157-15.794,0.776-23.602,2.868c-21.779,5.836-39.982,19.804-51.256,39.33
                                            c-4.655,8.063-7.8,16.585-9.569,25.243V65.079c0-4.164-3.374-7.538-7.538-7.538H97.72c-2.202-18.373-17.873-32.665-36.83-32.665
                                            h-7.202c-18.957,0-34.628,14.292-36.83,32.665H7.538C3.374,57.541,0,60.915,0,65.079v199.508c0,4.164,3.374,7.538,7.538,7.538
                                            h281.924c4.164,0,7.538-3.374,7.538-7.538V98.749z M214.081,39.952h21.86l45.982,61.31v104.863h-67.843V39.952z M199.005,128.455
                                            c-0.534,0.248-1.125,0.395-1.753,0.395c-2.33,0-4.225-1.896-4.225-4.226c0-2.33,1.895-4.225,4.225-4.225
                                            c0.627,0,1.218,0.144,1.753,0.39V128.455z M199.005,105.41c-0.577-0.055-1.161-0.088-1.753-0.088
                                            c-10.643,0-19.302,8.659-19.302,19.302c0,10.644,8.659,19.303,19.302,19.303c0.592,0,1.176-0.029,1.753-0.084v28.114
                                            c-8.827,0.347-17.59-1.781-25.428-6.306c-10.954-6.324-18.789-16.535-22.063-28.752c-3.273-12.217-1.593-24.977,4.731-35.93
                                            c6.324-10.954,16.535-18.788,28.752-22.062c4.079-1.093,8.219-1.634,12.333-1.634c0.559,0,1.117,0.022,1.675,0.042V105.41z
                                            M137.204,89.955c9.261-16.039,24.212-27.513,42.102-32.306c5.974-1.601,12.035-2.393,18.059-2.393c0.548,0,1.093,0.031,1.64,0.044
                                            v6.944c-5.965-0.165-11.985,0.511-17.911,2.098c-16.107,4.316-29.568,14.645-37.905,29.086
                                            c-8.338,14.441-10.552,31.264-6.237,47.371c4.316,16.107,14.645,29.568,29.086,37.905c9.62,5.554,20.294,8.391,31.112,8.391
                                            c0.617,0,1.236-0.017,1.854-0.036v6.846c-12.359,0.338-24.952-2.612-36.422-9.234C129.473,165.556,118.088,123.066,137.204,89.955z
                                            M155.045,197.729c8.038,4.641,16.529,7.795,25.158,9.568h-65.624v-65.911C119.234,164.279,133.271,185.157,155.045,197.729z
                                            M53.688,39.952h7.202c10.626,0,19.519,7.563,21.579,17.589H67.252l3.019-5.683c1.301-2.451,0.37-5.494-2.081-6.796
                                            c-2.449-1.3-5.494-0.371-6.796,2.081L55.87,57.541H32.109C34.169,47.515,43.062,39.952,53.688,39.952z M15.076,72.617h84.426
                                            v134.68H15.076V72.617z M281.924,257.048H15.076v-34.675h266.848V257.048z"></path>
                                        <path d="M73.873,174.129H40.706c-4.164,0-7.538,3.374-7.538,7.538s3.374,7.538,7.538,7.538h33.168c4.164,0,7.538-3.374,7.538-7.538
                                            S78.037,174.129,73.873,174.129z"></path>
                                    </svg>
                                </a> 
                              <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
            </tr> 
          </tbody>
      </table>



  </div>
</div>


<!-- Modal -->
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog model-xl ">
    <div class="modal-content">
      <div class="modal-header">
        <strong class="modal-title text-end" id="exampleModalLabel">لطف نموده ماشین مورد نظر خود را انتخاب نمایید</strong>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" id = "machine_form" method = "post" >
        <div class="modal-body">
            <div class="list-group">
                <input type="hidden" id = "EMPID" name="EMPID" >
                <input type="hidden" id = "machine_id" name="machine_id" >
                
                <?php if ($Machine->num_rows > 0) {  while($MACHINE = $Machine->fetch_assoc()){ ?> 
                    <label class="list-group-item">
                        <input class="form-check-input me-1"    onclick = "ApplyMachine(<?=$MACHINE['machine_id'] ?>)"    type="checkbox"  >
                        <?= $MACHINE['machine_name'] ?> 
                    </label>  
                <?php  } } else echo "Machine query has errors!"; ?>
                <!-- <label class="list-group-item">
                    <input class="form-check-input me-1" name = "HasManual"   value = "Manual"  type="checkbox"  >
                    Use Manual Also 
                </label>    -->
            </div> 
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  function AddEId(eid,ename) {  document.getElementById("EMPID").value=eid; }
  function ApplyMachine(machine_id) { 
      document.getElementById("machine_id").value=machine_id;
      document.getElementById("machine_id").form.submit(); 
  }
</script>
<?php  require_once '../App/partials/Footer.inc'; ?>





          