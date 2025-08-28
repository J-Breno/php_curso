<?php
var_dump(extension_loaded("gd"));
print_r(get_loaded_extensions());
$image = imagecreatetruecolor(300, 300);
$cor = imagecolorallocate($image, 255, 0, 0);
imagefill($image, 0, 0, $cor);

imagejpeg($image, 'nova_imagem.jpg', 100);