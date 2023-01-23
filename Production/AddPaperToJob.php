<?php 
    require_once 'Controller.php' ; 

  // this function is used to find country short letter name afghanistan find af 
  function country_abbr ( $country ){
    $countryList = array(
        'AF' => 'Afghanistan',
        'KZ' => 'Kazakhstan',
        'IR' => 'Iran',
        'AZ' => 'Azerbaijan',
        'BD' => 'Bangladesh',
        'DE' => 'Germany',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IQ' => 'Iraq',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KG' => 'Kyrgyz Republic',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'MY' => 'Malaysia',
        'MX' => 'Mexico',
        'FM' => 'Micronesia',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'AN' => 'Netherlands Antilles',
        'NL' => 'Netherlands the',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn Islands',
        'PL' => 'Poland',
        'PT' => 'Portugal, Portuguese Republic',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russia',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome and Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'SG' => 'Singapore',
        'ZA' => 'South Africa',
        'LK' => 'Sri Lanka',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland, Swiss Confederation',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks and Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States of America',
        'UZ' => 'Uzbekistan',
        'VE' => 'Venezuela',
        'VN' => 'Vietnam',
        'FL' => 'Finland'
    
         
  
    );
    $key = array_search($country , $countryList); // $key = 2;
    return $key ; 
}


if(isset($_POST['PaperStockId']) && trim(!empty($_POST['PaperStockId']))  && isset($_POST['CTNId']) && trim(!empty($_POST['CTNId']))   ) {
    // echo $_POST['CTNId']; echo "<br>"; 
    // echo $_POST['PaperStockId']; echo "<br>"; 
    // echo $_POST['Ctnp']; echo "<br>"; 
    // echo $_POST['PaperCatagory']; echo "<br>"; 
    // die(); 

    $key = $_POST['Ctnp'];
    $number = filter_var($_POST['Ctnp'], FILTER_SANITIZE_NUMBER_INT); 
    $PaperName= $Controller->CleanInput($_POST['PaperCatagory']);
    
    // prepare the reel_size with country 
    $PSI  = $Controller->QueryData('SELECT PId , PMade , PSize FROM  paperstock WHERE PId = ?', [$_POST['PaperStockId']] );
    $PaperStock = $PSI->fetch_assoc(); 
    $RSC = country_abbr($PaperStock['PMade']) . "-" . $PaperStock['PSize'];

    // check if the record exist in used paper or not 
    $CheckPSI  = $Controller->QueryData('SELECT carton_id FROM used_paper WHERE carton_id = ?', [$_POST['CTNId'] ]);
    if($CheckPSI->num_rows > 0 ) {
        $query =  'UPDATE used_paper SET '. $key.' = ?  , RSC_'. $number.' = ?  , PSPN_'. $number.' = ? WHERE carton_id = ? '; 
        $Update  = $Controller->QueryData($query , [ $_POST['PaperStockId'] , $RSC , $PaperName , $_POST['CTNId'] ] );
        // var_dump($Update); 
        header('Location:AvailablePaperStock.php?CTNId='.$_POST['CTNId'].'&PaperCatagory=Flute&Ctnp='. $_POST['Ctnp'] .'&msg=paper added successfully&class=success') ;
    }
    else { 
        if(!$Controller->QueryData('INSERT INTO used_paper (carton_id , '. $key .'  ,RSC_'. $number.' , PSPN_'. $number.') VALUES (?,?,?,?)',    [$_POST['CTNId'] ,$_POST['PaperStockId'] ,  $RSC  , $PaperName  ] )) {
            header('Location:AvailablePaperStock.php?CTNId='.$_POST['CTNId'].'&PaperCatagory=Flute&Ctnp=Ctnp3&msg=Paper not saved into system&class=danger') ;
        }
        header('Location:AvailablePaperStock.php?CTNId='.$_POST['CTNId'].'&PaperCatagory=Flute&Ctnp=Ctnp3&msg=paper added successfully&class=success') ;
    }
    
} // END IF BLOCK 
?>


