<?php
$nom = 'manet,tshergizbiev';
$prenom = 'cynthia,salakh';
if (!file_exists('./author.txt')) {
    $fd = fopen('./author.txt', 'w');
    fputs($fd, strtolower($nom) . ' ' . strtolower($prenom) . "\n");
    fclose($fd);
    echo 'file created with sucess!';
}
?>