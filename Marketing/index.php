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
    <div class="card text-white" style = "background-color:#F37053;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0"> 
            <svg id="marketing-svg" width="50" height="50" viewBox="0 0 512 496" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M360 426.016L240 355.424V204.352L360 126.704V426.016Z" fill="white"></path>
              <path d="M32 240H16V320H32V240Z" fill="white"></path>
              <path d="M224 208H48V352H224V208Z" fill="white"></path>
              <path d="M224 280H48V352H224V280Z" fill="#DCDDDE"></path>
              <path d="M360 432L240 360V280H360V432Z" fill="#DCDDDE"></path>
              <path d="M32 280H16V320H32V280Z" fill="#DCDDDE"></path>
              <path d="M416 319.192V240.808C434.232 244.528 448 260.68 448 280C448 299.32 434.232 315.472 416 319.192Z" fill="#44C8F5"></path>
              <path d="M168 488H128L96 360H152V440L168 464V488Z" fill="#F37053"></path>
              <path d="M400 112H376V440H400V112Z" fill="#F37053"></path>
              <path d="M136 160L104 136H8V56H136V160Z" fill="#FFD768"></path>
              <path d="M184 112L216 88H312V8H184V112Z" fill="#FFD768"></path>
              <path d="M464 280C464 251.848 443.096 228.544 416 224.64V96H360V107.648L229.64 192H32V224H0V336H32V368H89.752L121.752 496H176V461.576L160 437.576V407.28C180.056 403.896 195.888 388.056 199.28 368H229.824L360 444.576V456H416V335.36C443.096 331.456 464 308.152 464 280ZM32 320H16V240H32V320ZM160 480H134.248L106.248 368H144V442.424L160 466.424V480ZM160 390.864V368H182.864C179.952 379.192 171.192 387.952 160 390.864ZM224 352H48V208H224V352ZM360 426.016L240 355.424V204.352L360 126.704V426.016ZM400 368V384V440H376V112H400V368ZM416 319.192V240.808C434.232 244.528 448 260.68 448 280C448 299.32 434.232 315.472 416 319.192Z" fill="#0C3847"></path>
              <path d="M144 176V48H0V144H101.336L144 176ZM16 64H128V144L106.664 128H16V64Z" fill="#0C3847"></path>
              <path d="M48 88H32V104H48V88Z" fill="#0C3847"></path>
              <path d="M80 88H64V104H80V88Z" fill="#0C3847"></path>
              <path d="M112 88H96V104H112V88Z" fill="#0C3847"></path>
              <path d="M80 224H64V240H80V224Z" fill="#0C3847"></path>
              <path d="M112 224H96V240H112V224Z" fill="#0C3847"></path>
              <path d="M320 96V0H176V128L218.664 96H320ZM192 96V16H304V80H213.336L192 96Z" fill="#0C3847"></path>
              <path d="M288 40H272V56H288V40Z" fill="#0C3847"></path>
              <path d="M256 40H240V56H256V40Z" fill="#0C3847"></path>
              <path d="M224 40H208V56H224V40Z" fill="#0C3847"></path>
              <path d="M208 320H64V336H208V320Z" fill="#0C3847"></path>
              <path d="M454.917 386.852L446.917 372.996L433.061 380.996L441.061 394.852L454.917 386.852Z" fill="#0C3847"></path>
              <path d="M480.166 364.859L468.853 353.546L457.539 364.859L468.853 376.173L480.166 364.859Z" fill="#0C3847"></path>
              <path d="M498.864 337.06L485.008 329.06L477.008 342.916L490.864 350.916L498.864 337.06Z" fill="#0C3847"></path>
              <path d="M509.654 305.382L494.2 301.241L490.059 316.696L505.514 320.836L509.654 305.382Z" fill="#0C3847"></path>
              <path d="M512 272H496V288H512V272Z" fill="#0C3847"></path>
              <path d="M505.537 239.108L490.083 243.249L494.224 258.703L509.678 254.562L505.537 239.108Z" fill="#0C3847"></path>
              <path d="M490.857 209.081L477.001 217.081L485.001 230.937L498.857 222.937L490.857 209.081Z" fill="#0C3847"></path>
              <path d="M457.574 195.136L468.888 206.45L480.202 195.136L468.888 183.823L457.574 195.136Z" fill="#0C3847"></path>
              <path d="M433.062 179.014L446.918 187.014L454.918 173.158L441.062 165.158L433.062 179.014Z" fill="#0C3847"></path>
            </svg> Marketing Department
          </h3>
          
        </div>
    </div>
    
    <div  id="livesearch" class="list-group shadow z-index-2 position-absolute text-center  w-25 mt-3"></div>


    <!-- 
      <audio id="notification" src="../Public/Sound/notification_sound.wav" muted></audio>
      <button onclick="playSound()">Play</button> 
      document.getElementById('notification').muted = false;
      document.getElementById('notification').play(); 
    -->

  </div>
  

<?php  require_once '../App/partials/Footer.inc'; ?>


 

