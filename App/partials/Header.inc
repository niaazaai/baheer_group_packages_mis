<?php
session_start();
$ROOT_DIR = 'C:/xampp/htdocs/BGIS';
require_once  $ROOT_DIR . '/App/Controller.php';

$USER_DEPARTMENT = 0 ; 
  if(!isset($_SESSION['user']) && empty($_SESSION['user']))
  {
    header("Location: ../Auth/Login.php");
  }
  else
  {
      # Logout if the user time expires
       if((time() - $_SESSION['last_login_timestamp']) > 2000) // 900 = 15 * 60
           {
               header("Location:../Auth/Login.php");
           }
       else
       {
          $RowCount =  $Controller->QueryData("SELECT * FROM employeet WHERE EUserName = ?" , [$_SESSION['user']] );
          $r1 = $RowCount->fetch_row();
          // var_dump($r1[15]); 
          $USER_DEPARTMENT = $r1[15]; 
          #check user permissions
          if($r1[0]==200)  header("Location: ../../Auth/Login.php?msg=You are not authorized to access this page!");
          else $_SESSION['last_login_timestamp'] = time();
        }
  }
  // var_dump($USER_DEPARTMENT); 
  
?>

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


<style>
  body {  font-family: Roboto,sans-serif;  background-color: #f2f7ff  ; color:#25396f;}

  td , th {
    vertical-align:middle; 
  }
  
  .sidebar-menu-links {
    margin-top: -15px;
    color:black;
    background-color:none;
  }
  .sidebar-menu-links:hover {
    margin-left: 5px;
    transition: margin-left 0.50s;
  }

  .sm-fl {
    color:black;
  }

    .sm-fl:hover {
    margin-left: 5px;    transition: margin-left 0.50s;
  }

  .sidebar-nav-item {
      color:black;
  }
    .sidebar-nav-item:hover {
    background-color: #f0f1f5 ;
    font-weight: 600;
    border-radius: 7px;
    }

 .search{
    position: relative;
    box-shadow: 0 0 40px rgba(51, 51, 51, .1);
    }

  .search input{
    height: 50px;
    text-indent: 35px;
    border: 2px solid  #25396f;
  }
  
  .search input:focus{
    box-shadow: none;
    border: 2px solid #0d6efd;
  }

  .search .fa-search{
    position: absolute;
    top: 11px;
    left: 16px;
    color:gray;
    -moz-transform: scale(-1, 1);
    -webkit-transform: scale(-1, 1);
    -o-transform: scale(-1, 1);
    -ms-transform: scale(-1, 1);
    transform: scale(-1, 1);
  }

  tr:hover  {
    background-color:#F6F7FA ;
    color:black;
  }

  .custom-nav-link {
    color:#25396f;
  }
  .custom-nav-link:hover {
    color: black;
  }
    
  .custom-nav-link:focus {
    border-radius:4px;
    color:white;
    background-color: #0d6efd;
  }
  .bc-black {
    color:#25396f;
  }

  .sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 260px;
    box-shadow: 0 5px 1px rgb(0 0 0 / 10%);
    z-index: 100;
    transition: all 0.3s ease;
    background-color: #FFF;
  }
  .sidebar.close {
    width: 78px;
  }
  .sidebar .logo-details {
    height: 60px;
    width: 100%;
    display: flex;
    align-items: center;
  }
  .sidebar .logo-details i {
    font-size: 30px;
    color: #000;
    height: 50px;
    min-width: 78px;
    text-align: center;
    line-height: 50px;
  }
  .sidebar .logo-details .logo_name {
    font-size: 22px;
    color: #000;
    font-weight: 600;
    transition: 0.3s ease;
    transition-delay: 0.1s;
  }
  .sidebar.close .logo-details .logo_name {
    transition-delay: 0s;
    opacity: 0;
    pointer-events: none;
  }
  .sidebar .nav-links {
    height: 100%;
    padding: 0 0 150px 0;
    overflow: auto;
  }
  .sidebar.close .nav-links {
    overflow: visible;
  }
  .sidebar .nav-links::-webkit-scrollbar {
    display: none;
  }
  .sidebar .nav-links li {
    position: relative;
    list-style: none;
    transition: all 0.4s ease;
    margin-right:8px;
    margin-left:8px;
  }

  .sidebar .nav-links li:hover   {
    /* background-color: #4070f4; */
    background-color: #dadbe0;

    border-radius:5px;
    /* color:#FFF !important; */
  }

  .sidebar .nav-links li .icon-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  .sidebar.close .nav-links li .icon-link {
    display: block;
  }
  .sidebar .nav-links li i {
    height: 50px;
    min-width: 78px;
    text-align: center;
    line-height: 50px;
    color: #25396f;
    font-size: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-right:-8px;
    margin-left:-8px;
    /* margin-top:10px; */
  }
  /* .sidebar .nav-links li i:hover { */

  .sidebar .nav-links li.showMenu i.arrow {
    transform: rotate(-180deg);
  }
  .sidebar.close .nav-links i.arrow {
    display: none;
  }
  .sidebar .nav-links li a {
    display: flex;
    align-items: center;
    text-decoration: none;
  }
  .sidebar .nav-links li a .link_name {
    font-size: 18px;
    font-weight: 400;
    color: #000;
    transition: all 0.4s ease;
  }
  


  .sidebar.close .nav-links li a .link_name {
    opacity: 0;
    pointer-events: none;
  }
  .sidebar .nav-links li .sub-menu {
    padding: 6px 6px 14px 80px;
    margin-top: -10px;
    background: #fff;
    display: none;
  }
  .sidebar .nav-links li.showMenu .sub-menu {
    display: block;
  }
  .sidebar .nav-links li .sub-menu a {
    color: #000;
    font-size: 15px;
    padding: 5px 5px;
    white-space: nowrap;
    opacity: 0.6;
    transition: all 0.3s ease;
    border-radius:5px;
    

  }
  .sidebar .nav-links li .sub-menu a:hover {
    opacity: 1;
    color:#FFF;
    background-color: #4070f4;

  }

  .sidebar.close .nav-links li .sub-menu {
    position: absolute;
    left: 100%;
    top: -10px;
    margin-top: 0;
    padding: 10px 20px;
    border-radius: 0 6px 6px 0;
    opacity: 0;
    display: block;
    pointer-events: none;
    transition: 0s;
  }
  .sidebar.close .nav-links li:hover .sub-menu {
    top: 0;
    opacity: 1;
    pointer-events: auto;
    transition: all 0.3s ease;
  }

  .sidebar .nav-links li .sub-menu li:hover  {
    border-radius:5px;
  }

  .sidebar .nav-links li .sub-menu .link_name {
    display: none;
  }
  .sidebar.close .nav-links li .sub-menu .link_name {
    font-size: 18px;
    opacity: 1;
    display: block;
  }
  /* // this must be delete  */
  .sidebar .nav-links li .sub-menu.blank {
    opacity: 1;
    pointer-events: auto;
    padding: 3px 20px 6px 16px;
    opacity: 0;
    pointer-events: none;
  }

  /* // this must be delete  */

  .sidebar .nav-links li:hover .sub-menu.blank {
    top: 50%;
    transform: translateY(-50%);
  }
  .sidebar .profile-details {
    position: fixed;
    bottom: 0;
    width: 260px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: #fff;
    padding: 12px 0;
    transition: all 0.5s ease;
  }
  .sidebar.close .profile-details {
    background: none;
  }
  .sidebar.close .profile-details {
    width: 78px;
  }
  .sidebar .profile-details .profile-content {
    display: flex;
    align-items: center;
  }
  .sidebar .profile-details img {
    height: 52px;
    width: 52px;
    object-fit: cover;
    border-radius: 16px;
    margin: 0 14px 0 12px;
    background: #fff;
    transition: all 0.5s ease;
  }
  .sidebar.close .profile-details img {
    padding: 10px;
  }
  .sidebar .profile-details .profile_name,
  .sidebar .profile-details .job {
    color: #000;
    font-size: 18px;
    font-weight: 500;
    white-space: nowrap;
  }
  .sidebar.close .profile-details i,
  .sidebar.close .profile-details .profile_name,
  .sidebar.close .profile-details .job {
    display: none;
  }
  .sidebar .profile-details .job {
    font-size: 12px;
  }

  .home-section {
    position: relative;
    height: 100vh;
    left: 260px;
    width: calc(100% - 260px);
    transition: all 0.5s ease;
  }

  .sidebar.close ~ .home-section {
    left: 78px;
    width: calc(100% - 78px);
  }
  .home-section .home-content {
    height: 60px;
    display: flex;
    align-items: center;
  }
  .home-section .home-content .bx-menu,
  .home-section .home-content .text {
    color: #000;
    font-size: 35px;
  }
  .home-section .home-content .bx-menu {
    margin: 0 15px;
    cursor: pointer;
  }
  .home-section .home-content .text {
    font-size: 26px;
    font-weight: 600;
  }  
  @media (max-width: 420px) {
    .sidebar.close .nav-links li .sub-menu {
      display: none;
    }
  }
  </style>
