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
    echo "<a href=$url>Homepage</a>";
    $url = str_replace("home","calendar",$url);
    echo "<a href=$url>Calendar</a>";
    $url = str_replace("calendar","signup",$url);
    echo "<a href=$url>Sign Up</a>";

?>
</nav>

<center>
<?php
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
        echo "<div class = 'paragraph'><h1>Welcome</h1> <p>To take appointments you need an account. To sign up, click Sign Up from the bar above. If you already have an account, go to calender. Your login information will be requested upon selecting an available time.</p></div>";
    }
?>
</center>
</body>
<footer><center><small>&copy; 2021, Egemen Gülserliler</small></center></footer>
</html>