<h1>Take Appointment</h1>
<?php
    $s_year = $_GET["Years"];
    $s_month = $_GET["Months"];
    $s_day = $_GET["Days"];
    const mons = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    echo "Taking an appointment for: Year: ". $s_year. " Month: ".mons[$s_month]. " Day: ". $s_day;
    $s_month++;
    $servername = getenv('DB_HOST');
    $username = getenv('DB_USER');;
    $password = getenv('DB_PW');
    $db = getenv('DB');
    $scheisse = $s_year.'-'.$s_month.'-'.$s_day;
    // Create connection
    $conn = new mysqli($servername, $username, $password, $db);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $data = $conn->prepare('SELECT Time FROM appointment WHERE Date = ?');
    $data->bind_param('s', $scheisse);
    $data->execute();

    $result = $data->get_result();
    $array = array(8,9,10,11,12,13,14,15,16,17,18);
    while ($row = $result->fetch_assoc()) {
        array_splice($array, $row["Time"]-$array[0], 1);
    }
    if(date('Y-m-d')==$scheisse)
    {    
        while (time('h') >= $array[0]) {
            array_splice($array,0,1);
        }
    }
    echo "<form method='GET'><label>Available Hours<select name ='Hours' id = 'Hours'></label>";
    for ($i=0; $i < count($array); $i++) { 
        echo '<option value='.$array[$i].'>'.$array[$i].':00</option>';
    }
    echo "</select>";
    mysqli_close($conn);
    $_SESSION["Yr"] = $s_year;
    $_SESSION["Mn"] = $s_month;
    $_SESSION["Dy"] = $s_day;
?>
</form>
<input type="submit">
