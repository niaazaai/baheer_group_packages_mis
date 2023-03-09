<?php ob_start(); 
require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; 


$Gate = require_once  $ROOT_DIR . '/Auth/Gates/HOMEPAGE';
if(!in_array( $Gate['VIEW_PRICE_SETTING_PAGE'] , $_SESSION['ACCESS_LIST']  )) {
    header("Location:index.php?msg=You are not authorized to access this page!" );
  }


if (isset($_POST['Name']) && !empty($_POST['Name'])) 
{
    if (isset($_POST[$_POST['Name']])  && !empty($_POST[$_POST['Name']])) 
    {
       
        $_POST[$_POST['Name']] = $Controller->CleanInput($_POST[$_POST['Name']]);
        $_POST['Name']= $Controller->CleanInput($_POST['Name']);
        $_POST['OldPrice']  = $Controller->CleanInput($_POST['OldPrice']);

        if ($_POST['Name'] == 'ExchangeRate' || $_POST['Name'] == 'PaperGSM'  || $_POST['Name'] == 'PolimerPrice') {
            $SPU =  $Controller->QueryData("UPDATE paperprice  SET " . $_POST['Name'] . " = ? ", [ $_POST[$_POST['Name']]   ]) ;
        } else {
            $SPU =  $Controller->QueryData("UPDATE paperprice  SET Price = ? WHERE Name = ? ", [ $_POST[$_POST['Name']] , $_POST['Name'] ]);
        }


        $SetPriceHistory =  $Controller->QueryData("INSERT INTO set_price_history (name ,  old_value , new_value , by_who , by_who_id )
                VALUE (? ,? ,? ,?, ?)", [ $_POST['Name']  , (int) $_POST['OldPrice'] , (int)$_POST[$_POST['Name']] , $_SESSION['user'] , (int)$_SESSION['EId']  ]);
        if (!$SetPriceHistory) {
            die('Set History Not Working!');
        }

        if ($SPU) {
            $_SESSION['msg']= $_POST['Name'] . ' Price Updated!';
        }
    }
}

    $PP =  $Controller->QueryData("SELECT DISTINCT Name,Price,ExchangeRate,PaperGSM,PolimerPrice FROM paperprice" , [] );
    $PaperPrice = []; 
    while($PaperPriceDB = $PP->fetch_assoc())
    {
        $PaperPrice[$PaperPriceDB['Name']] = $PaperPriceDB['Price'];
        $PaperPrice['PaperGSM'] = $PaperPriceDB['PaperGSM'];
        $PaperPrice['PolimerPrice'] = $PaperPriceDB['PolimerPrice'];
        $PaperPrice['ExchangeRate'] = $PaperPriceDB['ExchangeRate'];
    } // LOOP 

    $inactive = 20; 
    if (isset($_SESSION['msg_time']) && (time() - $_SESSION['msg_time'] > $inactive))   unset($_SESSION['msg']);      
    $_SESSION['msg_time'] = time(); // Update session
?>


<style>
    .form-border {
        border-radius:0px; 
        border:2px solid black; 
        /* border-right:1px solid black;  */
    }
</style>

<div class="card m-3">
    <div class="card-body">
        <a class="btn btn-outline-primary me-3" href="SetPriceDashboard.php">
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
            </svg>
        </a>
    </div>
</div>


<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <?php if(isset( $_SESSION['msg'])) {    ?>
        <div class="alert alert-success alert-dismissible fade show shadow" role="alert">
            <strong>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-info-circle" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>  Information</strong> <?= $_SESSION['msg'] ?>
                            
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php } ?>
</div>


<div class="card m-3 ">
    <div class="card-body d-flex justify-content-between">
        <h4 class = "my-2" > 
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-tags" viewBox="0 0 16 16">
                <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z"/>
                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z"/>
            </svg>
            Price Setting   <span style= "color:#FA8b09; font-size:12px;" >    </span>     
        </h4>
        <div>
        <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
            </svg>
        </a>
        <a  class="btn btn-outline-primary  my-1 "  href= "SetPriceHistory.php"     title = "Click to check history  ">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-hourglass-split" viewBox="0 0 16 16">
            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z"/>
            </svg>
            History
        </a>
        </div>
    </div>
</div>

        
    <div class="card m-3 shadow" style = "font-family: Roboto,sans-serif;">
    <div class="card-body">
        <div class="row justify-content-center">
                <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" > 
                    
                    <div class="form-floating">
                        <input type="text" class="form-control fw-bold form-control-sm form-border" 
                        name = "Flute"  onchange = "this.form.submit();"  value = "<?=$PaperPrice['Flute']; ?>" id="Flute" >
                        <label for="Flute" style = "font-weight:bold;">Flute</label>
                        <input type="hidden" name = "Name" value = "Flute" >
                        <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['Flute']; ?>" >
                        <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                    </div>
                    </form>
                </div>

            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                <div class="form-floating"  >
                    <input type="text" class="form-control fw-bold  form-control-sm form-border" name = "WTL"   onchange = "this.form.submit();" value = "<?=$PaperPrice['WTL']; ?>" id="WTL" >
                    <label for="WTL" style = "font-weight:bold;">WTL</label>
                    <input type="hidden" name = "Name" value = "WTL" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['WTL']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </div>
                </form>
            </div>



            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                <div class="form-floating"  >
                    <input type="text" class="form-control fw-bold  form-control-sm form-border" name = "KLB"  onchange = "this.form.submit();" value = "<?=$PaperPrice['KLB']; ?>" id="KLB" >
                    <label for="KLB" style = "font-weight:bold;">KLB</label>
                    <input type="hidden" name = "Name" value = "KLB" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['KLB']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </div>
                </form>
            </div>

        
            
            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control fw-bold  form-control-sm form-border" name = "BB"  onchange = "this.form.submit();" value = "<?=$PaperPrice['BB']; ?>" id="BB" >
                        <label for="BB" style = "font-weight:bold;">Box Board</label>
                        <input type="hidden" name = "Name" value = "BB" >
                        <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['BB']; ?>" >
                        <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                    </div>
                </form>
            </div>

        
            <div class="col-xxl-3 col-xl-3 col-lg-2 col-md-2 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control  fw-bold  form-control-sm form-border" name = "WTKL"  onchange = "this.form.submit();" value = "<?=$PaperPrice['WTKL']; ?>" id="WTKL" >
                        <label for="WTKL" style = "font-weight:bold;">WTKL</label>
                    </div>
                    <input type="hidden" name = "Name" value = "WTKL" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['WTKL']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </form> 
            </div>
        </div>
               
    
        <div class="row mt-4 justify-content-center">
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control fw-bold  form-control-sm form-border" name = "TL"  onchange = "this.form.submit();" value = "<?=$PaperPrice['TL']; ?>" id="TL" >
                        <label for="TL" style = "font-weight:bold;">TL</label>
                    </div>
                    <input type="hidden" name = "Name" value = "TL" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['TL']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                    
                </form> 
            </div>

            <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control  fw-bold form-control-sm  form-border" name = "Liner"  onchange = "this.form.submit();" value = "<?=$PaperPrice['Liner']; ?>" id="Liner" >
                        <label for="Liner" style = "font-weight:bold;">Liner</label>
                    </div>
                    <input type="hidden" name = "Name" value = "Liner" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['Liner']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </form>          
            </div>

            <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control  fw-bold form-control-sm  form-border" name = "ExchangeRate"  onchange = "this.form.submit();" value = "<?=$PaperPrice['ExchangeRate']; ?>" id="ExchangeRate" >
                        <label for="ExchangeRate" style = "font-weight:bold;">Exchange Rate</label>
                    </div>
                    <input type="hidden" name = "Name" value = "ExchangeRate" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['ExchangeRate']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </form> 
            </div>

            
            <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control fw-bold form-control-sm  form-border" name = "PaperGSM"  onchange = "this.form.submit();" value = "<?=$PaperPrice['PaperGSM']; ?>" id="PaperGSM" >
                        <label for="PaperGSM" style = "font-weight:bold;">Paper GSM</label>
                    </div>
                    <input type="hidden" name = "Name" value = "PaperGSM" >
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['PaperGSM']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </form> 
            </div>

            
            <div class="col-xxl-3 col-xl-3 col-lg-4 col-md-4 col-sm-6 col-xs-12 ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="form-floating"  >
                        <input type="text" class="form-control fw-bold form-control-sm  form-border" name = "PolimerPrice"  onchange = "this.form.submit();" value = "<?=$PaperPrice['PolimerPrice']; ?>" id="PolimerPrice" >
                        <label for="PolimerPrice" style = "font-weight:bold;">Polymer Price</label>
                    </div>
                    <input type="hidden" name = "Name" value = "PolimerPrice" > 
                    <input type="hidden" name = "OldPrice" value = "<?=$PaperPrice['PolimerPrice']; ?>" >
                    <input type="hidden" name="form_token" value = "<?=$form_token;?>" >
                </form> 
            </div>
        </div>
    </div>
    </div>

<?php require_once '../App/partials/footer.inc'; ?>