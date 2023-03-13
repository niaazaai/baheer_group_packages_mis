<?php 
    require_once 'Controller.php'; 

    class QuotationController {

        private $Controller ; 

        public function  __construct( $Controller){
            $this->Controller = $Controller ; 
        }

        public function CreateQuotation($request , $Status = "New"){  
          

            foreach ($request as $key => $value) {
                $request[$key] = $this->Controller->CleanInput($value); 
            }
 
            if(!isset($request['JobNo'] ) ||  empty($request['JobNo']) ) {
                $request['JobNo'] = "NULL";
            }
            
            // if the record is job it will activate customer and conditon to working  
            if($request['JobNo'] != 'NULL'){
                $QuotationRows = $this->Controller->QueryData("UPDATE ppcustomer SET CusStatus = ? , PPCondition = ? WHERE CustId = ?" , 
                ['Active' , 'Working' , $request['CustomerId'] ]); 
            }

            if(isset($request['CartonQTY'] )   ) {
                $request['CartonQTY'] = str_replace(",","", $request['CartonQTY']); 
            }
            if(isset($request['TotalPrice'] ) ) {
                $request['TotalPrice'] = str_replace(",","", $request['TotalPrice']); 
            }
            
            if($request['JobNo'] == 'NULL' && (isset($request['RorderAndPrint']) || isset($request['Rorder']) ) )   $Status = 'New';              
            else if($request['JobNo'] != 'NULL' && (isset($request['RorderAndPrint']) || isset($request['Rorder']) ))  $Status = 'FNew';    
            else if($request['JobNo'] == 'NULL' && isset($request['RorderToDesign'])) $Status = 'Design';              
            else if($request['JobNo'] != 'NULL' && isset($request['RorderToDesign'])) {  header("Location:QuotationEdit.php?CTNId=". $request['CTNId'] ."&msg='Please Remove Job Number'&Page=". $_POST['Page']  );  }                   
            // else { header("Location:Quotation.php?CustId=". $request['CustomerId'] ." &CTNId=". $request['CTNId'] ."&msg='JobNo is not set correctly'&Page=". $_POST['Page']  );}

            // this part is used for design notification
            if($Status == 'Design') {
                $alert_comment = 'Please check new quotation arrived'; 
                $user = $this->Controller->QueryData("SELECT user_id FROM alert_access_list WHERE department = 'Design' AND notification_type = 'NEW-JOB'" , []);
                if($user->num_rows > 0 ) {
                    $user_id  =  $user->fetch_assoc()['user_id'];
                    $this->Controller->QueryData("INSERT INTO alert (department,user_id,title,alert_comment, `type`) 
                    VALUES ('Design',?,'New Job',?,'NEW-JOB')" , [$user_id,$alert_comment]);
                }
            }// END OF DESIGN 


            $CheckBoxs = [ 
                'CSlotted' => 'SLOTTED' ,
                'CDieCut' => 'DIE CUT' , 
                'CPasting' => 'PASTING' ,
                'CStitching' => 'STITCHING' ,
                'flexop' =>  'FLEXO P' , 
                'offesetp' => 'OFFSET P'];  

            foreach ($CheckBoxs as $key => $value){
                if(!isset($request[$key]) && empty($request[$key]) )  {
                    $request[$key] = 'No';
                }   
                else $request[$key] = 'Yes';
                 
            };  

            
            // var_dump($request);
            // die(); 
            
            
           

            $CurrentDate = (string) date(" Y-m-d");
            $request['Tax'] = (int)  $request['Tax']; 
            $Query = "
            INSERT INTO Carton (
                CTNType, CustId1, JobNo, EmpId, CTNWidth, CTNHeight, CTNLength, 
                CTNPrice, CTNTotalPrice, CTNOrderDate, CTNFinishDate, CTNStatus, CTNQTY,
                CTNUnit, CTNColor, CTNPaper, CTNPolimarPrice, CTNDiePrice, ProductName,
                FinalTotal, CSlotted, CDieCut, CPasting, CStitching, flexop, offesetp,
                CFluteType, JobType , Note, CtnCurrency, GrdPrice, MarketingNote, Ctnp1, Ctnp2, 
                Ctnp3, Ctnp4, Ctnp5, Ctnp6, Ctnp7, PaperP1, PaperP2, PaperP3, PaperP4,
                PaperP5, PaperP6, PaperP7, PexchangeUSD , Tax , polymer_info ,  die_info , NoFlip
            )
            VALUES (
                ? , ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ? , ? , ? , ? , ? , 
                ? , ? , ? , ? , ?, ? , ? , ?
            );    
            "; 
            
            $QuotationRows = $this->Controller->QueryData($Query , [
                $request['CartonType'] ,  $request['CustomerId'] ,  $request['JobNo'] ,   $request['EmployeeId'] ,  $request['PaperWidth'] ,  $request['PaperHeight'] ,  $request['PaperLength'] , 
                $request['PaperPriceAFN'] ,  $request['TotalPrice'] , $CurrentDate ,  $request['FinishDate'] ,  $Status ,  $request['CartonQTY'] , 
                $request['CartonUnit'] ,  $request['NoColor1'] ,  $request['CTNPaper'] ,  $request['PolymerPrice'] ,  $request['DiePrice'] ,  $request['ProductName'] , 
                $request['FinalTotal'] ,  $request['CSlotted'] ,  $request['CDieCut'] ,  $request['CPasting'] ,  $request['CStitching'] ,  $request['flexop'] ,  $request['offesetp'] , 
                $request['Flute'] ,  $request['jobType'] ,  $request['Note1'] ,  $request['CtnCurrency1'] ,  $request['PaperGrade'] ,  $request['Notemarket'] ,  $request['PaperName_1'] ,  $request['PaperName_2'] , 
                $request['PaperName_3'] ,  $request['PaperName_4'] ,  $request['PaperName_5'] ,  $request['PaperName_6'] ,  $request['PaperName_7'] ,  $request['PaperLayerPrice_1'] ,  $request['PaperLayerPrice_2'] ,  $request['PaperLayerPrice_2'] ,  $request['PaperLayerPrice_4'] , 
                $request['PaperLayerPrice_5'] ,  $request['PaperLayerPrice_6'] ,  $request['PaperLayerPrice_7'] ,  
                $request['ExchangeRate'] , $request['Tax'] ,   $request['NoColor'] , $request['DieExist'] ,  $request['NoFlip']
            ]); 
        

          
            // var_dump($QuotationRows); 

              // echo $request['NoColor']; 
            // echo $request['DieExist']; 
            // die();


            if($QuotationRows) {

                if(isset($_POST['SaveButton']) ) {
                    $LID = $this->Controller->QueryData('SELECT LAST_INSERT_ID() AS ID;' , []);   $LastID  = $LID->fetch_assoc();
                    header("Location:QuotationPrint.php?CTNId=". $LastID['ID']);
                }  
                elseif(isset($_POST['SendToDesign'])  || isset($_POST['SaveOnly'])  ) {
                    header("Location:IndividualQuotation.php");
                }
                elseif(isset($_POST['Rorder']) || isset($_POST['RorderToDesign']) || isset($_POST['RorderAndPrint'])   ){

                    $LID = $this->Controller->QueryData('SELECT LAST_INSERT_ID() AS ID;' , [])->fetch_assoc()['ID'];
                    $SelectDesigninfo= $this->Controller->QueryData("SELECT * FROM designinfo WHERE CaId=?",[ $_POST['CTNId']]);
                    $DataRows=$SelectDesigninfo->fetch_assoc();
                    
                    // var_dump($DataRows); 
                    // echo $_POST['CTNId'] ; 
                    // echo "<br>"; 
                    // echo $LID ; 

                    // die(); 


                    if($SelectDesigninfo->num_rows > 0)
                    {
                        $Insert=$this->Controller->QueryData("INSERT INTO designinfo (
                                DesignName1, DesignerName1, DesignStatus, DesignImage, CaId,  DesignCode1,   DesignDep, OriginalFile, design_type,  designer_id, Re_OrderStatus
                            ) 
                            VALUES (?,?,?,?,?,?,?,?,?,?,?)",
                            [   
                                $DataRows['DesignName1'],
                                $DataRows['DesignerName1'],
                                $DataRows['DesignStatus'],
                                $DataRows['DesignImage'],
                                $LID,
                                $DataRows['DesignCode1'],
                                $DataRows['DesignDep'],
                                $DataRows['OriginalFile'],
                                $DataRows['design_type'],
                                $DataRows['designer_id'],
                                'Yes'
                            ]);
                            if(!$Insert) die("<h1 style = 'text-align:center; margin-top:100px;color:red;'>Record not inserted successfully</h1>"); 
                    }
                    else  die("<h1 style = 'text-align:center; margin-top:100px;color:red;'>Design information does exist, please contact system admin</h1>");
 
                    if($request['JobNo'] == 'NULL')  header("Location:IndividualQuotation.php?CustId=".$request['CustomerId']);
                    else header("Location:CustomerProfile.php?id=".$request['CustomerId']);
                    
                }
                elseif(isset($_POST['RorderAndPrint']) ){
                    header("Location:QuotationPrint.php?CTNId=". $request['CTNId']);
                }

            }
            else {
                header("Location:Quotation.php?CustId=". $request['CustomerId'] ."&msg=Error Occured While Saving Quotation");
            }
        } // END OF SAVE METHOD 







        public function EditQuotation($request , $Status = "New"){  

            foreach ($request as $key => $value) {
                $request[$key] = $this->Controller->CleanInput($value); 
            }

            $CheckBoxs = [ 
                'CSlotted' => 'SLOTTED' ,
                'CDieCut' => 'DIE CUT' , 
                'CPasting' => 'PASTING' ,
                'CStitching' => 'STITCHING' ,
                'flexop' =>  'FLEXO P' , 
                'offesetp' => 'OFFSET P'
            ];  

            foreach ($CheckBoxs as $key => $value){
                if(!isset($request[$key]) && empty($request[$key]) ) {
                    $request[$key] = 'No';
                }
                else { 
                    $request[$key] = 'Yes';
                }
            }  
            // var_dump($request); 
            // // // echo  $request['flexop'];
            // // // echo "FLexo: " . $request['flexop']; 
            // // // echo "CSlotted: " . $request['CSlotted']; 
            // die(); 

            $CurrentDate = (string) date("Y-m-d");
            $request['Tax'] = (int)  $request['Tax']; 


            
            if(!isset($request['JobNo'] ) &&  empty($request['JobNo']) ) {
                $request['JobNo'] = "NULL";

                if(isset($_POST['SentDirectlyToFinance'])) {
                    $Status = 'New'; 
                }
            } 

            if($request['JobNo'] != 'NULL'){
                $QuotationRows = $this->Controller->QueryData("UPDATE ppcustomer SET CusStatus=? , PPCondition=? WHERE CustId = ?" , ['Active' , 'Working' , $request['CustomerId'] ]); 
            }
            //  else $Status = 'Order';
            


          
            if(trim($_POST['Page']) == 'JobList') {
                 $Status = $request['CTNStatus']; 
            }
            

            if($_POST['Page'] == 'CustomerOrderPage') {  
                // the edit comes from order page then if it is not job then it should be in the order page else send it to finance for payment 
                if($request['JobNo'] == 'NULL') {$Status = 'Order'; 
                } else  {
                    $Status = 'FNew'; 
                    // THIS PART IS USED FOR CREATING THE NOTIFICATION 
                    $user = $this->Controller->QueryData("SELECT user_id FROM alert_access_list WHERE department = ? AND notification_type = ?" , [ 'Finance' , 'NEW-JOB']); 
                    $user_id = 0 ; 
                    $alert_comment = 'Job with ID (' . $request['JobNo'] . ') Arrived'; 
                    if($user->num_rows > 0 ) $user_id  =  $user->fetch_assoc()['user_id'];
                    $this->Controller->QueryData("INSERT INTO alert (department,user_id,title,alert_comment, `type`) VALUES ('Finance',?,'New Job',?,'NEW-JOB')" , [$user_id ,  $alert_comment ]);
                } 
            }
                
                // echo $_POST['Page'];
                // echo "--"; 
                // echo $Status; 
                // echo "--"; 
                //  var_dump($request['JobNo']); 
                // die(); 
            if(isset($request['CartonQTY'] )   ) {
                $request['CartonQTY'] = str_replace(",","", $request['CartonQTY']); 
            }
            if(isset($request['TotalPrice'] ) ) {
                $request['TotalPrice'] = str_replace(",","", $request['TotalPrice']); 
            }



            $Query = "
                UPDATE Carton  SET 
                    CTNType = ? , CustId1 = ?, JobNo = ?, EmpId = ?, CTNWidth = ?, CTNHeight = ?, CTNLength = ? , 
                    CTNPrice = ?, CTNTotalPrice = ?, CTNOrderDate = ?, CTNFinishDate = ?, CTNStatus = ?, CTNQTY = ? , 
                    CTNUnit = ?, CTNColor = ?, CTNPaper = ?, CTNPolimarPrice = ?, CTNDiePrice = ?, ProductName = ? , 
                    FinalTotal = ?, CSlotted = ?, CDieCut = ?, CPasting = ?, CStitching = ?, flexop = ?, offesetp = ?, 
                    CFluteType = ?, JobType = ? , Note = ?, CtnCurrency = ?, GrdPrice = ?, MarketingNote = ?, Ctnp1 = ?, Ctnp2 = ?, 
                    Ctnp3 = ?, Ctnp4 = ?, Ctnp5 = ?, Ctnp6 = ?, Ctnp7 = ?, PaperP1 = ?, PaperP2 = ?, PaperP3 = ?, PaperP4 = ?,  PaperP5 = ? , 
                    PaperP6 = ?, PaperP7 = ?, PexchangeUSD = ? , CancelComment = ? , Canceldate  = ? , Tax = ? , polymer_info = ?,  die_info = ? , NoFlip = ?
                    WHERE CTNId = ?   
            "; 
           
          
            



            $QuotationRows = $this->Controller->QueryData($Query , [
                $request['CartonType'] ,  $request['CustomerId'] ,  $request['JobNo'] ,   $request['EmployeeId'] ,  $request['PaperWidth'] ,  $request['PaperHeight'] ,  $request['PaperLength'] , 
                $request['PaperPriceAFN'] ,  $request['TotalPrice'] , $CurrentDate ,  $request['FinishDate'] ,  $Status ,  $request['CartonQTY'] , 
                $request['CartonUnit'] ,  $request['NoColor'] ,  $request['CTNPaper'] ,  $request['PolymerPrice'] ,  $request['DiePrice'] ,  $request['ProductName'] , 
                $request['FinalTotal'] ,  $request['CSlotted'] ,  $request['CDieCut'] ,  $request['CPasting'] ,  $request['CStitching'] ,  $request['flexop'] ,  $request['offesetp'] ,  
                $request['Flute'] ,  $request['jobType'] ,  $request['Note1'] ,  $request['CtnCurrency1'] ,  $request['PaperGrade'] ,  $request['Notemarket'] ,  $request['PaperName_1'] ,  $request['PaperName_2'] , 
                $request['PaperName_3'] ,  $request['PaperName_4'] ,  $request['PaperName_5'] ,  $request['PaperName_6'] ,  $request['PaperName_7'] ,  
                $request['PaperLayerPrice_1'] ,  $request['PaperLayerPrice_2'] ,  $request['PaperLayerPrice_3'] ,  $request['PaperLayerPrice_4'] ,  $request['PaperLayerPrice_5'] ,
                $request['PaperLayerPrice_6'] ,  $request['PaperLayerPrice_7'] ,  $request['ExchangeRate'], 
                 $request['CancelComment'] ,  $request['Canceldate'] ,  $request['Tax'] ,    $request['NoColor'] , $request['DieExist'] , $request['NoFlip'] , $request['CTNId']
            ]); 

            

            if($QuotationRows) {
                    if(isset($_POST['SentDirectlyToFinance'])) {
                        header("Location:IndividualQuotation.php");
                    } 
                    else if(isset($_POST['EditToDesign']) || isset($_POST['EditOnly'])) {
                        header("Location:IndividualQuotation.php");
                    }
                    elseif( isset($_POST['COP_EditOnly']) ){
                        header("Location:". $_POST['Page']. ".php");
                    }
                   elseif( isset($_POST['CancelQuote']) ) {
                    header("Location:CancelQuotation.php");
                   }
            }
            else {
                header("Location:QuotationEdit.php?CTNId=". $request['CTNId'] ."&msg=Error Occured While Saving Quotation");
            }
        } // END OF SAVE METHOD 

    




    }// END OF CLASS 

    $QUOTATION = new QuotationController($Controller);

    if(isset($_POST) && !empty($_POST))
    {

        if(isset($_POST['Page'] ) && !empty($_POST['Page']) ) {

            if($_POST['Page'] == 'IndividualQuotation' ) { // || $_POST['Page'] == 'CustomerProductList' 
                if(isset($_POST['SentDirectlyToFinance']) ||  isset($_POST['EditOnly']) ) $QUOTATION->EditQuotation( $_POST , 'FNew');
                if(isset($_POST['EditToDesign'])  ) $QUOTATION->EditQuotation($_POST , 'Design' );
                if(isset($_POST['CancelQuote'])) $QUOTATION->EditQuotation($_POST , 'Cancel' );
            } 
            elseif($_POST['Page'] == 'CustomerOrderPage') {
                if( isset($_POST['COP_EditOnly'])) $QUOTATION->EditQuotation( $_POST, 'FNew');
            }
            elseif($_POST['Page'] == 'CancelQuotation') {
                if( isset($_POST['COP_EditOnly'])) $QUOTATION->EditQuotation( $_POST);
            }
            elseif($_POST['Page'] == 'JobList') {
                if( isset($_POST['COP_EditOnly'])) $QUOTATION->EditQuotation( $_POST, 'FNew');
            }
            elseif($_POST['Page'] == 'CustomerProfile') {
                if( isset($_POST['Rorder']) || isset($_POST['RorderAndPrint']) || isset($_POST['RorderToDesign']) ) {
                    $QUOTATION->CreateQuotation($_POST); 
                }   else die('Reorder : create quotation '); 
            }
        } 

        if(isset($_POST['SaveButton']) || isset($_POST['SaveOnly'])) $QUOTATION->CreateQuotation($_POST);  
        if(isset($_POST['SendToDesign'])  ) $QUOTATION->CreateQuotation($_POST , 'Design' );

        // EditButtonAndPrint SentDirectlyToFinance
        
       
    } 


?>