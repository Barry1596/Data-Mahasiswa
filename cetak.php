<?php


require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML('<h1>Hey Silahkan Tonton Ini </h1>

<a href="https://www.youtube.com/watch?v=C9Tj7EBrtFo&list=PLFIM0718LjIUqXfmEIBE3-uzERZPh3vp6&index=23">https://www.youtube.com/watch?v=C9Tj7EBrtFo&list=PLFIM0718LjIUqXfmEIBE3-uzERZPh3vp6&index=23</a>');
$mpdf->Output();



?>