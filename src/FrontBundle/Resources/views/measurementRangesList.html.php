<?php
if (empty($data)) exit('no data');


// "Pa" range exist?
foreach ($data as $row) :
    if ($row['unit'] == 'Па') { echo '<li class="header"><a href="#">Па</a></li>'; break; }
endforeach;

foreach ($data as $row) :
    if ($row['unit'] == 'Па'){
        echo '<li value="' . $row['id'] . '">'. $row['theRange'] .'</li>';
    }
endforeach;

echo '<li class="header"><a href="#">кПа</a></li>';
foreach ($data as $row) :
    if ($row['unit'] == 'кПа'){
        echo '<li value="' . $row['id'] . '">'. $row['theRange'] .'</li>';
    }
endforeach;

echo '<li class="header"><a href="#">МПа</a></li>';
foreach ($data as $row) :
    if ($row['unit'] == 'МПа'){
        echo '<li value="' . $row['id'] . '">'. $row['theRange'] .'</li>';
    }
endforeach;
?>

<script>
    //======Early it WORKS oO======\\
//    $(".dropdown-menu li.disabled").click(function() {
//        console.log(0);
//        return false;
//    });

    $('.dropdown-menu li.disabled').bind('click', function(e){
        e.preventDefault();
        return false;
    });
//arrrr


//$(".dropdown-menu li.disabled").load(function() {
//    console.log(1);
//    $('.dropdown-menu li.disabled').off('click')
//});

</script>
