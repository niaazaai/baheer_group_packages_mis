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
    <div class="card text-white" style = "background-color:#9d0000;" >
      <div class="card-body d-flex justify-content-between shadow">
          <h3 class="m-0 p-0"> 
          <svg id="marketing-svg" width="50" height="50" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_1058_258)">
            <path d="M378.208 162.808H500.416V86.9351C500.416 61.4511 479.565 40.6001 454.081 40.6001H57.919C32.435 40.6001 11.584 61.4511 11.584 86.9351V162.808H133.792H378.208Z" fill="#FF4E4E" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#9d0000;"></path>
            <path d="M133.792 101.706V370.563H256L378.208 248.355V101.706H133.792Z" fill="#FFCE47" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#795900;"></path>
            <path d="M378.208 248.355C378.208 315.853 323.498 370.563 256 370.563C279.862 346.701 291.794 315.425 291.794 284.149C323.07 284.149 354.346 272.218 378.208 248.355Z" fill="#FFEBB4" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#ffe398;"></path>
            <path d="M458.715 74.772C452.008 74.772 446.552 80.228 446.552 86.935C446.552 93.642 452.008 99.098 458.715 99.098C465.422 99.098 470.878 93.642 470.878 86.935C470.878 80.228 465.422 74.772 458.715 74.772Z" fill="#01121C" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#dfdcd8;"></path>
            <path d="M458.715 115.894C452.008 115.894 446.552 121.35 446.552 128.057C446.552 134.764 452.008 140.22 458.715 140.22C465.422 140.22 470.878 134.764 470.878 128.057C470.878 121.35 465.422 115.894 458.715 115.894Z" fill="#01121C" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#dfdcd8;"></path>
            <path d="M454.081 34.8081H57.919C25.982 34.8081 0 60.7911 0 92.7271V168.6C0 174.998 5.187 180.184 11.584 180.184H41.702V454.024H18.534C12.137 454.024 6.95 459.21 6.95 465.608C6.95 472.006 12.137 477.192 18.534 477.192H88.036C94.433 477.192 99.62 472.006 99.62 465.608C99.62 459.21 94.433 454.024 88.036 454.024H64.869V180.184H122.208V376.354C122.208 382.752 127.395 387.938 133.792 387.938H256C329.773 387.938 389.792 327.919 389.792 254.146V180.184H447.131V454.024H423.964C417.567 454.024 412.38 459.21 412.38 465.608C412.38 472.006 417.567 477.192 423.964 477.192H493.466C499.863 477.192 505.05 472.006 505.05 465.608C505.05 459.21 499.863 454.024 493.466 454.024H470.299V180.184H500.417C506.814 180.184 512.001 174.998 512.001 168.6V92.7271C512 60.7911 486.018 34.8081 454.081 34.8081ZM251.054 364.77H145.376V119.08H366.625V249.2C346.162 268.034 319.774 278.356 291.794 278.356C285.397 278.356 280.21 283.542 280.21 289.94C280.21 317.919 269.889 344.308 251.054 364.77ZM282.676 361.52C294.201 343.39 301.15 322.759 302.923 301.07C324.61 299.295 345.242 292.347 363.373 280.823C353.531 320.432 322.284 351.675 282.676 361.52ZM488.833 157.017H389.792V119.08H412.959C419.356 119.08 424.543 113.894 424.543 107.496C424.543 101.098 419.356 95.9121 412.959 95.9121H99.041C92.644 95.9121 87.457 101.098 87.457 107.496C87.457 113.894 92.644 119.08 99.041 119.08H122.208V157.017H23.167V92.7271C23.167 73.5651 38.756 57.9761 57.918 57.9761H454.081C473.243 57.9761 488.832 73.5651 488.832 92.7271V157.017H488.833Z" fill="#01121C" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#010e16;"></path>
            </g>
            <defs>
            <clipPath id="clip0_1058_258">
            <rect width="512" height="512" fill="white" data-darkreader-inline-fill="" style="--darkreader-inline-fill:#181a1b;"></rect>
            </clipPath>
            </defs>
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


 

