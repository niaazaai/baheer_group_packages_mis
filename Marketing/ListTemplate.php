<?php 
  require_once '../App/partials/header.inc';    
  require_once '../App/partials/Menu/MarketingMenu.inc';




  if (filter_has_var(INPUT_POST, 'FieldType')   ) {
    if(!empty($_POST['FieldType'])) {
        $FieldType = $Controller->CleanInput($_POST['FieldType']);
        $Query = 'SELECT * FROM TABLENAME WHERE FIELDNAME = ? ';
        $DBRows  = $Controller->QueryData( $Query, [$FieldType] );
        $DataRows-> $DBRows->fetch_assoc(); 
        // OR 
        $DataRows-> $DBRows->fetch_row(); 
        foreach ($DataRows as $key => $value) {
            print $key . ' : ' . $value ; 
        }

    } // END OF !EMPTY 
  } // END OF FILTER VAR 
?>
  
<div class="m-3">
    <div class="card mb-3 ">
    <div class="card-body d-flex justify-content-between">
        <h5 class = "my-2" > 
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
            <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h13zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
            <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8zm0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zm-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zM4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0zm0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0z"/>
        </svg>
        template list   <span style= "color:#FA8b09; font-size:12px;" > subtitle  </span>     
        </h5>
        <div>
        <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
                <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
                <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
            </svg>
        </a>
        <a href="" class = "btn btn-outline-primary  my-1"  title = " " >button 2</a>
        <a href = "" class="btn btn-outline-primary  my-1"  title = " ">button 1</a>
        <button type="button" class="btn btn-outline-primary  my-1 " data-bs-toggle="modal" data-bs-target="#staticBackdrop" title = "Click to setup Columns  ">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z"/>
                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z"/>
            </svg>
            Setup
        </button>
        </div>
    </div>
    </div>

        
    <div class="card mb-3" style = "font-family: Roboto,sans-serif;">
    <div class="card-body">
            <div class="row">
            <div class = "col-lg-6 col-md-6 col-sm-6 col-xs-12  ">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" >
                    <div class="input-group my-1  ">
                        <select class="form-select d-block" name="FieldType"  style = "max-width: 30%;">
                            <option disabled >Select a Field </option>  

                            <option value="CustName "> Customer Name</option>
                            <option value="CustCatagory "> Catagory</option>
                            <option value="CusReference "> Refrence </option>
                            <option value="CusProvince "> Customer Province</option>
                            <option value="CustPostion ">Customer Postion </option>
                            <option value="AgencyName "> Agency Name</option>
                            <option value="BusinessType "> Business Type </option>
                            <option value="BusinessNature ">Business Nature </option>
                            <option value="CusReference "> Point of Contact</option>
                        </select>
                        <input type="text" name = "SearchTerm"  aria-label="Write Search Term" class= "form-control" required  >  
                        <button type="submit" class="btn btn-outline-primary">Find</button>
                    </div>
                </form>
            </div>
            </div>
    </div>
    </div>




    <div class="card">
        <div class="card-body  table-responsive   ">
            <table class="table " id = ""  >
            <thead>
                <tr>
                    <th>Table heading</th>
                    <th>Table heading</th>
                    <th>Table heading</th>
                    <th>Table heading</th>
                    <th>OPS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>data</td>
                    <td>data</td>
                    <td>data</td>
                    <td>data </td>
                    <td style = "padding:0px;" >
                        <a class="btn btn-outline-primary btn-sm m-1"   href=" "  title = "" > 
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            OPS1
                        </a>
                        <a class="btn btn-outline-danger btn-sm m-1"   href=" "  title = "" > 
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                            </svg>
                            OPS2
                        </a>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" style = "font-family: Roboto,sans-serif;" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div   div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Model ... </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae hic corrupti, veritatis laborum repudiandae veniam accusamus quas unde? Omnis natus dolore officiis maiores in soluta nemo optio nesciunt est aliquam!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger " data-bs-dismiss="modal">Close</button>
                <button   class="btn btn-primary"  type="submit" >Set Columns</button>
            </div>
    </div>
    </div>
    <!-- Modal -->

</div><!-- END OF M-3  -->
<?php require_once '../App/partials/footer.inc'; ?>
