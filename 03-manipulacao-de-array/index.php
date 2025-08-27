<?php
$array = range(1, 20, 2);
$array2 = range('a', 'z', 2);

foreach ($array as $item) {
    echo $item."<br />";
}

foreach ($array2 as $item) {
    echo $item."<br />";
}