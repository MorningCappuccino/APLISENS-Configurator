<?php
if (empty($data)) {exit('no data');}

foreach ($data as $item){
   echo "<li value=". $item['id'] .">".  $item['name']  ."</li>";
}
