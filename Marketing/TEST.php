
<?php  
   require_once '../App/partials/Header.inc';  
   require_once '../App/partials/menu/MarketingMenu.inc'; 
?>
 
 
<style>


:root {
  --circle-size: clamp(1.5rem, 5vw, 3rem);
  --spacing: clamp(0.25rem, 2vw, 0.5rem);
}
 
.c-stepper__item {
  position: relative;
  display: flex;
  gap: 1rem;
  padding-bottom: 4rem;
}
.c-stepper__item:before {
  content: "";
  flex: 0 0 var(--circle-size);
  height: var(--circle-size);
  border-radius: 50%;
  background-color: lightgrey;
}
.c-stepper__item:not(:last-child):after {
  content: "";
  position: absolute;
  left: 0;
  top: calc(var(--circle-size) + var(--spacing));
  bottom: var(--spacing);
  z-index: -1;
  transform: translateX(calc(var(--circle-size) / 2));
  width: 2px;
  background-color: #e0e0e0;
}

.c-stepper__title {
  font-weight: bold;
  font-size: clamp(1rem, 4vw, 1.25rem);
  margin-bottom: clamp(0.85rem, 2vmax, 1rem);
}

.c-stepper__desc {
  color: grey;
  font-size: clamp(0.85rem, 2vmax, 1rem);
}

.c-stepper__content {
  max-width: 700px;
}

/*** Non-demo CSS ***/
.wrapper {
  max-width: 1000px;
  margin: 2rem auto 0;
}

  








 
.c-stepper1 {
  display: flex;
}

.c-stepper__item1 {
  display: flex;
  flex-direction: column;
  flex: 1;
  text-align: center;
}
.c-stepper__item1:before {
  --size: 3rem;
  content: "";
  display: block;
  width: var(--circle-size);
  height: var(--circle-size);
  border-radius: 50%;
  background-color: lightgrey;
  background-color: red;
  opacity: 0.5;
  margin: 0 auto 1rem;
}
.c-stepper__item1:not(:last-child):after {
  content: "";
  position: relative;
  top: calc(var(--circle-size) / 2);
  width: calc(100% - var(--circle-size) - calc(var(--spacing) * 2));
  left: calc(50% + calc(var(--circle-size) / 2 + var(--spacing)));
  height: 2px;
  background-color: #e0e0e0;
  order: -1;
}

.c-stepper__title1 {
  font-weight: bold;
  font-size: clamp(1rem, 4vw, 1.25rem);
  margin-bottom: 0.5rem;
}

.c-stepper__desc1 {
  color: grey;
  font-size: clamp(0.85rem, 2vw, 1rem);
  padding-left: var(--spacing);
  padding-right: var(--spacing);
}

/*** Non-demo CSS ***/
.wrapper1 {
  max-width: 1000px;
  margin: 2rem auto 0;
}

 
*,
*:before,
*:after {
  box-sizing: border-box;
}



</style>


 <div class="wrapper">
  <ol class="c-stepper">
    <li class="c-stepper__item  ">

      <div class="c-stepper__content">
        <h3 class="c-stepper__title">Marketing</h3>
        <p class="c-stepper__desc" style="line-height: 1.4;"> 
          <div class="wrapper1 option-1 option-1-1">
            <ol class="c-stepper1">
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Quotation</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Order</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Job</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
            </ol>
          </div>
        </p>

        
      </div>
    </li>
    <li class="c-stepper__item">

      <div class="c-stepper__content">
        <h3 class="c-stepper__title">Design</h3>
        <p class="c-stepper__desc"> 
          <div class="wrapper1 option-1 option-1-1">
            <ol class="c-stepper1">
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">New</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Assign</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Process</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Approval</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Completed</h3>
                <p class="c-stepper__desc1">Some desc text</p>
              </li>
            </ol>
          </div>

        </p>
        
      </div>
    </li>
    <li class="c-stepper__item">

      <div class="c-stepper__content">
        <h3 class="c-stepper__title">Step 3</h3>
        <p class="c-stepper__desc">
          <div class="wrapper1 option-1 option-1-1">
            <ol class="c-stepper1">
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Step 1</h3>
               
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Step 2</h3>
               
              </li>
              <li class="c-stepper__item1">
                <h3 class="c-stepper__title1">Step 3</h3>
           
              </li>
            </ol>
          </div>

        </p>
 
      </div>
    </li>
  </ol>
</div>


<!-- 

<div class="wrapper1 option-1 option-1-1">
  <ol class="c-stepper1">
    <li class="c-stepper__item1">
      <h3 class="c-stepper__title1">Step 1</h3>
      <p class="c-stepper__desc1">Some desc text</p>
    </li>
    <li class="c-stepper__item1">
      <h3 class="c-stepper__title1">Step 2</h3>
      <p class="c-stepper__desc1">Some desc text</p>
    </li>
    <li class="c-stepper__item1">
      <h3 class="c-stepper__title1">Step 3</h3>
      <p class="c-stepper__desc1">Some desc text</p>
    </li>
  </ol>
</div>
 -->












































































<div class="m-4">
 

<h1>HEY MAMA </h1>
<p> Lorem ipsum dolor sit amet,
    <br> consectetur adipisicing elit. Iure reiciendis at eum laboriosam eos officiis provident voluptates, 
    <br>  quos debitis laudantium repellat quo culpa, cum, vitae modi. In ullam commodi veniam!
</p> 

</div>



              <div class="row">
                  <div class="col-md-3">


                      <input type="text" id = "customer"  class = "form-control mb-2" onkeyup="AJAXSearch(this.value)">
                      <div  id="livesearch" class="list-group shadow">
                      </div>

                  </div>
              </div>      



        

 

 <script>
    function AJAXSearch(str) {
      document.getElementById('livesearch').style.display = '';
    if (str.length == 0) {
      return false;
    } else {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200)  {
                var response = JSON.parse(this.responseText);
                var html = ''; 
                    if(response !=  '-1'){
                      for(var count = 0; count < response.length; count++) {
                                  html += '<a href="#" onclick = "PutTheValueInTheBox(this.innerText)"  class="list-group-item list-group-item-action " aria-current="true">' ; 
                                  html+= response[count].CustName; 
                                  html += '   </a>';
                      }
                    }
                    else html += '<option value = "No Data Found" /> ';
                    document.getElementById('livesearch').innerHTML = html;  
                    filterFunction();
                   

          }
       }
      xmlhttp.open("GET", "AJAXSearch.php?query=" + str, true);
      xmlhttp.send();
    }
  }

  function PutTheValueInTheBox(inner) {
    document.getElementById('customer').value = inner;
    document.getElementById('livesearch').style.display = 'none';
    
  }
  </script>



 

<!-- <?php   require_once '../App/partials/Footer.inc'; ?> -->
