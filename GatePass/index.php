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
    <div class="card text-white" style = "background-color:#11dbff;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0"> 
          <svg id="marketing-svg" width="50" height="50" viewBox="0 0 464 400" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M224 0V32.652C218.713 33.486 213.385 35.1 208 37.282V16H192V45.16C190.302 46.12 188.598 47.113 186.885 48.14C183.287 50.3 179.655 52.62 176 55.045V32H160V66.19C154.676 70.04 149.336 74.016 144 78.012V64H128V89.965C122.598 93.973 117.25 97.865 112 101.557V80H96V112.213C94.96 112.86 93.91 113.525 92.885 114.141C88.437 116.811 84.119 119.144 80 121.103V112H64V126.973C61.11 127.643 58.425 128 56 128H48V96H0V400H48V144H56C58.658 144 61.324 143.77 64 143.348V400H80V138.717C85.272 136.579 90.6 133.897 96 130.84V400H112V120.955C117.294 117.443 122.637 113.691 128 109.811V400H144V256H160V400H176V74.443C181.462 70.605 186.81 67.016 192 63.787V208H208V54.898C213.793 52.144 219.188 50.143 224 49.028V208H240V49.027C244.812 50.143 250.207 52.144 256 54.897V208H272V63.787C277.19 67.017 282.538 70.605 288 74.443V400H304V256H320V400H336V109.81C341.363 113.69 346.706 117.443 352 120.955V400H368V130.84C373.4 133.896 378.728 136.58 384 138.717V400H400V143.348C402.676 143.77 405.342 144 408 144H416V400H464V96H416V128H408C405.575 128 402.89 127.643 400 126.973V112H384V121.102C379.88 119.142 375.563 116.81 371.115 114.142C370.089 113.525 369.04 112.86 368 112.212V80H352V101.557C346.748 97.867 341.402 93.973 336 89.965V64H320V78.012C314.664 74.016 309.324 70.042 304 66.189V32H288V55.045C284.346 52.621 280.713 50.299 277.115 48.141C275.402 47.114 273.698 46.121 272 45.161V16H256V37.283C250.615 35.1 245.287 33.486 240 32.653V0H224ZM24 32C10.65 32 0 42.65 0 56C0 69.35 10.65 80 24 80C37.35 80 48 69.35 48 56C48 42.65 37.35 32 24 32ZM440 32C426.65 32 416 42.65 416 56C416 69.35 426.65 80 440 80C453.35 80 464 69.35 464 56C464 42.65 453.35 32 440 32ZM160 86.035V240H144V97.988C145.6 96.79 147.203 95.598 148.8 94.4C152.55 91.59 156.284 88.792 160 86.035ZM304 86.035C307.716 88.792 311.45 91.59 315.2 94.4C316.797 95.6 318.4 96.79 320 97.988V240H304V86.035ZM192 224V256H272V224H192ZM192 272V400H208V272H192ZM224 272V400H240V272H224ZM256 272V400H272V272H256Z" fill="#2D707C"></path>
            </svg> Gatepass</h3>
          
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


 

