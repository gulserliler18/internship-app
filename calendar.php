<h1>Calendar</h1>
<?php
    $url= $_SERVER['REQUEST_URI'];
    $url = str_replace("calendar","login",$url);
    echo "<p>Today is ". date("Y/m/d") . "<br> You can take appointments for the following 6 months. <br> Please select a day and press submit to see the available hours.<p>";
    $startdate = strtotime("Today");
    $enddate = strtotime("+6 months", $startdate);
    $iter = $startdate;
    echo "<div class='calendar'><label style='color: #111111'>Year</label><form action='' method='GET'><select name ='Years' id = 'Years' onChange='SelectSubCat();' required='required'>";
    echo "<option value='' selected disabled>Choose here</option>";
    echo '<option value='.date("Y", $iter).'>'.date("Y", $iter).'</option>';
    if(date("Y",$enddate) != date("Y",$startdate))
        echo '<option value='.date("Y", $enddate).'>'.date("Y", $enddate).'</option>';
    echo "</select>";
?>
<label style="color: #111111" >Months</label>
<select name ='Months' id = 'Months' onChange='SelectDays();' required='required'>
</select> 
<label style="color: #111111" >Days</label>
<select name ='Days' id = 'Days' required='required'>
</select>
<input type="submit">
</form>
</div>
<script type="text/javascript">

function removeAll(selectBox) {
    while (selectBox.options.length > 0) {
        selectBox.remove(0);
    }
}

function SelectSubCat(){

    // ON selection of category this function will work
    
    const mons = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    var d = new Date();
    var y = d.getFullYear();
    var m = d.getMonth();
    removeAll(document.getElementById('Months'));
    var opt = document.createElement('option');
    opt.value = "";
    opt.innerHTML = "Select Month";
    opt.setAttribute("selected", "selected");
    opt.setAttribute("disabled", "disabled");
    document.getElementById('Months').appendChild(opt);
    if(document.getElementById('Years').value == y){
        while(d.getFullYear() != y+1)
        {
            opt = document.createElement('option');
            opt.value = d.getMonth();
            opt.innerHTML = mons[d.getMonth()];
            document.getElementById('Months').appendChild(opt);
            d.setMonth(d.getMonth()+1);
        }
    }
    else
    {
        m = 6 - (12 - m);
        d.setDate(1);
        d.setMonth(0);
        d.setFullYear(d.getFullYear()+1);
        while(m>d.getMonth())
        {
            mon = d.getMonth() + 1;
            opt = document.createElement('option');
            opt.value = d.getMonth();
            opt.innerHTML = mons[d.getMonth()];
            document.getElementById('Months').appendChild(opt);
            d.setMonth(mon);
        }
    }
}

function SelectDays(){

// ON selection of category this function will work
var d = new Date();
if(document.getElementById('Months').value != d.getMonth())
{
    d.setDate(1);
    d.setMonth(document.getElementById('Months').value);
    d.setFullYear(document.getElementById('Years').value)
}
var y = d.getFullYear();
var m = d.getMonth();
removeAll(document.getElementById('Days'));
var opt = document.createElement('option');
opt.value = "";
opt.innerHTML = "Select Day";
opt.setAttribute("selected", "selected");
opt.setAttribute("disabled", "disabled");
document.getElementById('Days').appendChild(opt);
while(d.getMonth() == m)
{
    opt = document.createElement('option');
    opt.value = d.getDate();
    opt.innerHTML = d.getDate();
    document.getElementById('Days').appendChild(opt);
    d.setDate(d.getDate()+1);
}
}
</script>
