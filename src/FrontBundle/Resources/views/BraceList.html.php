<?php
if (empty($data)) {exit('no data');}

echo "<li value=\"0\">без крепления</li>";
foreach ($data as $item){
    echo "<li value=". $item['id'] .">".  $item['name']  ."</li>";
}