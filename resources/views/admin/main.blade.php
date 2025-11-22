<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Panel')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
/* Reset */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins', sans-serif;}
body{background:#121212;color:white;overflow-x:hidden;}

/* Header */
header{
    background:linear-gradient(135deg, #ff4d4d, #ff1a1a);
    padding:15px 25px;
    display:flex;align-items:center;
    position:fixed;width:100%;top:0;z-index:1000;
    box-shadow:0 5px 15px rgba(0,0,0,0.4);
    border-bottom-left-radius:15px;
    border-bottom-right-radius:15px;
}
header h1{
    color:white;font-size:1.6rem;text-shadow: 1px 1px 5px rgba(0,0,0,0.7);
    flex:1;margin-left:15px;
}
.toggle-btn{
    font-size:1.6rem;color:white;cursor:pointer;display:block;z-index:1100;
}

/* Profile Menu */
.profile-menu{
    display:flex;align-items:center;gap:10px;position:relative;cursor:pointer;
}
.profile-img{
    width:40px;height:40px;border-radius:50%;object-fit:cover;
    border:2px solid white;
}
.username{
    font-size:1rem;font-weight:500;
}
.dropdown{
    position:absolute;top:52px;right:0;width:170px;
    background:#1c1c1c;border-radius:12px;display:none;
    flex-direction:column;overflow:hidden;
    box-shadow:0 5px 18px rgba(0,0,0,0.6);
}
.dropdown a, .dropdown button{
    padding:12px 15px;width:100%;font-size:0.96rem;
    color:white;border:none;background:none;text-align:left;
    display:flex;align-items:center;gap:10px;cursor:pointer;
}
.dropdown a:hover, .dropdown button:hover{
    background:#ff4d4d;
}

/* Sidebar */
aside{
    position:fixed;top:70px;left:0;width:250px;height:calc(100% - 70px);
    background:#1c1c1c;padding-top:20px;overflow-y:auto;transition:0.4s;
    border-top-right-radius:15px;border-bottom-right-radius:15px;
    box-shadow:4px 0 15px rgba(0,0,0,0.5);
    padding-bottom:70px; /* ⭐ FIX: footer overlap solve */
}
aside.hide{left:-270px;}
aside ul{list-style:none;}
aside ul li{
    padding:18px 25px;margin:10px;border-radius:12px;
    transition:0.3s;background:linear-gradient(145deg,#1f1f1f,#161616);
    box-shadow:5px 5px 15px rgba(0,0,0,0.6), -5px -5px 15px rgba(255,255,255,0.05);
}
aside ul li:hover{
    background:linear-gradient(145deg,#ff4d4d,#ff1a1a);
    transform:translateX(6px);
}
aside ul li a{color:white;text-decoration:none;font-weight:500;display:block;}

/* Main Content */
main{
    margin-left:250px;padding:90px 30px 70px 30px;
    transition:0.4s;
}
main.full{margin-left:0;}

/* Cards */
.card{
    background:#2c2c2c;padding:25px;border-radius:20px;margin-bottom:25px;
    box-shadow:8px 8px 20px rgba(0,0,0,0.7), -8px -8px 20px rgba(255,255,255,0.05);
    transition:0.3s;
}
.card:hover{
    transform: translateY(-5px) scale(1.02);
}

/* Footer */
footer{
    background:#1c1c1c;padding:15px 25px;text-align:center;
    position:fixed;bottom:0;width:100%;
    border-top-left-radius:15px;border-top-right-radius:15px;
    box-shadow:0 -4px 15px rgba(0,0,0,0.5);
}

/* Scrollbar */
aside::-webkit-scrollbar{width:6px;}
aside::-webkit-scrollbar-thumb{background:#ff4d4d;border-radius:10px;}

/* Responsive */
@media(max-width:768px){
    main{margin-left:0;padding-top:100px;}
}
</style>
</head>

<body>

<header>
    <i class="fas fa-bars toggle-btn" id="toggleBtn"></i>
    <h1>Admin Panel</h1>

    <div class="profile-menu" id="profileBtn">
        <img src="{{ Auth::user()->profile_image ? asset('uploads/profile/' . Auth::user()->profile_image) : asset('default.png') }}" class="profile-img">
        <span class="username">{{ Auth::user()->name }}</span>

        <div class="dropdown" id="profileDropdown">
            <a href="#"><i class="fa fa-user"></i> Profile</a>
            <a href="#"><i class="fa fa-cog"></i> Settings</a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
</header>

<aside id="sidebar">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li><a href="#">Manage Cars</a></li>
        <li><a href="#">Denting Jobs</a></li>
        <li><a href="#">Painting Jobs</a></li>
        <li><a href="#">Engine Services</a></li>
        <li><a href="#">Customer Feedback</a></li>
        <li><a href="#">Inventory</a></li>
        <li><a href="#">Staff Performance</a></li>
        <li><a href="#">Settings</a></li>
    </ul>
</aside>

<main id="mainContent">
    @yield('content')
</main>

<footer>
    &copy; 2025 Car Garage Admin Panel. All Rights Reserved.
</footer>

<script>
const toggleBtn = document.getElementById('toggleBtn');
const sidebar = document.getElementById('sidebar');
const mainContent = document.getElementById('mainContent');
toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('hide');
    mainContent.classList.toggle('full');
});

const profileBtn = document.getElementById("profileBtn");
const profileDropdown = document.getElementById("profileDropdown");
profileBtn.addEventListener("click", () => {
    profileDropdown.style.display = profileDropdown.style.display === "flex" ? "none" : "flex";
});
document.addEventListener("click", function(e){
    if(!profileBtn.contains(e.target)){ profileDropdown.style.display = "none"; }
});
</script>

</body>
</html>
