<?php
function tampil($arr) {
    $teks = '';
    foreach ($arr as $nilai) {
        $teks .= $nilai . ' ';
    }
    return $teks;
}
function tampilKunci($arr) {
    $teks = '';
    foreach ($arr as $kunci => $nilai) {
        $teks .= $kunci . '=> ' . $nilai . ', ';
    }
    return $teks;
}
$a = array('A');
echo 'Array awal: ("A")<br>';
array_push($a, 'B');
echo 'Hasil array_push: ' . tampil($a) . '<br><br>';

$b1 = array('A', 'B');
$b2 = array('C');
echo 'Array awal: ("A", "B") digabung dengan ("C")<br>';
echo 'Hasil array_merge: ' . tampil(array_merge($b1, $b2)) . '<br><br>';

$c = array('x' => 1, 'y' => 2);
echo 'Array awal: ("x" => 1, "y" => 2)<br>';
echo 'Hasil array_values: ' . tampil(array_values($c)) . '<br><br>';

$d = array('A', 'B', 'C');
echo 'Mencari "B" pada array: ("A", "B", "C")<br>';
echo 'Hasil array_search: ' . array_search('B', $d) . '<br><br>';

$e = array(0, 1, false, 2, '', 3, 'array');
echo 'Array awal: (0, 1, false, 2, "", 3, "array")<br>';
echo 'Hasil array_filter: ' . tampil(array_filter($e)) . '<br><br>';

$f = array(3, 1, 2);
echo 'Array awal: (3, 1, 2)<br>';
sort($f);
echo 'Hasil sort: ' . tampil($f) . '<br>';
rsort($f);
echo 'Hasil rsort: ' . tampil($f) . '<br><br>';

$age = array('Peter' => 35, 'Ben' => 37, 'Joe' => 43);
echo 'Array awal: ("Peter"=>35, "Ben"=>37, "Joe"=>43)<br>';

$t = $age;
asort($t);
echo 'Hasil asort: ' . tampilKunci($t) . '<br>';

$t = $age;
ksort($t);
echo 'Hasil ksort: ' . tampilKunci($t) . '<br>';

$t = $age;
arsort($t);
echo 'Hasil arsort: ' . tampilKunci($t) . '<br>';

$t = $age;
krsort($t);
echo 'Hasil krsort: ' . tampilKunci($t) . '<br>';
?>