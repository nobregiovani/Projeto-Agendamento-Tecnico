<?php
    session_start();
    
    // Bloqueia acesso se não estiver logado
    if (!isset($_SESSION['usuario'])) {
        header("Location: login.php");
        exit;
    }