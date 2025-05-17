<?php

$json_voyages=file_get_contents("../json/voyages.json");
$voyages=json_decode($json_voyages, true);

//rajouter verifs parametres

$id=$_POST["id"];
$total=$voyages[$id]["prix"];

foreach($voyages[$id]["etapes"] as $k=> $etape){
    foreach($etape["option"] as $i=>$option){
        if(isset($_POST['option'.$k.$i])){
            $total+=explode(';',$_POST['option'.$k.$i])[1];
        }
    }
}

echo json_encode([
  'success' => true,
  'total' => $total
]);
?>