</head>
<body >

<div class="sidebar close shadow">
  <div class="logo-details my-3 " style = "text-align:center;" >
    <i>
      <svg width="50" height="50" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 30C0 13.431 13.431 0 30 0C46.569 0 60 13.431 60 30C60 46.569 46.569 60 30 60C13.431 60 0 46.569 0 30V30ZM17.196 45.675H42.8033V32.589H41.241L40.5743 14.325H35.6625L34.995 32.5898H34.5038L25.296 25.4355V31.7287L17.196 25.4355L17.196 45.675ZM37.254 15.975H38.9835L39.09 18.891H37.1475L37.254 15.975ZM37.0868 20.541H39.15L39.2565 23.457H36.9802L37.0868 20.541ZM36.9195 25.107H39.3173L39.4238 28.023H36.813L36.9195 25.107ZM18.846 32.589V28.8067L23.7143 32.589H18.846ZM26.946 32.589V28.8067L31.815 32.589H26.946ZM36.753 29.673H39.4838L39.5903 32.589H36.6458L36.753 29.673ZM41.1547 34.2398H18.846V44.025H41.154L41.1547 34.2398ZM23.7938 41.0895H20.2335V36.9833H23.7938V41.0895ZM29.1158 41.0895H25.5555V36.9833H29.1158V41.0895ZM34.4392 41.0895H30.8783V36.9833H34.4392V41.0895ZM39.762 41.0895H36.2017V36.9833H39.762V41.0895ZM22.8945 37.8833H21.1327V40.1895H22.8945V37.8833ZM28.2165 37.8833H26.4548V40.1895H28.2165V37.8833ZM33.54 37.8833H31.7775V40.1895H33.54V37.8833ZM38.8628 37.8833H37.101V40.1895H38.8628V37.8833Z" fill="#0d6efd"/>
      </svg>
    </i>
    <span class="logo_name" style = "font-size:16px;">BAHEER GROUP</span>
  </div>
    
  <ul class="nav-links">
    <li>
      <a href="#">
        <i>   
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-speedometer2  " viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"></path>
            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"></path>
          </svg>
        </i>

        <span class="link_name">Dashboard</span>
      </a>
      <ul class="sub-menu  ">
        <li><a class="link_name" href="#">Dashboard</a></li>
      </ul>
    </li>

    <li>
      <div class="icon-link">
        <a href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-sliders2 bc-black" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"></path>
            </svg> 
          </i>
          <span class="link_name">System Setting </span>
        </a>
      </div>
    </li>

    <li >
      <div class="icon-link arrow-link">
        <a href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-door-closed bc-black" viewBox="0 0 16 16">
              <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"></path>
              <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"></path>
            </svg>
          </i>
          <span class="link_name arrow-text">Gatepass</span>
        </a>
        <i class='arrow'>
        <svg  class='arrow-svg' width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 12.94L8.53044 9.46891L7.46954 10.5293L12 15.0618L16.5304 10.5293L15.4695 9.46891L12 12.94Z" fill="#1F2328"></path> </g></svg>
        </i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Gatepass</a></li>
        <li><a href="../Gatepass/PkgGatePass.php">Packages  </a></li>
        <li><a href="#">Employee  </a></li>
        <li><a href="#">Printing Press   </a></li>
      </ul>
    </li>
      
    <li >
      <div class="icon-link ">
        <a href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-rolodex " viewBox="0 0 16 16">
              <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
              <path d="M1 1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h.5a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h.5a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H6.707L6 1.293A1 1 0 0 0 5.293 1H1Zm0 1h4.293L6 2.707A1 1 0 0 0 6.707 3H15v10h-.085a1.5 1.5 0 0 0-2.4-.63C11.885 11.223 10.554 10 8 10c-2.555 0-3.886 1.224-4.514 2.37a1.5 1.5 0 0 0-2.4.63H1V2Z"></path>
            </svg>
          </i>
          <span class="link_name arrow-text">Human Resource</span>
        </a>
      </div>
    </li>
 
    <li >
      <div class="icon-link arrow-link">
        <a href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bag-dash bc-black" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"></path>
              <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"></path>
            </svg>
          </i>
          <span class="link_name arrow-text ">Procurement</span>
        </a>
        <i class='arrow'>
        <svg class='arrow-svg' width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 12.94L8.53044 9.46891L7.46954 10.5293L12 15.0618L16.5304 10.5293L15.4695 9.46891L12 12.94Z" fill="#1F2328"></path> </g></svg>
        </i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Procurement</a></li>
        <li><a href="#">Local Purchase</a></li>
        <li><a href="#">International Purchase</a></li>
      </ul>
    </li>

    <li>
      <div class="icon-link arrow-link">
        <a href="#">
          <i>
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
              <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"></path>
            </svg>
          </i>
          <span class="link_name arrow-text">Stocks</span>
        </a>
        <i class='arrow'>
        <svg class='arrow-svg' width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 12.94L8.53044 9.46891L7.46954 10.5293L12 15.0618L16.5304 10.5293L15.4695 9.46891L12 12.94Z" fill="#1F2328"></path> </g></svg>
        </i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Stocks</a></li>
        <li><a href="#">Paper</a></li>
        <li><a href="#">Raw Material</a></li>
        <li><a href="#">Spare Parts</a></li>
        <li><a href="#">Sales Branch</a></li>
        <li><a href="#">Fixed Assets</a></li>
        <li><a href="#">Office Supply / Safety</a></li>
      </ul>
    </li>

    <li>
      <div class="icon-link arrow-link">
        <a href="#">
          <i>
            <svg width="28" height="28" viewBox="0 0 25 25" fill="currentColor"  xmlns="http://www.w3.org/2000/svg">
              <path d="M13.4945 14.3699C13.7126 14.3699 13.8895 14.1931 13.8895 13.975C13.8895 13.7569 13.7126 13.5801 13.4945 13.5801C13.2764 13.5801 13.0996 13.7569 13.0996 13.975C13.0996 14.1931 13.2764 14.3699 13.4945 14.3699Z" fill="black"/>
              <path d="M15.3578 14.3699C15.5759 14.3699 15.7527 14.1931 15.7527 13.975C15.7527 13.7569 15.5759 13.5801 15.3578 13.5801C15.1397 13.5801 14.9629 13.7569 14.9629 13.975C14.9629 14.1931 15.1397 14.3699 15.3578 14.3699Z" fill="black"/>
              <path d="M17.2218 14.3699C17.4399 14.3699 17.6167 14.1931 17.6167 13.975C17.6167 13.7569 17.4399 13.5801 17.2218 13.5801C17.0037 13.5801 16.8269 13.7569 16.8269 13.975C16.8269 14.1931 17.0037 14.3699 17.2218 14.3699Z" fill="black"/>
              <path d="M19.0858 14.3699C19.3039 14.3699 19.4808 14.1931 19.4808 13.975C19.4808 13.7569 19.3039 13.5801 19.0858 13.5801C18.8677 13.5801 18.6909 13.7569 18.6909 13.975C18.6909 14.1931 18.8677 14.3699 19.0858 14.3699Z" fill="black"/>
              <path d="M20.9499 14.3699C21.168 14.3699 21.3448 14.1931 21.3448 13.975C21.3448 13.7569 21.168 13.5801 20.9499 13.5801C20.7317 13.5801 20.5549 13.7569 20.5549 13.975C20.5549 14.1931 20.7317 14.3699 20.9499 14.3699Z" fill="black"/>
              <path d="M14.4948 15.7918C14.7129 15.7918 14.8897 15.615 14.8897 15.3969C14.8897 15.1788 14.7129 15.002 14.4948 15.002C14.2767 15.002 14.0999 15.1788 14.0999 15.3969C14.0999 15.615 14.2767 15.7918 14.4948 15.7918Z" fill="black"/>
              <path d="M16.3583 15.7918C16.5764 15.7918 16.7532 15.615 16.7532 15.3969C16.7532 15.1788 16.5764 15.002 16.3583 15.002C16.1402 15.002 15.9634 15.1788 15.9634 15.3969C15.9634 15.615 16.1402 15.7918 16.3583 15.7918Z" fill="black"/>
              <path d="M18.2223 15.7918C18.4404 15.7918 18.6172 15.615 18.6172 15.3969C18.6172 15.1788 18.4404 15.002 18.2223 15.002C18.0042 15.002 17.8274 15.1788 17.8274 15.3969C17.8274 15.615 18.0042 15.7918 18.2223 15.7918Z" fill="black"/>
              <path d="M20.0863 15.7918C20.3044 15.7918 20.4812 15.615 20.4812 15.3969C20.4812 15.1788 20.3044 15.002 20.0863 15.002C19.8682 15.002 19.6914 15.1788 19.6914 15.3969C19.6914 15.615 19.8682 15.7918 20.0863 15.7918Z" fill="black"/>
              <path d="M21.9503 15.7918C22.1685 15.7918 22.3453 15.615 22.3453 15.3969C22.3453 15.1788 22.1685 15.002 21.9503 15.002C21.7322 15.002 21.5554 15.1788 21.5554 15.3969C21.5554 15.615 21.7322 15.7918 21.9503 15.7918Z" fill="black"/>
              <path d="M13.6029 17.1956C13.821 17.1956 13.9979 17.0188 13.9979 16.8007C13.9979 16.5826 13.821 16.4058 13.6029 16.4058C13.3848 16.4058 13.208 16.5826 13.208 16.8007C13.208 17.0188 13.3848 17.1956 13.6029 17.1956Z" fill="black"/>
              <path d="M15.4669 17.1956C15.6851 17.1956 15.8619 17.0188 15.8619 16.8007C15.8619 16.5826 15.6851 16.4058 15.4669 16.4058C15.2488 16.4058 15.072 16.5826 15.072 16.8007C15.072 17.0188 15.2488 17.1956 15.4669 17.1956Z" fill="black"/>
              <path d="M17.331 17.1956C17.5491 17.1956 17.7259 17.0188 17.7259 16.8007C17.7259 16.5826 17.5491 16.4058 17.331 16.4058C17.1128 16.4058 16.936 16.5826 16.936 16.8007C16.936 17.0188 17.1128 17.1956 17.331 17.1956Z" fill="black"/>
              <path d="M19.1947 17.1956C19.4128 17.1956 19.5896 17.0188 19.5896 16.8007C19.5896 16.5826 19.4128 16.4058 19.1947 16.4058C18.9766 16.4058 18.7998 16.5826 18.7998 16.8007C18.7998 17.0188 18.9766 17.1956 19.1947 17.1956Z" fill="black"/>
              <path d="M21.0587 17.1956C21.2769 17.1956 21.4537 17.0188 21.4537 16.8007C21.4537 16.5826 21.2769 16.4058 21.0587 16.4058C20.8406 16.4058 20.6638 16.5826 20.6638 16.8007C20.6638 17.0188 20.8406 17.1956 21.0587 17.1956Z" fill="black"/>
              <path d="M14.4948 18.5647C14.7129 18.5647 14.8897 18.3879 14.8897 18.1698C14.8897 17.9517 14.7129 17.7749 14.4948 17.7749C14.2767 17.7749 14.0999 17.9517 14.0999 18.1698C14.0999 18.3879 14.2767 18.5647 14.4948 18.5647Z" fill="black"/>
              <path d="M16.3583 18.5647C16.5764 18.5647 16.7532 18.3879 16.7532 18.1698C16.7532 17.9517 16.5764 17.7749 16.3583 17.7749C16.1402 17.7749 15.9634 17.9517 15.9634 18.1698C15.9634 18.3879 16.1402 18.5647 16.3583 18.5647Z" fill="black"/>
              <path d="M18.2223 18.5647C18.4404 18.5647 18.6172 18.3879 18.6172 18.1698C18.6172 17.9517 18.4404 17.7749 18.2223 17.7749C18.0042 17.7749 17.8274 17.9517 17.8274 18.1698C17.8274 18.3879 18.0042 18.5647 18.2223 18.5647Z" fill="black"/>
              <path d="M20.0863 18.5647C20.3044 18.5647 20.4812 18.3879 20.4812 18.1698C20.4812 17.9517 20.3044 17.7749 20.0863 17.7749C19.8682 17.7749 19.6914 17.9517 19.6914 18.1698C19.6914 18.3879 19.8682 18.5647 20.0863 18.5647Z" fill="black"/>
              <path d="M21.9503 18.5647C22.1685 18.5647 22.3453 18.3879 22.3453 18.1698C22.3453 17.9517 22.1685 17.7749 21.9503 17.7749C21.7322 17.7749 21.5554 17.9517 21.5554 18.1698C21.5554 18.3879 21.7322 18.5647 21.9503 18.5647Z" fill="black"/>
              <path d="M13.6029 19.7937C13.821 19.7937 13.9979 19.6169 13.9979 19.3988C13.9979 19.1807 13.821 19.0039 13.6029 19.0039C13.3848 19.0039 13.208 19.1807 13.208 19.3988C13.208 19.6169 13.3848 19.7937 13.6029 19.7937Z" fill="black"/>
              <path d="M15.4669 19.7937C15.6851 19.7937 15.8619 19.6169 15.8619 19.3988C15.8619 19.1807 15.6851 19.0039 15.4669 19.0039C15.2488 19.0039 15.072 19.1807 15.072 19.3988C15.072 19.6169 15.2488 19.7937 15.4669 19.7937Z" fill="black"/>
              <path d="M17.331 19.7937C17.5491 19.7937 17.7259 19.6169 17.7259 19.3988C17.7259 19.1807 17.5491 19.0039 17.331 19.0039C17.1128 19.0039 16.936 19.1807 16.936 19.3988C16.936 19.6169 17.1128 19.7937 17.331 19.7937Z" fill="black"/>
              <path d="M19.1947 19.7937C19.4128 19.7937 19.5896 19.6169 19.5896 19.3988C19.5896 19.1807 19.4128 19.0039 19.1947 19.0039C18.9766 19.0039 18.7998 19.1807 18.7998 19.3988C18.7998 19.6169 18.9766 19.7937 19.1947 19.7937Z" fill="black"/>
              <path d="M21.0587 19.7937C21.2769 19.7937 21.4537 19.6169 21.4537 19.3988C21.4537 19.1807 21.2769 19.0039 21.0587 19.0039C20.8406 19.0039 20.6638 19.1807 20.6638 19.3988C20.6638 19.6169 20.8406 19.7937 21.0587 19.7937Z" fill="black"/>
              <path d="M7.03721 6.72559C6.23887 6.72559 5.58936 7.52666 5.58936 8.51143C5.58936 9.49619 6.23887 10.2973 7.03721 10.2973C7.83555 10.2973 8.48506 9.49619 8.48506 8.51143C8.48506 7.52671 7.8356 6.72559 7.03721 6.72559ZM7.03721 9.50742C6.68052 9.50742 6.3792 9.05132 6.3792 8.51143C6.3792 7.97148 6.68057 7.51538 7.03721 7.51538C7.3939 7.51538 7.69522 7.97148 7.69522 8.51143C7.69522 9.05132 7.39385 9.50742 7.03721 9.50742Z" fill="black"/>
              <path d="M9.45298 14.7026C8.65464 14.7026 8.00513 15.5037 8.00513 16.4884C8.00513 17.4731 8.65464 18.2743 9.45298 18.2743C10.2513 18.2743 10.9008 17.4731 10.9008 16.4884C10.9008 15.5037 10.2513 14.7026 9.45298 14.7026ZM9.45298 17.4844C9.09629 17.4844 8.79497 17.0283 8.79497 16.4884C8.79497 15.9485 9.09634 15.4925 9.45298 15.4925C9.80967 15.4925 10.111 15.9486 10.111 16.4884C10.111 17.0283 9.80967 17.4844 9.45298 17.4844Z" fill="black"/>
              <path d="M3.41416 14.7026C2.61582 14.7026 1.96631 15.5037 1.96631 16.4884C1.96631 17.4731 2.61582 18.2743 3.41416 18.2743C4.2125 18.2743 4.86201 17.4731 4.86201 16.4884C4.86201 15.5037 4.2125 14.7026 3.41416 14.7026ZM3.41421 17.4844C3.05752 17.4844 2.7562 17.0283 2.7562 16.4884C2.7562 15.9485 3.05757 15.4925 3.41421 15.4925C3.7709 15.4925 4.07222 15.9486 4.07222 16.4884C4.07222 17.0283 3.7709 17.4844 3.41421 17.4844Z" fill="black"/>
              <path d="M22.3685 12.7772C23.875 12.3216 25 10.5825 25 8.51138C25 8.29326 24.8232 8.11646 24.6051 8.11646H21.9661C21.81 5.88389 20.3453 4.12793 18.5664 4.12793H7.0373C5.15469 4.12793 3.62305 6.09434 3.62305 8.51133C3.62305 9.99717 4.20234 11.3118 5.08569 12.1049H3.41426C1.53164 12.105 0 14.0714 0 16.4884C0 18.9055 1.53164 20.8718 3.41426 20.8718H20.5549C22.4375 20.8718 23.9691 18.9054 23.9691 16.4884C23.9691 14.9265 23.3291 13.5538 22.3685 12.7772ZM24.1944 8.9064C24.0712 10.4437 23.2365 11.6916 22.1524 12.0197C22.7158 11.4762 23.1465 10.7068 23.3628 9.78794C23.4128 9.57563 23.2813 9.36299 23.0689 9.31304C22.8568 9.26304 22.644 9.39458 22.594 9.60698C22.2906 10.8957 21.464 11.8438 20.5071 12.0587C21.0598 11.5446 21.4927 10.8189 21.7262 9.95293C21.7831 9.74238 21.6583 9.52563 21.4478 9.4688C21.2372 9.41196 21.0204 9.53672 20.9636 9.74727C20.6332 10.9726 19.8422 11.8482 18.9232 12.0568C19.5058 11.5115 19.9514 10.728 20.1728 9.78799C20.2227 9.57568 20.0912 9.36309 19.8789 9.31309C19.6666 9.26309 19.454 9.39463 19.404 9.60698C19.1018 10.8902 18.2809 11.8355 17.3292 12.0559C17.9112 11.5106 18.3565 10.7274 18.5777 9.78794C18.6276 9.57563 18.4961 9.36304 18.2838 9.31304C18.0717 9.26304 17.8588 9.39458 17.8089 9.60693C17.5058 10.8942 16.6806 11.8417 15.725 12.0582C16.2852 11.5361 16.7213 10.7958 16.952 9.91143C17.0071 9.70039 16.8807 9.48467 16.6696 9.42964C16.4586 9.37451 16.2429 9.50103 16.1878 9.71201C15.862 10.9609 15.0638 11.852 14.131 12.0589C14.6969 11.5313 15.1356 10.7803 15.3645 9.88228C15.4184 9.6709 15.2907 9.45591 15.0793 9.40205C14.8681 9.34814 14.653 9.47583 14.5991 9.68726C14.2305 11.1333 13.2341 12.105 12.1196 12.105H12.0097C12.8133 11.3829 13.3647 10.2282 13.457 8.90635H24.1944V8.9064ZM18.5664 4.91792V4.91787C19.916 4.91787 21.0306 6.32021 21.1746 8.11655H20.3717C20.3087 7.21821 20.0323 6.36265 19.5773 5.67358C19.4572 5.49155 19.2121 5.44141 19.0302 5.56162C18.8482 5.68184 18.798 5.92681 18.9182 6.10874C19.2899 6.67173 19.5189 7.37329 19.5792 8.1166H18.7765C18.7146 7.23433 18.4463 6.39146 18.0055 5.70913C17.8871 5.52593 17.6427 5.47339 17.4594 5.59175C17.2762 5.71011 17.2237 5.95459 17.342 6.13779C17.7023 6.69536 17.9246 7.38667 17.984 8.1166H17.1815C17.1189 7.22324 16.8451 6.37178 16.3946 5.68477C16.275 5.50239 16.0302 5.45151 15.8478 5.57109C15.6653 5.69067 15.6145 5.9355 15.7341 6.11792C16.1021 6.67915 16.3291 7.37754 16.3891 8.1166H15.5863C15.5258 7.25923 15.2703 6.43633 14.8511 5.76523C14.7355 5.58027 14.4918 5.52393 14.3069 5.63955C14.122 5.75513 14.0657 5.99878 14.1813 6.18369C14.524 6.73237 14.7361 7.40732 14.794 8.1166H13.9913C13.9309 7.25923 13.6753 6.43633 13.2561 5.76523C13.1405 5.58027 12.8968 5.52393 12.712 5.63955C12.527 5.75513 12.4707 5.99878 12.5863 6.18369C12.9291 6.73237 13.1412 7.40732 13.1991 8.1166H13.0761C12.858 8.1166 12.6812 8.29341 12.6812 8.51152C12.6812 9.79224 12.189 10.9179 11.4504 11.5544C12.0441 10.7654 12.4105 9.69263 12.4105 8.51152C12.4105 7.55532 12.1766 6.64731 11.7338 5.88579C11.6241 5.69717 11.3824 5.6332 11.1939 5.74287C11.0053 5.85249 10.9414 6.09419 11.051 6.28276C11.4237 6.92388 11.6208 7.69458 11.6208 8.51152C11.6208 10.493 10.4435 12.1051 8.99634 12.1051H8.98906C9.87241 11.312 10.4517 9.99736 10.4517 8.51152C10.4517 7.02568 9.87241 5.71108 8.98906 4.91792H18.5664V4.91792ZM4.41289 8.51138C4.41289 6.52988 5.59019 4.91777 7.0373 4.91777C8.48442 4.91777 9.66172 6.52988 9.66172 8.51138C9.66172 10.4929 8.48442 12.105 7.0373 12.105C5.59023 12.105 4.41289 10.4929 4.41289 8.51138ZM7.50132 12.8948C7.05645 13.2943 6.68896 13.8258 6.43359 14.4453C6.17827 13.8258 5.81074 13.2943 5.36587 12.8948H7.50132ZM3.41426 20.082C1.96714 20.082 0.789844 18.4699 0.789844 16.4884C0.789844 14.5069 1.96714 12.8948 3.41426 12.8948C4.86138 12.8948 6.03867 14.5069 6.03867 16.4884C6.03867 18.4699 4.86138 20.082 3.41426 20.082ZM5.36587 20.082C5.81074 19.6826 6.17822 19.1511 6.43359 18.5316C6.68892 19.151 7.05645 19.6826 7.50132 20.082H5.36587ZM9.45288 20.082C8.00576 20.082 6.82847 18.4699 6.82847 16.4884C6.82847 14.5069 8.00576 12.8948 9.45288 12.8948C10.9 12.8948 12.0773 14.5069 12.0773 16.4884C12.0773 18.4699 10.9 20.082 9.45288 20.082ZM20.5549 20.082H11.4045C12.2878 19.2889 12.8671 17.9743 12.8671 16.4884C12.8671 15.0026 12.2878 13.6879 11.4045 12.8948H20.5548C22.002 12.8948 23.1792 14.5069 23.1792 16.4884C23.1792 18.4699 22.002 20.082 20.5549 20.082Z" fill="black"/>
            </svg>
          </i>
          <span class="link_name arrow-text">Production</span>
        </a>
        <i class='arrow'>
        <svg class='arrow-svg' width="32px" height="32px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12 12.94L8.53044 9.46891L7.46954 10.5293L12 15.0618L16.5304 10.5293L15.4695 9.46891L12 12.94Z" fill="#1F2328"></path> </g></svg>
        </i>
      </div>
      <ul class="sub-menu">
        <li><a class="link_name" href="#">Production </a></li>
        <li><a href="#">Packages</a></li>
        <li><a href="#">Paper Mill</a></li>
        <li><a href="#">Printing Press</a></li>

      </ul>
    </li>
      
    <li>
      <a href="#">
        <i>
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16" data-darkreader-inline-fill="" style="--darkreader-inline-fill:currentColor;">
            <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"></path>
          </svg>
        </i>
        <span class="link_name">Sale Report</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Sale Report</a></li>
      </ul>
    </li>

    <li>
      <a href="#">
        <i>
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-cash-coin bc-black" viewBox="0 0 16 16" data-darkreader-inline-fill="" style="--darkreader-inline-fill:currentColor;">
          <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"></path>
          <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"></path>
          <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"></path>
          <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"></path>
        </svg>
        </i>
        <span class="link_name">Finance</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Finance</a></li>
      </ul> 
    </li>

    <li>
      <a href="#">
        <i class='bx bx-cog'></i>
        <span class="link_name">Setting</span>
      </a>
      <ul class="sub-menu blank">
        <li><a class="link_name" href="#">Setting</a></li>
      </ul>
    </li>
    </ul>
  </div>


  <section class="home-section"    >
 <!-- TOP NAVAGATION BAR   -->
 <nav class="navbar navbar-expand-lg  navbar-expand-md   "  >
  <div class="container-fluid d-flex align-items-center">


      <button class="navbar-toggler  bg-dark pb-2 " type="button" data-bs-toggle="collapse" data-bs-target="#navbarTo1" aria-controls="navbarTo1" aria-expanded="false" aria-label="Toggle navigation">
          <svg width="20" height="20" viewBox="0 0 6 5" fill="none" xmlns="http://www.w3.org/2000/svg"  >
              <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.5C0 2.36739 0.0526785 2.24021 0.146447 2.14645C0.240215 2.05268 0.367392 2 0.5 2H5.5C5.63261 2 5.75979 2.05268 5.85355 2.14645C5.94732 2.24021 6 2.36739 6 2.5C6 2.63261 5.94732 2.75979 5.85355 2.85355C5.75979 2.94732 5.63261 3 5.5 3H0.5C0.367392 3 0.240215 2.94732 0.146447 2.85355C0.0526785 2.75979 0 2.63261 0 2.5ZM0 4.5C0 4.36739 0.0526785 4.24021 0.146447 4.14645C0.240215 4.05268 0.367392 4 0.5 4H5.5C5.63261 4 5.75979 4.05268 5.85355 4.14645C5.94732 4.24021 6 4.36739 6 4.5C6 4.63261 5.94732 4.75979 5.85355 4.85355C5.75979 4.94732 5.63261 5 5.5 5H0.5C0.367392 5 0.240215 4.94732 0.146447 4.85355C0.0526785 4.75979 0 4.63261 0 4.5Z" fill="white"/>
              <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5C0 0.367392 0.0526785 0.240214 0.146447 0.146446C0.240215 0.052678 0.367392 0 0.5 0H5.5C5.63261 0 5.75979 0.052678 5.85355 0.146446C5.94732 0.240214 6 0.367392 6 0.5C6 0.632608 5.94732 0.759786 5.85355 0.853554C5.75979 0.947322 5.63261 1 5.5 1H0.5C0.367392 1 0.240215 0.947322 0.146447 0.853554C0.0526785 0.759786 0 0.632608 0 0.5ZM0 2.5C0 2.36739 0.0526785 2.24021 0.146447 2.14645C0.240215 2.05268 0.367392 2 0.5 2H5.5C5.63261 2 5.75979 2.05268 5.85355 2.14645C5.94732 2.24021 6 2.36739 6 2.5C6 2.63261 5.94732 2.75979 5.85355 2.85355C5.75979 2.94732 5.63261 3 5.5 3H0.5C0.367392 3 0.240215 2.94732 0.146447 2.85355C0.0526785 2.75979 0 2.63261 0 2.5Z" fill="white"/>
          </svg>
      </button>

    <div class="collapse navbar-collapse justify-content-between " id="navbarTo1">

    <div class = " d-flex justify-content-between" >
      <i class='bx bx-menu mt-1'>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
      </i>

      <div class="search ">
         <i class="fa-search">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"></path>
          </svg>
        </i>
        <input type="text" class="form-control border-3 "   style = "width:220%;font-weight:bold"    placeholder="Search Anything"  >
      </div>
      </div>

      <ul class="navbar-nav   d-flex align-items-center  ">
        <li class="nav-item ">
          <a  class="nav-link " href="javascript:poptasticCalender('../Converter/calc.php');"   style = "color: black;"  >
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-calendar-event" viewBox="0 0 16 16">
              <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
              <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
            </svg>
          </a>
        </li>

        <li class="nav-item ">
        <a href="BugReport.php" class="nav-link align-middle px-0    "style = "color: black;">
          <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-bug" viewBox="0 0 16 16">
             <path d="M4.355.522a.5.5 0 0 1 .623.333l.291.956A4.979 4.979 0 0 1 8 1c1.007 0 1.946.298 2.731.811l.29-.956a.5.5 0 1 1 .957.29l-.41 1.352A4.985 4.985 0 0 1 13 6h.5a.5.5 0 0 0 .5-.5V5a.5.5 0 0 1 1 0v.5A1.5 1.5 0 0 1 13.5 7H13v1h1.5a.5.5 0 0 1 0 1H13v1h.5a1.5 1.5 0 0 1 1.5 1.5v.5a.5.5 0 1 1-1 0v-.5a.5.5 0 0 0-.5-.5H13a5 5 0 0 1-10 0h-.5a.5.5 0 0 0-.5.5v.5a.5.5 0 1 1-1 0v-.5A1.5 1.5 0 0 1 2.5 10H3V9H1.5a.5.5 0 0 1 0-1H3V7h-.5A1.5 1.5 0 0 1 1 5.5V5a.5.5 0 0 1 1 0v.5a.5.5 0 0 0 .5.5H3c0-1.364.547-2.601 1.432-3.503l-.41-1.352a.5.5 0 0 1 .333-.623zM4 7v4a4 4 0 0 0 3.5 3.97V7H4zm4.5 0v7.97A4 4 0 0 0 12 11V7H8.5zM12 6a3.989 3.989 0 0 0-1.334-2.982A3.983 3.983 0 0 0 8 2a3.983 3.983 0 0 0-2.667 1.018A3.989 3.989 0 0 0 4 6h8z"/>
           </svg>
        </a>
      </li>


        <li class="nav-item dropdown">
          <a  class="nav-link btn-sm" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style = "color: black;    padding-top:10px; padding-bottom: 10px;"  >
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
              <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
            </svg>
            <span class="badge bg-danger" id = "NotificationNavbar__counter"  >4</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end " aria-labelledby="offcanvasNavbarDropdown" id = "NotificationNavbar__" >
          </ul>
        </li>

        <li class="nav-item dropdown  " style = "border-left:1.5px solid black; margin-left:10px;" >
          <a class="nav-link dropdown-toggle " href="#" id="UserArea" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style = "color: black;" >
            <strong > <?php echo (isset($_SESSION['user'] )) ? $_SESSION['user']  : '' ; ?></strong>
            <img  style = " border-radius: 50%;" src="../Public/Img/profile.png" width="45px"  height = "45px" alt="User Image">
          </a>
          <ul class="dropdown-menu" aria-labelledby="UserArea">
            <li><a class="dropdown-item" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
                <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
              </svg>

              My Profile</a></li>
            <li><a class="dropdown-item" href="#">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chat-right-dots" viewBox="0 0 16 16">
                <path d="M2 1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h9.586a2 2 0 0 1 1.414.586l2 2V2a1 1 0 0 0-1-1H2zm12-1a2 2 0 0 1 2 2v12.793a.5.5 0 0 1-.854.353l-2.853-2.853a1 1 0 0 0-.707-.293H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12z"/>
                <path d="M5 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
              </svg>
              Chats</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="../Auth/Login.php">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0v2z"/>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
              </svg>

              Logout</a></li>
          </ul>
        </li>
      </ul>

    </div>
  </div>
