<?php
// scripts/criar_admin.php

require __DIR__ . "/../conexao/conexao.php";

/*
 | CONFIGURAÇÃO DO ADMIN
 | Altere SOMENTE estes dados
*/
$nome  = "Administrador";
$email = "admin@admin.com";
$senha = "admin123";
$perfil = "admin";

/*
 | VERIFICA SE JÁ EXISTE ADMIN
 | Evita duplicação
*/
$stmt = $pdo->prepare(
    "SELECT id FROM usuarios WHERE email = ?"
);
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    die("Administrador já existe. Script não executado.");
}

/*
 | GERA HASH SEGURO DA SENHA
*/
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/*
 | INSERE ADMIN
*/
$stmt = $pdo->prepare(
    "INSERT INTO usuarios (nome, email, senha, perfil)
     VALUES (?, ?, ?, ?)"
);

$stmt->execute([
    $nome,
    $email,
    $senhaHash,
    $perfil
]);

echo "Administrador criado com sucesso! 🚀";
