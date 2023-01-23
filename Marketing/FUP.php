<?php require_once '../App/partials/Header.inc';  ?>
<?php require_once '../App/partials/Menu/MarketingMenu.inc'; ?>  
<style>
    .task-bg          { background-color:#78DEC7;}
    .pendingPro-bg    { background-color:#FF5D6C;}
    .pendingCus-bg    { background-color:#C299FC;}
    .circle-Product   { background:#FA163F;}
    .circle-Customer  { background:#8843F2;}
    .circle-task      { background:#27AA80;}
</style>



<div class="card m-3">
    <div class="card-body d-flex justify-content-between">
        <div>
            <p class="fs-3 fw-bold text-center my-1">Follow Up Home</p>
        </div>
        
        <div>
        <a href="Manual/CustomerRegistrationForm_Manual.php"   class = "text-primary" title = "Click to Read the User Guide " >
			<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-journal-text" viewBox="0 0 16 16">
				<path d="M5 10.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0-2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
				<path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
				<path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
			</svg>
			</a>
        </div>
        
    </div>
</div>


<div class="card m-3 border-primary">
    <div class="card-body">      
        <div class="row">
           <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <a href="IndividualFollowUpPage.php?Type=Individual">
                    <div class="card pendingPro-bg shadow">
                        <div class="card-body pb-3 pt-3"  >
                            <div class= "text-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-person-video2" viewBox="0 0 16 16">
                                    <path d="M10 9.05a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                    <path d="M2 1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2H2ZM1 3a1 1 0 0 1 1-1h2v2H1V3Zm4 10V2h9a1 1 0 0 1 1 1v9c0 .285-.12.543-.31.725C14.15 11.494 12.822 10 10 10c-3.037 0-4.345 1.73-4.798 3H5Zm-4-2h3v2H2a1 1 0 0 1-1-1v-1Zm3-1H1V8h3v2Zm0-3H1V5h3v2Z"/>
                                </svg>
                            </div>
                        </div>
                            <a href="IndividualFollowUpPage.php?Type=Individual"   style='color:white;text-decoration:none; mt-5'>
                                <div class="card-footer circle-Product  text-center " id = "card-footer"  >
                                    <strong>
                                        Individual Follow Up  
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                        </svg>
                                    </strong>
                                </div>
                            </a> 
                    </div> <!-- END OF CARD  -->
                </a> 
            </div>  <!-- END OF COL   -->




            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                    <a href="InternalFollowUp.php">
                    <div class="card pendingCus-bg  shadow">
                        <div class="card-body pb-3 pt-3"  >
                            <div class= "text-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="200" height="200" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M14.763.075A.5.5 0 0 1 15 .5v15a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5V14h-1v1.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V10a.5.5 0 0 1 .342-.474L6 7.64V4.5a.5.5 0 0 1 .276-.447l8-4a.5.5 0 0 1 .487.022zM6 8.694 1 10.36V15h5V8.694zM7 15h2v-1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5V15h2V1.309l-7 3.5V15z"/>
                                    <path d="M2 11h1v1H2v-1zm2 0h1v1H4v-1zm-2 2h1v1H2v-1zm2 0h1v1H4v-1zm4-4h1v1H8V9zm2 0h1v1h-1V9zm-2 2h1v1H8v-1zm2 0h1v1h-1v-1zm2-2h1v1h-1V9zm0 2h1v1h-1v-1zM8 7h1v1H8V7zm2 0h1v1h-1V7zm2 0h1v1h-1V7zM8 5h1v1H8V5zm2 0h1v1h-1V5zm2 0h1v1h-1V5zm0-2h1v1h-1V3z"/>
                                </svg>
                            </div>
                        </div>
                        <a href="InternalFollowUp.php"   style='color:white;text-decoration:none; mt-5'>
                            <div class="card-footer circle-Customer   text-center " id = "card-footer"  >
                                <strong>
                                    Internal Follow Up  
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                    </svg>
                                </strong>
                            </div>
                        </a> 
                    </div> <!-- END OF CARD  -->
                    </a> 
            </div>  <!-- END OF COL   -->

            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                <a href="IndividualFollowUpPage.php?Type=General">
                    <div class="card task-bg shadow-lg">
                        <div class="card-body pb-3 pt-3"  >
                                <div class = "text-center ">
                                <svg width="200" height="200" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_224_58)">
                                    <path d="M42.984 35.1751C42.975 33.3942 41.5189 31.9453 39.7379 31.9453C38.9695 31.9453 33.2973 31.9453 32.6078 31.9453C32.9137 32.5397 33.0875 33.2126 33.0875 33.9259C33.0875 34.7501 32.8569 35.5211 32.4568 36.1783C34.0466 36.2426 35.4397 37.0958 36.2538 38.3562H39.6665V35.1098C39.6665 34.9502 39.7958 34.8209 39.9554 34.8209C40.115 34.8209 40.2443 34.9502 40.2443 35.1098C40.2443 35.1348 40.2431 35.1612 40.2407 35.189L40.2567 38.3563H42.9999L42.984 35.1751Z" fill="white"/>
                                    <path d="M24.399 33.9257C24.399 33.2001 24.5788 32.5161 24.8947 31.9141H22.2362H22.2244H18.5647C18.8566 32.4976 19.0219 33.1551 19.0219 33.8507C19.0219 34.5382 18.8607 35.1885 18.5753 35.7669V36.1034H18.5752C19.8299 36.157 20.9612 36.7023 21.7815 37.5508C22.627 36.7248 23.7797 36.2126 25.0475 36.2058C24.6073 35.495 24.399 34.6971 24.399 33.9257Z" fill="white"/>
                                    <path d="M22.2416 25.6016C20.6721 25.6016 19.3987 26.8734 19.3987 28.4444C19.3987 30.0115 20.6707 31.2874 22.2416 31.2874C23.8032 31.2874 25.0844 30.0206 25.0844 28.4444C25.0845 26.8743 23.8117 25.6016 22.2416 25.6016Z" fill="white"/>
                                    <path d="M10.788 31.9165C10.6691 31.9106 10.9485 31.9124 6.95004 31.9124H6.93828H3.26229C1.49064 31.9124 0.0251953 33.3536 0.016209 35.1421L0 38.3543C1.24188 38.3543 1.47267 38.3543 2.74343 38.3543L2.75947 35.1558C2.75947 35.1558 2.75947 35.1558 2.75947 35.1557C2.76922 35.0007 2.90015 34.8815 3.05535 34.8864C3.21055 34.8914 3.33359 35.0186 3.33359 35.1739V38.3542H7.17915C7.91645 37.1756 9.15942 36.3441 10.5992 36.1657V35.3472C10.4271 34.8799 10.3328 34.3753 10.3328 33.8491C10.3329 33.1551 10.4973 32.499 10.788 31.9165Z" fill="white"/>
                                    <path d="M6.93255 25.6016C5.36255 25.6016 4.0896 26.8743 4.0896 28.4444C4.08968 30.0196 5.37019 31.2874 6.93255 31.2874C8.50021 31.2874 9.77543 30.0141 9.77543 28.4444C9.77534 26.8743 8.50256 25.6016 6.93255 25.6016Z" fill="white"/>
                                    <path d="M28.7433 31.082C27.1732 31.082 25.9004 32.3548 25.9004 33.9249C25.9004 35.4951 27.1731 36.7679 28.7433 36.7679C30.3128 36.7679 31.5862 35.4964 31.5862 33.9249C31.5862 32.3529 30.3118 31.082 28.7433 31.082Z" fill="white"/>
                                    <path d="M14.6773 31.0078C13.1065 31.0078 11.8345 32.281 11.8345 33.8507C11.8345 35.4205 13.1069 36.6936 14.6773 36.6936C16.2466 36.6936 17.5202 35.421 17.5202 33.8507C17.5202 32.2807 16.2474 31.0078 14.6773 31.0078Z" fill="white"/>
                                    <path d="M35.6031 40.9037C35.5944 39.1178 34.0401 37.6738 32.2639 37.6738C31.4588 37.6738 25.8232 37.6738 25.0729 37.6738C23.5177 37.6738 22.068 38.7789 21.7194 40.2448C21.3632 38.7882 19.9199 37.6921 18.3709 37.6921C15.9527 37.6921 16.7885 37.6921 11.1798 37.6921C9.39893 37.6921 7.66272 39.141 7.65382 40.9219L7.6377 42.3613H10.3811L10.3972 40.9358C10.3973 40.9154 10.3994 40.8948 10.4032 40.8744C10.4361 40.7018 10.595 40.5825 10.77 40.5993C10.9449 40.6159 11.0783 40.7629 11.0783 40.9387V42.3615C15.0855 42.3615 9.3131 42.3615 18.3439 42.3615V40.883C18.3439 40.6847 18.5047 40.5238 18.7031 40.5238C18.9014 40.5238 19.0623 40.6845 19.0624 40.8829C19.0624 40.8998 19.0617 40.9175 19.0602 40.9359L19.0762 42.3614C20.2838 42.3614 20.5929 42.3614 21.6239 42.3614H21.8196H24.3673L24.3833 40.9176C24.3835 40.876 24.3944 40.8355 24.4135 40.7968C24.4739 40.6741 24.6109 40.6092 24.744 40.6403C24.8771 40.6714 24.9712 40.7901 24.9712 40.9268V42.3614C26.58 42.3614 30.7306 42.3614 32.2368 42.3614V40.9191C32.2368 40.7476 32.3755 40.6082 32.547 40.6076C32.7185 40.6068 32.8583 40.7449 32.8597 40.9165C32.8597 40.9169 32.8597 40.9172 32.8597 40.9176L32.8758 42.3615H35.6192L35.6031 40.9037Z" fill="white"/>
                                    <path d="M36.0675 25.6328C34.4939 25.6329 33.2246 26.9083 33.2246 28.4758C33.2246 30.0446 34.4962 31.3186 36.0675 31.3186C37.6388 31.3186 38.9104 30.0459 38.9104 28.4758C38.9104 26.9056 37.6377 25.6328 36.0675 25.6328Z" fill="white"/>
                                    <path d="M16.025 22L13.25 19.225V6.35L16.025 3.575H26.325L29.1 6.35V9.75L24.55 9.725V8L23.65 7.125H18.825L17.925 8V17.55L18.825 18.45H22.75L25.15 16.325V15.675H21.775V12.1H29.375V22H25.425V20.35L23.575 22H16.025Z" fill="white"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_224_58">
                                    <rect width="43" height="43" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                                </div>
                        </div>
                        <a href='IndividualFollowUpPage.php?Type=General'   style='color:white;text-decoration:none; mt-5'>
                            <div class="card-footer circle-task  text-center " id = "card-footer"  >
                                <strong>
                                    General Follow Up  
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-right-circle" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                    </svg>
                                </strong>
                            </div>
                        </a> 
                    </div> <!-- END OF CARD  -->
                    </a>
            </div>  <!-- END OF COL   -->



        </div>   

    </div>
</div>

<?php  require_once '../App/partials/Footer.inc'; ?>
