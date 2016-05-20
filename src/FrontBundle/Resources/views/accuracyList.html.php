<?php
//print_r(var_dump($data));
if (empty($data)) {exit('no data');}

foreach ($data as $item){
   echo "<li value=". $item['id'] .">". floatval( $item['name'] ) ."</li>";
}
