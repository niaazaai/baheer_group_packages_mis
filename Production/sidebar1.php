<HTML>
<head>

    <title>CODE</title>

    <!-- BoxIcons v2.1.2 -->
    <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">

    <!-- Roboto Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- CSS File -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        * {
    margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    list-style: none;
    box-sizing: border-box;
}

body {
    height: 100vh;
    background-image: url('https://4kwallpapers.com/images/walls/thumbs_2t/9192.png');
    background-repeat: no-repeat;
    background-size: cover;
    font-family: 'Roboto', sans-serif;
}

.sidebar {
    width: 120px;
    height: 200%;
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    background: rgba(10, 10, 10, .65);
    box-shadow: 0 8px 32px rgb(2, 4, 24);
    border-right: 2px solid rgba(255, 255, 255, .09);
    transition: .4s ease-in-out;
}

.sidebar.open {
    width: 360px;
}

.sidebar .logo {
    width: 100%;
    height: 240px;
    padding: 40px 0;
    display: grid;
    align-items: center;
    justify-items: center;
}

.sidebar .logo img {
    width: 56px;
    transition: .4s;
}

.sidebar.open .logo img {
    width: 96px;
}

.sidebar .logo h3 {
    color: #fff;
    font-size: 36px;
    margin-top: 12px;
    font-variant: small-caps;
    pointer-events: none;
    scale: 0;
    opacity: 0;
}

.sidebar.open .logo h3 {
    scale: 1;
    opacity: 1;
    transition: .4s;
    transition-delay: .2s;
}

.sidebar .nav-title {
    color: #dadada;
    margin: 40px 0 18px;
    pointer-events: none;
    opacity: 0;
}

.sidebar.open .nav-title {
    opacity: 1;
    transition: .4s;
    transition-delay: .2s;
}

.sidebar nav {
    padding: 0 30px;
}

.sidebar nav .nav-item {
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    border-radius: 4px;
    width: 100%;
    height: 56px;
    padding: 0 16px;
    margin: 8px 0;
    color: #fff;
    transition: .3s;
}

.sidebar nav .nav-item.active {
    background: #ff328e !important;
}

.sidebar nav .nav-item:hover {
    background: rgba(255, 255, 255, .1);
}

.sidebar nav .nav-item i {
    font-size: 26px;
}

.sidebar nav .nav-item span {
    font-size: 18px;
    margin-left: 8px;
    opacity: 0;
    pointer-events: none;
}

.sidebar.open nav .nav-item span {
    opacity: 1;
    pointer-events: visible;
    transition: .4s;
    transition-delay: .2s;
}

.sidebar hr {
    width: 100%;
    height: 2px;
    border-radius: 3px;
    margin: 40px 0 50px;
    background: rgba(255, 255, 255, .1);
    opacity: 0;
}

.sidebar.open hr {
    opacity: 1;
    transition: .4s;
}

.sidebar .toggle {
    cursor: pointer;
    position: absolute;
    color: #fff;
    top: 180px;
    right: -20px;
    font-size: 38px;
    line-height: 50%;
    text-align: center;
    border-radius: 50%;
    padding: 2px 0 2px 2px;
    background: linear-gradient(
        90deg,
        transparent 50%,
        rgba(10, 10, 10, .65) 50%
    );
}

.sidebar.open .toggle {
    transform: translateY(45px);
}

.sidebar .toggle i {
    transition: .4s linear;
}

.sidebar.open .toggle i {
    transform: rotateY(180deg);
}


    </style>

</head>

<body>

    <div class="sidebar">

        <div class="toggle">
            <i class="bx bx-chevron-right"></i>
        </div>

        <div class="logo">
            <img src="https://wallpaperaccess.com/full/1755108.jpg" alt="...">
            <h3>KRISH</h3>
        </div>

        <nav>

            <div class="nav-title">
                MENU
            </div>

            <ul>
                <li class="nav-item active">
                    <i class="bx bxs-dashboard"></i>
                    <span>Dashboard</span>
                </li>
                <li class="nav-item">
                    <i class="bx bxs-bar-chart-alt-2"></i>
                    <span>Analytics</span>
                 

                </li>
                <li class="nav-item">
                    <i class="bx bxs-wallet"></i>
                    <span>Wallet</span>
                </li>
                <li class="nav-item">
                    <i class="bx bxs-bell"></i>
                    <span>Notifications</span>
                </li>
                <li class="nav-item">
                    <i class="bx bxs-cog"></i>
                    <span>Settings</span>
                </li>
            </ul>

            <hr>

            <div class="nav-title">
                Supports
            </div>

            <ul>
                <li class="nav-item">
                    <i class="bx bxs-help-circle"></i>
                    <span>Get Help</span>
                </li>
                <li class="nav-item">
                    <i class="bx bxs-message-dots"></i>
                    <span>Send Feedback</span>
                </li>
            </ul>
          <CENTER>
           <div class="nav-title">
                Made by KRISH
            </div>
          </CENTER>

        </nav>

    </div>

    <!-- JS File -->
    <script>
        const sidebar = document.querySelector('.sidebar');
const navItems = document.querySelectorAll('nav .nav-item');
const toggle = document.querySelector('.sidebar .toggle');

toggle.addEventListener('click', () => {

    if (sidebar.className === 'sidebar')
        sidebar.classList.add('open');
    else
        sidebar.classList.remove('open');

});

navItems.forEach(navItem => {

    navItem.addEventListener('click', () => {

        navItems.forEach(navItem => {
            navItem.classList.remove('active');
        });

        navItem.classList.add('active');

    });

});

    </script>
    <script type="text/javascript" src="js/script.js"></script>

</body>
</html>