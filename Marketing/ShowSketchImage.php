<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BGC MIS Department">
    <title>BGIS</title>
    <link rel="stylesheet" href="../Public/Css/bootstrap.min.css">
 </head>
 <body>
 
 
<?php 
if ( filter_has_var(INPUT_GET, 'Url') && filter_has_var(INPUT_GET, 'ProductName')  ) {
    $URL = $_GET['Url'];  
    $ProductName = $_GET['ProductName']; 
}
else {

?> 

    <div class="alert alert-danger m-3 d-flex align-items-center" role="alert">
        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
        <div>
        Image URL Not Found 
        </div>
    </div>
<?php  die(); } ?>


 <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="#">
        <svg width="60" height="60" viewBox="0 0 512 457" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M434.086 411.826H77.9121V456.348H434.086V411.826Z" fill="black"/>
            <path d="M350.609 16.6958V83.4778H417.391L350.609 16.6958Z" fill="black"/>
            <path d="M317.216 116.87V0H77.9121V166.957H434.086V116.87H317.216Z" fill="black"/>
            <path d="M0 200.348V378.435H512V200.348H0ZM79.496 323.585C67.809 323.585 57.862 320.487 49.143 314.769L56.354 300.444C62.59 304.696 70.451 308.76 79.796 308.76C85.606 308.76 88.511 306.99 88.511 303.451C88.511 299.55 83.946 297.394 78.143 295.838C58.683 290.622 52.149 285.845 52.149 274.2C52.149 262.402 60.017 251.061 78.395 251.061C88.331 251.061 96.122 254.471 104.04 258.875L96.827 272.499C90.906 268.038 82.836 265.687 77.894 265.687C72.017 265.687 69.079 267.658 69.079 271.597C69.079 276.804 76.245 278.195 84.005 280.312C99.704 284.595 106.143 289.812 106.143 301.849C106.142 313.786 97.861 323.585 79.496 323.585ZM164.743 322.783L144.608 294.133L137.195 301.846V322.782H120.766V251.659H137.195V282.313L163.24 251.659H181.672L155.027 283.414L183.476 322.782H164.743V322.783ZM193.792 322.783V251.66H242.877V266.086H210.22V279.91H238.268V293.233H210.22V308.359H243.778V322.783H193.792V322.783ZM312.998 266.084H291.36V322.782H274.931V266.084H253.193V251.659H312.997V266.084H312.998ZM353.668 323.384C334.263 323.384 318.607 306.088 318.607 286.62C318.607 265.253 335.793 251.259 354.269 251.259C369.672 251.259 378.716 259.479 382.619 266.785L369.996 275.6C365.592 265.671 355.336 265.884 353.869 265.884C343.515 265.884 335.337 274.458 335.337 287.221C335.337 297.369 341.755 308.76 354.07 308.76C361.559 308.76 367.586 304.768 369.998 298.943L383.422 306.856C379.62 315.826 368.282 323.384 353.668 323.384ZM457.849 322.783H441.419V293.632H413.07V322.783H396.641V251.66H413.07V279.208H441.419V251.66H457.849V322.783Z" fill="black"/>
        </svg>

         <span class = "fw-bold fs-2 mt-2 pt-3"> <?=$ProductName ?> </span>
     </a>
  </div>
</nav>




<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <img src="../Assets/<?=$URL;?>" class="img-fluid" alt="Design Image ">
        </div>
    </div>
</div>


 </body>
 </html>