<?php
if (!isset($_GET['dev'])) {
    echo 'main tain';
    exit;
}
if (!in_array($_SERVER['SERVER_ADDR'], [
    '172.31.26.108'
]) {
    exit;
}