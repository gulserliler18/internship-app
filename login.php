<h1>Confirm Appointment</h1>
<p>
<?php
    $s_year = $_SESSION["Yr"];
    $s_month = $_SESSION["Mn"];
    $s_day = $_SESSION["Dy"];
    $s_hour = $_GET["Hours"];
    $_SESSION["Hr"] = $s_hour;
    echo "<div class='paragraph'>You are taking an appointment on ". intval($s_day)."/". intval($s_month). "/". intval($s_year). " at ".$s_hour.":00. </div>";
?>
Please enter your GSM Number and Password to take the appointment.</p>
<div class='calendar'>
<form method="POST">
    <label for='GSM'>GSM Number</label>
    <input type="tel" name = "GSM" id="GSM" placeholder="123-456-7890" pattern="[0-9]{10}" required="required" >
    <label for='passkey'>Password</label>
    <input type="password" name = "passkey" id="passkey" required="required" >
<input type="submit">
</form>
</div>
<?php
if(isset($_POST["GSM"]))
{
    $servername = getenv('DB_HOST');
    $username = getenv('DB_USER');;
    $password = getenv('DB_PW');
    $db = getenv('DB')
    $scheisse = $_SESSION["Yr"].'-'.$_SESSION["Mn"].'-'.$_SESSION["Dy"];
    $conn = new mysqli($servername, $username, $password, $db);
    $gsm = $_POST['GSM'];
    $pk = $_POST['passkey'];
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = $conn->prepare('SELECT Passkey FROM user WHERE GSM = ?');
    $data->bind_param('s', $gsm);
    $data->execute();

    $result = $data->get_result();
    $row = $result->fetch_assoc();
    if ($row['Passkey'] == $pk) {
        $data = $conn->prepare('SELECT * FROM appointment WHERE Date=? and Time=?');
        $data->bind_param('ss', $scheisse,$_SESSION["Hr"]);
        $data->execute();

        $result = $data->get_result();
        $row = $result->fetch_assoc();
        $url= $_SERVER['REQUEST_URI']; 
        $pos = strpos($url, "?");
        $url = substr($url,0,$pos);
        $url = $url."?page=home";
        if (empty($row)) {
            $data = $conn->prepare('INSERT into appointment (Date,Time,GSM) values (?,?,?)');
            $data->bind_param('sss',$scheisse,$_SESSION["Hr"],$gsm);
            $data->execute();
            mysqli_close($conn);
            session_destroy();
            $message = 'OK';
            $gsm = substr($gsm,9,1);
            if (intval($gsm)%2) {
                echo "<script>alert('Redirecting to homepage, your GSM number is an odd number');";
            }
            else {
                echo "<script>alert('Redirecting to homepage, your GSM number is an even number');";
            }
            echo "window.location = '$url';</script>";
        }
        else {
            echo "<script>alert('Redirecting to homepage, this hour is full'); window.location = '$url';</script>";
        }
    }
    else {
        echo "<script>alert('Wrong password or GSM number')</script>";
    }
}
?>
