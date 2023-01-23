<?php 
require_once '../App/partials/Header.inc'; 
require_once '../App/partials/Menu/MarketingMenu.inc'; 

if(isset($_GET['CTNId']) && !empty($_GET['CTNId']))
{ 
    $ListType=$_GET['ListType'];
    $SQL= " SELECT JobNo , RVocherNo ,  RSectionName ,  CustName , ProductName , FinalTotal , RAmount  ,CtnCurrency , Ename , FinalTotal , RComment     , RDate
    FROM carton   INNER JOIN  receivabletr ON carton.CTNId = receivabletr.SectionId  INNER JOIN  ppcustomer ON ppcustomer.CustId=carton.CustId1  LEFT JOIN   employeet ON  receivabletr.RUserId   = employeet.EId
    WHERE receivabletr.SectionId=?   LIMIT 50 " ; 
    $DataRows=$Controller->QueryData($SQL,[$_GET['CTNId']]);

}
else {
    header('Location:JobCenter.php?msg=No Carton ID'); 
}
?>

<style>
.div1 {
float: left;
}

.text {
  display: block;
  width: 100px;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
 

h5[title]:hover::after {
  content: attr(title);
  position: absolute;
  top: -90%;
  left: 0;
}

</style>
 



<div class="card m-3">
    <div class="card-body">
        <h3>
            <a class="btn btn-outline-primary me-3" href="JobCenter.php?ListType=<?=$ListType?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                </svg>
            </a>
            <svg width="35" height="35" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.9466 0.954198H21.0893C21.1115 0.883206 21.1344 0.812214 21.1344 0.733588C21.1344 0.329008 20.8046 0 20.3992 0C19.9939 0 19.6656 0.329008 19.6656 0.733588C19.6656 0.812977 19.687 0.883206 19.7107 0.954198H16.9015C16.9237 0.883206 16.9466 0.812214 16.9466 0.733588C16.9466 0.329008 16.6168 0 16.2114 0C15.8069 0 15.4771 0.329008 15.4771 0.733588C15.4771 0.812977 15.4992 0.883206 15.5229 0.954198H12.713C12.7351 0.883206 12.7573 0.812214 12.7573 0.733588C12.7565 0.329008 12.4282 0 12.0229 0C11.6176 0 11.2893 0.329008 11.2893 0.733588C11.2893 0.812977 11.3107 0.883206 11.3336 0.954198H8.52366C8.5458 0.883206 8.5687 0.812214 8.5687 0.733588C8.5687 0.329008 8.23969 0 7.83511 0C7.42977 0 7.10076 0.329008 7.10076 0.733588C7.10076 0.812977 7.12214 0.883206 7.14504 0.954198H4.33588C4.35878 0.883206 4.38092 0.812214 4.38092 0.733588C4.38092 0.329008 4.05267 0 3.64733 0C3.24198 0 2.91298 0.329008 2.91298 0.733588C2.91298 0.812977 2.93435 0.883206 2.95725 0.954198H2.09924C0.940458 0.954198 0 1.89542 0 3.05344V22.9008C0 24.0595 0.940458 25 2.09924 25H19.5763L24.0458 20.5305V3.05344C24.0458 1.89542 23.1053 0.954198 21.9466 0.954198ZM17.7603 3.25038L18.0389 4.16718C18.0702 4.27863 18.1092 4.41603 18.1313 4.51527H18.1435C18.1695 4.41603 18.2 4.27481 18.2267 4.16718L18.4557 3.25038H19.0779L18.6427 4.48015C18.3756 5.22214 18.1954 5.51908 17.987 5.70687C17.7832 5.88244 17.5695 5.94427 17.426 5.9626L17.3038 5.46947C17.3763 5.45725 17.4679 5.4229 17.5557 5.37023C17.6427 5.32366 17.7382 5.23206 17.7947 5.13664C17.8137 5.10992 17.826 5.07939 17.826 5.05343C17.826 5.03435 17.8214 5.00382 17.7992 4.95725L17.1153 3.24962L17.7603 3.25038ZM16.1962 3.25038L16.2145 3.59466H16.2305C16.326 3.32366 16.5557 3.2084 16.7344 3.2084C16.7878 3.2084 16.8145 3.2084 16.8565 3.21603V3.7626C16.8145 3.75496 16.7649 3.74656 16.7 3.74656C16.487 3.74656 16.3405 3.86107 16.3023 4.04122C16.2947 4.07939 16.2908 4.12519 16.2908 4.17176V5.11832H15.7099V3.86565C15.7099 3.59008 15.7023 3.41069 15.6947 3.24962L16.1962 3.25038ZM14.2336 3.60611C14.0427 3.60611 13.8389 3.67099 13.7176 3.74733L13.6092 3.37328C13.7397 3.30076 13.9954 3.20916 14.3344 3.20916C14.9573 3.20916 15.1557 3.57557 15.1557 4.01603V4.66489C15.1557 4.84504 15.1641 5.01679 15.1824 5.11985H14.6603L14.626 4.93359H14.6145C14.4924 5.08168 14.3015 5.1626 14.0794 5.1626C13.7023 5.1626 13.4756 4.88779 13.4756 4.58931C13.4756 4.10382 13.9122 3.87099 14.5733 3.87481V3.84809C14.574 3.74656 14.5198 3.60611 14.2336 3.60611ZM11.2718 3.25038H11.8565V4.25496C11.8565 4.52595 11.9443 4.69008 12.1473 4.69008C12.3076 4.69008 12.3992 4.57939 12.4374 4.48779C12.4534 4.45344 12.455 4.40763 12.455 4.36183V3.24962H13.0412V4.51832C13.0412 4.7626 13.0489 4.96107 13.0565 5.11756H12.5527L12.5267 4.8542H12.5153C12.4412 4.96794 12.2664 5.15954 11.9298 5.15954C11.5511 5.15954 11.2725 4.92214 11.2725 4.3458L11.2718 3.25038ZM9.43588 3.25038L9.4626 3.50687H9.47405C9.55115 3.38855 9.74198 3.2084 10.0511 3.2084C10.4328 3.2084 10.7198 3.46031 10.7198 4.01069V5.11832H10.1382V4.08397C10.1382 3.84351 10.055 3.67863 9.84427 3.67863C9.68397 3.67863 9.58779 3.79008 9.55038 3.89618C9.53435 3.93053 9.52672 3.98855 9.52672 4.04122V5.11832H8.94657V3.84656C8.94657 3.61298 8.93893 3.41527 8.93053 3.25038H9.43588ZM7.47023 3.60611C7.27863 3.60611 7.07634 3.67099 6.9542 3.74733L6.84733 3.37328C6.9771 3.30076 7.23282 3.20916 7.57252 3.20916C8.19466 3.20916 8.39389 3.57557 8.39389 4.01603V4.66489C8.39389 4.84504 8.40229 5.01679 8.42061 5.11985H7.89695L7.8626 4.93359H7.85114C7.72901 5.08168 7.5374 5.1626 7.31603 5.1626C6.9374 5.1626 6.71221 4.88779 6.71221 4.58931C6.71221 4.10382 7.14733 3.87099 7.80916 3.87481V3.84809C7.80992 3.74656 7.75649 3.60611 7.47023 3.60611ZM5.01832 4.62901C5.09847 4.65573 5.20153 4.67557 5.31679 4.67557C5.56107 4.67557 5.7145 4.56489 5.7145 4.16336V2.54351H6.29542V4.17176C6.29542 4.90534 5.94427 5.16107 5.37863 5.16107C5.24504 5.16107 5.06947 5.13817 4.95496 5.1L5.01832 4.62901ZM22.9008 20.0557L22.6634 20.2931H20.8656C20.0244 20.2931 19.3389 20.9786 19.3389 21.8198V23.6176L19.1015 23.855H2.09924C1.57328 23.855 1.14504 23.4267 1.14504 22.9008V6.87023H22.9008V20.0557Z" fill="black"></path>
            <path d="M7.28702 4.53059C7.28702 4.67944 7.38625 4.75196 7.51603 4.75196C7.66106 4.75196 7.78015 4.65654 7.81832 4.53899C7.82671 4.50769 7.82977 4.47334 7.82977 4.43899V4.23593C7.5229 4.23288 7.28702 4.3054 7.28702 4.53059Z" fill="black"></path>
            <path d="M14.0504 4.53059C14.0504 4.67944 14.1496 4.75196 14.2802 4.75196C14.4244 4.75196 14.5435 4.65654 14.5817 4.53899C14.5893 4.50769 14.5947 4.47334 14.5947 4.43899V4.23593C14.2878 4.23288 14.0504 4.3054 14.0504 4.53059Z" fill="black"></path>
            <path d="M11.5657 18.6274C10.468 18.6274 9.46948 18.2709 8.76032 17.8823L8.25269 19.8602C8.89467 20.2327 9.99391 20.5381 11.1267 20.5877V22.1938H12.7832V20.4701C14.7267 20.132 15.7916 18.8465 15.7916 17.3427C15.7916 15.8213 14.9809 14.8907 12.9702 14.1801C11.5321 13.6388 10.9412 13.2831 10.9412 12.7266C10.9412 12.2526 11.2947 11.7801 12.3939 11.7801C13.6107 11.7801 14.387 12.1686 14.8275 12.3549L15.3176 10.4449C14.7611 10.1747 13.9977 9.93807 12.8664 9.88693V8.3999H11.2107V10.0052C9.40154 10.3602 8.35498 11.5274 8.35498 13.0144C8.35498 14.6549 9.5878 15.5007 11.3977 16.1075C12.6473 16.5312 13.187 16.9365 13.187 17.5801C13.187 18.2556 12.5298 18.6274 11.5657 18.6274Z" fill="black"></path>
            </svg>&nbsp;&nbsp;
                Payment History 
        </h3>
    </div>
</div>


<?php 

    $Data=$Controller->QueryData("SELECT JobNo,CustName,ProductName ,FinalTotal FROM carton INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE CTNId=? LIMIT 50 ",[$_GET['CTNId']]);
    $Info = $Data->fetch_assoc(); 


?>

 <div class="row m-1    " >
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="card m-3 shadow" style = " border:2px solid #6610f2; border-radius:18px;" >
            <div class="card-body align-item-center" >
                <div class="div1 p-3" > 
                    <svg width="40" height="40" viewBox="0 0 736 736" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M728 250C732.4 250 736 246.4 736 242V182C736 177.6 732.4 174 728 174H564V8C564 3.6 560.4 0 556 0H492C487.6 0 484 3.6 484 8V174H256V8C256 3.6 252.4 0 248 0H184C179.6 0 176 3.6 176 8V174H8C3.6 174 0 177.6 0 182V242C0 246.4 3.6 250 8 250H176V486H8C3.6 486 0 489.6 0 494V554C0 558.4 3.6 562 8 562H176V728C176 732.4 179.6 736 184 736H248C252.4 736 256 732.4 256 728V562H484V728C484 732.4 487.6 736 492 736H556C560.4 736 564 732.4 564 728V562H728C732.4 562 736 558.4 736 554V494C736 489.6 732.4 486 728 486H564V250H728ZM484 486H256V250H484V486Z" fill="#6610f2"/>
                    </svg>
                </div>
                <div class="div1 ps-0 pt-2"> <h5 style = "margin:0px; padding:0px; font-weight:bold"><?= $Info['JobNo'];?></h5>
                    <p style = "margin:0px; padding:0px; " >Job No</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="card m-3 shadow" style = " border:2px solid #2EE377; border-radius:18px;" >
            <div class="card-body align-item-center" >
                <div class="div1 p-3" > 
                    <svg width="40" height="40" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M30 0C13.432 0 0 13.432 0 30C0 46.568 13.432 60 30 60C46.568 60 60 46.568 60 30C60 13.432 46.568 0 30 0ZM25.408 37.521C26.724 39.142 28.396 39.952 30.426 39.952C32.504 39.952 34.09 39.257 35.182 37.866C35.786 37.118 36.286 35.996 36.684 34.5H42.707C42.187 37.663 40.859 40.235 38.725 42.217C36.588 44.198 33.854 45.189 30.516 45.189C26.387 45.189 23.141 43.851 20.78 41.173C18.417 38.484 17.235 34.795 17.235 30.11C17.235 25.044 18.579 21.139 21.266 18.397C23.604 16.008 26.577 14.814 30.186 14.814C35.016 14.814 38.547 16.415 40.78 19.618C42.014 21.416 42.676 23.22 42.766 25.031H36.703C36.316 23.639 35.822 22.591 35.219 21.882C34.139 20.622 32.537 19.991 30.416 19.991C28.256 19.991 26.553 20.881 25.305 22.659C24.059 24.437 23.436 26.954 23.436 30.208C23.436 33.462 24.094 35.899 25.408 37.521" fill="#2EE377"/>
                    </svg>
                </div>
                <div class="div1 ps-0 pt-2"> <h5 style = "margin:0px; padding:0px; font-weight:bold" class = "text" title="(<?=$Info['CustName'];?>)"><?=$Info['CustName'];?></h5>
                    <p style = "margin:0px; padding:0px; " >Company</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="card m-3 shadow" style = " border:2px solid #C69666; border-radius:18px;" >
            <div class="card-body align-item-center" >
                <div class="div1 p-3" > 
                    <svg width="40" height="40" viewBox="0 0 408 424" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M300.138 17.931H247.172V0.276001H158.896V17.931H34.869C15.36 17.931 0 33.741 0 53.241V388.69C0 408.19 15.36 424 34.869 424H370.759C390.259 424 406.069 408.19 406.069 388.69V123.862C406.069 17.931 424.5 17.931 300.138 17.931Z" fill="#C69666"/>
                    <path d="M234.221 113.5L203.033 88.553L171.845 113.5C166.628 117.675 158.895 113.959 158.895 107.277V0.278015H247.171V107.277C247.171 113.959 239.438 117.676 234.221 113.5Z" fill="#E8D5B2"/>
                    <path d="M52.9668 388.69H176.553V282.759H52.9668V388.69Z" fill="#E8D5B2"/>
                    <path d="M141.24 326.897H88.2753C83.4023 326.897 79.4473 322.942 79.4473 318.069C79.4473 313.196 83.4023 309.241 88.2753 309.241H141.241C146.114 309.241 150.069 313.196 150.069 318.069C150.069 322.942 146.113 326.897 141.24 326.897Z" fill="#CBB292"/>
                    <path d="M123.585 362.207H88.2753C83.4023 362.207 79.4473 358.252 79.4473 353.379C79.4473 348.506 83.4023 344.551 88.2753 344.551H123.585C128.458 344.551 132.413 348.506 132.413 353.379C132.413 358.252 128.458 362.207 123.585 362.207Z" fill="#CBB292"/>
                </svg>

                </div>
                <div class="div1 ps-0 pt-2"> <h5 style = "margin:0px; padding:0px; font-weight:bold "  class = "text" title="( <?=$Info['ProductName'];?> )"> <?= $Info['ProductName'];?></h5>
                    <p style = "margin:0px; padding:0px; " >Product Name</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
        <div class="card m-3 shadow" style = " border:2px solid #0dcaf0; border-radius:18px;" >
            <div class="card-body align-item-center" >
                <div class="div1 p-3" > 
                <svg width="40" height="40" viewBox="0 0 498 498" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g filter="url(#filter0_d_1234_13)">
                    <path d="M221.1 158.3C217.1 163.7 215.1 169.8 215.1 176.3C215.1 182.3 216.9 187.9 220.5 193.1C224.1 198.3 229.6 202.4 237 205.6V146.7C230.4 149 225.1 152.9 221.1 158.3Z" fill="#0dcaf0"/>
                    <path d="M313.6 339.5C301.2 353.6 283.9 362.2 261.8 365.4V397.2H237.1V366.2C217.5 363.8 201.5 356.5 189.3 344.3C177.1 332.1 169.2 314.8 165.8 292.4L210.2 287.6C212 296.7 215.4 304.5 220.4 311.1C225.4 317.7 230.9 322.4 237.1 325.4V254.1C214.9 247.7 198.6 238.1 188.2 225.3C177.8 212.4 172.6 196.8 172.6 178.4C172.6 159.8 178.5 144.2 190.2 131.5C201.9 118.9 217.6 111.6 237.1 109.6V92.8H261.8V109.6C279.8 111.8 294.2 117.9 304.8 128.1C315.5 138.3 322.3 151.8 325.2 168.8L282.2 174.4C279.6 161 272.8 151.9 261.8 147.2V213.7C289 221.1 307.6 230.6 317.4 242.4C327.3 254.1 332.2 269.2 332.2 287.6C332.2 308.1 326 325.4 313.6 339.5ZM249 0C113.9 0 4 109.9 4 245C4 380.1 113.9 490 249 490C384.1 490 494 380.1 494 245C494 109.9 384.1 0 249 0Z" fill="#0dcaf0"/>
                    <path d="M261.801 261.4V327.8C270.301 326.2 277.201 322.3 282.601 316C287.901 309.7 290.601 302.3 290.601 293.8C290.601 286.2 288.401 279.7 283.901 274.1C279.301 268.6 272.001 264.4 261.801 261.4Z" fill="#0dcaf0"/>
                    </g>
                    <defs>
                    <filter id="filter0_d_1234_13" x="0" y="0" width="498" height="498" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                    <feOffset dy="4"/>
                    <feGaussianBlur stdDeviation="2"/>
                    <feComposite in2="hardAlpha" operator="out"/>
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_1234_13"/>
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_1234_13" result="shape"/>
                    </filter>
                    </defs>
                </svg>


                </div>
                <div class="div1 ps-0 pt-2"> <h5 style = "margin:0px; padding:0px; font-weight:bold"><?= number_format($Info['FinalTotal']);?></h5>
                    <p style = "margin:0px; padding:0px; " >Total Amount</p>
                </div>
            </div>
        </div>
    </div>

    
 </div>
 
 




<div class="card m-3 shadow">
    <div class="card-body">
        <table class="table">
            <tr class="table-info ">
                <th  >RecieptNo</th>
                <th  >Received Date</th>
                <th title="Received Amount" class="text-center">Received.Amt</th>
                <th title="Remain Amount" class="text-center">Remain.Amt</th>
                <th class="text-end">Recieved By</th>
                <th class="text-end">Comment</th>
               
            </tr>       
            <?php
                $RecievedAmount=0;$RemainingAmount=0;
                while($Rows=$DataRows->fetch_assoc())
                {

                    $RecievedAmount=$RecievedAmount+$Rows['RAmount']; $RemainingAmount=$Rows['FinalTotal']-$RecievedAmount; 
                    
            ?>
            <input type="hidden" name="CustName" value = "<?=$Rows['CustName']?>">  
            <input type="hidden" name="ProductName" value = "<?=$Rows['ProductName']?>">  
            <input type="hidden" name="JobNo" value = "<?=$Rows['JobNo']?>">  
            <input type="hidden" name="FinalTotal" value = "<?=number_format($Rows['FinalTotal'] ,2) ;?>">  
                    <tr> 
                        <td  ><?=$Rows['RVocherNo']?></td> 
                        <td  ><?=$Rows['RDate'];?></td>
                        <td class="text-center"><?=number_format($Rows['RAmount'],2); ?><span class="badge bg-warning " ><?=$Rows['CtnCurrency']?></span></td>
                        <td class="text-center"><?=number_format($RemainingAmount ,2 );  ?></td>
                        <td class="text-end"><?=$Rows['Ename']?></td>
                        <td class="text-end"><?=$Rows['RComment']?></td>
                     
                    </tr>
                    
            <?php 
                } 
            ?>  
                    <tr>
                        <td class="fw-bolder text-center" colspan="2">Total</td>
                        <td class="fw-bolder text-center" colspan="1"  style=""><?=$RecievedAmount;?></td>
                        <td class="fw-bolder text-center" colspan="1"><?=$RemainingAmount;?></td>
                        <td></td>
                        <td></td>
                    </tr>         
        </table>
    </div>
</div>
<?php  require_once '../App/partials//Footer.inc'; ?>