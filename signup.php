<h1>Sign Up</h1>
<p>Please enter your Name, GSM Number and Password to create an account.</p>
<div class='calendar'>
<form method="POST">
    <label for='Name'>Full Name</label>
    <input type="text" pattern="{50}" required="required" name='name' id='name'>
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
    $conn = new mysqli($servername, $username, $password, $db);
    $gsm = $_POST['GSM'];
    $pk = $_POST['passkey'];
    $name = $_POST['name'];
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = $conn->prepare('SELECT * FROM user WHERE GSM = ?');
    $data->bind_param('s', $gsm);
    $data->execute();

    $result = $data->get_result();
    $row = $result->fetch_assoc();
    if (count($row)) {
        echo "<script>alert('An account to that GSM already exists');</script>";
    }
    else {
        $data = $conn->prepare('insert into User (GSM, Name_Surname, Passkey) values (?,?,?);');
        $data->bind_param('sss',$gsm,$name,$pk);
        $data->execute();
        $url= $_SERVER['REQUEST_URI']; 
        $pos = strpos($url, "?");
        $url = substr($url,0,$pos);
        $url = $url."?page=home";
        mysqli_close($conn);
        echo "<script>alert('Your account is set. Redirecting to homepage.'); window.location = '$url';</script>";
    }
}
?>
