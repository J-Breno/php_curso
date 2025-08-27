<?php
echo date('d/m/Y H:i:s');
$data = '2025-08-27';
$time = strtotime($data);
echo date('d/m/Y', $time);
echo date('d/m/Y', strtotime($data));