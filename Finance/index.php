<?php    require_once '../App/partials/Header.inc';  ?>
<?php   require_once '../App/partials/Menu/MarketingMenu.inc'; 

//  $user_id = $Controller->QueryData("SELECT user_id FROM alert_access_list WHERE department = ? AND notification_type = ?" , [ 'Design' , 'NEW-JOB'])->fetch_assoc()['user_id'];
// echo $user_id; 
?>  




<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>
  <div class="m-3">
    <div class="card text-white" style = "background-color:#704e2e;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0"> 
          <svg id="marketing-svg" width="40" height="50" viewBox="0 0 417 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M155.712 409.072H102.928V451.299H155.712V409.072Z" fill="#546A79" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#a7a094;"></path>
                  <path d="M60.702 7.91797H7.91797V504.083H60.702V7.91797Z" fill="#8C6239" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#704e2e;"></path>
                  <path d="M409.072 18.474V493.526C409.072 499.332 404.321 504.083 398.515 504.083H60.7012V7.91797H398.515C404.322 7.91797 409.072 12.668 409.072 18.474ZM345.732 176.825C345.732 115.807 296.432 66.296 235.414 65.98C235.203 65.98 235.097 65.98 234.886 65.98C173.657 65.98 124.041 115.596 124.041 176.825C124.041 237.843 173.341 287.354 234.359 287.67C234.57 287.67 234.676 287.67 234.887 287.67C296.116 287.67 345.732 238.054 345.732 176.825ZM155.712 451.299V409.072H102.928V451.299H155.712Z" fill="#A67C52" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#856342;"></path>
                  <path d="M235.415 65.9785C235.204 65.9785 235.098 65.9785 234.887 65.9785C173.658 65.9785 124.042 115.595 124.042 176.824C124.042 237.842 173.342 287.353 234.36 287.669C234.571 287.669 234.677 287.669 234.888 287.669C296.117 287.669 345.733 238.053 345.733 176.824C345.732 115.807 296.432 66.2955 235.415 65.9785Z" fill="#FFD248" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#795b00;"></path>
                  <path d="M398.516 0H0V512H398.515C408.701 512 416.989 503.712 416.989 493.526V18.474C416.99 8.288 408.702 0 398.516 0ZM15.835 15.835H52.783V496.165H15.835V15.835ZM401.155 493.526C401.155 494.956 399.946 496.165 398.516 496.165H68.619V15.835H398.516C399.946 15.835 401.155 17.044 401.155 18.474V493.526V493.526Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#000000;"></path>
                  <path d="M377.403 401.154H324.619V416.989H377.403V401.154Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path>
                  <path d="M377.402 443.381H271.835V459.216H377.402V443.381Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path>
                  <path d="M353.65 176.826C353.65 145.21 341.368 115.46 319.066 93.0535C296.769 70.6535 267.075 58.2255 235.456 58.0625H234.887C169.401 58.0625 116.124 111.34 116.124 176.826C116.124 208.441 128.406 238.191 150.708 260.597C173.005 282.997 202.699 295.426 234.359 295.589H234.887C300.373 295.589 353.65 242.312 353.65 176.826ZM234.887 279.753H234.4C177.913 279.461 131.959 233.288 131.959 176.826C131.959 120.07 178.132 73.8975 234.887 73.8975H235.392C291.869 74.2015 337.815 120.37 337.815 176.826C337.815 233.581 291.642 279.753 234.887 279.753Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#000000;"></path>
                  <path d="M256 116.124H242.804V92.3711H226.969V116.124H213.773C203.587 116.124 195.299 124.412 195.299 134.598V166.268C195.299 176.454 203.587 184.742 213.773 184.742H256C257.43 184.742 258.639 185.951 258.639 187.381V219.051C258.639 220.481 257.43 221.69 256 221.69H213.773C212.343 221.69 211.134 220.481 211.134 219.051V203.216H195.299V219.051C195.299 229.237 203.587 237.525 213.773 237.525H226.969V261.278H242.804V237.525H256C266.186 237.525 274.474 229.237 274.474 219.051V187.381C274.474 177.195 266.186 168.907 256 168.907H213.773C212.343 168.907 211.134 167.698 211.134 166.268V134.598C211.134 133.168 212.343 131.959 213.773 131.959H256C257.43 131.959 258.639 133.168 258.639 134.598V150.433H274.474V134.598C274.474 124.412 266.186 116.124 256 116.124Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#000000;"></path>
                  <path d="M95.0098 459.216H163.629V401.154H95.0098V459.216ZM110.846 416.989H147.794V443.381H110.846V416.989Z" fill="black" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#e8e6e3;"></path>
                </svg> Finance Department
          </h3>
          
        </div>
    </div>
    
    <div  id="livesearch" class="list-group shadow z-index-2 position-absolute text-center  w-25 mt-3"></div>

 

  </div>
  

<?php  require_once '../App/partials/Footer.inc'; ?>


 

