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

//3.1
$height = array('Andy' => '176', 'Barry' => '165', 'Charlie' => '170');
echo 'Andy is ' . $height['Andy'] . ' cm tall.<br><br>';
$height['David'] = '180';
$height['Ethan'] = '172';
$height['Frank'] = '168';
$height['George'] = '175';
$height['Harry'] = '182';

echo tampilAsosiatif('height', $height) . '<br>';
echo 'Nilai dengan indeks terakhir: ' . $height[array_key_last($height)] . '<br><br>';

unset($height['Barry']);
echo tampilAsosiatif('height', $height) . '<br>';
echo 'Nilai dengan indeks terakhir setelah dihapus: ' . $height[array_key_last($height)] . '<br><br>';

//3.2
$weight = array('Andy' => '70', 'Barry' => '65', 'Charlie' => '75');
echo tampilAsosiatif('weight', $weight) . '<br>';
$nilaiWeight = array_values($weight);
echo 'Data kedua: ' . $nilaiWeight[1] . '<br>';