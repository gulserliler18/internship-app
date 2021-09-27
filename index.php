<?php
    $url= $_SERVER['REQUEST_URI'];  
    session_start();  

    if(!isset($_GET["page"]))
    {
        if(isset($_GET["Years"]))
        {
            header("Location: $url&page=confirm");
        }
        else if (isset($_GET["Hours"]))
            header("Location: $url&page=login");
        else
            header("Location: $url?page=home");
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $_GET["page"]?></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar">
<?php
    $pos = strpos($url, "?");
    $url = substr($url,0,$pos);
    $url = $url."?page=home";
    $home = $url; 
    echo "<a href=$url  class='na'>Homepage</a>";
    $url = str_replace("home","calendar",$url);
    echo "<a href=$url  class='na'>Calendar</a>";
    $url = str_replace("calendar","signup",$url);
    echo "<a href=$url  class='na'>Sign Up</a>";
    echo "<a href=$home class='na' onclick='return darkmode();'>Toggle dark mode</a>";

?>
</nav>
    
<script>
 var element = document.body;
if (localStorage.getItem("theme") === "dark") {
  element.classList.add('dark-mode');
  }
function darkmode() {
  if (element.classList.contains('dark-mode')) {
    element.classList.remove('dark-mode');
    localStorage.setItem("theme", "light");
  } 
  else {
    element.classList.add('dark-mode');
    localStorage.setItem("theme", "dark");
  }
   return false;
}
</script>

<center>
<?php
    ini_set("display_errors", 1);
    error_reporting(E_ALL);
    if($_GET["page"] == "calendar")
    require "calendar.php";
    else if($_GET["page"] == "confirm")
    require "confirm.php";
    else if($_GET["page"] == "login")
    require "login.php";
    else if($_GET["page"] == "signup")
    require "signup.php";
    elseif ($_GET["page"]== "home") {
        $url= $_SERVER['REQUEST_URI']; 
        echo "<div class = 'paragraph'><h1>Welcome</h1> <p>To take appointments you need an account. To sign up, click Sign Up from the bar above. If you already have an account, go to calender. Your login information will be requested upon selecting an available time.</p></div>
    <div class='about'><h5>About Me</h5><p>I'm a senior year Computer Engineering student at ITU. I'm 21 years old. Actively looking for part time or freelance opportunities. Contact: gulserliler18@itu.edu.tr</p></div>";
    }
?>
</center>
</body>
    <footer><small>&copy; 2021, Egemen Gülserliler, reach the <a href="https://github.com/gulserliler18/internship-app">source codes</a></small></footer>
</html>
