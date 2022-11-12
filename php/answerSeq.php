<?php
include "db_conn.php";

extract($_POST);
foreach($qid as $k => $v){
    $adata = " survey_id=$survey_id ";
    $adata .= ", question_id='$qid[$k]' ";
    if($type[$k] == 'check_box'){
        $adata .= ", answer='[".implode("],[",$answer[$k])."]' ";
    }else{
        $adata .= ", answer='$answer[$k]' ";
    }
    $save[] = $conn->query("INSERT INTO answers set $adata");
}

header("Location: ../html/Thanks.html");
?>