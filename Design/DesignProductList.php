<?php require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; ?>
<?php 
        $ListType="ProductList";
        $SQL="SELECT DISTINCT `CTNId`,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size ,`CTNOrderDate`, `CTNStatus`, `CTNQTY`,`ProductName`,
              CTNPaper, CTNColor, JobNo, Note, `Ctnp1`, `Ctnp2`, `Ctnp3`, `Ctnp4`,
                                `Ctnp5`, `Ctnp6`, `Ctnp7` ,offesetp, DesignImage , designinfo.DesignCode1 FROM `carton` 
                                INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo 
              ON designinfo.CaId=carton.CTNId   where CTNStatus NOT IN  ('Cancel','FConfirm','DesignProcess', 'New' ) order by CTNOrderDate DESC";
              
        $DataRows=$Controller->QueryData($SQL,[]);


?>




<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <?php if(   isset($msg)    &&   !empty($msg)     ) {    ?>
            <div class="alert alert-danger  alert-dismissible fade show shadow" role="alert">
                <strong>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>  
                
                Information</strong> <?= $msg[0] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php } ?>
</div>





<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between  align-middle   ">
    
        <h3  class = "m-0 p-0  " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg>
            Design Department Product List 
        </h3>
        <div  class = "my-1"> <!--Button trigger modal div-->
            <a href="Manual/CustomerRegistrationForm_Manual.php" class="text-primary me-2  " style = "margin-top:10px;"  title="Click to Read the User Guide ">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
	    </div><!-- Button trigger modal div end -->

    </div>
</div> 



 


