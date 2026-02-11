<?php
require_once 'conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Clínica Médica</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; }
        header { background: #218838; color: white; padding: 20px; margin-bottom: 30px; border-radius: 5px; }
        nav { margin: 20px 0; }
        nav a { display: inline-block; margin-right: 15px; padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; }
        nav a:hover { background: #218838; }
        .section { background: #f8f9fa; padding: 20px; margin: 20px 0; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #007bff; color: white; }
        tr:hover { background: #f5f5f5; }
        .btn { padding: 8px 15px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .btn-edit { background: #ffc107; color: black; }
        .btn-delete { background: #dc3545; color: white; }
        .btn-add { background: #007bff; color: white; }
        form { max-width: 500px; margin: 20px 0; }
        input, select, textarea { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 4px; }
        button { padding: 10px 20px; background: #28a745; color: white; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Cadastro Clínica Médica</h1>
        </header>
        
        <nav>
            <a href="?section=medicos">Médicos</a>
    <a href="?section=pacientes">Pacientes</a>
    <a href="?section=consultas">Consultas</a>
        </nav>
        
        <?php
        // Determinar qual seção mostrar
        $section = isset($_GET['section']) ? $_GET['section'] : 'medicos';
        
        if ($section === 'medicos') {
            include 'medicos.php';
        } elseif ($section === 'pacientes') {
            include 'pacientes.php';
        } elseif ($section === 'consultas') {
            include 'consultas.php';
        }
        ?>
    </div>
</body>
</html>