<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bootstrap 5 Side Bar Navigation</title>
  <!-- bootstrap 5 css -->
  <link rel="stylesheet" href="../../Public/Css/bootstrap.min.css">
  <!-- BOX ICONS CSS-->
  <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" rel="stylesheet" />
  <!-- custom css -->

  <style>
      * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

 
.side-navbar {
  width: 250px;
  height: 100%;
  position: fixed;
  margin-left: -300px;
  background-color: #ffffff;
  transition: 0.5s;
}

.nav-link:active,
.nav-link:focus,
.nav-link:hover {
  background-color: #f3f3f3;
  border-left:3px solid black;
  font-weight:bold; 
  color:black;
  padding:15px;
  
}

.my-container {
  transition: 0.4s;
}

.active-nav {
  margin-left: 0;
}

/* for main section */
.active-cont {
  margin-left: 250px;
}

#menu-btn {
  background-color: #100901;
  color: #fff;
  margin-left: -62px;
}

.my-container input {
  border-radius: 2rem;
  padding: 2px 20px;
}



 
  </style>
</head>

<body>
  <!-- Side-Nav -->
  <div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column"  id="sidebar">
    <ul class="nav flex-column text-white w-100 bg-white">
      <a href="#" class="nav-link h3 text-white my-2  mb-4 text-center">
                        <img class= "img-fluid" src="../../Public/Img/Brand.svg" width="100px"  height = "100px" alt=""> 
                    </a>

        <li class="nav-item  px-2 align-items-center  py-1   border-top sidebar-nav-item ">
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-speedometer2" viewBox="0 0 16 16">
                <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item">Dashboard</span>
            </a>
        </li>

        <li class="nav-item  px-2 align-items-center  py-1  sidebar-nav-item ">
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-sliders2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10.5 1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4H1.5a.5.5 0 0 1 0-1H10V1.5a.5.5 0 0 1 .5-.5ZM12 3.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Zm-6.5 2A.5.5 0 0 1 6 6v1.5h8.5a.5.5 0 0 1 0 1H6V10a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5ZM1 8a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2A.5.5 0 0 1 1 8Zm9.5 2a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V13H1.5a.5.5 0 0 1 0-1H10v-1.5a.5.5 0 0 1 .5-.5Zm1.5 2.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5Z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item">System Setting </span>
            </a>
        </li>
        
        <li class="nav-item  px-2 align-items-center  py-1  sidebar-nav-item " >
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"/>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item">Gatepass </span>
            </a>
        </li>

        <li class="nav-item  px-2 align-items-center  py-1   sidebar-nav-item ">
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-person-rolodex" viewBox="0 0 16 16">
                <path d="M8 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                <path d="M1 1a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h.5a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5.5.5 0 0 1 1 0 .5.5 0 0 0 .5.5h.5a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1H6.707L6 1.293A1 1 0 0 0 5.293 1H1Zm0 1h4.293L6 2.707A1 1 0 0 0 6.707 3H15v10h-.085a1.5 1.5 0 0 0-2.4-.63C11.885 11.223 10.554 10 8 10c-2.555 0-3.886 1.224-4.514 2.37a1.5 1.5 0 0 0-2.4.63H1V2Z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item ">Human Resource  </span>
            </a>
        </li>
        <li class="nav-item  px-2 align-items-center  py-1    sidebar-nav-item ">
            <a class="nav-link px-0   align-middle"  href = "#"   data-bs-toggle="collapse" data-bs-target="#pro-collapse" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-bag-dash" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M5.5 10a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5z"/>
                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item ">Procurment</span> 
            </a>
            <ul class="collapse nav shadow-sm rounded ms-1 flex-column border  sb-sub-menu  mb-3  " id="pro-collapse" style = "    " >
            <li><a href="#" class=" nav-link sm-fl"  >Local Purchase</a></li>
            <li><a href="#" class=" nav-link sidebar-menu-links "   >International Purchase</a></li>
            </ul>
        </li>
                      
                      
                      
                      
                      
                      
        <li class="nav-item  px-2 align-items-center  py-1  sidebar-nav-item ">
            <a class="nav-link px-0  toggle-btn align-middle"    data-toggle="collapse"   href = "stock-collapse"   data-bs-toggle="collapse" data-bs-target="#stock-collapse" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434L7.752.066ZM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567L4.25 7.504ZM7.5 9.933l-2.75 1.571v3.134l2.75-1.571V9.933Zm1 3.134 2.75 1.571v-3.134L8.5 9.933v3.134Zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567-2.742 1.567Zm2.242-2.433V3.504L8.5 5.076V8.21l2.75-1.572ZM7.5 8.21V5.076L4.75 3.504v3.134L7.5 8.21ZM5.258 2.643 8 4.21l2.742-1.567L8 1.076 5.258 2.643ZM15 9.933l-2.75 1.571v3.134L15 13.067V9.933ZM3.75 14.638v-3.134L1 9.933v3.134l2.75 1.571Z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item ">Stocks</span> 
            </a>
            <ul class="collapse nav shadow-sm rounded mx-3 mb-3  flex-column border  sb-sub-menu" id="stock-collapse"   >
                <li><a href="#" class=" nav-link  sm-fl" >Paper</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Raw Material</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Spare Parts</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Sales Branch</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Fixed Assets</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Office Supply / Safety</a></li>
        
            </ul>
        </li>



        
        <li class="nav-item  px-2 align-items-center  py-1    sidebar-nav-item ">
            <a class="nav-link px-0   align-middle"  href = "#"   data-bs-toggle="collapse" data-bs-target="#mark-collapse" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-megaphone" viewBox="0 0 16 16">
                <path d="M13 2.5a1.5 1.5 0 0 1 3 0v11a1.5 1.5 0 0 1-3 0v-.214c-2.162-1.241-4.49-1.843-6.912-2.083l.405 2.712A1 1 0 0 1 5.51 15.1h-.548a1 1 0 0 1-.916-.599l-1.85-3.49a68.14 68.14 0 0 0-.202-.003A2.014 2.014 0 0 1 0 9V7a2.02 2.02 0 0 1 1.992-2.013 74.663 74.663 0 0 0 2.483-.075c3.043-.154 6.148-.849 8.525-2.199V2.5zm1 0v11a.5.5 0 0 0 1 0v-11a.5.5 0 0 0-1 0zm-1 1.35c-2.344 1.205-5.209 1.842-8 2.033v4.233c.18.01.359.022.537.036 2.568.189 5.093.744 7.463 1.993V3.85zm-9 6.215v-4.13a95.09 95.09 0 0 1-1.992.052A1.02 1.02 0 0 0 1 7v2c0 .55.448 1.002 1.006 1.009A60.49 60.49 0 0 1 4 10.065zm-.657.975 1.609 3.037.01.024h.548l-.002-.014-.443-2.966a68.019 68.019 0 0 0-1.722-.082z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item ">Production</span> 
            </a>
            <ul class="collapse nav shadow-sm rounded ms-1 flex-column border  sb-sub-menu  mb-3  " id="mark-collapse"   >
                <li><a href="#" class=" nav-link  sm-fl"  >Packages</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Paper Mill</a></li>
                <li><a href="#" class=" nav-link sidebar-menu-links "  >Printing Press</a></li>
            </ul>
        </li>
        <li class="nav-item  px-2 align-items-center  py-1  sidebar-nav-item ">
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-graph-up" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M0 0h1v15h15v1H0V0Zm14.817 3.113a.5.5 0 0 1 .07.704l-4.5 5.5a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61 4.15-5.073a.5.5 0 0 1 .704-.07Z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item ">Sales Report </span>
            </a>
        </li>

        <li class="nav-item  px-2 align-items-center  py-1   sidebar-nav-item ">
            <a href="index.php" class="nav-link align-middle px-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z"/>
                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z"/>
                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
                </svg>
                <span class="ms-1 d-none d-sm-inline sidebar-nav-item">Finance </span>
            </a>
        </li>
                       

                      
    </ul>

    <span href="#" class="nav-link h4 w-100 mb-5 ">
      <a href=""><i class="bx bxl-instagram-alt "></i></a>
      <a href=""><i class="bx bxl-twitter px-2  "></i></a>
      <a href=""><i class="bx bxl-facebook"></i></a>
    </span>
  </div>

  <!-- Main Wrapper -->
  <div class="p-1 my-container active-cont">






















    <!-- Top Nav -->
    <!-- <nav class="navbar top-navbar navbar-light bg-light px-5">
      <a class="btn border-0 ms-1" id="menu-btn"><i class="bx bx-menu"></i></a>
    </nav> -->

     <!-- TOP NAVAGATION BAR   -->
     <nav class="navbar top-navbar navbar-expand-lg  navbar-expand-md"  style="background-color: white;">
     <a class="btn border-0 ms-2" style = "margin-left:3px;"  id="menu-btn"><i class="bx bx-menu"></i></a>

      <div class="container-fluid d-flex align-items-center">
        <a class="navbar-brand fs-3 text-center" href="#"> <strong class = "text-primary">BAHEER</strong>GROUP</a>
        <button class="navbar-toggler  bg-dark pb-2" type="button" data-bs-toggle="collapse" data-bs-target="#FirstTopNav" aria-controls="FirstTopNav" aria-expanded="false" aria-label="Toggle navigation">
            <svg width="20" height="20" viewBox="0 0 6 5" fill="none" xmlns="http://www.w3.org/2000/svg"  >
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 2.5C0 2.36739 0.0526785 2.24021 0.146447 2.14645C0.240215 2.05268 0.367392 2 0.5 2H5.5C5.63261 2 5.75979 2.05268 5.85355 2.14645C5.94732 2.24021 6 2.36739 6 2.5C6 2.63261 5.94732 2.75979 5.85355 2.85355C5.75979 2.94732 5.63261 3 5.5 3H0.5C0.367392 3 0.240215 2.94732 0.146447 2.85355C0.0526785 2.75979 0 2.63261 0 2.5ZM0 4.5C0 4.36739 0.0526785 4.24021 0.146447 4.14645C0.240215 4.05268 0.367392 4 0.5 4H5.5C5.63261 4 5.75979 4.05268 5.85355 4.14645C5.94732 4.24021 6 4.36739 6 4.5C6 4.63261 5.94732 4.75979 5.85355 4.85355C5.75979 4.94732 5.63261 5 5.5 5H0.5C0.367392 5 0.240215 4.94732 0.146447 4.85355C0.0526785 4.75979 0 4.63261 0 4.5Z" fill="white"/>
                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0.5C0 0.367392 0.0526785 0.240214 0.146447 0.146446C0.240215 0.052678 0.367392 0 0.5 0H5.5C5.63261 0 5.75979 0.052678 5.85355 0.146446C5.94732 0.240214 6 0.367392 6 0.5C6 0.632608 5.94732 0.759786 5.85355 0.853554C5.75979 0.947322 5.63261 1 5.5 1H0.5C0.367392 1 0.240215 0.947322 0.146447 0.853554C0.0526785 0.759786 0 0.632608 0 0.5ZM0 2.5C0 2.36739 0.0526785 2.24021 0.146447 2.14645C0.240215 2.05268 0.367392 2 0.5 2H5.5C5.63261 2 5.75979 2.05268 5.85355 2.14645C5.94732 2.24021 6 2.36739 6 2.5C6 2.63261 5.94732 2.75979 5.85355 2.85355C5.75979 2.94732 5.63261 3 5.5 3H0.5C0.367392 3 0.240215 2.94732 0.146447 2.85355C0.0526785 2.75979 0 2.63261 0 2.5Z" fill="white"/>
            </svg>
        </button>

        <div class="collapse navbar-collapse justify-content-between " id="FirstTopNav">
 
            <form action="">
                <div class="input-group   ">
                    <span class="input-group-text" id="basic-addon1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                    </span>
                    <input type="text" class="form-control form-control-lg "  placeholder="Search Here " aria-label="Username" aria-describedby="basic-addon1">
                </div>
            </form>

          <ul class="navbar-nav   d-flex align-items-center ">
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
              <a  class="nav-link  btn-sm" href="#" id="offcanvasNavbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style = "color: black;    padding-top:10px; padding-bottom: 10px;"  >
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
                  <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2zM8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                </svg>
    
                <span class="badge bg-danger">4</span>
              </a>
              <ul class="dropdown-menu" aria-labelledby="offcanvasNavbarDropdown">
                <li><a class="dropdown-item" href="#">Noti - 1 </a></li>
                <li><a class="dropdown-item" href="#">Noti - 2</a></li>
                <li><a class="dropdown-item" href="#">Noti - 3 </a></li>
                <li><a class="dropdown-item" href="#">Noti - 4 </a></li>
                <li><a class="dropdown-item" href="#">Noti - 5 </a></li>
              </ul>
            </li>
    
            <li class="nav-item dropdown  " style = "border-left:1.5px solid black; margin-left:10px;" >
              <a class="nav-link dropdown-toggle " href="#" id="UserArea" role="button" data-bs-toggle="dropdown" aria-expanded="false"  style = "color: black;" >
                <strong >Username</strong>
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
                <li><a class="dropdown-item" href="#">
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












<?php require_once '../partials/Menu/MarketingMenu.inc';   ?>
    <!--End Top Nav -->
    <h3 class="text-dark p-3">CONTENT HERE  💻 📱  </h3>
  </div>


  <!-- bootstrap js -->
  <script   src="../../Public/Js/bootstrap.min.js"></script>  
  

</body>
<script>
    var menu_btn = document.querySelector("#menu-btn");
var sidebar = document.querySelector("#sidebar");
var container = document.querySelector(".my-container");
menu_btn.addEventListener("click", () => {
  sidebar.classList.toggle("active-nav");
  container.classList.toggle("active-cont");
});

 
</script>
</html>