<div class="card m-3">
    <div class="card-body">

        <table class= "table " id = "JobTable" >
            <thead>
                <tr class="table-info">
                    <th>#</th>
                    <th title="Order Date">O.Date</th>
                    <th title="Quotation No">Q.No</th>
                    <th>JobNo</th>
                    <th title="Company Name">C.Name</th> 
                    <th title="Product Name">P.Name</th>
                    <th>Size (LxWxH) cm</th>
                    <th>Color</th>
                    <th>Paper</th>
                    <th>Offset</th>
                    <th>Type</th>
                    <th title="Order QTY">O.QTY</th>
                    <th title="Design Code">D.Code</th>
                    <!-- <th>Status</th> -->
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $Counter=1; 
                    while($Rows=$DataRows->fetch_assoc())
                    {
                        if($Rows['DesignCode1']=='')
                        {
 
                ?>  
                        <tr>
                            <td><?=$Counter?></td>
                            <td><?=$Rows['CTNOrderDate']?></td>
                            <td><?=$Rows['CTNId']?></td>
                            <td><?=$Rows['JobNo']?></td>
                            <td><?=$Rows['CustName']?></td>
                            <td><?=$Rows['ProductName']?></td>
                            <td><?=$Rows['Size']?></td>
                            <td><?=$Rows['CTNColor']?></td>
                            <td>
                                <?php 
                                    $arr = []; 
                                    for ($index=1; $index <= 7 ; $index++) 
                                    { 
                                        if(empty($Rows['Ctnp'.$index])) continue; 
                                        $arr[] = $Rows['Ctnp'.$index];   
                                    } 
                                    $arr = array_count_values($arr);
                                    foreach ($arr as $key => $value) {
                                        if(trim($key) === 'Flute') echo $value . " " . $key ;
                                        else  echo $key ; 
                                        if ($key === array_key_last($arr)) continue ; 
                                        echo " x ";  
                                    }
                                ?>
                            </td>
                            <td><?=$Rows['offesetp']?></td>
                            <td><?=$Rows['CTNUnit']?></td>
                            <td><?=number_format($Rows['CTNQTY'])?></td> 
                            
                            <td class = "align-item-center <?php if(isset($Rows['DesignCode1'])) echo 'bg-danger'?>">
                            <?php 
                                if(empty($Rows['DesignCode1'])) 
                                {    
                                    echo '<span class = "text-danger" >N/A</span>';
                                } 
                            ?>
                            </td>
  
                            <!-- <td><?=$Rows['CTNStatus']?></td> -->
                            <td>
                                <a class="btn  "  href="DesignManage.php?CTNId=<?=$Rows['CTNId']?>&ListType=<?=$ListType?>"> 
                                    <svg width="24" height="30" viewBox="0 0 368 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M364.232 282.174L343.855 267.076C346.18 251.392 346.198 235.626 343.906 220.08L364.232 205.019C367.188 202.829 368.274 198.908 366.866 195.51L347.231 148.109C345.823 144.71 342.279 142.704 338.645 143.248L313.623 146.971C304.25 134.358 293.091 123.223 280.354 113.775L284.088 88.689C284.629 85.05 282.625 81.51 279.227 80.103L231.826 60.47C228.428 59.062 224.506 60.148 222.317 63.104L217.409 69.727V25.119C217.408 11.268 206.14 0 192.289 0H175.187C161.336 0 150.068 11.268 150.068 25.119V69.726L145.16 63.102C142.971 60.146 139.05 59.061 135.651 60.468L88.25 80.101C84.851 81.509 82.847 85.049 83.389 88.687L87.112 113.71C74.5 123.083 63.365 134.241 53.918 146.978L28.832 143.245C25.192 142.702 21.653 144.708 20.246 148.106L0.611005 195.507C-0.796995 198.906 0.289008 202.827 3.24501 205.016L23.622 220.114C21.297 235.798 21.28 251.564 23.571 267.11L3.24501 282.171C0.289008 284.361 -0.796995 288.282 0.611005 291.68L20.246 339.082C21.654 342.481 25.198 344.486 28.832 343.943L53.855 340.22C63.228 352.833 74.386 363.968 87.123 373.416L83.389 398.502C82.848 402.14 84.852 405.681 88.25 407.088L135.651 426.723C139.05 428.131 142.971 427.045 145.16 424.089L150.068 417.465V418.47C150.068 419.25 150.181 420.026 150.406 420.773L176.059 506.285C177.077 509.677 180.198 512 183.738 512C187.278 512 190.399 509.677 191.417 506.287L217.07 420.775C217.294 420.028 217.408 419.252 217.408 418.472V417.467L222.316 424.091C223.864 426.181 226.277 427.336 228.759 427.336C229.787 427.336 230.828 427.137 231.825 426.726L279.226 407.091C282.625 405.683 284.629 402.143 284.087 398.505L280.364 373.482C292.977 364.109 304.113 352.949 313.56 340.214L338.645 343.947C342.285 344.49 345.824 342.484 347.231 339.086L366.865 291.685C368.274 288.285 367.188 284.364 364.232 282.174ZM166.101 25.119C166.101 20.109 170.177 16.033 175.187 16.033H192.289C197.299 16.033 201.375 20.109 201.375 25.119V42.756H166.102V25.119H166.101ZM166.101 58.789H201.374V82.723C189.597 81.408 177.797 81.392 166.101 82.674V58.789V58.789ZM150.068 303.75C136.658 296.224 125.986 284.329 120.043 269.98C106.543 237.388 119.996 200.257 150.068 183.45V303.75ZM183.738 476.084L168.859 426.488H198.616L183.738 476.084ZM201.375 410.455H166.102V176.963C177.939 173.823 190.069 173.981 201.375 176.989V410.455ZM151.219 165.088C107.929 183.02 87.299 232.827 105.23 276.116C113.678 296.514 129.88 312.887 150.068 321.616V341.098C122.094 331.489 99.891 310.713 88.442 283.07C66.677 230.523 91.719 170.065 144.266 148.301C196.813 126.536 257.269 151.577 279.035 204.124C289.579 229.579 289.579 257.616 279.035 283.07C268.491 308.525 248.667 328.349 223.212 338.894C221.303 339.684 219.363 340.407 217.409 341.083V321.596H217.408C237.82 312.794 253.721 296.698 262.247 276.117C270.933 255.146 270.933 232.049 262.247 211.078C244.315 167.789 194.509 147.159 151.219 165.088ZM217.408 303.749V183.489C230.473 190.79 241.275 202.345 247.433 217.214C254.48 234.228 254.48 252.967 247.433 269.981C241.429 284.476 230.909 296.225 217.408 303.749ZM334.814 327.167L311.083 323.636C308.068 323.187 305.062 324.486 303.322 326.987C293.402 341.246 281.227 353.446 267.137 363.248C264.636 364.988 263.337 367.995 263.786 371.009L267.307 394.674L231.471 409.518L217.408 390.536V357.93C221.447 356.734 225.447 355.322 229.346 353.707C258.758 341.525 281.664 318.617 293.846 289.207C306.028 259.796 306.028 227.4 293.846 197.99C268.697 137.276 198.841 108.342 138.127 133.49C77.413 158.638 48.478 228.493 73.626 289.209C87.563 322.857 115.285 347.701 150.066 357.926V390.539L136.001 409.52L100.165 394.676L103.697 370.946C104.145 367.933 102.847 364.925 100.346 363.185C86.087 353.263 73.887 341.089 64.085 327C62.345 324.499 59.338 323.199 56.324 323.649L32.659 327.17L17.815 291.334L37.038 277.091C39.487 275.277 40.695 272.232 40.156 269.232C37.125 252.338 37.142 235.102 40.209 218.005C40.747 215.006 39.54 211.961 37.091 210.148L17.813 195.864L32.657 160.028L56.387 163.559C59.4 164.007 62.407 162.709 64.147 160.209C74.07 145.949 86.244 133.749 100.332 123.948C102.833 122.209 104.132 119.201 103.683 116.188L100.162 92.523L135.998 77.679L150.242 96.903C152.056 99.352 155.099 100.559 158.099 100.021C174.991 96.99 192.226 97.007 209.326 100.074C212.323 100.612 215.368 99.404 217.182 96.956L231.466 77.678L267.302 92.522L263.77 116.254C263.322 119.267 264.62 122.274 267.121 124.014C281.381 133.936 293.58 146.11 303.382 160.199C305.122 162.7 308.131 164.001 311.143 163.55L334.808 160.029L349.652 195.864L330.429 210.108C327.98 211.922 326.772 214.966 327.311 217.965C330.342 234.86 330.325 252.095 327.258 269.192C326.72 272.191 327.927 275.236 330.376 277.049L349.653 291.333L334.814 327.167Z" fill="#027ACD"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                <?php 
                        }
                    $Counter++;  
                    }
                ?>
            </tbody>
        </table>

    </div>
</div>

<?php  require_once '../App/partials/Footer.inc'; ?>

