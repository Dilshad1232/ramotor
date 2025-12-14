<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin Panel')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<style>
/* Reset */
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins', sans-serif;}
body{background:#121212;color:white;overflow-x:hidden;transition:0.3s;}

/* Header */
header{
    background:linear-gradient(135deg,#ff4d4d,#ff1a1a);
    padding:15px 25px;
    display:flex;align-items:center;justify-content:space-between;
    position:fixed;width:100%;top:0;z-index:1000;
    box-shadow:0 5px 15px rgba(0,0,0,0.4);
    border-bottom-left-radius:15px;
    border-bottom-right-radius:15px;
}
header h1{
    color:white;font-size:1.6rem;text-shadow:1px 1px 5px rgba(0,0,0,0.7);
}
.toggle-btn{
    font-size:1.6rem;color:white;cursor:pointer;display:none;
}

/* Profile Menu */
.profile-menu{
    display:flex;align-items:center;gap:10px;position:relative;cursor:pointer;
}
.profile-img{
    width:40px;height:40px;border-radius:50%;object-fit:cover;border:2px solid white;
}
.username{
    font-size:1rem;font-weight:500;
}
.dropdown{
    position:absolute;top:52px;right:0;width:180px;
    background:#1c1c1c;border-radius:12px;display:none;
    flex-direction:column;overflow:hidden;box-shadow:0 5px 18px rgba(0,0,0,0.6);
}
.dropdown a,.dropdown button{
    padding:12px 15px;width:100%;font-size:0.95rem;color:white;border:none;background:none;text-align:left;
    display:flex;align-items:center;gap:10px;cursor:pointer;
}
.dropdown a:hover,.dropdown button:hover{background:#ff4d4d;}

/* Sidebar */
aside{
    position:fixed;top:70px;left:0;width:250px;height:calc(100% - 70px);
    background:#1c1c1c;padding-top:20px;overflow-y:auto;transition:0.4s;
    border-top-right-radius:15px;border-bottom-right-radius:15px;
    box-shadow:4px 0 15px rgba(0,0,0,0.5);padding-bottom:70px;
}
aside.hide{left:-270px;}
aside ul{list-style:none;padding:0;}
aside ul li{
    padding:15px 25px;margin:8px;border-radius:12px;
    transition:0.3s;background:linear-gradient(145deg,#1f1f1f,#161616);
    box-shadow:5px 5px 15px rgba(0,0,0,0.6), -5px -5px 15px rgba(255,255,255,0.05);
}
aside ul li:hover{
    background:linear-gradient(145deg,#ff4d4d,#ff1a1a);transform:translateX(5px);
}
aside ul li a{color:white;text-decoration:none;font-weight:500;display:block;}
.menu-dropdown{padding-left:20px;}

/* Main Content */
main{
    margin-left:250px;padding:90px 25px 70px 25px;transition:0.4s;
}
main.full{margin-left:0;}

/* Cards */
.card{
    background:#2c2c2c;padding:20px;border-radius:15px;margin-bottom:20px;
    box-shadow:8px 8px 20px rgba(0,0,0,0.7), -8px -8px 20px rgba(255,255,255,0.05);
    transition:0.3s;
}
.card:hover{transform: translateY(-5px) scale(1.02);}

/* Footer */
footer{
    background:#1c1c1c;padding:15px 25px;text-align:center;position:fixed;bottom:0;width:100%;
    border-top-left-radius:15px;border-top-right-radius:15px;
    box-shadow:0 -4px 15px rgba(0,0,0,0.5);
}

/* Scrollbar */
aside::-webkit-scrollbar{width:6px;}
aside::-webkit-scrollbar-thumb{background:#ff4d4d;border-radius:10px;}

/* Responsive */
@media(max-width:992px){
    .toggle-btn{display:block;}
    aside{left:-270px;z-index:1000;}
    main{margin-left:0;padding-top:100px;}
}
@media(max-width:576px){
    header h1{font-size:1.3rem;}
    .profile-menu .username{display:none;}
}
</style>
</head>

<body>

<header>
    <i class="fas fa-bars toggle-btn" id="toggleBtn"></i>
    <h1>Admin Panel</h1>

    <div class="profile-menu" id="profileBtn">
        <img src="{{ Auth::user()->profile_image ? asset('uploads/admin/' . Auth::user()->profile_image) : asset('default.png') }}" class="profile-img">
        <span class="username">{{ Auth::user()->name }}</span>

        <div class="dropdown" id="profileDropdown">
            <a href="{{ route('admin.profile') }}"><i class="fa fa-user"></i> Profile</a>
            <a href="{{ url('/') }}"><i class="fa fa-cog"></i> Go to Website</a>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button type="submit"><i class="fa fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
</header>



<aside id="sidebar">
    <ul>
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-tachometer-alt me-2"></i> Dashboard</a></li>

        <li class="menu-btn">
            <a href="javascript:void(0)"><i class="fa fa-users me-2"></i> Customers Management
                <i class="fa fa-caret-down float-end"></i></a>
        </li>
        <ul class="menu-dropdown" style="display:none;">
            <li><a href="{{ route('admin.customers') }}"><i class="fa fa-list me-2"></i> Customer List</a></li>
            <li><a href="#"><i class="fa fa-history me-2"></i> Past Service History</a></li>
        </ul>

        <li class="menu-btn">
            <a href="javascript:void(0)"><i class="fa fa-tools me-2"></i> Services Management
                <i class="fa fa-caret-down float-end"></i></a>
        </li>
        <ul class="menu-dropdown" style="display:none;">
            <li><a href="{{ route('admin.services') }}"><i class="fa fa-plus-circle me-2"></i> Add Services</a></li>
        </ul>

        <li class="menu-btn">
            <a href="javascript:void(0)"><i class="fa fa-user-cog me-2"></i> Employees Management
                <i class="fa fa-caret-down float-end"></i></a>
        </li>
        <ul class="menu-dropdown" style="display:none;">
            <li><a href="{{ route('admin.mechanic') }}"><i class="fa fa-user-plus me-2"></i> Add Mechanics</a></li>
            <li><a href="{{ route('admin.mechanic.specializations') }}"><i class="fa fa-cogs me-2"></i> Mechanic Specialization</a></li>
        </ul>

        <li><a href="{{ route('admin.bookings') }}"><i class="fa fa-clipboard-list me-2"></i> Booking Orders Management</a></li>

        <li><a href="#"><i class="fa fa-file-invoice-dollar me-2"></i> Invoice / Payment Management</a></li>
        <li><a href="{{ route('admin.bill') }}"><i class="fa fa-clipboard-list me-2"></i> Bill</a></li>
        <li><a href="{{ route('admin.contactview') }}"><i class="fa fa-clipboard-list me-2"></i> Contact View</a></li>

        <li><a href="{{ route('admin.profile') }}"><i class="fa fa-user-circle me-2"></i> Profile & Settings</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">@csrf
                <button style="background:none;border:none;color:white;cursor:pointer;padding:0;text-align:left;">
                    <i class="fa fa-sign-out-alt me-2"></i> Logout
                </button>
            </form>
        </li>
    </ul>
</aside>

<main id="mainContent">
    @yield('content')
</main>

<footer>
    &copy; 2025 Car Garage Admin Panel. All Rights Reserved.
</footer>

<script>
    // Sidebar toggle
    const toggleBtn = document.getElementById('toggleBtn');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth < 992) {
            // Mobile behavior: slide in/out
            if (sidebar.style.left === '0px') {
                sidebar.style.left = '-270px';
            } else {
                sidebar.style.left = '0px';
            }
        } else {
            // Desktop behavior: push content
            sidebar.classList.toggle('hide');
            mainContent.classList.toggle('full');
        }
    });

    // Profile dropdown
    const profileBtn = document.getElementById("profileBtn");
    const profileDropdown = document.getElementById("profileDropdown");
    profileBtn.addEventListener("click", () => {
        profileDropdown.style.display = profileDropdown.style.display === "flex" ? "none" : "flex";
    });
    document.addEventListener("click", function(e){
        if(!profileBtn.contains(e.target)){ profileDropdown.style.display = "none"; }
    });

    // Sidebar submenu
    const menuBtns = document.querySelectorAll(".menu-btn");
    menuBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            let dropdown = btn.nextElementSibling;
            dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
        });
    });

    // Optional: Hide sidebar when clicking outside on mobile
    document.addEventListener("click", function(e){
        if(window.innerWidth < 992 && !sidebar.contains(e.target) && !toggleBtn.contains(e.target)){
            sidebar.style.left = '-270px';
        }
    });
    </script>

@yield('scripts')

</body>
</html>
