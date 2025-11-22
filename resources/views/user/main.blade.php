<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'CarServices Dashboard')</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Roboto',sans-serif;}
body{display:flex;flex-direction:column;min-height:100vh;background:#111;color:#fff;}

/* Header */
header{
  height:60px;background:#d32f2f;color:white;
  display:flex;align-items:center;padding:0 20px;
  position:sticky;top:0;z-index:1001;box-shadow:0 2px 5px rgba(0,0,0,0.4);
}
.logo{font-weight:700;font-size:1.5rem;}
.user{margin-left:auto;display:flex;align-items:center;}
.user img{width:40px;height:40px;border-radius:50%;margin-left:10px;}

/* Mobile Toggle Button */
.menu-toggle{
  display:none;font-size:1.8rem;font-weight:700;cursor:pointer;color:white;
  margin-right:auto;margin-left:0;
}

/* Container */
.container{display:flex;flex:1;overflow:hidden;position:relative;}

/* Sidebar */
.sidebar{
  width:220px;background:#2c2c2c;color:white;flex-shrink:0;
  display:flex;flex-direction:column;
  position:fixed;top:60px;bottom:0;left:0;overflow-y:auto;z-index:1000;
  transition:0.3s;border-right:2px solid #d32f2f;
}
.sidebar h2{text-align:center;padding:20px 0;border-bottom:1px solid rgba(255,255,255,0.2);}
.sidebar nav a{
  padding:15px 20px;display:block;border-bottom:1px solid rgba(255,255,255,0.1);
  color:white;font-weight:500;border-left:4px solid transparent;
  transition:0.3s;
}
.sidebar nav a:hover{background:#d32f2f;border-left:4px solid #fff;border-radius:5px;}

/* Main content */
.main-content{
  margin-left:220px;
  flex:1;padding:30px;overflow-y:auto;background:#1c1c1c;
  min-height:calc(100vh - 60px);
}

/* Footer */
footer{
  background:#d32f2f;color:white;text-align:center;padding:20px;margin-top:auto;
}

/* Responsive */
@media(max-width:768px){
  .menu-toggle{display:block;margin-left:10px;}
  .sidebar{left:-240px;}
  .sidebar.active{left:0;}
  .main-content{margin-left:0;padding:15px;}
}
</style>
</head>
<body>

<header>
  <div class="menu-toggle" onclick="toggleSidebar()">☰</div>
  <div class="logo">CarServices</div>
  <div class="user">User <img src="https://i.pravatar.cc/40" alt="User"></div>
</header>

<div class="container">
  <aside class="sidebar" id="sidebar">
    <h2>Menu</h2>
    <nav>
      <a href="#">Dashboard</a>
      <a href="#">Book Service</a>
      <a href="#">My Services</a>
      <a href="#">Invoices</a>
      <a href="#">Statistics</a>
      <a href="#">Profile</a>
      <a href="#">Settings</a>
      <a href="#">Contact</a>
      <a href="{{ route('logout') }}">Logout</a>
    </nav>
  </aside>

  <main class="main-content">
    @yield('content')  <!-- Your dashboard page will go here -->
  </main>
</div>

<footer>
  &copy; 2025 CarServices. All rights reserved.
</footer>

<script>
function toggleSidebar(){
  document.getElementById('sidebar').classList.toggle('active');
}
</script>

</body>
</html>
