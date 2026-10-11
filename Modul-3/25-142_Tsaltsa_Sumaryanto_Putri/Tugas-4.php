<?php
function tampilAsosiatif($nama, $arr) {
    $teks = '';
    foreach ($arr as $kunci => $nilai) {
        if ($teks != '') {
            $teks .= ', ';
        }
        $teks .= '"' . $kunci . '"=>"' . $nilai . '"';
    }
    return $nama . ' = (' . $teks . ')';
}
$height = array('Andy' => '176', 'Barry' => '165', 'Charlie' => '170');

// 4.1 
$height['David'] = '180';
$height['Ethan'] = '172';
$height['Frank'] = '168';
$height['George'] = '175';
$height['Harry'] = '182';

echo tampilAsosiatif('height', $height) . '<br><br>';
foreach ($height as $nama => $tinggi) {
    echo $nama . ' is ' . $tinggi . ' cm tall.<br>';
}
echo '<br>';

// 4.2 
$weight = array('Andy' => '70', 'Barry' => '65', 'Charlie' => '75');
echo tampilAsosiatif('weight', $weight) . '<br><br>';

$daftarNama = array();
foreach ($weight as $kunci => $nilai) {
    $daftarNama[] = $kunci;
}
for ($i = 0; $i < count($daftarNama); $i++) {
    $nama = $daftarNama[$i];
    echo $nama . ' is ' . $weight[$nama] . ' kg.<br>';
}