</nav> <!-- TOP NAVAGATION BAR   -->

<script>
  let iconlink = document.querySelectorAll(".arrow-link");
  let arrow = document.querySelectorAll(".arrow");
  let arrow_svg = document.querySelectorAll(".arrow-svg");
  let arrow_text = document.querySelectorAll(".arrow-text");

  for (var i = 0; i < arrow.length; i++) {
      arrow[i].addEventListener("click", (e)=>{ e.target.parentElement.parentElement.classList.toggle("showMenu"); });
      arrow_svg[i].addEventListener("click", (e)=>{ e.target.parentElement.parentElement.parentElement.classList.toggle("showMenu"); });
      arrow_text[i].addEventListener("click", (e)=>{ e.target.parentElement.parentElement.parentElement.classList.toggle("showMenu"); });
      iconlink[i].addEventListener("click", (e)=>{ e.target.parentElement.classList.toggle("showMenu"); });
  }

  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".bx-menu");
 
  sidebarBtn.addEventListener("click", ()=> {
    sidebar.classList.toggle("close");
  });




  function GetNotification(department , user_id ) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)  {
            var response = JSON.parse(this.responseText);
            var html = ''; 
            var noti_count = 0 ; 
            if(response !=  '-1'){
              for(var count = 0; count < response.length; count++) {
                html += `<li><a class="dropdown-item p-0  " style = "font-size:12px; width:300px; " href="#" id = 'Notification_${response[count].id}' onclick = "RemoveNotification(${response[count].id})">`; 
                html += '<div class="m-0" style = "border-radius:0px;"><div class="row ps-2 pe-2"><div class="col-2 py-2 text-center " >'; 
                html += '<svg xmlns="http://www.w3.org/2000/svg" width="27" height="27" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">'; 
                html += '<path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>';
                html += '</svg></div>';
                html += '<div class="col-10 my-1 p-0"><div class=" d-flex justify-content-between ">';      
                html += `<div><strong>${response[count].title}</strong> </div>`;
                html += `<div class = "me-4">${response[count].created_at} </div> `;
                html += ' </div><div class="">';
                html += response[count].alert_comment
                html += '</div></div></div></div></a></li>';
                last_time_notfication =   response[count].last_time ; 
                // console.log(response[count].last_time); 
              }
              noti_count = response.length;  
            }
            document.getElementById('NotificationNavbar__counter').innerHTML = noti_count; 


            
            
            document.getElementById('NotificationNavbar__').innerHTML = html;  
        }
    }
    xmlhttp.open("GET", "GetNotification.php?department=" + department + "&user_id=" + user_id , true);
    xmlhttp.send();
  } // END OF GET NOTIFICATION

  window.onload = function() {
    GetNotification(`<?=$USER_DEPARTMENT?>`,`<?=$_SESSION['EId']?>`);
  };
  
  setInterval(() => {
    GetNotification(`<?=$USER_DEPARTMENT?>`,`<?=$_SESSION['EId']?>`);
  }, 40 * 1000);

  function RemoveNotification(id){
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200)  {
          var response = JSON.parse(this.responseText);
          if(response !=  '-1')  {
            document.getElementById('Notification_' + response[0]).remove();
            document.getElementById('NotificationNavbar__counter').innerHTML = Number(document.getElementById('NotificationNavbar__counter').innerHTML) - 1 ; 
          } 
          else console.log('Somthing went wrong!'); 
        }
    }
    xmlhttp.open("GET", "SetNotification.php?id=" + id, true);
    xmlhttp.send();
  } // end of Remove Notification 


</script>
 


