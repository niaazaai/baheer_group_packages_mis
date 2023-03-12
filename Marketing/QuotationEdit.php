<?php    require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<?php
 
    // CustId is Sout 
    if(isset($_POST['CTNId']) && !empty($_POST['CTNId'])){
      $CTNId=$_POST['CTNId'];
    }

    if(isset($_GET['CTNId']) && !empty($_GET['CTNId'])){
      $CTNId=$_GET['CTNId'];
    } else die('Carton ID is has not set correctly'); 

    if(isset($_GET['Page']) && !empty($_GET['Page'])){
      $Page = $_GET['Page'] ; 
    } else die('Page Parameter is not set Correctly'); 

    $CTN  =  $Controller->QueryData("SELECT * From carton WHERE CTNId = ?  " , [ $CTNId ] );
    $CTN = $CTN->fetch_assoc(); 
 
    // FOR TAKING LAST JOB-NO 
    $Customer =  $Controller->QueryData("SELECT CustId, CustName,  CustContactPerson, CustMobile, CustEmail,  CustAddress, CustWebsite, CustCatagory 
    FROM ppcustomer WHERE CustId=  ?" , [ $CTN['CustId1'] ] );
    $Customer = $Customer->fetch_assoc(); 
    $CustId =  $CTN['CustId1'] ;  

    # THIS BLOCK OF CODE IS FOR RETRIVING LAST JOB NO 
    $q =  $Controller->QueryData("SELECT CTNId, CTNType, CustId1, JobNo FROM carton 
    INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 where JobNo!='NULL' ORDER BY carton.`CTNId` DESC" , [] );
    $LastJobNo = $q->fetch_row(); 

    # THIS BLOCK OF CODE IS FOR RETRIVING PAPER PRICE AND NAMES FOR PLYs TO SHOW  
    $PP =  $Controller->QueryData("SELECT DISTINCT Name,Price FROM paperprice" , [] );
    $PaperPrice = []; 
    while($PaperPriceDB = $PP->fetch_assoc()){
      
      $PaperPrice[$PaperPriceDB['Name']] = $PaperPriceDB['Price']  ;
      echo '<input type = "hidden" name= "PaperName"   id="'.$PaperPriceDB['Name'] . '"   value = "'.$PaperPriceDB['Price']  .'" > ';
    } // LOOP 

    // this block is used to find the user grade limit 
    $GradeLimitData = 0 ; 
    $GradeLimit = $Controller->QueryData("SELECT grade_limit FROM set_grade WHERE employeet_id = ?" , [$_SESSION['EId']]  );
    $GradeLimitDatabase = $GradeLimit->fetch_assoc();
    if(empty($GradeLimitDatabase))   $GradeLimitData = 40  ;
    else $GradeLimitData  =  $GradeLimitDatabase['grade_limit']; 

 ?>
 <style>
 

  .custom-search {
  position: relative;
  }
  .custom-search-input {
    width: 100%;
    padding: 10px 80px 10px 10px; 
    line-height: 1;
    box-sizing: border-box;
    outline: none;
  }
  .custom-search-botton {
    position: absolute;
    right: 5px; 
    top: 5px;
    bottom: 5px;
    border: 0;
    outline: none;
    z-index: 2;
  }

  .csi-Grade {
    width: 100%;
    padding: 10px 80px 10px 10px; 
    line-height: 1;
    box-sizing: border-box;
    outline: none;
  }
  
  .csb-Grade {
    position: absolute;
    right: 5px; 
    top: 5px;
    bottom: 15px;
    border: 0;
    outline: none;
    z-index: 2;
  }
  .quotation-icon:active {
    padding:2px;
  }
  .quotation-icon:hover {
    color:#444444;
  }

  .form-control {
    border: 2px solid #000; 

  }
  .form-select {
    border: 2px solid #000; 
  }
  .form-check-input {
    border: 2px solid #000; 
  }

  .form-control:focus{
    box-shadow: 5px 10px #AAAAAA ;
  }

  .btn {
    border: 2px solid #0d6efd;

    
  }
  .bi-clipboard2-plus:active {
    padding:2px;
    
  }
  .bi-clipboard2-plus:hover{
    color:#0d6efd; 
  } 
  #NewPriceBox:hover {
    background-color:black; 
    color:white;
  }

  .blink {
    animation: blink 2s steps(1, end) infinite;
  }
  @keyframes blink{
      0%{     opacity:1;     }
      50%{    opacity:0;     }
      100%{   opacity: 1;    }
  }

 </style>


 <div class="card m-3  ">
    <div class="card-body    my-1   d-flex justify-content-between">
    
      <div>
        <h4>
          <svg onclick = "HideJobType();" title = "Click to Select Quotation Type"  xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-clipboard2-plus" viewBox="0 0 16 16">
            <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5h3Z"></path>
            <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-12Z"></path>
            <path d="M8.5 6.5a.5.5 0 0 0-1 0V8H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V9H10a.5.5 0 0 0 0-1H8.5V6.5Z"></path>
          </svg>
          PKG Estimation Calculation Form For <span class = "" style= "color:#FA8b09;" >   <?php echo  "( ".  $Customer['CustName'] . " )"; ?> </span>   
         
          <span class = "blink" style = " font-size:20px; color:red; font-weight:bold; " >
          <?php if($CTN['CTNStatus'] == 'Cancel') echo 'CANCELED'; ?></span>
        </h4>
       
      </div>

      <div class ="my-1" >
        <a class="btn btn-outline-primary mx-2 fw-bold " data-bs-toggle="collapse" href="#setting" role="button" aria-expanded="false" aria-controls="setting">  
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
          </svg> 
          More  
        </a>
        
        <a href="Manual/CustomerRegistrationForm_Manual.php" class = "text-primary" title = "Click to Read the User Guide " >
          <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
              <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
              <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
              <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>
        </a>
      </div>
                                       
    </div>
  </div>
  <div class="collapse" id="setting">
  <div class="card card-body m-3">
    
      <!-- BUTTONS OUTSIDE OF FORM -->
      <div class="btn-group" role="group" aria-label="Top Buttons for Quotations">
           
            <a href="Customerlist.php" title="Find and select customer"  target= "_blank"  class="btn btn-outline-primary  fw-bold" >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
                </svg>  
                Find Customer
            </a>

            <a href=" ../Archive/PolymerList.php" target= "_blank" title="Find Exist Polymer & Die"  class="btn btn-outline-primary  fw-bold cc ">
                <svg width="25" height="25" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"></path>
                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"></path>
                    <path d="M188 363V149H270.267C286.084 149 299.556 152.1 310.69 158.3C321.82 164.43 330.306 172.963 336.144 183.9C342.049 194.767 345 207.306 345 221.518C345 235.729 342.013 248.267 336.04 259.135C330.067 270.002 321.414 278.466 310.077 284.526C298.811 290.587 285.168 293.617 269.148 293.617H216.711V257.358H262.02C270.506 257.358 277.499 255.861 282.994 252.865C288.561 249.8 292.702 245.586 295.418 240.222C298.198 234.788 299.592 228.553 299.592 221.518C299.592 214.412 298.198 208.212 295.418 202.918C292.702 197.554 288.561 193.409 282.994 190.483C277.431 187.488 270.371 185.99 261.817 185.99H232.086V363H188Z" fill="#B3404A"></path>
                </svg>
               -  Find Polymer  And Die - 

                <svg width="25" height="25" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"></path>
                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"></path>
                    <path d="M242.307 366H164.963V147.818H242.946C264.892 147.818 283.784 152.186 299.622 160.922C315.46 169.587 327.641 182.051 336.163 198.315C344.757 214.58 349.054 234.04 349.054 256.696C349.054 279.423 344.757 298.955 336.163 315.29C327.641 331.625 315.389 344.161 299.409 352.896C283.5 361.632 264.466 366 242.307 366ZM211.092 326.476H240.389C254.026 326.476 265.496 324.061 274.8 319.232C284.175 314.331 291.206 306.767 295.893 296.54C300.652 286.241 303.031 272.96 303.031 256.696C303.031 240.574 300.652 227.399 295.893 217.172C291.206 206.945 284.21 199.416 274.906 194.587C265.602 189.757 254.132 187.342 240.496 187.342H211.092V326.476Z" fill="#B3404A"></path>
                </svg>
            </a>
            
            <a  href="javascript:poptastic('../PaperStock/BalanceSheetPaper.php');"title="Find Paper In Stock "   class="btn btn-outline-primary  fw-bold"   >
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                    <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"/>
                </svg>
                Check Stock
            </a>

            <a title="Find and paper weight"  onclick="" class="btn btn-outline-primary  fw-bold" data-bs-toggle="modal" data-bs-target="#staticBackdrop"  >
              <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calculator" viewBox="0 0 16 16">
                <path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"/>
                <path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"/>
              </svg>
                Paper Weight
            </a>
      </div>
      <!-- BUTTONS OUTSIDE OF FORM -->
  </div>
</div>


 
 <!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Paper Weight Calculation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
 
        <div class="row mb-1">
          <div class="col-lg-6" id = "PaperWeightList">
          </div>

          <div class="col-lg-6" >
              <div class="input-group my-2 _Paper_" id = "bb_input_group" > 
                <input type="text" class = "form-control " Value = "BB" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "BB_name" value = "0" readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "wtl_input_group1"> 
                <input type="text" class = "form-control " Value = "WTL" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "WTL_name1" value = "0" readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "wtkl_input_group2"> 
                <input type="text" class = "form-control " Value = "WTKL" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "WTKL_name2" value = "0"  readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "tl_input_group"> 
                <input type="text" class = "form-control " Value = "TL" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "TL_name" value = "0" readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "klb_input_group"> 
                <input type="text" class = "form-control " Value = "KLB" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "KLB_name" value = "0" readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "liner_input_group" > 
                <input type="text" class = "form-control " Value = "Liner" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "Liner_name" value = "0" readonly > 
              </div> 

              <div class="input-group my-2 _Paper_" id = "flute_input_group" > 
                <input type="text" class = "form-control " Value = "Flute" style = "border-right:none;" readonly>
                <input type="text" class = "form-control PIV" id = "Flute_name" value = "0" readonly > 
              </div> 
              
              <div class="input-group my-2  "  > 
                <input type="text" class = "form-control " Value = "TOTAL" style = "border-right:none;border:2px solid #6610f2;" readonly>
                <input type="text" class = "form-control" id = "paper_weight_total"  style = "border:2px solid #6610f2;" readonly > 
              </div> 

               <div class="input-group my-2">
                    <select class="form-select "  style = "max-width:70px"  id="DieckleSelect"  onchange = "ChangeDieckle(this.value)" >
                      <option value="0.1">1</option>
                      <option value="0.2">2</option>
                      <option value="0.3">3</option>
                      <option value="0.4">4</option>
                    </select>
                    <input type="text" class = "form-control "    style = "max-width:100%" style = "max-width:120px" style = "border-right:none;" id = "DieckleInput" readonly >
              </div>
          </div>
        </div><!-- END OF ROW  -->
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  data-bs-dismiss="modal" >Understood</button>
      </div>
    </div>
  </div>
</div>

<!-- CARD -->
<div class="card m-3 shadow">
  <div class="card-body"><!-- CARD-BODY -->
 
  <form class=" " enctype="multipart/form-data" id="feedback_form" method="post" action="<?=htmlspecialchars('QuotationController.php'); ?>">

      <?php $PaperGEP =  $Controller->QueryData("SELECT Id, PaperGSM, ExchangeRate, PolimerPrice FROM paperprice" , [] ); $GEP = $PaperGEP->fetch_assoc();    ?>
      <input type="hidden" name="CustomerId" value = "<?=$CustId?>" >
      <input type="hidden" name="EmployeeId" value = "<?=$_SESSION['EId']?>" >
      <input type="hidden" name="CTNPaper" id = "CTNPaper"  value = "" >
      <input type='hidden' name='ExchangeRate'  id='ExchangeRate' value = "<?=$CTN['PexchangeUSD']?>" >
      <input type='hidden' name='NewExchangeRate'  id='NewExchangeRate' value = "<?=$GEP['ExchangeRate']?>" >
      <input type='hidden' name='PaperGSM'      id='PaperGSM'     value = "<?=$GEP['PaperGSM']?>" >
      <input type='hidden' name='PolimerPrice'  id='PolimerPrice' value = "<?=$GEP['PolimerPrice']?>" > 
      <input type="hidden" name='CTNId' value = "<?=$CTNId?>" > 
      <input type="hidden" name='Page' value = '<?=$Page?>' >
      <input type="hidden" name='CTNStatus' value = '<?=$CTN['CTNStatus']?>' >
      <div class="row my-3 gy-2 gx-3 align-items-center " id = "JobTypeRow"  style = "display:none;">
        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
            <!-- ZERO ROW  -->
            <select name="jobType" id = 'JobType' class ="form-select"    required  >
              <?php if($Page == 'CustomerProfile') {  ?>
                  <option selected value="Reorder">Reorder</option>
              <?php } else {  ?>
              <option selected value="<?=$CTN['JobType']?>"> <?=$CTN['JobType'];?> </option>
              <?php } ?>
              <option value="Only Product">Only Product</option>
            </select>
            <!-- ZERO ROW  -->
        </div>
      </div>
        
      <hr id = "jobTypeHr" style = "display:none; ">
  
      <!-- FIRST ROW  -->
      <div class="row   align-items-center " >
        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
          <strong class = "fs-5 ms-5" > 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
          </svg>
          Customer Details </strong>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"   >
        <label for="CustomerName" class="form-label">Last Job No <span class="text-danger"> * </span></label>
          <div class="custom-search" >
            <!-- $Page != 'IndividualQuotation' &&  -->
            <input type="text" class="custom-search-input form-control" value = "<?=$LastJobNo[3];?>"    id="CustomerName"  name="CustomerName1" <?=($Page == 'IndividualQuotation'  ||  $Page == 'CustomerProfile') ? ' disabled' : '' ;   ?>   >
            <?php if($Page != 'CustomerProfile') { ?>  
              <a class="custom-search-botton text-dark" required readonly onclick = "CopyValueToJobNo(`<?=$LastJobNo[3];?>`)"  > 
                <svg  class = "quotation-icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-right-square-fill" viewBox="0 0 16 16">
                  <path d="M0 14a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2v12zm4.5-6.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5a.5.5 0 0 1 0-1z"/>
                </svg>
              </a>  
            <?php } ?>
          </div>
        </div>


        <!-- <?=($Page == 'IndividualQuotation') ? 'disabled' : '' ;   ?>   -->
        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="JobNo" class="form-label">Job No <span class="text-danger"> * </span> </label>
          <input class="form-control " 
            style = "<?=($Page == 'CustomerOrderPage') ? ' border:2px solid red; ' : '' ;   ?>"  id="JobNo" name="JobNo"   
            value="<?=($Page == 'CustomerProfile') ? 'NULL' : $CTN['JobNo'] ; ?>" type="text"  placeholder="NULL"   />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="ProductName" class="form-label"> Product Name <span class="text-danger"> * </span>  </label>
          <input class="form-control" id="ProductName" placeholder="Write Product Name "  name="ProductName"   type="text" required   value="<?=$CTN['ProductName'] ?> " />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
          <label for="FinishDate" class="form-label">DeadLine <span class="text-danger " > * </span></label>
          <input type="Date" class="form-control" id="FinishDate" name="FinishDate"  required   value="<?=$CTN['CTNFinishDate']?>" />
        </div>

        <div class="col-xxl-2  col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"  >
          <label for="PaperGrade" class="form-label">Grade <span class="text-danger"> * </span></label>
          <div class="custom-search" >
            <input   class="form-control csi-Grade" id="PaperGrade" name="PaperGrade" type="text" required onchange = 'AddInputValues(this.name , this.value)' value="<?=$CTN['GrdPrice']?>"  /> 
            <?php if($Page == 'CustomerProfile') {   ?>  
              <input type="checkbox"  id="NewPrice"  class="csb-Grade text-dark form-check-input fs-4" style= "margin-top:3.5px;"  id="NewPrice " onclick = "UpdateToNewPrice(); " >
            <?php } ?>
          </div> 
        </div>
      </div>
      <!-- FIRST ROW  -->

      <hr>
      <!-- SECOND ROW  -->
      <div class="row   align-items-center " >
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12  ">
          <strong  class = "fs-5 ms-5" >
          <svg    style = "transform: rotate(-180deg);"  xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16">
          <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1H1z"/>
        </svg> Size Details </strong>
        </div>
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
            <label for="CartonUnit" class="form-label">Carton Type  <!-- AKA UNIT IN PREVIOUS FORM --> <span class="text-danger"> * </span></label>
            <select class="form-select" id="CartonUnit"  name="CartonUnit" onchange = "CalculateCartonType(this.value);"  >
              <option disabled = "disabled"  > Select Unit</option>
              <option selected value="<?=$CTN['CTNUnit']?> "><?=$CTN['CTNUnit']?> </option>
              <option value="Carton">Carton</option>
              <option value="Box">Box</option>
              <option value="Sheet">Sheet</option>
              <option value="Tray">Tray</option>
              <option value="Separator">Separator</option>
              <option value="Belt">Belt</option>
            </select>
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="CartonQTY" class="form-label"> Quantity <span class="text-danger"> * </span> </label>
          <input class="form-control" id="CartonQTY" placeholder="Quantity" name="CartonQTY" type="text"   required value = "<?=$CTN['CTNQTY']?>" onkeyup = "AddComma(this.value , this.id)"  onchange = "AddInputValues(this.name , this.value);"  />
        </div>

        <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="PaperLength" class="form-label" > L <span class="text-danger"> * </span></label>
           <input class="form-control" id="PaperLength" placeholder="Lenght cm" name="PaperLength" type="text" value = "<?=$CTN['CTNLength']?>" onchange = "AddInputValues(this.name , this.value) "  required  />
        </div>

        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12"  id = "PaperWidthCol">
          <label for="PaperWidth" class="form-label"> W <span class="text-danger"> * </span></label>
          <input class="form-control" id="PaperWidth" placeholder="Width cm" name="PaperWidth" type="text" value = "<?=$CTN['CTNWidth']?>" onchange = "AddInputValues(this.name , this.value) "   value=""  />
        </div>

        <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12" >
          <label for="PaperHeight" class="form-label"> H <span class="text-danger"> * </span></label>
          <input class="form-control"   id="PaperHeight"  placeholder="Height cm" name="PaperHeight"  value = "<?=$CTN['CTNHeight']?>" onchange = "AddInputValues(this.name , this.value) "  type="text" required  />
        </div>
      </div>
      <!-- SECOND  ROW  -->
      <hr>

       <!-- THIRD ROW  -->
       <div class="row align-items-center "    >
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12   ">
          <strong  class = "fs-5 ms-5 "> 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-file-earmark" viewBox="0 0 16 16">
            <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
          </svg> Paper Details </strong>
        </div>
         
        <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
            <label for="CartonType" class="form-label">Carton Type <span class="text-danger"> * </span></label>
            <select class="form-select" name="CartonType" id="CartonType" onchange="ShowPly(this.value)" >
              <option> Select Ply Type</option>
              <option selected value="<?=$CTN['CTNType']?>"><?=$CTN['CTNType']?>-Ply</option>
              <option value="3">3-Ply</option>
              <option value="5">5-Ply</option>
              <option value="7">7-Ply</option>
            </select>
        </div>
              
          <!--   PaperLayerName with it is GSM  -->
          <?php for ($index=1; $index <= 7  ; $index++):   ?>
                  <div class="col-xxl-1 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-3">
                        <select class="form-select" name="PaperLayerPrice_<?=$index?>" id="PaperLayerPrice_<?=$index?>"  style="display:none;" onchange = "ChangePrice(this.name,this.value)">
                          <option selected value='<?=$CTN['PaperP'.$index]?>'>L<?=$index?>- <?=$CTN['Ctnp'.$index]; ?></option>
                          <?php  foreach ($PaperPrice as $key => $value)  { 
                              if($key == $CTN['Ctnp'.$index]) continue; // this line is to avoid duplicated option in select 
                                echo "<option value='$value'>L$index- $key</option>";
                          } ?>
                        </select>

                        <input  class="form-control mt-2"  style="display:none ;" name="PaperLayerGSM_<?=$index?>" id="PaperLayerGSM_<?=$index?>"
                        value="  <?php echo ($CTN['Ctnp'.$index] == 'BB') ? 250 : 125 ?> " type="text"  onchange = "ChangeGSM( 'PaperLayerPrice_<?=$index?>', this.value )" />
                  </div>
                  <input type="hidden" name="PaperName_<?=$index?>" id = "PaperName_<?=$index?>" value = "" />
          <?php endfor; ?>
        <!--   PaperLayerName with it is GSM  --> 

      </div>  <!-- THIRD  ROW  -->
      <hr>
       
      <!-- Fourth ROW  -->
      <div class="row   d-flex align-items-center  "  >
          <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12 col-xs-12    " >
            <strong class = "fs-5 ms-5" >
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
              <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
              <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg> Print Details </strong>
          </div>
          <div  class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-12 col-xs-12">
              <label for="Flute" class="form-label">Flute Type   <span class="text-danger"> * </span></label>
              <select name="Flute" id = "FlutType"  class="form-select" required>
                <option value="">Flute Type</option> 
                <option selected value="<?=$CTN['CFluteType']?>"> <?=$CTN['CFluteType'] ?></option>
              </select>
          </div>
                    
          <!--   PaperLayerName with it is GSM  -->
          <?php  
          $CheckBoxs = [ 
            'CSlotted' => 'SLOTTED' ,
            'CDieCut' => 'DIE CUT' , 
            'CPasting' => 'PASTING' ,
            'CStitching' => 'STITCHING' ,
            'flexop' =>  'FLEXO P' , 
            'offesetp' => 'OFFSET P'];  

         foreach ($CheckBoxs as $key => $value):  ?>
            <div class="col-xxl-1 col-xl-2 col-lg-2 col-md-2 col-sm-4 col-xs-3">
              <label for=" " class="form-label"> </label>
              <div class="form-check fw-bold" >
                <input class="form-check-input" type="checkbox" id="<?=$key?>" name="<?=$key?>"  <?= ($CTN[$key] == 'Yes') ? 'checked' : '';  ?>  > 
                <label class="form-check-label "   for="<?=$key?>"><?=$value?></label> 
              </div>
            </div>
            <!-- <?= ($CTN[$key] == 'Yes') ? 'checked' : ''; ?> -->
        <?php endforeach; ?>
        <!--   PaperLayerName with it is GSM   value = "<?= $CTN[$key] ?>"  -->
         
        </div>
        <!-- Fourth  ROW  -->
        <hr>

        <!-- FIFTH ROW  -->
        <div class="row  d-flex align-items-center  "  >
          
          <div class="col-xxl-2 col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12  ">
            <strong class = "fs-5 ms-5 "  > 
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-aspect-ratio" viewBox="0 0 16 16">
              <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h13A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 12.5v-9zM1.5 3a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-13z"/>
              <path d="M2 4.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1H3v2.5a.5.5 0 0 1-1 0v-3zm12 7a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1 0-1H13V8.5a.5.5 0 0 1 1 0v3z"/>
            </svg>
            P/D Details </strong>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <label for="NoColor1" class="form-label">Select Color<span class="text-danger"> * </span></label>
            <select class="form-select " name="NoColor1" id="NoColor1">
              <option selected value="<?= $CTN['CTNColor'] ?>"><?=($CTN['CTNColor'] == 0 ) ? 'No Color' : ( ($CTN['CTNColor'] == 'FullColor') ? 'F-Color' : $CTN['CTNColor']) ;  ?></option>
              <option value="0" >No Color</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="FullColor">F-Color</option>
            </select>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label for="NoColor" class="form-label">Select Polymer<span class="text-danger"> * </span></label>
              <select class="form-select" name="NoColor" id="NoColor" onchange="AddInputValues(this.name , this.value);" >
                <option selected value="<?=isset($CTN['polymer_info']) ? $CTN['polymer_info'] : '';  ?>">  <?=isset($CTN['polymer_info']) ? $CTN['polymer_info'] : '';  ?> </option>
                <option value="Polymer Exist" >Polymer Exist</option>
                <option value="No Print" >No Print</option>
                <option value="Free Polymer" >Free Polymer </option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12" id="DieExist1">
              <label for="DieExist" class="form-label">Select Die<span class="text-danger"> * </span></label>
              <select class="form-select" name="DieExist" id="DieExist"  onchange = "CheckDiePriceInput(this.value);"   >
                <option selected value="<?=isset($CTN['die_info']) ?   $CTN['die_info'] : '';  ?>" >  <?=isset($CTN['die_info']) ?   $CTN['die_info'] : '';  ?> </option>
                <option value="New Die">New Die</option>
                <option value="Die Exist" >Die Exist</option>
                <option value="Personal Die" >Personal Die</option>
                <option value="Free Die" >Free Die </option>
                <option value="No Die"> No Die</option>
              </select>
          </div>
           
          <div id = "PolymerPriceCol" class="col-xxl-1 col-xl-1 col-lg-3 col-md-3 col-sm-12 col-xs-12">
            <label for="PolymerPrice" class="form-label">Polymer Price  </label>
            <input type="text" class="form-control" id="PolymerPrice" name="PolymerPrice"   value = "<?=$CTN['CTNPolimarPrice']?>"  required   />
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-3 col-md-3 col-sm-12 col-xs-12" id="DiePrice">
            <label for="DiePrice" class="form-label" >Die Price  </label>
            <input class="form-control"  placeholder="Die Price" id = "DiePriceInput" name="DiePrice" value = "<?=$CTN['CTNDiePrice']?>"   type="text" onchange = "AddInputValues(this.name , this.value)" value = ""  />
          </div>

          <div  id = "NoFlipCol"  class="col-xxl-1 col-xl-1 col-lg-2 col-md-2 col-sm-12 col-xs-12">

                <label    class="form-label" for="NoFlip"> Manual </label>
                <select  class="form-select" name="NoFlip" id="NoFlip" required onchange = "ShowNoFlip( this.value)" >
                  
                  <option value="" disabled>Select Flip</option>
                  <option selected value="<?=$CTN['NoFlip']?>">
                    <?php 
                      if($CTN['NoFlip'] == 'FF') echo 'Full Flip'; 
                      else if($CTN['NoFlip'] == 'TF') echo 'Top Flip'; 
                      else if($CTN['NoFlip'] == 'WF') echo 'Witout Flip'; 
                    ?>
                  </option>
                  <option value="FF">Full Flip </option>
                  <option value="TF">Top Flip</option>
                  <option value="WF">Witout Flip</option>
                </select>
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-4 col-md-4 col-sm-12 col-xs-12" style = "display:none; " id = "NoFilpArea"  >
              <label   for=""> </label>
              <div class="input-group">
                <input class="form-control" id="NoFlipLength" style = "max-width:50%"  placeholder="Length" value = "" onchange = "AddInputValues(this.name , this.value , true  )"  type="text"  style="width:75px; " />
                <input class="form-control" id="NoFlipHeight"  style = "max-width:50%" placeholder="Height" value = "" onchange = "AddInputValues(this.name , this.value , true  )"   type="text"  style="width:75px;" />
              </div>
          </div>

        </div>
        <!-- FIFTH  ROW  -->

        <hr>
        <!-- SIXTH ROW  -->
        <div class="row my-3   "  >
          <div class="col-xxl-2 col-xl-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 d-flex align-items-center" >
            <strong class = "fs-5 ms-5 "  > 
              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1H1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V5zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2H3z"/>
              </svg>
              Cost Details </strong>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <label for="PricePercarton" class="form-label">Currency <span class="text-danger"> * </span></label>
                <select class="form-select" name="CtnCurrency1" id="CtnCurrency1" required onchange = "ChangeCurrencyType( this.value)" >
                  <option value="" disabled>Select Currency</option>
                  <option selected value = "<?=$CTN['CtnCurrency']?>" > <?=$CTN['CtnCurrency']?> </option>
                  <option value="AFN">AFN</option>
                  <option value="USD">USD</option>
                </select>
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="TotalPriceAfn" class="form-label">Unit Price  <span id = "UPCurrencyLabel"></span> <span class="text-danger"> * </span></label>
                <input class="form-control" id="PaperPriceAFN" style="font-weight: bold;"   name="PaperPriceAFN" value = "<?=$CTN['CTNPrice']?>"   type="text" required onchange = "ChangeGrade(this.value)"  />
          </div>

          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="TotalPrice" class="form-label">Sub Total   <span id = "TACurrencyLabel"></span>  <span class="text-danger"> * </span></label>
                <input class="form-control" id="TotalPrice" readonly  name="TotalPrice" type="text"  value = "<?=$CTN['CTNTotalPrice']?>"   style="font-weight:bold;"    /> 
          </div>
 
          <div class="col-xxl-2 col-xl-2 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="FinalTotal" class="form-label">Total Amount   <span id = "FTCurrencyLabel"></span>  <span class="text-danger"> * </span></label>
                <input class="form-control" id="FinalTotal" readonly  name="FinalTotal" type="text"  style="font-weight:bold;" value = "<?=$CTN['FinalTotal']?>"   /> 
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-3 col-md-4 col-sm-12 col-xs-12">
                <label for="Tax " class="form-label">Tax <span class="text-danger"> % </span></label>
                <select class="form-select" id="Tax"  name="Tax"  onchange = "AddInputValues(this.name , this.value)  "  >
                  <option value="" disabled>Select Tax</option>
                  <option value = "<?=$CTN['Tax']?>"  > <?=$CTN['Tax']?> </option>
                  <option value="0">None</option>
                  <option value="2">2 %</option>
                  <option value="4">4 % </option>
                </select>
          </div>

          <div class="col-xxl-1 col-xl-1 col-lg-4 col-md-4 col-sm-12 col-xs-12">
              <label for="d" class="form-label"> </label>
              <div> <a  class="btn btn-outline-primary fw-bold mt-2 " data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">  Update </a>  </div>
          </div>
          
      </div>
      <!-- SIXTH  ROW  -->
      <hr>
      <!-- SEVENTH ROW  -->
      <div class="row my-3 d-flex align-items-center  " >
        <div class="col-lg-2 col-md-2 col-sm-12 col-xs-12  ">
          <strong class ="fs-5 ms-5" > 
          <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-journal-bookmark" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M6 8V1h1v6.117L8.743 6.07a.5.5 0 0 1 .514 0L11 7.117V1h1v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z"/>
            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
            <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
          </svg>
          Add Note </strong>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="Note1" class="form-label">Note For Job Card</label>
            <textarea name="Note1"  style="height: 100px;  " class = "form-control" placeholder = "Note For Order Card "   ><?=$CTN['Note']?></textarea> 
        </div>
        <div  class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <label for="Notemarket" class="form-label">Note For Quotation</label>
            <textarea name="Notemarket"  style="height: 100px; " class = "form-control" placeholder = "Note For Quotation" ><?=$CTN['MarketingNote']?> </textarea> 
        </div>
        
        <div class=" col-2"   >
        <div class="collapse" id="collapseExample">
          <div class="  d-grid gap-2   mx-auto ">

            <?php  if( $Page == 'CustomerOrderPage' ) {  ?>
                <button type="submit"  id="COP_EditOnly"  name="COP_EditOnly" class="btn btn-outline-primary fw-bold" style = "max-width:180px;" onclick = "alert('Are you sure you want to update?');">Update</button>
                <a  data-bs-toggle="modal" data-bs-target="#exampleModal"    class="btn btn-outline-danger border-danger  fw-bold " style = "max-width:180px;"   >Cancel Quote</a>
              <?php }elseif( $Page == 'JobList') { // DONE ?>
                <button type="submit"  id="COP_EditOnly"  name="COP_EditOnly" class="btn btn-outline-primary fw-bold" style = "max-width:180px;" onclick = "alert('Are you sure you want to update?');">Update</button>
                <a  data-bs-toggle="modal" data-bs-target="#exampleModal"    class="btn btn-outline-danger border-danger  fw-bold " style = "max-width:180px;"   >Cancel Quote</a>
                <?php } elseif( $Page == 'CancelQuotation') { // DONE ?>
                  <button type="submit"  id="COP_EditOnly"  name="COP_EditOnly" class="btn btn-outline-success fw-bold" style = "max-width:180px;" onclick = "alert('Are you sure you want to process this again?');">Process Again</button>
                <?php } elseif( $Page == 'IndividualQuotation') { // DONE || $Page == 'CustomerProductList'   ?>
                <!-- <button type="submit"  id="EditButtonAndPrint"  name="EditButtonAndPrint" class="btn btn-outline-primary fw-bold " style = "max-width:180px;"    >Update & Print</button> -->
                <button type="submit"  id="EditOnly"  name="EditOnly" class="btn btn-outline-primary fw-bold" style = "max-width:180px;"    >Update</button>
                <a  data-bs-toggle="modal" data-bs-target="#exampleModal"    class="btn btn-outline-danger border-danger  fw-bold " style = "max-width:180px;"   >Cancel Quote</a>
              <?php } elseif($Page == 'CustomerProfile') {  ?>
                <button type="submit"  id="RorderAndPrint"  name="RorderAndPrint" class="btn btn-outline-primary fw-bold " style = "max-width:180px;" >Rorder & Print</button>
                <button type="submit"  id="RorderToDesign"  name="RorderToDesign" class="btn btn-outline-primary fw-bold   " style = "max-width:180px;"  >Send To Design</button>
                <button type="submit"  id="Rorder"  name="Rorder" class="btn btn-outline-primary fw-bold " style = "max-width:180px;"   >Reorder</button>
              <?php }  ?>
          </div>
        </div>
        </div>
      </div>
      <!-- SEVENTH  ROW  -->

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Please <strong class= "text-danger">  explain </strong> why your canceling this product  </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class = "fw-bold ">120 / <span  class = "text-danger"id = "comment_length" >  </span></div>
              <textarea name="CancelComment" class= "form-control" id="CancelComment" cols="30" rows="10" onkeyup = 'CheckCancelCommentLength();'>  <?=$CTN['CancelComment']?>  </textarea>
              <input type="hidden" name="Canceldate" value = "<?=date('Y-m-d H:i:s') ?>" > 
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary border-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" id="CancelQuote"  name="CancelQuote" class="btn btn-outline-danger border-danger ">Save changes</button>
            </div>
          </div>
        </div>
      </div>

  </div><!-- CARD-BODY -->
</div><!-- CARD -->
</form>

 <script>

  let InputValues = {}; 
  var PaperType =  {} 
  var Paper  =  {} 
  var ExchangeTotalPrice = []; 
  var Results = {}; 
  var CTNPaper = {}; 
  let Unit = document.getElementById("PolimerPrice").value-0; 
  let DatabasePaperGSM  = document.getElementById("PaperGSM").value-0 
  var GradeLimit = <?=$GradeLimitData?> ; 

  function Precision(number , decimal=2) {
    return Number.parseFloat(number).toFixed(decimal);
  }

  function RemoveComma(x) {
    return  x.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, "")
  }

  function AddComma(value1 , id ){
      let x = 0 ; 
      x = value1.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
      document.getElementById(id).value  = x ; 
  }

  function AddToPaper(name , gsm , Price) {
    PaperType['GSM'] = Precision(gsm) ; PaperType['Price'] = Precision(Price); 
    Paper[name] = Object.assign({}, PaperType);
  } 

  function RemoveFromPaper(name) {
    delete Paper[name];  
  } 

  function ChangeGSM( name ,  value ) {
    Paper[name]['GSM'] = Precision(value);
    CalculateUnitPrice(InputValues);
  }

  function ChangePrice( name ,  value ) {
    Paper[name].Price = Precision(value);  
    CalculateUnitPrice(InputValues);
    StorePaperTypeName(name);
    // THis Block will change Paper GSM to 250 when we select BB else 125 
    let element = document.getElementById(name); 
    let PaperTypeName = element.options[element.selectedIndex].text.slice(3).trim();
    if(PaperTypeName == 'BB')  {
      document.getElementById('PaperLayerGSM_'+ name.slice(-1)).value = 250;
      document.getElementById('offesetp').checked = true;  
      document.getElementById('flexop').checked = false;   
      ChangeGSM('PaperLayerPrice_'+ name.slice(-1),250); 
    }  
    else  {
      document.getElementById('PaperLayerGSM_'+ name.slice(-1)).value = 125 ; 
      document.getElementById('offesetp').checked = false;  
      document.getElementById('flexop').checked = true;  
      ChangeGSM('PaperLayerPrice_'+ name.slice(-1),125); 
    }
  }

  function AddInputValues( name , value , NoFlip = false   ){

    if(name == 'PaperGrade') {
      if(value < 1 || value > 100 ) {
        alert('Grade must be within 1 and 100 : your value is ' + value ); 
        document.getElementById('PaperGrade').value = GradeLimit; 
        value = GradeLimit; 
      }
      else {
        if(value < GradeLimit ){
          alert('You are not allowed to set grade lower than ' + GradeLimit ); 
          document.getElementById('PaperGrade').value = GradeLimit; 
          value = GradeLimit; 
        }
      }
      
    }

    if(typeof value === 'string') {
      if(name == 'CartonQTY') {
        value = RemoveComma(value) ;
      }  
    }

    if (name == 'NoColor') {
      if(value == 'No Print' || value == 'Polymer Exist'  || value == 'Free Polymer') {
        document.getElementById('NoFlipCol').style.display = "none"; 
        document.getElementById('PolymerPriceCol').style.display = "none"; 
        document.getElementById('NoFilpArea').style.display = "none"; 
        document.getElementById('PolymerPrice').value = 0.0; 
        value = 0; 
      }
      else if ( value == '1' || value == '2' || value == '3' ||value == '4' ) {
            document.getElementById('NoFlipCol').style.display = ""; 
            document.getElementById('PolymerPriceCol').style.display = ""; 
      }
    }

    
    value = Precision(value)
    InputValues[name] = value; 
    CalculateUnitPrice(InputValues , NoFlip );  
  }


   
  function StorePaperTypeName(PaperLayerName ){
    let string = '' ;
    let element = document.getElementById(PaperLayerName); 
    CTNPaper[PaperLayerName] = element.options[element.selectedIndex].text.slice(3);  
    for (const key in CTNPaper) {
      string = string  +   CTNPaper[key] + " " ;   
    }
    document.getElementById('CTNPaper').value = string ; 
    document.getElementById('PaperName_'+ PaperLayerName.slice(-1)).value = element.options[element.selectedIndex].text.slice(3); 
  }

 
  // this function will show number of plys when we select 3-ply | 5-ply | 7-ply 
  function ShowPly(CT_Value){
        let display = null; 
        let CTNPaper = '' ;
        for (let index = 1; index <= 7   ;   index++) {
          if(index  <= CT_Value  ) {
            display = '';
            AddToPaper(  document.getElementById('PaperLayerPrice_'+ index).name  ,  document.getElementById('PaperLayerGSM_'+ index).value  
             , document.getElementById('PaperLayerPrice_'+ index).value ); 
            let element = document.getElementById('PaperLayerPrice_'+ index); 
            AddToPaper(   element.name , document.getElementById('PaperLayerGSM_'+ index).value, element.value ); 
            CTNPaper = CTNPaper + ' ' +  element.options[element.selectedIndex].text.slice(3) ; 
            document.getElementById('PaperName_'+ index).value = element.options[element.selectedIndex].text.slice(3);

          }  else  { 
            display ='none'; RemoveFromPaper(document.getElementById('PaperLayerPrice_'+ index).name );
            let element  = document.getElementById('PaperLayerPrice_'+ index) ; 
            element.options[element.selectedIndex].text =  "L" + index + "-Flute"
            removeDuplicateOptions(document.getElementById('PaperLayerPrice_'+index));
            document.getElementById('PaperName_'+ index).value = '';
          }
          document.getElementById('PaperLayerPrice_'+ index).style.display = display;
          document.getElementById('PaperLayerGSM_' + index).style.display = display;
        }

        let FlutOptions = ''; 
        if(CT_Value == 3 )  FlutOptions =  '<option value="None">None</option><option value="C">C</option> <option value="B">B</option> <option value="E">E</option> ';  
        else if(CT_Value == 5 )  FlutOptions =  '<option value="None">None</option><option value="BC">BC</option> <option value="CE">CE</option> '; 
        else if(CT_Value == 7 )   FlutOptions =  '<option value="None">None</option><option value="BCB">BCB</option>'; 
        else FlutOptions = '<option value="None">None</option><option value="C">C</option><option value="B">B</option><option value="E">E</option><option value="BC">BC</option><option value="CE">CE</option><option value="BCB">BCB</option>'; 

        document.getElementById('FlutType').innerHTML = document.getElementById('FlutType').innerHTML + FlutOptions
        removeDuplicateOptions(document.getElementById('FlutType'));
        CalculateUnitPrice(InputValues); 
        document.getElementById('CTNPaper').value = CTNPaper ; 

  } // END OF SLOWPLY 

  function CalculateUnitPrice(InputValues , NoFlip = false){

    let BoxQuantity = Number(InputValues['CartonQTY'] ) || 0 ;
    let Grade = Number(InputValues['PaperGrade']) || 0;
    let UserLength = Number(InputValues['PaperLength'])  || 0;
    let UserWidth =  Number(InputValues['PaperWidth']) || 0;
    let UserHeight =  Number(InputValues['PaperHeight']) || 0;
    let DiePrice = Number(InputValues['DiePrice']) || 0;
    let ColorNumber = Number(InputValues['NoColor']) || 1;
    let Tax = Number(InputValues['Tax']) || 0;
    let ExchangeRate = Number(InputValues['ExchangeRate']) || 0;
    let Values = {}; 

    if(UserLength < UserWidth) {
      alert('Width of product is larger then Length of Product!');
      document.getElementById('PaperWidth').style.border = '2px solid red'; 
      document.getElementById('PaperWidth').value = 0 ; 
      InputValues['PaperWidth'] = 0 ; 
    }
    else {
      document.getElementById('PaperWidth').style.border = '2px solid black'; 
    }

    if(NoFlip) {
      PolymerHeight = Number(document.getElementById('NoFlipHeight').value);
      // console.log('IF:::> ' + PolymerHeight + ' - ' + ColorNumber ); 
    }
    else {
      PolymerHeight = UserWidth + UserHeight;
      // console.log('ELSE:::> ' + PolymerHeight + ' - ' + ColorNumber); 
    }

    Height = UserWidth + UserHeight;
    Length = (UserWidth + UserLength) * 2  + 50 ; 
 
     // To Find POLYMER : Polymer size in mm 2 
    let PolymerSize = (Length * PolymerHeight) / 100 ;
    let TotalPolymerSize = PolymerSize * ColorNumber ; 
    let PolymerPrice = TotalPolymerSize * Unit; 
    let PaperWeight = {} ; 

    // this block is used to calculate and sum each ply or paper price 
    let indexxx = 1 ; 
    var PaperTotalPrice = 0 ; 
    for (const property in Paper) {  
        let EachPaperPrice = Number(CalculateEachPaperPrice(Length , Height , Paper[property].GSM  , Paper[property].Price  ));
        let element = document.getElementById('PaperLayerPrice_'+ indexxx); // element.name , document.getElementById('PaperLayerGSM_'+ index).value, element.value    
        Values[element.options[element.selectedIndex].text.slice(3) + "_" + indexxx] =  EachPaperPrice;
        PaperWeight[element.options[element.selectedIndex].text.slice(3) + "_" + indexxx] = Paper[property].GSM ; 
        indexxx++;
    }

    let value_length = 0 ;
    if( Object.keys(Values).length == 3 ) value_length = 1 ; 
    if( Object.keys(Values).length == 5 ) value_length = 2 ; 
    if( Object.keys(Values).length == 7 ) value_length = 3; 
        
    let value_counter = 1 ; 
    for (const property in Values) {  
      if( value_counter <= value_length )  {
          if(property.includes("Flute")){
                PaperTotalPrice = PaperTotalPrice +  (Values[property] * 1.38 )  ;  
                PaperWeight[property] = PaperWeight[property]  * 1.38;  
                value_counter++; 
          }
          else PaperTotalPrice = PaperTotalPrice + Values[property];
      }
      else PaperTotalPrice = PaperTotalPrice + Values[property];
    } // end of loop 
    // calculate paper weight 
    CalculatePaperWeight(UserLength , UserWidth , UserHeight, PaperWeight , BoxQuantity  ); 

    // This line is used for reversing the formulla and to find grade 
    Results['UnitPrice'] = PaperTotalPrice; 
    let PaperGrade  = (( PaperTotalPrice * Grade ) / 100);
 
    let UnitPriceRate = 0 ; 
    let TotalPrice = 0 ;
    let FinalPrice = 0 ;  

    // UNIT IS THE SUM OF all paper price + grade 
    let UnitPrice = PaperTotalPrice +  PaperGrade;
    
    // change the price from USD to AFN 
    PolymerPrice = PolymerPrice * ExchangeRate ; 
    UnitPriceRate = UnitPrice * ExchangeRate ; 

    // this part is to emptying polymer price when there no color selected 
    let NoColor = document.getElementById('NoColor');
    let smile = NoColor.options[NoColor.selectedIndex].value
    if(smile == 'No Print' || smile == 'Polymer Exist'  || smile == 'Free Polymer') {
      document.getElementById('PolymerPrice').value = 0;
      PolymerPrice = 0 ; 
    }  

    TotalPrice  = Precision(UnitPriceRate)  * BoxQuantity ; 
    TotalPrice = Precision(TotalPrice , 0 ); 
    PolymerPrice =  Precision(PolymerPrice , 0 ); 
    DiePrice = Precision(DiePrice , 0 );
    FinalPrice = Number(TotalPrice) + Number(PolymerPrice) + Number(DiePrice); 

    // to add tax value if we have it. 
    TaxAmount = ( FinalPrice * Tax ) / 100 ; 
    TaxAmount = Precision(TaxAmount , 0 );
    FinalPrice = FinalPrice + Number(TaxAmount); 

    document.getElementById('PolymerPrice').value   =   Precision (PolymerPrice);    
    document.getElementById('PaperPriceAFN').value  =   Precision (UnitPriceRate);  
    document.getElementById('TotalPrice').value     =   Precision(TotalPrice  )   
    document.getElementById('FinalTotal').value     =   Precision (FinalPrice )    

    // STORE below results in array for exchange in afn and USD 
    ExchangeTotalPrice[0] = UnitPriceRate; 
    ExchangeTotalPrice[1] = TotalPrice;
    ExchangeTotalPrice[2] = PolymerPrice;
    ExchangeTotalPrice[3] = DiePrice;
    ExchangeTotalPrice[4] = FinalPrice;

      // get the exact currency 
    let element = document.getElementById('CtnCurrency1');
    ChangeCurrencyType(element.options[element.selectedIndex].value); 
    
    let tp = document.getElementById('TotalPrice').value; 
    tp = Precision(tp , 0 ) 
    tp = tp.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
    document.getElementById('TotalPrice').value  = tp;

    let cq = document.getElementById('CartonQTY').value; 
    cq = cq.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","); 
    document.getElementById('CartonQTY').value  = cq;

  } // END OF Calculate Unit Price 
    
  
  function CalculateEachPaperPrice( Length , Height , PaperGSM ,  Price){
    let PaperGsm = ( Length * Height * PaperGSM ) / 1000000;
    let Wastage = (  PaperGsm * 10  / 100  )  + PaperGsm; 
    let PaperPrice = ( Price / 1000000 ) * Wastage ;  // THERE IS ANOTHER CHAGNE WHICH IS  ( Price / 1000000 ) * Wastage * PaperGSM from table  which is DatabasePaperGSM 
    return PaperPrice ; 
  } // CALCULATE EACH PAPER PRICE 

  function ChangeCurrencyType( value ) {
    
    let UnitPrice =  ExchangeTotalPrice[0];
    let TotalPrice = ExchangeTotalPrice[1];
    let PolymerPrice = ExchangeTotalPrice[2];
    let DiePrice = ExchangeTotalPrice[3];
    let FinalPrice = ExchangeTotalPrice[4];
    let ExchangeRate = Number(InputValues['ExchangeRate']) ; 
    // If the checkbox is checked, display USD total price and total  
    if (value == 'USD'){
      document.getElementById('PaperPriceAFN').value =    Precision(ExchangeTotalPrice[0] / ExchangeRate , 3 );
      document.getElementById('TotalPrice').value =       Precision(ExchangeTotalPrice[1] / ExchangeRate , 3 ); 
      document.getElementById('PolymerPrice').value =     Precision(ExchangeTotalPrice[2] / ExchangeRate , 3 ); 
      document.getElementById('DiePriceInput').value =    Precision(ExchangeTotalPrice[3] / ExchangeRate , 3 ); 
      document.getElementById('FinalTotal').value =       Precision(ExchangeTotalPrice[4] / ExchangeRate , 3 );  

      document.getElementById('UPCurrencyLabel').innerText = 'USD';
      document.getElementById('TACurrencyLabel').innerText = 'USD';
      document.getElementById('FTCurrencyLabel').innerText = 'USD';
    } else if(value == 'AFN')  {
      
      document.getElementById('PaperPriceAFN').value =  Precision( UnitPrice) ; 
        document.getElementById('TotalPrice').value =       Precision( TotalPrice );
        document.getElementById('PolymerPrice').value =     Precision( PolymerPrice );
        document.getElementById('DiePriceInput').value =    Precision( DiePrice );
        document.getElementById('FinalTotal').value =       Precision( FinalPrice );   

        document.getElementById('UPCurrencyLabel').innerText = 'AFN';
        document.getElementById('TACurrencyLabel').innerText = 'AFN';
        document.getElementById('FTCurrencyLabel').innerText = 'AFN';
    } // END OF ELSE IF BLOCK   
  } // END OF cHANGE CURRENCY TYPE 

  function ShowNoFlip(NoFlip){

    // Top Flip = (L+W) *2 +5cm, H= W/2 +H
    // Without flip = (L+W) *2 +5cm, H= H
    // Full Flip = = (L+W) *2 +5cm, H= W +H

    let UserLength1 =  Number(document.getElementById('PaperLength').value) || 0;
    let UserWidth1 =   Number(document.getElementById('PaperWidth').value) || 0;   
    let UserHeight1 =  Number(document.getElementById('PaperHeight').value) || 0; 

    var Length1 , Height1 ;   
    if(NoFlip == 'TF')   Height1 = (UserWidth1 / 2 ) + UserHeight1; 
    else if(NoFlip == 'WF') Height1 = UserHeight1; 
    else if(NoFlip == 'FF') Height1 = UserWidth1 + UserHeight1; 


    document.getElementById('NoFilpArea').style.display = '';
    
    document.getElementById('NoFlipLength').value  =    (UserWidth1 + UserLength1) * 2  + 50 ; 
    document.getElementById('NoFlipHeight').value  =  Height1

    // InputValues['PaperHeight'] = Height   // Number(document.getElementById('PaperHeight').value  ); 
    CalculateUnitPrice(InputValues , true );  
  } // SHOW NO FLIP 

  // THIS BLOCK IS USED TO CALCULATE THE SHEET AND BOX JUST REMOVING THE HEIGHT FROM FORMULLA 
  function CalculateCartonType(value){

    if(value == 'Carton') {
      document.getElementById('PaperWidthCol').style.display = '' ;
      InputValues['PaperWidth'] = document.getElementById('PaperWidth').value ;
    }
    else {
      document.getElementById('PaperWidthCol').style.display = 'none' ;
      InputValues['PaperWidth'] = 0 ; 
    }
    CalculateUnitPrice(InputValues );  
  }

  function ChangeGrade( UserUnitPrice){
    let UUP =  Number(UserUnitPrice) / Number(InputValues['ExchangeRate']) ; 

    let Grade = (100 *  UUP -  100 * Results['UnitPrice']  ) ; 
    let Grade1 = Grade  /  Results['UnitPrice']; 
    document.getElementById('PaperGrade').value = Grade1; 
    AddInputValues('PaperGrade' , Grade1);
  } // CHANGE GRADE 


  // THIS FUNCTION IS CHECK EMPTYNESS OF FIELDS 
  function isEmpty(str) {
      return !str.trim().length;
  }

  // OLD FUNCTION NEED TO DELETE A TIME AFTER DEPLOYMENT 
  // function CopyValueToJobNo(value){
  //   let JobNumber = document.getElementById('JobNo') ; 
  //   if(isEmpty(JobNumber.value)) JobNumber.value = value + 1 ;
  //   else JobNumber.value = '' ;
  // }

  function pad(num, size) {
      var s = "000" + num;
      return s.substr(s.length-size);
  }
    
  function CopyValueToJobNo(value)
  {
    let JobNumber = document.getElementById('JobNo') ; 
    let LastJobNo= document.getElementById('CustomerName').value; 
    let SplitString = LastJobNo.substr(0, 3); 
    let SplitDigit = LastJobNo.substr(3); 
    let x = Number(SplitDigit) + 1 ; 
    let NewData =JobNumber.value = pad( x,5);
    JobNumber.value = SplitString.concat(NewData); 
  }


 
  function HideJobType(){
    let jobtype =  document.getElementById('JobTypeRow') ;
    if(jobtype.style.display == 'none') {
      jobtype.style.display = '';   document.getElementById('jobTypeHr').style.display = ''; 
    }
    else {
      jobtype.style.display = 'none';  document.getElementById('jobTypeHr').style.display = 'none'; 
    }

  }

  function CalculatePaperWeight(L , W , H , PaperWeight , CTNQTY ){
    
    let Length = (L+W) * 2 + 50 ; 
    let Dieckle = ( W+H ) * 0.1; 
    let SheetArea = Number(Precision( ((Length * 0.1 ) * Dieckle ) * 0.0001 , 4 ))   ;
    let RequiredPaperKG = 0 ; 
    let PaperTotalWeight = 0 ;
    let PaperTotalGSM = 0 ;  
    let SingleCartonWeight = 0 ; 
    let TrayArea = 0 ; 
    let counter = 1; 
    let PaperWeightListHTML = ''; 
    let PaperWeightollectedListHTML 
    let PWTLH = ''; 
   

  
    // this block is used to hide all unwanted paper weight 
    const collection = document.getElementsByClassName("_Paper_");
    for (let i = 0; i < collection.length; i++) {
      collection[i].style.display = 'none' ;

    }
    const collection1 = document.getElementsByClassName("PIV");
    for (let i = 0; i < collection1.length; i++) {
      collection1[i].value = 0;
    }

    let RG = /[a-z]+/i;
    for (const property in PaperWeight) {  
      RequiredPaperKG = SheetArea * PaperWeight[property] * CTNQTY * 0.001; 
      PaperTotalWeight += Number(Precision(RequiredPaperKG)) ; 
      PaperTotalGSM += Number(Precision(  PaperWeight[property])) ; 

      PaperWeightListHTML += '<div class="input-group my-2"> <input type="text" class = "form-control " style = "border-right:none;" value = "L' + counter + " - " + RG.exec(property) +'"readonly>';
      PaperWeightListHTML +=  '<input type="text" class = "form-control" value="'+ Precision(RequiredPaperKG/1000 ,2 ) + ' TON" readonly > </div>';


      var _paper = property.replace(/[^A-Za-z]/g, '');

      switch (_paper) {
        case 'Flute':
          document.getElementById('Flute_name').value  = Precision( Number(document.getElementById('Flute_name').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ; 
          document.getElementById('flute_input_group').style.display = ''; 
          break;
        case 'BB':
            document.getElementById('BB_name').value =  Precision( Number(document.getElementById('BB_name').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ; 
            document.getElementById('bb_input_group').style.display = ''; 
           break;
        case 'WTKL':
            document.getElementById('WTKL_name2').value =  Precision( Number(document.getElementById('WTKL_name2').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ; 
            document.getElementById('wtkl_input_group2').style.display = ''; 
           break;
        case 'TL':
            document.getElementById('TL_name').value =  Precision( Number(document.getElementById('TL_name').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ; 
           document.getElementById('tl_input_group').style.display = '';
           break;
        case 'WTL':
            document.getElementById('WTL_name1').value =  Precision( Number(document.getElementById('WTL_name1').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ;  
            document.getElementById('wtl_input_group1').style.display = ''; 
           break;
        case 'KLB':
            document.getElementById('KLB_name').value =  Precision( Number(document.getElementById('KLB_name').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ;  
            document.getElementById('klb_input_group').style.display = ''; 
           break;
        case 'Liner':
            document.getElementById('Liner_name').value =  Precision( Number(document.getElementById('Liner_name').value  ) + Number(Precision(RequiredPaperKG/1000,2) )  , 2 ) ;  
            document.getElementById('liner_input_group').style.display = ''; 
           break;
        default:
          console.log('No Paper Found!');
          break;
      }

      counter++; 
    
    }// END OF LOOP 

    // PaperTotalWeight = Number(Precision( PaperTotalWeight )); 
    PaperTotalGSM = Number(Precision( PaperTotalGSM ));  
    PaperTotalWeightTon = Number(Precision( PaperTotalWeight / 1000 , 2  )); 
    
    document.getElementById('paper_weight_total').value = PaperTotalWeightTon + ' TON';

    // PaperWeightListHTML += '<li class="list-group-item d-flex justify-content-between align-items-center "  > <span style = "font-weight:bold; padding:0px;">TOTAL</span> <span class = "shadow" style = "border:2px solid #6610f2; padding:4px; padding-left:6px; padding-right:6px;  border-radius:4.5px;  "  > '; 
    // PaperWeightListHTML += '<strong>' + PaperTotalWeightTon + ' TON </strong></span> </li>' ;
    // PaperWeightollectedList  
    document.getElementById('PaperWeightList').innerHTML = PaperWeightListHTML ; 

    // document.getElementById('PaperWeightollectedList').innerHTML = PaperWeightollectedList ; 

    // SingleCartonWeight =  Number(Precision( PaperTotalGSM * SheetArea) ) ; 
    // TrayArea = Number(Precision(L * W * 0.000001 )); 
    // TrayWeight = Number(Precision(TrayArea * PaperTotalGSM )); 
    // OneCartonPaperUsage = Number(Precision( PaperTotalWeight * 1 / CTNQTY ))  ; 
    document.getElementById('DieckleInput').value = Dieckle ; 
  }// END OF calculate paper weight 

function ChangeDieckle(value) {
 let W =  document.getElementById('PaperWidth').value-0;
 let H =  document.getElementById('PaperHeight').value-0;
 document.getElementById('DieckleInput').value = ( W+H ) * value ; 

}

 

    function collectionContains(collection, searchText) {
        for (var i = 0; i < collection.length; i++) {
            if( collection[i].innerText.toLowerCase().indexOf(searchText) > -1 ) {
                return true;
            }
        }
        return false;
    } 

    function UpdateToNewPrice(){
      let ex; 
        if(document.getElementById('NewPrice').checked)  {
            var PaperName = document.getElementsByName('PaperName') ; 
            for (let index = 1; index <= 7 ; index++) {
                Array.from(PaperName).forEach(function(element) {
                    if(element.id.trim()  === document.getElementById('PaperName_'+index).value.trim()  ) {
                      ChangePrice("PaperLayerPrice_"+index , element.value ); 
                    }
                });
                ex = document.getElementById('NewExchangeRate').value ; 
            }
        }  
        else {
          ex =  document.getElementById('ExchangeRate').value ;   
          let CartonType = document.getElementById('CartonType');    
          CartonType =  CartonType.options[CartonType.selectedIndex].value;
          for (let index = 1; index <= CartonType ; index++) { 
            let element = document.getElementById('PaperLayerPrice_'+ index);  
            ChangePrice("PaperLayerPrice_"+index , element.options[element.selectedIndex].value ); 
          }
        } 
        AddInputValues('ExchangeRate' , ex ); 
    }

    
    function CheckFlexoOffset(){
      let flexo = document.getElementById('flexop'); 
      let offset = document.getElementById('offesetp'); 

      if(flexo.checked == true) {
        offset.checked = false; 
      }
      else if (offset.checked == true) {
        flexo.checked = false; 
      }
    } // end of function 


    function CheckCancelCommentLength(){
      let CancelComment = document.getElementById('CancelComment');
      document.getElementById('comment_length').innerHTML = CancelComment.value.length;
      if(CancelComment.value.length >= 120 ) {
        CancelComment.setAttribute('maxlength', 120); 
      }
    }
    CheckCancelCommentLength(); 

    function CheckDiePriceInput(value){
      if(value == 'No Die' || value == 'Die Exist') {
        document.getElementById('DiePriceInput').setAttribute('disabled' , 'disabled'); 
        document.getElementById('DiePriceInput').value = 0 ; 
        InputValues['DiePrice'] = 0
      }//end of if block 
      else {
        document.getElementById('DiePriceInput').removeAttribute('disabled'); 
      }
    }// end of function 


    function removeDuplicateOptions(s, comparitor) {
      if(s.tagName.toUpperCase() !== 'SELECT') { return false; }
      var c, i, o=s.options, sorter={};
      if(!comparitor || typeof comparitor !== 'function') {
        comparitor = function(o) { return o.value; };//by default we comare option values.
      }
      for(i=0; i<o.length; i++) {
        c = comparitor(o[i]);
        if(sorter[c]) {
          s.removeChild(o[i]);
          i--;
        }
        else { sorter[c] = true; }
      }
      return true;
    }

  </script>
  <?php 
      $CallAgain = [   'PaperGrade'  => $CTN['GrdPrice'] , 'CartonQTY' => $CTN['CTNQTY']  ,
        'PaperLength' => $CTN['CTNLength'] ,  'PaperWidth' => $CTN['CTNWidth'] , 
        'PaperHeight' => $CTN['CTNHeight'] ,  'NoColor' => $CTN['polymer_info'] ,  
        'DiePrice' => $CTN['CTNDiePrice'] ,  
        'Tax' => $CTN['Tax']  , 'ExchangeRate' => $CTN['PexchangeUSD'] , 'DieExist' => $CTN['die_info']]; 
        $CTNType = $CTN['CTNType']; 

        $Exct = "<script>" ; 
        $Exct .= "ShowPly($CTNType);"; 
          foreach ($CallAgain as $key => $value) {
            $Exct .= "AddInputValues('$key' ,  `$value`); "; 
          }
        $Exct .= "ShowNoFlip(`{$CTN['NoFlip']}`); console.log(InputValues);  "; 
        $Exct .= "CheckDiePriceInput(`{$CTN['die_info']}`)";
        $Exct .= "</script>" ;
        echo $Exct; 
  ?>
<script>
  let SelectID = ['CartonUnit' , 'CtnCurrency1' , 'Tax' , 'NoColor1' , 'NoColor' ,'DieExist' ,'FlutType' ,'CartonType' , 'NoFlip']
    for (let index = 0; index <  SelectID.length; index++) {
      removeDuplicateOptions(document.getElementById(SelectID[index]));
  }
</script>
  

<?php require_once '../App/partials/Footer.inc'; ?> 