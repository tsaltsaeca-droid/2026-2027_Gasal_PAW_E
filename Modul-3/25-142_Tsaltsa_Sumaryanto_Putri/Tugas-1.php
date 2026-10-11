<?php
function tampilIndeks($nama, $arr) {
    $teks = '';
    foreach ($arr as $nilai) {
        if ($teks != '') {
            $teks .= ', ';
        }
        $teks .= '"' . $nilai . '"';
    }
    return $nama . ' = ( ' . $teks . ' )';
}
// 1.1
$fruits = ['Avocado', 'Blueberry', 'Cherry'];
$fruits[] = 'Durian';
$fruits[] = 'Elderberry';
$fruits[] = 'Fig';
$fruits[] = 'Grape';
$fruits[] = 'Honeydew';

echo tampilIndeks('fruits', $fruits) . '<br>';
echo 'Nilai dengan indeks tertinggi: ' . $fruits[array_key_last($fruits)] . '<br><br>';

// 1.2
unset($fruits[1]);
echo 'Data Blueberry dihapus.<br>';
echo tampilIndeks('fruits', $fruits) . '<br>';
echo 'Nilai dengan indeks tertinggi: ' . $fruits[array_key_last($fruits)] . '<br>';
