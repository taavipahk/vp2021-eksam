<?php
require_once("header.php");

$notice="";
$data=get_jams();

if(isset($_POST["submit"])){
    if(!empty($_POST["jam_input"]) and !empty($_POST["amount_input"])){
        $curr_amt=$data[2][array_search($_POST["jam_input"],$data[0])];
        $notice=take_jam($_POST["jam_input"],$_POST["amount_input"],$curr_amt);
    }else{
        $notice="Infot on puudu!";
    }
}

$data=get_jams();
?>
<h3>Moosi sahvrist võtmise lehekülg</h3>
<h4><?php echo $notice; ?></h4>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="jam_input">Moosisort</label><br>
    <select name="jam_input" id="jam_input">
        <option selected disabled>Vali moos</option>
        <?php echo(selectable_jams($data)); ?>
    </select><br><br>
    <label for="amount_input">Kogus purke, mida võtad sahvrist</label><br>
    <input name="amount_input" id="amount_input" type="number" min="1"><br><br>
    <input name="submit" id="submit" type="submit" value="Võtan selle koguse!">
</form>
</body>