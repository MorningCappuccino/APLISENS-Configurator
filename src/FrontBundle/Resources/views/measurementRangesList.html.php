<?php
if (empty($data)) exit('no data');


// "Pa" range exist?
foreach ($data as $row) :
    if ($row['unit'] == 'Па') { echo '<li class="header">Па</li>'; break; }
endforeach;

foreach ($data as $row) :
    if ($row['unit'] == 'Па'){
        echo '<li value="' . $row['id'] . '">'. $row['theRange'] .'</li>';
    }
endforeach;

echo '<li class="header disabled">кПа</li>';
foreach ($data as $row) :
    if ($row['unit'] == 'кПа'){
        echo '<li value="' . $row['id'] . '">'. $row['theRange'] .'</li>';
    }
endforeach;

echo '<li class="header disabled">мПа</li>';
foreach ($data as $row) :
    if ($row['unit'] == 'МПа'){
        echo '<li value="' . $row[0] . '">'. $row[1] .'</li>';
    }
endforeach;
?>

<script>
    $(".dropdown-menu li.disabled").click(function() {
        return false;
    });
</script>
