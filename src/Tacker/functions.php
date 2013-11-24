<?php

function tacker_array_map_recursive(array $array, $callback) {
    $mapped = array();

    foreach ($array as $k => $v) {
        if (is_array($v)) {
            $v = tacker_array_map_recursive($v, $callback);
        } else {
            $v = call_user_func($callback, $v);
        }

        $mapped[$k] = $v;
    }

    return $mapped;
}
