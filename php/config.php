<?php
try {
    $conexao = new PDO("mysql:host=localhost;port=3306;dbname=cadastrovox", "root", "");
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Erro na conexão: ' . $e->getMessage();
    exit;
}
?>
