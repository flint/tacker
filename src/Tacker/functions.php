<?php

function tacker_array_map_recursive(array $array, $callback) {
    $mapped = array();

    foreach ($array as $k => $v) {
        $mapped[$k] = is_array($v) ? tacker_array_map_recursive($v, $callback) : $callback($v);
    }

    return $mapped;
}
