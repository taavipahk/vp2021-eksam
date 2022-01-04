<?php
    $database="if21_taavi_pa";
    require("../../config.php");

    function new_name($name){
        $default_amt=0;
        $conn=new mysqli($GLOBALS["server_host"],$GLOBALS["server_user"],$GLOBALS["server_pass"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt=$conn->prepare("INSERT INTO vp_eksam (jam_name,jam_amount) VALUES(?,?)");
        echo $conn->error;
        $stmt->bind_param("si",$name,$default_amt);
        if($stmt->execute()){
			$notice="Uus moos lisatud!";
		}else{
            $notice="Tekkis viga andmebaasiga!";
        }
        $stmt->close();
		$conn->close();
        return $notice;
    }

    function name_in_db($name){
        $conn=new mysqli($GLOBALS["server_host"],$GLOBALS["server_user"],$GLOBALS["server_pass"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt=$conn->prepare("SELECT COUNT(jam_name) FROM vp_eksam WHERE jam_name=?;");
        echo $conn->error;
        $stmt->bind_param("s",$name);
        $stmt->bind_result($query);
        $stmt->execute();
        if($stmt->fetch()){
            $answer=$query;
        }
        $stmt->close();
        $conn->close();
        if($answer>0){
            return true;
        }else{
            return false;
        }
    }

    function sanitize($str){
        $new=filter_var($str,FILTER_SANITIZE_STRING);
        return $new;
    }

    function give_jam($id,$take_amt,$curr_amt){
        $new_amt=$curr_amt+$take_amt;
        $conn=new mysqli($GLOBALS["server_host"],$GLOBALS["server_user"],$GLOBALS["server_pass"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt=$conn->prepare("UPDATE vp_eksam SET jam_amount=? WHERE id=?");
        echo $conn->error;
        $stmt->bind_param("ii",$new_amt,$id);
        if($stmt->execute()){
            $notice=$take_amt." moosipurki lisatud!";
        }else{
            $notice="Tekkis viga andmebaasiga!";
        }
        $stmt->close();
		$conn->close();
        return $notice;
    }

    function take_jam($id,$take_amt,$curr_amt){
        $new_amt=$curr_amt-$take_amt;
        $conn=new mysqli($GLOBALS["server_host"],$GLOBALS["server_user"],$GLOBALS["server_pass"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt=$conn->prepare("UPDATE vp_eksam SET jam_amount=? WHERE id=?");
        echo $conn->error;
        $stmt->bind_param("ii",$new_amt,$id);
        if($stmt->execute()){
            $notice=$take_amt." moosipurki võetud!";
        }else{
            $notice="Tekkis viga andmebaasiga!";
        }
        $stmt->close();
		$conn->close();
        return $notice;
    }

    function selectable_jams($data,$include_0=false){
        $html="";
        $ids=$data[0];
        $names=$data[1];
        $amounts=$data[2];
        foreach($ids as $curr_id){
            $curr_name=$names[array_search($curr_id,$ids)];
            $curr_amt=$amounts[array_search($curr_id,$ids)];
            if($include_0==false){
                if($curr_amt==0){
                    continue;
                }
            }
            $html.='<option value="'.$curr_id.'">'.$curr_name.', '.$curr_amt.' olemas</option>';
        }
        return $html;
    }

    function get_jams(){
        $db_ids=[];
        $db_names=[];
        $db_amounts=[];
        $conn=new mysqli($GLOBALS["server_host"],$GLOBALS["server_user"],$GLOBALS["server_pass"],$GLOBALS["database"]);
        $conn->set_charset("utf8");
        $stmt=$conn->prepare("SELECT id, jam_name, jam_amount FROM vp_eksam ORDER BY jam_name ASC");
        echo $conn->error;
        $stmt->bind_result($db_id,$db_name,$db_amt);
        $stmt->execute();
        while($stmt->fetch()){
            array_push($db_ids,$db_id);
            array_push($db_names,$db_name);
            array_push($db_amounts,$db_amt);
        }
        $stmt->close();
        $conn->close();
        $db_data=[
            $db_ids,
            $db_names,
            $db_amounts];
        return $db_data;
    }

    function links($clink){
        $url=explode("/",$clink)[3];
        $available_links=["take_jam.php","give_jam.php"];
        $pagenames=["Võta sahvrist moosi","Lisa sahvrisse moosi (purke ja uusi sorte)"];
        unset($available_links[array_search($url,$available_links)]);
        $html="<ul>\n";
        foreach($available_links as $link){
            $html.="<li><a href='".$link."'>".$pagenames[array_search($link,$available_links)]."</a></li>\n";
        }
        $html.="</ul>";
        return $html;
    }
?>