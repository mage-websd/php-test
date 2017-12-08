<?php
$file = fopen ('lib/domain_keyword', 'r');
$array = [];
while(!feof($file)) {
    $string = trim(fgets($file));
    if (!$string) {
        continue;
    }
    $stringArray = explode(',', $string);
    foreach ($stringArray as $stringItemNew) {
        $same = false;
        $stringItemNew = trim($stringItemNew);
        foreach ($array as $item) {
            if (mb_strtolower($item) == mb_strtolower($stringItemNew)) {
                $same = true;
                break;
            }
        }
        if (!$same) {
            $array[] = $stringItemNew;
        }
    }
}
sort($array);
fclose($file);
echo '\'' . (implode('\',<br/>\'', $array)) . '\'';