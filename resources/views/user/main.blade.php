<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'User Dashboard')</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Roboto',sans-serif;}
body{display:flex;flex-direction:column;min-height:100vh;background:#121212;color:#fff;}

/* Header */
header{
    display:flex;align-items:center;justify-content:space-between;
    padding:0 20px;height:60px;background:linear-gradient(135deg,#ff4d4d,#d32f2f);
    position:sticky;top:0;z-index:1000;box-shadow:0 4px 8px rgba(0,0,0,0.5);
}
.logo{font-weight:700;font-size:1.5rem;}
.menu-toggle{display:none;font-size:1.8rem;cursor:pointer;}
.user-menu{display:flex;align-items:center;gap:10px;position:relative;cursor:pointer;}
.user-menu img{width:40px;height:40px;border-radius:50%;border:2px solid white;}
.user-dropdown{
    display:none;position:absolute;right:0;top:60px;background:#1c1c1c;border-radius:10px;
    overflow:hidden;box-shadow:0 5px 15px rgba(0,0,0,0.7);
}
.user-dropdown a{
    display:block;padding:12px 15px;color:white;text-decoration:none;transition:0.2s;
}
.user-dropdown a:hover{background:#ff4d4d;}

/* Sidebar */
.container{display:flex;flex:1;overflow:hidden;}
.sidebar{
    width:220px;background:#1c1c1c;flex-shrink:0;
    display:flex;flex-direction:column;position:fixed;top:60px;bottom:0;left:0;overflow-y:auto;
    transition:0.3s;border-right:2px solid #ff4d4d;
}




/* Sidebar 3D Redesign */
.sidebar {
    width: 240px;
    background: linear-gradient(145deg, #1a1a1a, #2a2a2a);
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    position: fixed;
    top: 60px;
    bottom: 0;
    left: 0;
    overflow-y: auto;
    transition: 0.3s;
    border-right: 3px solid #ff4d4d;
    box-shadow: 8px 0 20px rgba(0,0,0,0.6);
    /* border-radius: 0 20px 20px 0; 3D rounded edge effect */
}

/* Sidebar Links */
.sidebar nav a {
    padding: 18px 25px;
    display: block;
    color: white;
    font-weight: 500;
    border-left: 6px solid transparent;
    transition: all 0.3s ease;
    margin: 4px 8px;
    border-radius: 10px;
    background: linear-gradient(145deg, #222, #1c1c1c);
    box-shadow: inset 0 0 5px rgba(255,255,255,0.05), 0 4px 15px rgba(0,0,0,0.4);
}

/* Hover Effect - Pop out 3D look */
.sidebar nav a:hover {
    background: linear-gradient(145deg, #ff4d4d, #d32f2f);
    border-left: 6px solid #fff;
    transform: translateX(5px) scale(1.02);
    box-shadow: 0 8px 20px rgba(0,0,0,0.7);
}

/* Active link effect */
.sidebar nav a.active {
    background: linear-gradient(145deg, #ff6666, #ff1a1a);
    border-left: 6px solid #fff;
}

/* Scrollbar customization */
.sidebar::-webkit-scrollbar {
    width: 8px;
}
.sidebar::-webkit-scrollbar-thumb {
    background: #ff4d4d;
    border-radius: 10px;
}
.sidebar::-webkit-scrollbar-track {
    background: #1c1c1c;
}











.sidebar.active{left:-250px;}
.sidebar nav a{
    padding:15px 20px;display:block;color:white;font-weight:500;border-left:4px solid transparent;
    transition:0.3s;margin:2px 0;border-radius:5px;
}
.sidebar nav a:hover{background:#ff4d4d;border-left:4px solid #fff;}

/* Main content */
.main-content{margin-left:220px;flex:1;padding:30px;overflow-y:auto;background:#121212;transition:0.3s;min-height:calc(100vh - 60px);}

/* Footer */
footer{background:#ff1a1a;text-align:center;color:white;padding:15px;margin-top:auto;}

/* Responsive */
@media(max-width:768px){
    .menu-toggle{display:block;}
    .sidebar{left:-250px;position:fixed;}
    .sidebar.active{left:0;}
    .main-content{margin-left:0;padding:15px;}
}
</style>
</head>
<body>

<header>
    <div class="menu-toggle" onclick="toggleSidebar()"><i class="fa fa-bars"></i></div>
    <div class="logo">Car Garage</div>
    <div class="user-menu" onclick="toggleDropdown()">
        {{ auth()->user()->name ?? 'User' }}
        <img src="{{ Auth::user()->profile_image ? asset('uploads/profile/' . Auth::user()->profile_image) : asset('default.png') }}" alt="User">
        <div class="user-dropdown" id="user-dropdown">
            <a href="#">Profile</a>
            <a href="#">Settings</a>
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
        </div>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
</header>

<div class="container">
    <aside class="sidebar" id="sidebar">
        <nav>
            <a href="#">Dashboard</a>
            <a href="#">Book Service</a>
            <a href="#">My Services</a>
            <a href="#">Invoices</a>
            <a href="#">Statistics</a>
            <a href="#">Contact</a>
        </nav>
    </aside>
    <main class="main-content">
        @yield('content')
    </main>
</div>

<footer>
    &copy; 2025 Car Garage. All Rights Reserved.
</footer>

<script>
function toggleSidebar(){
    document.getElementById('sidebar').classList.toggle('active');
}
function toggleDropdown(){
    const dropdown = document.getElementById('user-dropdown');
    dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function(e){
    const dropdown = document.getElementById('user-dropdown');
    const menu = document.querySelector('.user-menu');
    if(!menu.contains(e.target)){ dropdown.style.display = 'none'; }
});
</script>

</body>
</html>
