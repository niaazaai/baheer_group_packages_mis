<?php require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; ?>
<?php 
        $ListType="ArchiveProductList";
        $SQL="SELECT DISTINCT CTNId,ppcustomer.CustName, CTNUnit, CONCAT( FORMAT(CTNLength / 10 ,1 ) , ' x ' , FORMAT ( CTNWidth / 10 , 1 ), ' x ', FORMAT(CTNHeight/ 10,1) ) AS Size , carton.CustId1,  
        CTNStatus,CTNQTY,DieId,PolyId ,carton.ProductName,carton.CTNColor, DesignImage ,designinfo.DesignCode1,cdie.DieCode,cdie.CDSampleNo,cpolymer.CPNumber,cpolymer.CartSample FROM carton  INNER JOIN ppcustomer ON 
        ppcustomer.CustId=carton.CustId1 LEFT OUTER JOIN designinfo ON designinfo.CaId=carton.CTNId LEFT OUTER JOIN cdie ON cdie.CDieId=carton.DieId LEFT OUTER JOIN cpolymer ON cpolymer.CPid=carton.PolyId  
        where CTNStatus!='New' order by CTNOrderDate DESC";             
        $DataRows=$Controller->QueryData($SQL,[]);
 
?>
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <?php if(   isset($msg)    &&   !empty($msg)  ) {    ?>
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
    <div class="card-body d-flex justify-content-between  align-middle">
       
        <h3  class = "m-0 p-0  " > 
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-box" viewBox="0 0 16 16">
                    <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
            </svg>
            Archive Department Product List 
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
                    <th title="Company Name">C.Name</th> 
                    <th title="Product Name">P.Name</th>
                    <th>Size (LxWxH) cm</th>
                    <th>Color</th>  
                    <th title="Design Code">D.Code</th>
                    <th> Poly.No</th>
                    <th title="Sample No">S.No</th>
                    <th>Die.Code</th>
                    <th title="Sample No">S.No</th>          
                    <!-- <th>Status</th> -->
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $Counter=1; 
                    while($Rows=$DataRows->fetch_assoc())
                    {
                         
                        if($Rows['CPNumber']=='' || $Rows['CartSample']=='' || $Rows['DieCode']=='' || $Rows['CDSampleNo']=='' )
                        {    
                ?>  
                            <tr>
                                <td><?=$Counter?></td> 
                                <td><?=$Rows['CustName']?></td>
                                <td><?=$Rows['ProductName']?></td>
                                <td><?=$Rows['Size']?></td>
                                <td><?=$Rows['CTNColor']?></td> 
                                <td class = " align-item-center ">        
                                    <?php if(isset($Rows['DesignCode1']) && !empty($Rows['DesignCode1']) )  { ?>
                                        <a class = " " style ="text-decoration:none;" target = "_blank" title = "Click To Show Design Image"  
                                            href="ShowDesignImage.php?Url=<?= $Rows['DesignImage']?>&ProductName=<?= $Rows['ProductName']?>" >
                                    <?php   echo '<span class = "text-success" >'. $Rows['DesignCode1'] . '</span>';  ?>  
                                        </a>
                                    <?php }  else {
                                        echo '<span class = "text-danger" >N/A</span>';
                                    } ?>
                                </td> 
                                <td>
                                    <?php
                                        if($Rows['CPNumber']=='')
                                        {?>
                                            <svg style="color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                            </svg>
                                        <?php 
                                        }
                                        else
                                        { 
                                            echo $Rows['CPNumber']; 
                                        }                 
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($Rows['CartSample']=='')
                                        {?>
                                            <svg style="color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                            </svg>
                                        <?php 
                                        }
                                        else
                                        {
                                            echo $Rows['CartSample'];
                                        } 
                                    ?>
                                </td>
                                <td>
                                    <?php 
                                        if($Rows['DieCode']=='')
                                        {?>
                                            <svg style="color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                            </svg>
                                        <?php 
                                        }
                                        else
                                        {
                                            echo $Rows['DieCode'];
                                        } 
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($Rows['CDSampleNo']=='')
                                        {?>
                                            <svg style="color:red" xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                                            </svg>
                                        <?php 
                                        }
                                        else
                                        { 
                                            echo $Rows['CDSampleNo']; 
                                        }              
                                    ?>
                                </td>
                                <!-- <td><?=$Rows['CTNStatus']?></td> -->
                                <td>
                                    <?php 
                                        if($Rows['CPNumber']=='' || $Rows['CartSample']=='')
                                        {?>
                                            <a class="text-primary m-1" href="CreatePolymer.php?CTNId=<?=$Rows['CTNId']?>&CustId=<?=$Rows['CustId1']?>&ListType=<?=$ListType?>">  
                                                <svg width="30" height="30" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"></path>
                                                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"></path>
                                                    <path d="M188 363V149H270.267C286.084 149 299.556 152.1 310.69 158.3C321.82 164.43 330.306 172.963 336.144 183.9C342.049 194.767 345 207.306 345 221.518C345 235.729 342.013 248.267 336.04 259.135C330.067 270.002 321.414 278.466 310.077 284.526C298.811 290.587 285.168 293.617 269.148 293.617H216.711V257.358H262.02C270.506 257.358 277.499 255.861 282.994 252.865C288.561 249.8 292.702 245.586 295.418 240.222C298.198 234.788 299.592 228.553 299.592 221.518C299.592 214.412 298.198 208.212 295.418 202.918C292.702 197.554 288.561 193.409 282.994 190.483C277.431 187.488 270.371 185.99 261.817 185.99H232.086V363H188Z" fill="#B3404A"></path>
                                                </svg>
                                            </a>
                                        <?php
                                        }
                                        if($Rows['DieCode']=='' || $Rows['CDSampleNo']=='')
                                        {?>
                                             <a class="text-primary m-1" href="CreateDie.php?CTNId=<?=$Rows['CTNId']?>&CustId=<?=$Rows['CustId1']?>&ListType=<?=$ListType?>">  
                                                <svg width="30" height="30" viewBox="0 0 512 512" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M496.105 512H15.895C7.118 512 0 504.884 0 496.105C0 487.326 7.118 480.21 15.895 480.21H480.21V31.79H31.79V398.825C31.79 407.604 24.672 414.72 15.895 414.72C7.118 414.72 0 407.605 0 398.826V15.895C0 7.116 7.118 0 15.895 0H496.105C504.882 0 512 7.116 512 15.895V496.105C512 504.884 504.884 512 496.105 512Z" fill="#B3404A"></path>
                                                    <path d="M426.08 441.975H85.922C77.145 441.975 70.027 434.859 70.027 426.08V85.9199C70.027 77.1409 77.145 70.0249 85.922 70.0249H426.08C434.857 70.0249 441.975 77.1409 441.975 85.9199C441.975 94.6989 434.857 101.815 426.08 101.815H101.817V410.184H410.185V154.829C410.185 146.05 417.303 138.934 426.08 138.934C434.857 138.934 441.975 146.05 441.975 154.829V426.08C441.975 434.859 434.857 441.975 426.08 441.975Z" fill="#B3404A"></path>
                                                    <path d="M242.307 366H164.963V147.818H242.946C264.892 147.818 283.784 152.186 299.622 160.922C315.46 169.587 327.641 182.051 336.163 198.315C344.757 214.58 349.054 234.04 349.054 256.696C349.054 279.423 344.757 298.955 336.163 315.29C327.641 331.625 315.389 344.161 299.409 352.896C283.5 361.632 264.466 366 242.307 366ZM211.092 326.476H240.389C254.026 326.476 265.496 324.061 274.8 319.232C284.175 314.331 291.206 306.767 295.893 296.54C300.652 286.241 303.031 272.96 303.031 256.696C303.031 240.574 300.652 227.399 295.893 217.172C291.206 206.945 284.21 199.416 274.906 194.587C265.602 189.757 254.132 187.342 240.496 187.342H211.092V326.476Z" fill="#B3404A"></path>
                                                </svg>
                                            </a>
                                        <?php
                                        }
                                    ?> 
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

