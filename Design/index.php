<?php 
     ob_start();  require_once '../App/partials/Header.inc'; require_once '../App/partials/Menu/MarketingMenu.inc'; 
    
    $Gate = require_once  $ROOT_DIR . '/Auth/Gates/DESIGN_DEPT';
    if(!in_array( $Gate['VIEW_DASHBOARD'] , $_SESSION['ACCESS_LIST']  )) {
        header("Location:../index.php?msg=You are not authorized to access dashboard of design department page!" );
    }

   
    $NEWJOB=$Controller->QueryData('SELECT COUNT(CTNId) AS new_jobs FROM carton  WHERE CTNStatus="Design" OR  CTNStatus="Film"',[])->fetch_assoc()['new_jobs'];
 

    $JobUnderProcess='SELECT DISTINCT COUNT(CTNId) AS JOBS FROM `carton` 
        INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 
        INNER JOIN designinfo ON designinfo.CaId=carton.CTNId  
        WHERE CTNStatus="DesignProcess" order by CTNOrderDate DESC';
    $DataRows=$Controller->QueryData($JobUnderProcess,[]);
    $Row=$DataRows->fetch_assoc();

    $SFA= $Controller->QueryData('SELECT COUNT(DesignId) AS SFA FROM designinfo WHERE DesignStatus="Sent For Approval"',[])->fetch_assoc()['SFA'];
    $Step = $Controller->QueryData("SELECT COUNT(CaId) AS Process FROM designinfo WHERE DesignStatus='Processing'",[])->fetch_assoc()['Process'];
    $Pending = $Controller->QueryData("SELECT COUNT(CaId) AS Pending FROM designinfo WHERE DesignStatus='Pending'",[])->fetch_assoc()['Pending'];
    $Done = $Controller->QueryData("SELECT COUNT(CaId) AS Done FROM designinfo WHERE DesignStatus='Done'",[])->fetch_assoc()['Done'];
    $number_of_films =$Controller->QueryData('SELECT COUNT(`CTNId`) AS film FROM `carton` INNER JOIN ppcustomer ON ppcustomer.CustId=carton.CustId1 WHERE CTNStatus="Film" order by CTNOrderDate DESC',[])->fetch_assoc()['film'];

    $FCEM = $Controller->QueryData("SELECT 
    SUM(IF(month = 'Jan', total, 0)) AS 'Jan',
    SUM(IF(month = 'Feb', total, 0)) AS 'Feb',
    SUM(IF(month = 'Mar', total, 0)) AS 'Mar',
    SUM(IF(month = 'Apr', total, 0)) AS 'Apr',
    SUM(IF(month = 'May', total, 0)) AS 'May',
    SUM(IF(month = 'Jun', total, 0)) AS 'Jun',
    SUM(IF(month = 'Jul', total, 0)) AS 'Jul',
    SUM(IF(month = 'Aug', total, 0)) AS 'Aug',
    SUM(IF(month = 'Sep', total, 0)) AS 'Sep',
    SUM(IF(month = 'Oct', total, 0)) AS 'Oct',
    SUM(IF(month = 'Nov', total, 0)) AS 'Nov',
    SUM(IF(month = 'Dec', total, 0)) AS 'Dec',
    SUM(total) AS total_yearly
    FROM ( SELECT DATE_FORMAT(CompleteTime, '%b') AS month, COUNT(designinfo.DesignId) as total FROM designinfo
    WHERE CompleteTime <= NOW() and CompleteTime >= Date_add(Now(),interval - 12 month) AND YEAR(CompleteTime) = YEAR(CURRENT_DATE()) AND design_type = 'Film'
    GROUP BY DATE_FORMAT(CompleteTime, '%m-%Y')) as sub ",[])->fetch_assoc();    
    
    $ColorCount = []; 
    $a = $Controller->QueryData("SELECT CTNColor as Color , COUNT(*) as Count FROM carton GROUP BY CTNColor ORDER BY CTNColor",[]); 
    while ($NumberofColors =  $a->fetch_assoc()) {
        $ColorCount[ $NumberofColors['Color']] =  $NumberofColors['Count']  ; 
    }
 
    $DataRows=$Controller->QueryData("SELECT DesignerName1, COUNT(DesignStatus) AS Design 
    FROM designinfo WHERE DesignStatus='Done' group by DesignerName1",[]);
    $EmployeesDesign = []; 
    while($Data=$DataRows->fetch_assoc()) {
        $EmployeesDesign[$Data['DesignerName1']] = $Data['Design'] ; 
    }

    $DP = $Controller->QueryData("SELECT  DesignId,DesignerName1,COUNT(DesignId) AS Design 
    FROM designinfo WHERE DesignStatus='Processing' group by DesignerName1",[]);


?>

<script src="../Public/Js/chart.js"></script>
<style>
    .NewJobs-bg { background-color:#FB7AFC;}
    .circle {
        width: 60px;
        height: 60px;
        line-height: 60px;
        border-radius: 50%;
        font-size: 20px;
        color: #fff;
        text-align: center;
        margin:0px; 
        display:table-cell;
        vertical-align: middle; 
    }
    .circle-jobs { background:#f2f7ff; }
    .circle-jup { background:#f2f7ff; color:#ffc107; }
    .circle-process { background:#f2f7ff; color:#FA05FF; }
    .circle-pended { background:#f2f7ff; color:#FF0000; }
    .circle-done { background:#f2f7ff; color:#198754; }
</style>
 

<div class="card m-3 shadow">
    <div class="card-body d-flex justify-content-between">
        <h3 class="my-1  "> 
            <svg id = "marketing-svg"  width="50" height="50" viewBox="0 0 504 504" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M251.734 328.746C256.854 328.746 260.267 333.013 260.267 337.279C260.267 341.545 256.854 345.812 251.734 345.812C246.614 345.812 243.201 341.545 243.201 337.279C243.201 333.013 246.614 328.746 251.734 328.746Z" fill="#FFD7D7"/>
            <path d="M499.201 38.613V294.613H379.734V72.746L337.067 4.47998H465.067C482.134 4.47998 499.201 21.546 499.201 38.613ZM123.734 260.48V294.613H4.2666V38.613C4.2666 21.546 21.3336 4.47998 38.4006 4.47998H89.6006H123.734V55.68V89.813V123.946V158.079V192.212V226.345V260.48ZM337.067 4.47998L294.4 72.747V294.614H260.267V4.47998H337.067Z" fill="#F2EDDA"/>
            <path d="M337.066 4.47998L379.733 72.746H294.4L337.066 4.47998Z" fill="#ECF4F7"/>
            <path d="M337.066 294.613H294.4V72.7461H379.733V294.613H337.066Z" fill="#80D6FA"/>
            <path d="M209.066 448.213H294.4V379.947H209.066V448.213Z" fill="#ECF4F7"/>
            <path d="M123.733 226.346V192.213V158.08V123.946V89.813V55.68V4.47998H260.266V294.613H123.733V260.48V226.346Z" fill="#FFE079"/>
            <path d="M499.201 294.613V345.813C499.201 362.88 482.134 379.946 465.068 379.946H294.401H209.068H38.4006C21.3336 379.946 4.26758 362.879 4.26758 345.813V294.613H123.734H260.267H294.4H337.067H379.734H499.201Z" fill="#ECF4F7"/>
            <path d="M465.067 490.88V499.413H396.8V490.88C396.8 476.373 407.893 465.28 422.4 465.28H439.467C453.974 465.28 465.067 476.373 465.067 490.88Z" fill="#ECF4F7"/>
            <path d="M465.067 503.68H396.8C394.24 503.68 392.533 501.973 392.533 499.413V490.88C392.533 474.667 406.186 461.013 422.4 461.013H439.467C455.68 461.013 469.334 474.666 469.334 490.88V499.413C469.334 501.973 467.627 503.68 465.067 503.68ZM401.067 495.147H460.8V490.88C460.8 478.933 451.413 469.547 439.467 469.547H422.4C410.453 469.547 401.067 478.934 401.067 490.88V495.147ZM345.601 503.68H38.401C35.841 503.68 34.134 501.973 34.134 499.413C34.134 496.853 35.841 495.146 38.401 495.146H51.201V482.346C51.201 479.786 52.908 478.079 55.468 478.079C58.028 478.079 59.735 479.786 59.735 482.346V495.146H85.335V482.346C85.335 479.786 87.042 478.079 89.602 478.079C92.162 478.079 93.869 479.786 93.869 482.346V495.146H119.469V482.346C119.469 479.786 121.176 478.079 123.736 478.079C126.296 478.079 128.003 479.786 128.003 482.346V495.146H153.603V482.346C153.603 479.786 155.31 478.079 157.87 478.079C160.43 478.079 162.137 479.786 162.137 482.346V495.146H187.737V482.346C187.737 479.786 189.444 478.079 192.004 478.079C194.564 478.079 196.271 479.786 196.271 482.346V495.146H221.871V482.346C221.871 479.786 223.578 478.079 226.138 478.079C228.698 478.079 230.405 479.786 230.405 482.346V495.146H256.005V482.346C256.005 479.786 257.712 478.079 260.272 478.079C262.832 478.079 264.539 479.786 264.539 482.346V495.146H290.139V482.346C290.139 479.786 291.846 478.079 294.406 478.079C296.966 478.079 298.673 479.786 298.673 482.346V495.146H324.273V482.346C324.273 479.786 325.98 478.079 328.54 478.079C331.1 478.079 332.807 479.786 332.807 482.346V495.146H345.607C348.167 495.146 349.874 496.853 349.874 499.413C349.874 501.973 348.161 503.68 345.601 503.68ZM294.401 452.48C291.841 452.48 290.134 450.773 290.134 448.213V414.08C290.134 411.52 291.841 409.813 294.401 409.813C296.961 409.813 298.668 411.52 298.668 414.08V448.213C298.667 450.773 296.961 452.48 294.401 452.48ZM209.067 452.48C206.507 452.48 204.8 450.773 204.8 448.213V414.08C204.8 411.52 206.507 409.813 209.067 409.813C211.627 409.813 213.334 411.52 213.334 414.08V448.213C213.334 450.773 211.627 452.48 209.067 452.48ZM465.067 384.213H38.401C18.774 384.213 0.001 365.44 0.001 345.813V294.613C0.001 292.053 1.708 290.346 4.268 290.346H465.068C467.628 290.346 469.335 292.053 469.335 294.613C469.335 297.173 467.628 298.88 465.068 298.88H8.534V345.813C8.534 360.32 23.894 375.68 38.401 375.68H465.068C479.575 375.68 494.935 360.32 494.935 345.813V38.613C494.935 24.106 479.575 8.746 465.068 8.746H379.734C377.174 8.746 375.467 7.039 375.467 4.479C375.467 1.919 377.174 0.212 379.734 0.212H465.067C484.694 0.212 503.467 18.985 503.467 38.612V345.812C503.467 365.44 484.694 384.213 465.067 384.213ZM251.734 350.08C244.907 350.08 238.934 344.107 238.934 337.28C238.934 330.453 244.907 324.48 251.734 324.48C258.561 324.48 264.534 330.453 264.534 337.28C264.534 344.106 258.561 350.08 251.734 350.08ZM251.734 333.013C249.174 333.013 247.467 334.72 247.467 337.28C247.467 339.84 249.174 341.547 251.734 341.547C254.294 341.547 256.001 339.84 256.001 337.28C256.001 334.72 254.294 333.013 251.734 333.013ZM379.734 264.746C377.174 264.746 375.467 263.039 375.467 260.479V106.879C375.467 104.319 377.174 102.612 379.734 102.612C382.294 102.612 384.001 104.319 384.001 106.879V260.479C384.001 263.04 382.294 264.746 379.734 264.746ZM337.067 264.746C334.507 264.746 332.8 263.039 332.8 260.479V106.879C332.8 104.319 334.507 102.612 337.067 102.612C339.627 102.612 341.334 104.319 341.334 106.879V260.479C341.334 263.04 339.627 264.746 337.067 264.746ZM294.401 264.746C291.841 264.746 290.134 263.039 290.134 260.479V72.746C290.134 71.893 290.134 71.039 290.987 70.186L333.654 1.92C335.361 -0.64 339.627 -0.64 340.481 1.92L383.148 70.187C384.001 71.894 384.001 72.747 383.148 74.454C382.295 76.161 380.588 77.014 379.735 77.014H328.535C325.975 77.014 324.268 75.307 324.268 72.747C324.268 70.187 325.975 68.48 328.535 68.48H372.055L337.068 12.16L298.668 73.6V260.48C298.667 263.04 296.961 264.746 294.401 264.746ZM260.267 264.746C257.707 264.746 256 263.039 256 260.479V8.746H128V51.413H174.933C177.493 51.413 179.2 53.12 179.2 55.68C179.2 58.24 177.493 59.947 174.933 59.947H128V85.547H140.8C143.36 85.547 145.067 87.254 145.067 89.814C145.067 92.374 143.36 94.081 140.8 94.081H128V119.681H140.8C143.36 119.681 145.067 121.388 145.067 123.948C145.067 126.508 143.36 128.215 140.8 128.215H128V153.815H174.933C177.493 153.815 179.2 155.522 179.2 158.082C179.2 160.642 177.493 162.349 174.933 162.349H128V187.949H140.8C143.36 187.949 145.067 189.656 145.067 192.216C145.067 194.776 143.36 196.483 140.8 196.483H128V222.083H140.8C143.36 222.083 145.067 223.79 145.067 226.35C145.067 228.91 143.36 230.617 140.8 230.617H128V260.484C128 263.044 126.293 264.751 123.733 264.751C121.173 264.751 119.466 263.044 119.466 260.484V4.484C119.466 1.924 121.173 0.217 123.733 0.217H260.266C262.826 0.217 264.533 1.924 264.533 4.484V260.484C264.534 263.04 262.827 264.746 260.267 264.746ZM4.267 264.746C1.707 264.746 0 263.039 0 260.479V38.613C0 18.986 18.773 0.213 38.4 0.213H89.6C92.16 0.213 93.867 1.92 93.867 4.48C93.867 7.04 92.16 8.747 89.6 8.747H38.4C23.894 8.746 8.534 24.106 8.534 38.613V260.48C8.534 263.04 6.827 264.746 4.267 264.746Z" fill="#51565F"/>
            </svg>
            &nbsp; 
            Design Department
        </h3>

        <div class = "mt-2">
            
            <?php  if(in_array( $Gate['VIEW_DASHBOARD_JOB_CENTER_BUTTON'] , $_SESSION['ACCESS_LIST']  )) { ?>
                <a href="JobCenter.php" class=" btn btn-outline-primary " >
                    <svg width="23" height="23" viewBox="0 0 505 505" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M482.743 160.797L417.551 191.665C443.652 248.064 435.629 316.332 393.262 365.359L357.747 329.843V453.419H481.323L444.541 416.637C508.969 345.468 521.634 243.996 482.743 160.797Z" fill="#F31919"></path>
                        <path d="M343.938 482.719L313.042 417.555C256.667 443.68 188.371 435.633 139.349 393.267L174.864 357.751H51.2881V481.327L88.0701 444.545C159.244 508.968 260.717 521.633 343.938 482.719Z" fill="#FA05FF"></path>
                        <path d="M111.451 139.348L146.966 174.863V51.2874H23.3853L60.1623 88.0644C-4.23167 159.267 -16.8977 260.739 21.9933 343.939L87.1613 313.043C61.0373 256.666 69.0843 188.371 111.451 139.348Z" fill="#48FFD3"></path>
                        <path d="M453.425 146.96V23.3844L416.648 60.1614C345.445 -4.23162 243.973 -16.8976 160.774 21.9934L191.666 87.1574C248.066 61.0564 316.337 69.0794 365.359 111.446L329.844 146.961H453.425V146.96Z" fill="#25B6D2"></path>
                        <path d="M252.354 351.081C306.88 351.081 351.082 306.879 351.082 252.353C351.082 197.827 306.88 153.625 252.354 153.625C197.828 153.625 153.626 197.827 153.626 252.353C153.626 306.879 197.828 351.081 252.354 351.081Z" fill="black"></path>
                        <path d="M205.181 268.009C205.181 270.606 204.793 272.862 204.019 274.776C203.267 276.713 202.173 278.308 200.737 279.562C199.325 280.838 197.616 281.783 195.61 282.398C193.628 283.036 191.406 283.355 188.945 283.355C186.94 283.355 185.072 283.185 183.34 282.843C181.608 282.501 180.184 282.091 179.067 281.612V273.956C179.705 274.298 180.423 274.628 181.221 274.947C182.041 275.289 182.884 275.585 183.75 275.836C184.639 276.109 185.539 276.314 186.45 276.451C187.362 276.611 188.262 276.69 189.15 276.69C191.68 276.69 193.571 275.961 194.824 274.503C196.077 273.045 196.704 270.903 196.704 268.077V240.768H180.195V234.273H205.181V268.009ZM205.864 224.771C205.864 225.523 205.728 226.23 205.454 226.891C205.181 227.551 204.793 228.132 204.292 228.634C203.813 229.112 203.232 229.5 202.549 229.796C201.888 230.069 201.17 230.206 200.396 230.206C199.621 230.206 198.903 230.069 198.242 229.796C197.581 229.5 197 229.112 196.499 228.634C196.021 228.132 195.645 227.551 195.371 226.891C195.098 226.23 194.961 225.523 194.961 224.771C194.961 224.02 195.098 223.313 195.371 222.652C195.645 221.992 196.021 221.41 196.499 220.909C197 220.408 197.581 220.021 198.242 219.747C198.903 219.451 199.621 219.303 200.396 219.303C201.17 219.303 201.888 219.451 202.549 219.747C203.232 220.021 203.813 220.408 204.292 220.909C204.793 221.41 205.181 221.992 205.454 222.652C205.728 223.313 205.864 224.02 205.864 224.771ZM249.512 251.363C249.512 254.098 249.124 256.604 248.35 258.883C247.575 261.139 246.458 263.076 245 264.693C243.542 266.311 241.753 267.564 239.634 268.453C237.515 269.342 235.099 269.786 232.388 269.786C229.813 269.786 227.511 269.41 225.483 268.658C223.455 267.906 221.735 266.79 220.322 265.309C218.91 263.805 217.827 261.936 217.075 259.703C216.323 257.447 215.947 254.827 215.947 251.842C215.947 249.085 216.335 246.578 217.109 244.322C217.907 242.066 219.035 240.141 220.493 238.546C221.974 236.951 223.774 235.72 225.894 234.854C228.013 233.966 230.405 233.521 233.071 233.521C235.669 233.521 237.982 233.909 240.01 234.684C242.038 235.436 243.758 236.563 245.171 238.067C246.584 239.571 247.655 241.44 248.384 243.673C249.136 245.883 249.512 248.447 249.512 251.363ZM240.83 251.568C240.83 247.968 240.146 245.268 238.779 243.468C237.435 241.645 235.441 240.733 232.798 240.733C231.34 240.733 230.098 241.018 229.072 241.588C228.047 242.158 227.204 242.944 226.543 243.946C225.882 244.926 225.392 246.077 225.073 247.398C224.777 248.72 224.629 250.133 224.629 251.637C224.629 255.26 225.358 257.994 226.816 259.84C228.275 261.663 230.269 262.574 232.798 262.574C234.188 262.574 235.396 262.301 236.421 261.754C237.446 261.184 238.278 260.41 238.916 259.43C239.554 258.427 240.033 257.254 240.352 255.909C240.671 254.565 240.83 253.118 240.83 251.568ZM287.964 251.021C287.964 254.212 287.508 256.969 286.597 259.293C285.708 261.617 284.455 263.554 282.837 265.104C281.242 266.63 279.351 267.77 277.163 268.521C274.976 269.251 272.594 269.615 270.02 269.615C267.49 269.615 265.132 269.422 262.944 269.034C260.78 268.67 258.706 268.168 256.724 267.53V220.704H265.063V232.052L264.722 238.888C265.975 237.27 267.433 235.971 269.097 234.991C270.783 234.011 272.799 233.521 275.146 233.521C277.197 233.521 279.02 233.932 280.615 234.752C282.21 235.572 283.543 236.746 284.614 238.272C285.708 239.776 286.54 241.611 287.109 243.775C287.679 245.917 287.964 248.333 287.964 251.021ZM279.214 251.363C279.214 249.449 279.077 247.82 278.804 246.476C278.53 245.131 278.132 244.026 277.607 243.16C277.106 242.294 276.479 241.668 275.728 241.28C274.998 240.87 274.155 240.665 273.198 240.665C271.785 240.665 270.43 241.235 269.131 242.374C267.855 243.513 266.499 245.063 265.063 247.022V262.198C265.724 262.449 266.533 262.654 267.49 262.813C268.47 262.973 269.461 263.053 270.464 263.053C271.785 263.053 272.982 262.779 274.053 262.232C275.146 261.686 276.069 260.911 276.821 259.908C277.596 258.906 278.188 257.687 278.599 256.251C279.009 254.793 279.214 253.163 279.214 251.363ZM323.853 258.78C323.853 260.763 323.408 262.46 322.52 263.873C321.654 265.263 320.492 266.402 319.033 267.291C317.598 268.157 315.957 268.784 314.111 269.171C312.288 269.581 310.42 269.786 308.506 269.786C305.954 269.786 303.652 269.661 301.602 269.41C299.551 269.182 297.614 268.84 295.791 268.385V260.865C297.933 261.754 300.063 262.403 302.183 262.813C304.325 263.201 306.341 263.395 308.232 263.395C310.42 263.395 312.049 263.053 313.12 262.369C314.214 261.663 314.761 260.751 314.761 259.635C314.761 259.111 314.647 258.632 314.419 258.199C314.191 257.766 313.758 257.356 313.12 256.969C312.505 256.559 311.628 256.148 310.488 255.738C309.349 255.305 307.856 254.827 306.011 254.303C304.302 253.824 302.798 253.289 301.499 252.696C300.223 252.081 299.163 251.363 298.32 250.543C297.477 249.723 296.839 248.777 296.406 247.706C295.996 246.612 295.791 245.336 295.791 243.878C295.791 242.465 296.11 241.132 296.748 239.879C297.386 238.626 298.332 237.532 299.585 236.598C300.861 235.641 302.445 234.889 304.336 234.342C306.227 233.795 308.438 233.521 310.967 233.521C313.154 233.521 315.091 233.635 316.777 233.863C318.464 234.091 319.956 234.342 321.255 234.615V241.417C319.272 240.779 317.404 240.335 315.649 240.084C313.918 239.811 312.197 239.674 310.488 239.674C308.779 239.674 307.401 239.981 306.353 240.597C305.327 241.212 304.814 242.066 304.814 243.16C304.814 243.684 304.917 244.151 305.122 244.562C305.327 244.972 305.726 245.37 306.318 245.758C306.934 246.145 307.777 246.555 308.848 246.988C309.941 247.398 311.377 247.854 313.154 248.355C315.16 248.925 316.846 249.54 318.213 250.201C319.58 250.839 320.674 251.568 321.494 252.389C322.337 253.209 322.941 254.143 323.306 255.191C323.67 256.24 323.853 257.436 323.853 258.78Z" fill="#F8F2F2"></path>
                    </svg>
                    Job Center
                </a>
            <?php } ?>  
            <a href="Manual/ProductList_Manual.php" class="text-primary" title="Click to Read the User Guide">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
                    <path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"></path>
                    <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"></path>
                    <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"></path>
                </svg>
            </a>
        </div>
    </div>
</div>



<?php if(isset($_GET['msg']) && !empty($_GET['msg']))  {
          echo' <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                  <strong>Attention: </strong>'. $_GET['msg'] .' 
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'; 
      }  
?>

  

    <div class = "m-3">
        <div class="row ">
       
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_NEW_JOB_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12 mb-md-3">
            <a href="JobCenter.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #0d6efd;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div>
                            <h2 class = "p-0 m-0" style= "color:#0d6efd" ><?= sprintf('%02d', $NEWJOB);?></h2>
                            <span>New Jobs</span>
                        </div>
                        <div >
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-circle-square" viewBox="0 0 16 16">
                            <path d="M0 6a6 6 0 1 1 12 0A6 6 0 0 1 0 6z"/>
                            <path d="M12.93 5h1.57a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1.57a6.953 6.953 0 0 1-1-.22v1.79A1.5 1.5 0 0 0 5.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 4h-1.79c.097.324.17.658.22 1z"/>
                        </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 
          
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_SFA_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12 mb-sm-3">
            <a href="JobCenter.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #ffc107;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div  style= "color:#ffc107">
                            <h2 class = "p-0 m-0" ><?= sprintf('%02d', $SFA);?></h2>
                            <span>Sent For Approval</span>
                        </div>
                        <div >
                            <svg width="50" height="50" viewBox="0 0 32 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 6H17V8H15V6ZM6.5 6C6.224 6 6 6.224 6 6.5C6 6.776 6.224 7 6.5 7C6.776 7 7 6.776 7 6.5C7 6.224 6.776 6 6.5 6ZM21.5 25H20V23H12V25H10.5C10.224 25 10 25.224 10 25.5C10 25.776 10.224 26 10.5 26H21.5C21.776 26 22 25.776 22 25.5C22 25.224 21.776 25 21.5 25ZM32 3V19C32 20.657 30.657 22 29 22H3C1.343 22 0 20.657 0 19V3C0 1.343 1.343 0 3 0H29C30.657 0 32 1.343 32 3ZM26.966 6.174C26.846 5.602 26.379 5.144 25.806 5.03C25.024 4.876 24.331 5.33 24.093 6H18V5H14V6H7.908C7.67 5.33 6.976 4.876 6.195 5.03C5.622 5.143 5.155 5.602 5.035 6.174C4.83 7.145 5.565 8 6.5 8C7.152 8 7.702 7.581 7.908 7H14V7.224C9.612 8.121 6.255 11.882 6.014 16.47C5.999 16.757 6.227 17 6.515 17C6.778 17 6.999 16.796 7.012 16.533C7.221 12.468 10.146 9.123 14 8.244V9H18V8.243C21.854 9.123 24.779 12.468 24.988 16.532C25.002 16.796 25.222 17 25.485 17C25.773 17 26.001 16.757 25.986 16.47C25.745 11.882 22.388 8.121 18 7.224V7H24.092C24.299 7.581 24.848 8 25.5 8C26.435 8 27.17 7.145 26.966 6.174ZM25.5 6C25.224 6 25 6.224 25 6.5C25 6.776 25.224 7 25.5 7C25.776 7 26 6.776 26 6.5C26 6.224 25.776 6 25.5 6Z" fill="#FFC107"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 

        <?php  if(in_array( $Gate['VIEW_DASHBAORD_PROCESS_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12 mb-md-3">
            <a href="JobCenter.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #FA05FF;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div  style= "color:#FA05FF">
                            <h2 class = "p-0 m-0" ><?= sprintf('%02d', $Step);?></h2>
                            <span>Processing</span>
                        </div>
                        <div >
                            <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-arrow-repeat" style = "color:#FA05FF" viewBox="0 0 16 16">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z"/>
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 

        <?php  if(in_array( $Gate['VIEW_DASHBAORD_PENDED_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12 mb-sm-3 ">
            <a href="JobCenter.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #FF0000;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div  style= "color:#FF0000">
                            <h2 class = "p-0 m-0" ><?= sprintf('%02d', $Pending );?></h2>
                            <span>Pended Jobs</span>
                        </div>
                        <div >
                            <svg width="50" height="50" viewBox="0 0 45 75" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M44.9744 51.2909C44.9985 44.3394 44.9738 22.0222 44.9735 21.8007C44.9857 18.6169 42.6705 16.113 39.7027 16.1006H39.6805C38.5123 16.1006 37.4278 16.4907 36.5404 17.1528V12.0616C36.5462 10.5455 35.9976 9.11936 34.9955 8.04622C33.9866 6.96574 32.6334 6.36734 31.1853 6.36128H31.163C30.0068 6.36128 28.933 6.74761 28.0528 7.4041V5.7C28.0586 4.18356 27.5004 2.75553 26.4809 1.67888C25.4613 0.602394 24.1026 0.0062234 22.6549 0H22.6326C19.631 0 17.1792 2.5366 17.1673 5.65915V7.33468C16.2917 6.68074 15.2248 6.29394 14.0757 6.28915H14.0536C11.0346 6.28915 8.56881 8.82574 8.55678 11.9485V24.5231C7.67548 23.8647 6.60009 23.475 5.44183 23.4701H5.41959C2.44327 23.4701 0.0120382 26.0066 3.17387e-06 29.1316C0.000155516 29.2875 0.0254444 44.8039 3.17387e-06 51.435C-0.000149169 51.5017 0.00518341 51.5678 0.0158474 51.6327C0.115327 64.5354 10.2109 75 22.606 75C28.614 75 34.2448 72.5678 38.4613 68.1515C42.6778 63.7352 45 57.8371 45 51.544C45 51.457 44.9913 51.3724 44.9744 51.2909V51.2909ZM31.176 8.75489C32.0076 8.7584 32.784 9.10117 33.3619 9.72C33.9415 10.3406 34.2588 11.1688 34.2553 12.0568V36.1454L28.0528 36.1246V12.0255C28.0598 10.2222 29.4551 8.75489 31.176 8.75489V8.75489ZM22.606 72.6064C11.4094 72.6064 2.30022 63.1111 2.30022 51.4398C2.30022 51.376 2.29535 51.3134 2.2859 51.2523C2.31028 44.5122 2.28545 29.2821 2.28529 29.1343C2.29215 27.331 3.69827 25.8637 5.43269 25.8637C7.14852 25.8708 8.55007 27.3377 8.55693 29.1287V47.6156C8.55693 48.2746 9.0656 48.8097 9.69493 48.8124C12.8719 48.8258 15.8409 50.1364 18.055 52.5029C20.2658 54.8659 21.4763 58.0109 21.4635 61.3588C21.461 62.0197 21.9705 62.5578 22.6015 62.5604C23.2351 62.5604 23.7462 62.0277 23.7487 61.3684C23.7641 57.3865 22.3215 53.643 19.6871 50.8273C17.3085 48.2853 14.2017 46.763 10.8421 46.4705V11.9532C10.8489 10.1804 12.3196 8.68261 14.0665 8.68261C15.7694 8.68979 17.1605 10.1564 17.1673 11.9472V27.7068C17.1673 28.3677 17.6789 28.9036 18.3099 28.9036C18.9409 28.9036 19.4525 28.3677 19.4525 27.7068V5.66394C19.4593 3.86058 20.886 2.39362 22.6456 2.39362C23.483 2.39713 24.2688 2.74197 24.8585 3.36463C25.4482 3.98729 25.771 4.81324 25.7677 5.69505V36.1168L19.4523 36.0957V32.4941C19.4523 31.8332 18.9407 31.2973 18.3097 31.2973C17.6787 31.2973 17.1672 31.8332 17.1672 32.4941V36.0884L16.0283 36.0846C15.3953 36.0846 14.884 36.6179 14.882 37.2776C14.8801 37.9385 15.3899 38.4761 16.021 38.4782L35.2694 38.5423C35.3116 38.5473 35.3544 38.5503 35.3979 38.5503C35.4394 38.5503 35.4806 38.5476 35.5211 38.5431L37.6793 38.5503C38.3123 38.5503 38.8236 38.017 38.8256 37.3573C38.8275 36.6964 38.3176 36.1588 37.6866 36.1567L36.5404 36.1529V21.7645C36.5473 19.9612 37.956 18.494 39.6935 18.494C41.3799 18.5011 42.6954 19.9494 42.6884 21.7972C42.6885 22.0275 42.7138 44.9074 42.6884 51.5389C42.688 51.6251 42.6966 51.7103 42.7135 51.7932C42.5858 63.2931 33.6148 72.6064 22.606 72.6064V72.6064Z" fill="#FF0000"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_DONE_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12 ">
            <a href="JobCenter.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #198754;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div  style= "color:#198754">
                            <h2 class = "p-0 m-0" ><?= sprintf('%02d',$Done  ); ?></h2>
                            <span>Done</span>
                        </div>
                        <div >
                            <svg width="50" height="50" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M199.996 0C89.713 0 0 89.72 0 200C0 310.28 89.713 400 199.996 400C310.279 400 400 310.28 400 200C400 89.72 310.279 0 199.996 0ZM199.996 373.77C104.18 373.77 26.23 295.816 26.23 200C26.23 104.183 104.179 26.231 199.996 26.231C295.813 26.231 373.767 104.184 373.767 200C373.768 295.816 295.812 373.77 199.996 373.77Z" fill="#198754"/>
                                <path d="M272.406 134.526L169.275 237.652L127.586 195.972C122.463 190.855 114.164 190.852 109.041 195.975C103.916 201.1 103.916 209.4 109.041 214.523L160.004 265.478C162.565 268.036 165.92 269.316 169.275 269.316C172.63 269.316 175.994 268.036 178.554 265.474C178.562 265.463 178.568 265.452 178.581 265.439L290.95 153.071C296.075 147.951 296.075 139.645 290.95 134.525C285.828 129.402 277.523 129.402 272.406 134.526Z" fill="#198754"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_FILM_CARD'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-sm-6 col-md-4 col-lg-4 col-xl-2 col-xs-12  ">
            <a href="Film.php" style = "text-decoration:none;">
                <div class="card shadow-lg" style="border:2px solid #5E00EC;">
                    <div class="card-body d-flex justify-content-between align-items-center" >
                        <div  style= "color:#5E00EC">
                            <h2 class = "p-0 m-0" ><?= sprintf('%02d',$number_of_films ); ?></h2>
                            <span> Films </span>
                        </div>
                        <div >
                            <svg width="45" height="45" viewBox="0 0 62 60" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M59 47H1C0.4 47 0 47.4 0 48V59C0 59.6 0.4 60 1 60H59C59.6 60 60 59.6 60 59V48C60 47.4 59.6 47 59 47ZM58 58H51V53H49V58H41V53H39V58H31V53H29V58H21V53H19V58H11V53H9V58H2V49H58V58Z" fill="#5E00EC"/>
                                <path d="M1 8H7H50C50.1 8 50.1 8 50.2 8C50.4 8 50.5 7.9 50.6 7.8L59.3 4.9C59.7 4.8 60 4.4 60 4C60 3.6 59.7 3.2 59.3 3.1L50.6 0.2C50.5 0.1 50.3 0 50.1 0H50H7H1C0.4 0 0 0.4 0 1V7C0 7.6 0.4 8 1 8ZM51 5.6V2.4L55.8 4L51 5.6ZM49 3H11V5H49V6H8V2H49V3ZM2 2H6V6H2V2Z" fill="#5E00EC"/>
                                <path d="M2.27557 40V13.8182H19.9176V18.3821H7.81108V24.6207H19.0099V29.1847H7.81108V35.4361H19.9688V40H2.27557ZM29.5089 13.8182L34.7887 22.7415H34.9933L40.2987 13.8182H46.5501L38.56 26.9091L46.729 40H40.3626L34.9933 31.0639H34.7887L29.4194 40H23.0785L31.2731 26.9091L23.2319 13.8182H29.5089Z" fill="#5E00EC"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </a>
        </div> <!-- END OF COL-LG-2 --> 
        <?php } ?> 
    </div> <!-- END OF ROW  --> 
</div> <!-- END OF M-3 --> 

<div class= "m-3">
    <div class="row  " >
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_FILM_GENERATED_CHART'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 mb-3">
            <div class="card shadow">
                <div class="card-body">
                    <div  ><canvas id="myChart"></canvas></div>
                </div>
            </div>
        </div>
        <?php } ?> 
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_DESIGN_REPORT_CHART'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 mb-3">
            <div class="card shadow">
                <div class="card-body  ">
                    <div><canvas id="myChart1" ></canvas></div>
                </div>
            </div>
        </div>
        <?php } ?> 
    </div>
</div><!-- END OF M-3  -->

<div class= "m-3">
    <div class="row " >
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_COLOR_CHART'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-xl-6 col-lg-6 col-sm-12 col-md-6 ">
            <div class="card shadow">
                <div class="card-body  d-flex justify-content-center">
                    <div><canvas id="myChart2"></canvas></div>
                </div>
            </div>
        </div>
        <?php } ?> 
        <?php  if(in_array( $Gate['VIEW_DASHBAORD_CURRENT_DESIGN_CHART'] , $_SESSION['ACCESS_LIST']  )) { ?>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-body ">
                    <ol class="list-group list-group-numbered"> 
                        <div class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="me-auto">
                                <div class="fw-bold" > Currently Designing  </div>
                            </div>
                        </div>
                        <?php while($employee = $DP->fetch_assoc()): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                <div class="fw-bold"><?= $employee['DesignerName1']; ?> </div>
                            
                                </div>
                                <span class="badge bg-primary rounded-pill"><?= $employee['Design']; ?> Design</span>
                            </li>
                        <?php endwhile; ?>
                    </ol>
                </div>
            </div>
        </div>
        <?php } ?> 
    </div>
</div><!-- END OF M-3  -->

<div style = "height:50px;" ></div>

<input type="hidden" id = "Film" value = '<?=json_encode($FCEM)?>' >
<input type="hidden" id = "ColorCount" value = '<?=json_encode($ColorCount)?>' >
<input type="hidden" id = "EmployeesDesign" value = '<?=json_encode($EmployeesDesign)?>' >
<script>
    
    var xValues = [];
    var yValues = []; 
    JSON.parse(document.getElementById('Film').value, function (key, value) {
        xValues.push(key); 
        yValues.push(value); 
    });
    const data = {
        labels: xValues,
        datasets: [{
        label: 'Film Generated In Each Month',
        data: yValues,
        backgroundColor: [
            'rgba(255, 99, 132 )',
            'rgba(255, 159, 64 )',
            'rgba(255, 205, 86 )',
            'rgba(75, 192, 192 )',
            'rgba(54, 162, 235 )',
            'rgba(153, 102, 255 )',
            'rgba(201, 203, 207 )',
            'rgba(153, 102, 255 )',
        ],
        }]
    };
    const config = {
        type: 'bar',
        data: data,
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }  
        },
    };
    var myChart = new Chart( document.getElementById('myChart'), config );


    var laabels = []; 
    var dataaa = []; 
    JSON.parse(document.getElementById('EmployeesDesign').value, function (key, value) {
        laabels.push(key); 
        dataaa.push(value); 
    });
    const data1 = {
        labels: laabels,
        datasets: [{
        label: 'Design Report',
        data: dataaa,
        backgroundColor: [
            'rgba(255, 99, 132 )',
            'rgba(255, 159, 64 )',
            'rgba(255, 205, 86 )',
            'rgba(75, 192, 192 )',
            'rgba(54, 162, 235 )',
            'rgba(153, 102, 255 )',
            'rgba(201, 203, 207 )',
            'rgba(153, 102, 255 )',
        ],
        }]
    };

    const config1 = {
        type: 'bar',
        data: data1,
        options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }  
        },
    };
    var myChart = new Chart( document.getElementById('myChart1'), config1 );


    var labels2 = []; 
    var data3 = []; 
    JSON.parse(document.getElementById('ColorCount').value, function (key, value) {

        console.log(  key); 
        switch(key){
            case '1':
                key = 'One Color'; 
                break;
            case '2':
                key = 'Two Color'; 
            break;

            case '3':
                key = 'Three Color'; 
            break;

            case '4':
                key = 'Four Color'; 
            break;

            case 'NoColor':
                key = 'No Color'; 
            break;
            
            case 'FullColor':
                key = 'Full Color'; 
            break;
            default: 
                break;
        }


        labels2.push(key); 
        data3.push(value); 
    });
    const data2 = {
        labels: labels2,
        datasets: [{
            label: 'Jobs According to Color',
            data: data3,
            backgroundColor: [
                'rgb(255, 99, 132)',
                '#F637EC',
                'rgb(255, 205, 86)',
                '#54E346',
                'rgb(54, 162, 235)'
            ],
            hoverOffset: 4
        }]
    };
    const config2 = {
        type: 'doughnut',
        data: data2,
        options: {
            legend: {display: true} , 
            position: 'bottom',
             
        }
    };
    new Chart( document.getElementById('myChart2'), config2 );

</script>
<?php  require_once '../App/partials/Footer.inc'; ?>