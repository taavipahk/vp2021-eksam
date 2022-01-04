<?php
require_once("header.php");

$notice="";
$notice2="";
$data=get_jams();

if(isset($_POST["submit"])){
    if(!empty($_POST["jam_input"]) and !empty($_POST["amount_input"])){
        $curr_amt=$data[2][array_search($_POST["jam_input"],$data[0])];
        $notice=give_jam($_POST["jam_input"],$_POST["amount_input"],$curr_amt);
    }else{
        $notice="Infot on puudu!";
    }
}

if(isset($_POST["submit2"])){
    if(!empty($_POST["name_input"])){
        $name=strtolower(sanitize($_POST["name_input"]));
        if(name_in_db($name)==true){
            $notice2="Selline moos on juba andmebaasis olemas!";
        }else{
            $notice2=new_name($name);
        }
    }else{
        $notice2="Sisesta nimi!";
    }
}

$data=get_jams();
?>
<h3>Lisamise lehekülg</h3>
<h3>Lisa purke</h3>
<h4><?php echo $notice; ?></h4>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="jam_input">Moosisort</label><br>
    <select name="jam_input" id="jam_input">
        <option selected disabled>Vali moos</option>
        <?php echo(selectable_jams($data,true)); ?>
    </select><br><br>
    <label for="amount_input">Kogus purke, mida lisad sahvrisse</label><br>
    <input name="amount_input" id="amount_input" type="number" min="1"><br><br>
    <input name="submit" id="submit" type="submit" value="Lisan selle koguse!">
</form>
<hr>
<h3>Lisa uus moosisort</h3>
<h4><?php echo $notice2; ?></h4>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="name_input">Uus moosisort</label><br>
    <input name="name_input" id="name_input" type="text"><br><br>
    <input name="submit2" id="submit2" type="submit" value="Lisan uue sordi!">
</form>
</body>