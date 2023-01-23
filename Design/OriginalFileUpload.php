
<?php 
ob_start();
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc';

if(isset($_GET['CTNId']) && !empty(trim($_GET['CTNId']))  && isset($_GET['ProductName']) && !empty(trim($_GET['ProductName']))  && isset($_GET['DesignCode']) && !empty(trim($_GET['DesignCode'])))
{
    $CTNId = $_GET['CTNId']; 
    $DesignCode = $_GET['DesignCode']; 
}
else header('Location:OrignalFile.php?ListType=Upload Files&msg=No carton id and design code provided&class=danger' );

?>
 




<div class="card m-3">
<div class="card-body  ">
    <h4 class="fw-bold m-0"> 
        <a class="btn btn-outline-primary   me-3" href="OrignalFile.php?ListType=Download Files">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>

        <svg width="50" height="50" viewBox="0 0 512 512" fill="#E8E6E6" xmlns="http://www.w3.org/2000/svg">
            <path d="M511.344 274.266C511.77 268.231 512 262.143 512 256C512 114.615 397.385 0 256 0C114.615 0 0 114.615 0 256C0 373.769 79.53 472.949 187.809 502.801L511.344 274.266Z" fill="#B3DA73"/>
            <path d="M511.344 274.266L314.991 77.913L119.096 434.087L187.81 502.801C209.522 508.787 232.385 512 256 512C391.243 512 501.976 407.125 511.344 274.266Z" fill="#89C429"/>
            <path d="M278.328 333.913L255.711 77.913H119.096V311.652L278.328 333.913Z" fill="white"/>
            <path d="M392.904 311.652V155.826L337.252 133.565L314.991 77.913H255.711L256.067 333.913L392.904 311.652Z" fill="#E8E6E6"/>
            <path d="M314.99 155.826V77.913L392.903 155.826H314.99Z" fill="white"/>
            <path d="M392.905 311.652H119.096V434.087H392.905V311.652Z" fill="#709E21"/>
            <path d="M222.957 354.863L215.162 364.096C211.682 359.858 206.535 357.209 201.842 357.209C193.442 357.209 187.085 363.868 187.085 372.572C187.085 381.426 193.442 388.161 201.842 388.161C206.308 388.161 211.453 385.739 215.162 381.955L223.033 390.279C217.356 396.106 208.956 399.966 201.161 399.966C185.192 399.966 173.312 388.236 173.312 372.721C173.312 357.434 185.497 345.931 201.617 345.931C209.487 345.933 217.66 349.413 222.957 354.863Z" fill="white"/>
            <path d="M253.841 346.387C270.49 346.387 281.994 357.133 281.994 372.874C281.994 388.54 270.338 399.362 253.311 399.362H231.061V346.387H253.841ZM244.531 388.615H254.142C262.391 388.615 268.293 382.258 268.293 372.95C268.293 363.566 262.088 357.133 253.536 357.133H244.53V388.615H244.531Z" fill="white"/>
            <path d="M315.068 384.453H314.69H304.473V399.362H291.002V346.387H314.689C328.69 346.387 336.712 353.046 336.712 364.852C336.712 372.949 333.306 378.777 327.101 381.879L338.226 399.362H322.939L315.068 384.453ZM314.69 373.858C320.518 373.858 323.923 370.906 323.923 365.306C323.923 359.781 320.518 356.982 314.69 356.982H304.473V373.859H314.69V373.858Z" fill="white"/>
        </svg>
        Upload File <span style="color:#FA8b09;"> <?=(isset($_REQUEST['DesignCode'])) ? '( for ' . $_REQUEST['ProductName'] . " with design code [".   $_REQUEST['DesignCode'] . ' ] )'  : "" ;  ?> </span>     
    </h4>
</div>
</div>


<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11" >
    <div class="alert alert-dismissible fade show shadow" role="alert" id = "msg_type" >
        <strong>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
        </svg>  
        Information</strong> <span id = "msg" ></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
 

<div class="container mt-5" style="max-width: 900px">
    <div class="card shadow-lg">
        <div class="card-body">
            <div class="input-group">
                <input type="file" class = "form-control" id="select_file" />
                <button onclick = "uploadfile()" class="btn btn-outline-primary fw-bold ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                        <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
                    </svg>   Upload
                </button>
            </div>
        </div>
    </div>
    <br />
    <div class="progress" id="progress_bar" style="display:none;height:50px; line-height: 50px;">
        <div class="progress-bar" id="progress_bar_process" role="progressbar" style="width:0%;">0%</div>
    </div>
    <div id="uploaded_image" class="row mt-5"></div>
</div>

 



<script>


var progress_bar = document.getElementById('progress_bar');
var progress_bar_process = document.getElementById('progress_bar_process');
var uploaded_image = document.getElementById('uploaded_image');

 function uploadfile (){
    var file_element = document.getElementById('select_file');
    var form_data = new FormData();

    if(file_element.files[0] == undefined) {
        document.getElementById('msg_type').classList = 'alert alert-dismissible fade show shadow alert-danger'; 
        document.getElementById('msg').innerText =  'No File Provided, Please choose a file first';
        return;  
    }
 
        form_data.append('file', file_element.files[0]);
        form_data.append('CTNId'  , '<?=$CTNId?>'); 
        form_data.append('DesignCode'  , '<?=$DesignCode?>');

        progress_bar.style.display = 'block';
        var ajax_request = new XMLHttpRequest();
        ajax_request.open("POST", "AJAXUpload.php");

        ajax_request.upload.addEventListener('progress', function(event){
            var percent_completed = Math.round((event.loaded / event.total) * 100);
            progress_bar_process.style.width = percent_completed + '%';
            progress_bar_process.innerHTML = percent_completed + '% completed';
        });

        ajax_request.addEventListener('load', function(event){

            var response = JSON.parse(event.target.response);


            if(response.redirect == true && response.type == 'success'){
                document.getElementById('msg_type').classList =  'alert alert-dismissible fade show shadow alert-success'; 
                document.getElementById('msg').innerText = response.msg;
                window.location.replace ('OrignalFile.php?ListType=Download Files');
                 
            }
            else if(response.msg = '-1') {
                document.getElementById('msg_type').classList = 'alert alert-dismissible fade show shadow alert-danger'; 
                document.getElementById('msg').innerText = 'Please check you have no design code for this job '; 
            }
            else if(response.msg = '-2') {
                document.getElementById('msg_type').classList = 'alert alert-dismissible fade show shadow alert-danger'; 
                document.getElementById('msg').innerText = 'Somthing went wrong , the file was not uploaded'; 
                
            }
            else if(response.msg = '-3') {
                document.getElementById('msg_type').classList = 'alert alert-dismissible fade show shadow alert-danger'; 
                document.getElementById('msg').innerText = 'Somthing went wrong while uploading file.'; 
                
            }
            else {
                document.getElementById('msg_type').classList = 'alert alert-dismissible fade show shadow alert-danger'; 
                document.getElementById('msg').innerText = response.msg; 
            }



      
            // uploaded_image.innerHTML = '<div class="alert alert-success">Files Uploaded Successfully : '+file_data+' </div>';
            // file_element.value = '';



            file_element.value = '';
           


        });
        ajax_request.send(form_data);


};

</script>  




<?php  require_once '../App/partials/Footer.inc'; ?>





          