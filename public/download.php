<?php
$usuario = 'user';
$senha = 'senha;

if ((isset($_GET['usuario']) && isset($_GET['senha'])) && ($_GET['usuario'] == $usuario && $_GET['senha'] == $senha) && isset($_GET['arquivo'])) {
    $file = '../../../csv/'.$_GET['arquivo'];
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Content-Length: ' . filesize($file));
    readfile($file);
    exit;
}