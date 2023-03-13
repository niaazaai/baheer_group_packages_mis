<?php 
    session_start();
    $ROOT_DIR = 'C:/xampp/htdocs/BGIS/'; 
    require_once $ROOT_DIR. 'App/Controller.php'; 
    
    class CustomerPaymentController {

        private $Controller ; 

        public function  __construct( $Controller){
            $this->Controller = $Controller ; 
        }

        public function StorePayment($request  ){  
          

            if (!function_exists('str_contains')) {
                function str_contains($haystack, $needle) {
                    return $needle !== '' && mb_strpos($haystack, $needle) !== false;
                }
            }

            $REQUEST = []; 
            $PAYMENT = []; 
            $LOOP_COUNT = 0; 


            foreach ($request as $key => $value) {
                $request[$key] = $this->Controller->CleanInput($value); 
                // echo $key . " : " . $value ;
                // check if the keys have payment in them if they are not empty the store it in request 


                if (str_contains($key, "Payment_")) {
                    if (!empty($request[$key])) {

                        $CTNID = filter_var($key, FILTER_SANITIZE_NUMBER_INT);
                        $PAYMENT['PAYMENT'][$LOOP_COUNT] = $request[$key];
                        $PAYMENT['EX'][$LOOP_COUNT] = $request['EX_'.$CTNID];
                        $PAYMENT['CTNID'][$LOOP_COUNT] =  $CTNID;
                        $LOOP_COUNT++;   
                    }
                }
                else {
                    $REQUEST[$key] =  $request[$key] ;
                } 
                 
            }
            $REQUEST['RExchangeAmount'] = 0 ; 
            // echo "LOOP Count : " . $LOOP_COUNT ;
           
            foreach ($REQUEST as $key => $value) {
                if( empty($value) ) $REQUEST[$key] = 'NULL'; 
            }
            // var_dump($REQUEST); 

            for ($index=0; $index <  $LOOP_COUNT ; $index++) { 
         
                // echo  $PAYMENT['CTNID'][$index]; 
                
                // THIS BLOCK IS FOR CONVERTING CURRENT EXCHANGE CURRENCY WITH RCIEVE AMOUNT 
                if($REQUEST['OrignalCurrency'] == 'USD' &&  $REQUEST['RExchangeCurrency'] == 'AFN' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] * $PAYMENT['EX'][$index] ;
                elseif($REQUEST['OrignalCurrency'] == 'USD' &&  $REQUEST['RExchangeCurrency'] == 'PKR' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] * $PAYMENT['EX'][$index];
                elseif($REQUEST['OrignalCurrency'] == 'AFN' &&  $REQUEST['RExchangeCurrency'] == 'USD' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] / $PAYMENT['EX'][$index];
                elseif($REQUEST['OrignalCurrency'] == 'AFN' &&  $REQUEST['RExchangeCurrency'] == 'PKR' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] * $PAYMENT['EX'][$index];
                elseif($REQUEST['OrignalCurrency'] == 'PKR' &&  $REQUEST['RExchangeCurrency'] == 'USD' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] /  $PAYMENT['EX'][$index];
                elseif($REQUEST['OrignalCurrency'] == 'PKR' &&  $REQUEST['RExchangeCurrency'] == 'AFN' ) $REQUEST['RExchangeAmount'] =  $PAYMENT['PAYMENT'][$index] /  $PAYMENT['EX'][$index];
                
                $Query = "  INSERT INTO receivabletr(
                    RVocherNo,RDate,RAmount,RCurrency,
                    Rmethod,RExchangeRate,RCustIdF,RExchangeCurrency,RExchangeAmount,
                    RSectionName, RUserId,RComment,SectionId) 
                    VALUES
                    ( ?,?,?,?,
                    ?,?,?,?,?,
                    ?,?,?,?)";
                    
                $PaymentRows = $this->Controller->QueryData($Query ,  [ 
                $REQUEST['ReferenceNo']  , $REQUEST['PaymentDate'] , $PAYMENT['PAYMENT'][$index],  $REQUEST['OrignalCurrency'] , 
                $REQUEST['PaymentMethod'] , $REQUEST['ExchangeRate'] , $REQUEST['CustId'] ,   $REQUEST['RExchangeCurrency']  ,  $REQUEST['RExchangeAmount']  , 
                $REQUEST['SectionName'] ,  $_SESSION['EId'] ,  $REQUEST['Note'] , $PAYMENT['CTNID'][$index] ]);  
 

                // get recieve amount from carton sum it with new amout
                $SELECT_CARTON = $this->Controller->QueryData('SELECT ReceivedAmount , offesetp FROM carton WHERE CTNId=?',  [ $PAYMENT['CTNID'][$index] ]);
                $OLD_PAYMENT = $SELECT_CARTON->fetch_assoc(); 
                $AMOUNT = $PAYMENT['PAYMENT'][$index] + $OLD_PAYMENT['ReceivedAmount']; 
                
                if(empty($OLD_PAYMENT['ReceivedAmount']) || $OLD_PAYMENT['ReceivedAmount'] == 0 ) {
                   if(trim($OLD_PAYMENT['offesetp']) == 'Yes' ) {
                        $this->Controller->QueryData('UPDATE carton SET ReceivedAmount = ? , CTNStatus = "Printing"  WHERE CTNId=?' ,  [ $AMOUNT , $PAYMENT['CTNID'][$index] ]);
                    }
                    else 
                    {
                        $Check=$this->Controller->QueryData("SELECT Re_OrderStatus FROM designinfo INNER JOIN carton ON carton.CTNId=designinfo.CaId WHERE CTNId = ? AND Re_OrderStatus='Yes'",[$PAYMENT['CTNID'][$index]]);
                        if($Check->num_rows > 0)
                        {
                            $this->Controller->QueryData('UPDATE carton SET CTNStatus = "Archive" WHERE CTNId=?', [$PAYMENT['CTNID'][$index]]);
                        }
                        else
                        {
                             // put it back to recive amount 
                            $this->Controller->QueryData('UPDATE carton SET ReceivedAmount = ? , CTNStatus = "Film" WHERE CTNId=?' ,  [ $AMOUNT , $PAYMENT['CTNID'][$index] ]);
                        }
                       
                    }
                }
                $this->Controller->QueryData('UPDATE carton SET ReceivedAmount = ? WHERE CTNId=?' ,  [ $AMOUNT , $PAYMENT['CTNID'][$index] ]);

            } // END OF LOOP 

                if($PaymentRows) { 
                    if( isset($REQUEST['SaveNext'])) {
                        header("Location:CustomerPayment.php?msg=New Amounts Applied!&class=success&ListType=".$request['ListType']);
                    }
                    else if(isset($REQUEST['SaveClose'])) {
                        // header("Location:CustomerPayment.php");
                        die('Comming Soon!');
                    }

                }// payment block 
                else {
                    header("Location:CustomerPayment.php?msg=Records Not Saved, Please Try Again&class=danger ");
                }
            // echo "<pre>";    
            // print_r($REQUEST); 
            // echo "</pre>";
        
 
        } // END OF SAVE METHOD 




    }// END OF CLASS 

    $PAYMENT = new CustomerPaymentController($Controller);

    if(isset($_POST) && !empty($_POST))
    {
        var_dump($_POST); 
        // if(isset($_POST['SaveClose']) || isset($_POST['SaveOnly'])) $QUOTATION->CreateQuotation($_POST);  
        if(isset($_POST['SaveNext']) ) $PAYMENT->StorePayment($_POST);  
    } 


?>