<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@600&display=swap');
body {
    margin: 0;
    background: #eaeef6;
}

* {
    text-align: center;
    font-family: 'Open Sans', sans-serif;
}

.TopBox {
    width: 71px;
    height: 5px;
    margin: 0 auto;
    background: #406ff3;
    border-radius: 0 0 12px 12px;
}

.HoverBox {
    width: 55px;
    height: 55px;
    margin: 0 auto;
    background: #406ff3;
    border-radius: 10px;
    position: absolute;
    z-index: 0;
    left: 15px;
    top: 20px;
    transition: 250ms;
}

.PageContact {
    margin-left: 200px;
    margin-right: 103px;
    margin-top: 47px;
}

.MenuBox>ul>li>span {
    position: absolute;
    left: 80%;
    opacity: 0;
    top: 12px;
    margin-left: 2rem;
    color: #406ff3;
    background: #fff;
    transition: 250ms ease all;
    border-radius: 17.5px;
    line-height: 0;
    padding: 16px 15px;
    z-index: -1;
}

.MenuBox>ul>li {
    display: block;
    width: 55px;
    height: 55px;
    border-radius: 10px;
    cursor: pointer;
    position: relative;
    z-index: 1;
    margin-bottom: 12px;
    line-height: 68px;
}

.MenuBox:not(:hover),
.MenuBox>ul>li:hover svg {
    color: white;
}

.MenuBox>ul>li:hover span {
    display: block;
    left: 100%;
    opacity: 1;
}

.Active>svg {
    color: white;
}

.feather {
    color: #6e6c6c;
    width: 25px;
    transition: 1s;
}

.MenuBox {
    background: white;
    position: absolute;
    margin: 34px 12px;
    height: 90%;
    border-radius: 9px;
    box-shadow: 0 0 40px 0 rgb(94 92 154 / 6%);
}

.Contact {
    display: flex;
}

.MenuBox>ul {
    padding: 0 15px;
    margin-top: 15px;
}

.PageContact>div {
    transition: .5s;
}

@keyframes Effect_0 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}

@keyframes Effect_1 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}

@keyframes Effect_2 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}

@keyframes Effect_3 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}

@keyframes Effect_4 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}

@keyframes Effect_5 {
    0% {
        transform: scale(1, 1);
    }
    50% {
        transform: scale(0.5, 1.5);
    }
    100% {
        transform: scale(1, 1);
    }
}


/* Style About Box  */

@import url('https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap');
.linkAbout {
    text-decoration: auto;
    margin: 0 5px;
    color: black;
}

.about {
    position: absolute;
    top: 0;
    background: #ffffff;
    padding: 10px;
    border-radius: 0 0 15px 15px;
    font-size: 1em;
    font-family: 'Heebo', sans-serif;
    right: 31px;
}

.linkAbout:hover {
    color: #406ff3;
}


/* End Style About Box  */ 

    </style>
</head>
<body>


<div class="Contact">
        <div class="MenuBox">
            <div class="TopBox"></div>
            <div class="HoverBox"></div>
            <ul>
                <li class="Active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                    <span>Home</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                    <span>Chat</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                    <span>Customers</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span>Notes</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-help-circle"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>Help</span>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-settings"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
                    <span>Setting</span>
                </li>
            </ul>
        </div>
        <div class="PageContact">
            <div>
                <h1>Page</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Tempor id eu nisl nunc. Faucibus et molestie ac feugiat sed lectus vestibulum. Etiam sit amet nisl purus in. Lorem
                    sed risus ultricies tristique. Odio ut sem nulla pharetra diam sit. Morbi quis commodo odio aenean sed adipiscing. Elementum nibh tellus molestie nunc non blandit massa enim nec. Malesuada fames ac turpis egestas sed tempus urna et
                    pharetra. Enim eu turpis egestas pretium aenean pharetra magna ac. Consectetur lorem donec massa sapien faucibus et molestie ac feugiat. Quis lectus nulla at volutpat diam. Sapien pellentesque habitant morbi tristique senectus et netus
                    et. Augue mauris augue neque gravida in. Sed lectus vestibulum mattis ullamcorper velit. Et tortor at risus viverra adipiscing at in tellus integer. Ligula ullamcorper malesuada proin libero nunc consequat interdum varius sit.</p>
            </div>
        </div>
    </div>


    <!-- About Box -->
    <div class="about">
        <a href="https://Instagram.com/emnatkins" class="linkAbout">Instagram</a>
        <a href="https://codepen.io/emnatkins" class="linkAbout">CodePen</a>
        <a href="https://GitHub.com/emnatkins" class="linkAbout">GitHub</a>
    </div>
    <!-- End About Box -->

    <script>
        var button_s = document.querySelectorAll(".MenuBox>ul>li");
var svg_s = document.querySelectorAll(".MenuBox>ul>li>svg");
var HoverBox_s = document.getElementsByClassName("HoverBox")[0];

function clearTag(id) {
    for (let item of svg_s) {
        if (item == svg_s[id]) {
            continue;
        }
        item.style.color = "#6e6c6c";
    }
}

function Action_s(Index, Top) {
    HoverBox_s.style.top = Top;
    HoverBox_s.style.animation = `Effect_${Index} 250ms 1`;
    svg_s[Index].style.color = "white"
    clearTag(Index)
}
button_s[0].addEventListener("mouseover", function() {
    Action_s(0, "20px");
});

button_s[1].addEventListener("mouseover", function() {
    Action_s(1, "87px");
});

button_s[2].addEventListener("mouseover", function() {
    Action_s(2, "154px");
});

button_s[3].addEventListener("mouseover", function() {
    Action_s(3, "221px");
});

button_s[4].addEventListener("mouseover", function() {
    Action_s(4, "288px");
});

button_s[5].addEventListener("mouseover", function() {
    Action_s(5, "355px");

});

    </script>
    
    
</body>
</html>