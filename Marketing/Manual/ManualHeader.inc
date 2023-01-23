<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="BGC MIS Department">
    <title>BGIS User Manual </title>
    <link href="bootstrap.min.css" rel="stylesheet">
    <style>

        html {
        height: -webkit-fill-available;
        }
        body {
        
        min-height: -webkit-fill-available;
        }
        main {
        
        height: -webkit-fill-available;
         
        overflow-x: auto;
        overflow-y: hidden;
        }

        .dropdown-toggle { outline: 0; }

        .btn-toggle {
        padding: .25rem .5rem;
        font-weight: 600;
        color: rgba(0, 0, 0, .65);
        background-color: transparent;
        }
        .btn-toggle:hover,
        .btn-toggle:focus {
        color: rgba(0, 0, 0, .85);
        background-color: #d2f4ea;
        }

        .btn-toggle::before {
        width: 1.25em;
        line-height: 0;
        content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
        transition: transform .35s ease;
        transform-origin: .5em 50%;
        }

        .btn-toggle[aria-expanded="true"] {
        color: rgba(0, 0, 0, .85);
        }
        .btn-toggle[aria-expanded="true"]::before {
        transform: rotate(90deg);
        }

        .btn-toggle-nav a {
        padding: .1875rem .5rem;
        margin-top: .125rem;
        margin-left: 1.25rem;
        }
        .btn-toggle-nav a:hover,
        .btn-toggle-nav a:focus {
        background-color: #d2f4ea;
        }

        .scrollarea {
        overflow-y: auto;
        }



      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
        height: 3rem;
        background-color: rgba(0, 0, 0, .1);
        border: solid rgba(0, 0, 0, .15);
        border-width: 1px 0;
        box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
      }

      .b-example-vr {
        flex-shrink: 0;
        width: 1.5rem;
        height: 100vh;
      }

      .bi {
        vertical-align: -.125em;
        fill: currentColor;
      }

      .nav-scroller {
        position: relative;
        z-index: 2;
        height: 2.75rem;
        overflow-y: hidden;
      }

      .nav-scroller .nav {
        display: flex;
        flex-wrap: nowrap;
        padding-bottom: 1rem;
        margin-top: -1px;
        overflow-x: auto;
        text-align: center;
        white-space: nowrap;
        -webkit-overflow-scrolling: touch;
      }

      .content-font {
        font-family: Roboto,sans-serif; 
      }

      .dot {
        height: 50px;
        width: 50px;
        background-color: red;
        border-radius: 50%;
        color:white;
        display: inline-block;
        padding-top:7.5px;
        padding-left:16px;
      }

    </style>
  </head>
  <body>
  <main class="d-flex flex-nowrap">
    <div class="  p-3 bg-white" style="width: 20vw;">
      <a href="/" class="d-flex align-items-center pb-3 mb-3 link-dark text-decoration-none border-bottom">
        <span class="fs-5 fw-semibold">BGIS User Manual</span>
      </a>
      <ul class="list-unstyled ps-0">
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
            Home
          </button>
          <div class="collapse show" id="home-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Overview</a></li>
            </ul>
          </div>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
            Dashboard
          </button>
          <div class="collapse" id="dashboard-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Overview</a></li>
            </ul>
          </div>
        </li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#product-list-collapse" aria-expanded="false">
            Product List
          </button>
          <div class="collapse" id="product-list-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Introduction</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Product List Introduction</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Product List Opreations</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to list products</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Search Customer Products</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Find a Specific Product</a></li>
                <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to setup Columns </a></li>
            </ul>
          </div>
        </li>

        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#customer-list-collapse" aria-expanded="false">
          Customer List
          </button>
          <div class="collapse" id="customer-list-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Page Introduction</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Page Opreations</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Customer List Introduction</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Customer List Opreations</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to List Customer</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to List Customer According to Status </a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Print Customer List Report </a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Search Specific Customer </a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Register Customer </a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Edit Customer Info</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to setup Columns </a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Quot a Customer</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to View Customer Profile</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">How to Find Customer List</a></li>
                  <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded"> </a></li>
            </ul>
          </div>
        </li>


        <li class="border-top my-3"></li>
        <li class="mb-1">
          <button class="btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
            General 
          </button>
          <div class="collapse" id="account-collapse">
            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
              <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Bug Report </a></li>
              <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">Manual Objectives </a></li>
              <li><a href="#" class="link-dark d-inline-flex text-decoration-none rounded">About BGC</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="b-example-divider b-example-vr"></div>
    <div class="  " style="width: 80vw;">
    <header class="navbar navbar-dark  bg-dark flex-md-nowrap p-0 shadow" >
      <input class="form-control form-control-dark fs-4 w-100" type="text" placeholder="Search topics in here " style = "border-radius:0px;" aria-label="Search">
    </header>
    <div class="mx-5">






























