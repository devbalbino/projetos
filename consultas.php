<div id="consultas" class="section">
    <h2>Gerenciar Consultas</h2>
    
    <?php
    require_once 'conexao.php';
    // Cadastrar consulta
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_consulta'])) {
        $id_medico = $_POST['id_medico'];
        $id_paciente = $_POST['id_paciente'];
        $data_consulta = $_POST['data_consulta'];
        $diagnostico = $_POST['diagnostico'];
        $tratamento = $_POST['tratamento'];
        $prescricao_medica = $_POST['prescricao_medica'];
        $valor = $_POST['valor'];
        $status = $_POST['status'];
        
        $sql = "INSERT INTO consultas (id_medico, id_paciente, data_consulta, diagnostico, tratamento, prescricao_medica, valor, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$id_medico, $id_paciente, $data_consulta, $diagnostico, $tratamento, $prescricao_medica, $valor, $status]);
            echo "<p style='color: green;'>Consulta cadastrada com sucesso!</p>";
        } catch(PDOException $e) {
            echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
        }
    }
    
    // Excluir consulta
    if (isset($_GET['excluir_consulta'])) {
        $id = $_GET['excluir_consulta'];
        $sql = "DELETE FROM consultas WHERE id_consulta = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "<p style='color: green;'>Consulta excluída com sucesso!</p>";
    }
    ?>
    
    <h3>Agendar Nova Consulta</h3>
    <form method="POST">
        <?php
        // Buscar médicos
        $sql_medicos = "SELECT * FROM medicos ORDER BY nome";
        $stmt_medicos = $pdo->query($sql_medicos);
        $medicos = $stmt_medicos->fetchAll(PDO::FETCH_ASSOC);
        
        // Buscar pacientes
        $sql_pacientes = "SELECT * FROM pacientes ORDER BY nome";
        $stmt_pacientes = $pdo->query($sql_pacientes);
        $pacientes = $stmt_pacientes->fetchAll(PDO::FETCH_ASSOC);
        ?>
        
        <select name="id_medico" required>
            <option value="">Selecione o médico</option>
            <?php foreach($medicos as $medico): ?>
                <option value="<?php echo $medico['id_medico']; ?>">
                    <?php echo $medico['nome'] . " - " . $medico['especialidade']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <select name="id_paciente" required>
            <option value="">Selecione o paciente</option>
            <?php foreach($pacientes as $paciente): ?>
                <option value="<?php echo $paciente['id_paciente']; ?>">
                    <?php echo $paciente['nome']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <input type="datetime-local" name="data_consulta" required>
        <input type="number" step="0.01" name="valor" placeholder="Valor da consulta" required>
        <select name="status" required>
            <option value="agendada">Agendada</option>
            <option value="realizada">Realizada</option>
            <option value="cancelada">Cancelada</option>
        </select>
        <textarea name="diagnostico" placeholder="Diagnóstico" rows="3"></textarea>
        <textarea name="tratamento" placeholder="Tratamento" rows="3"></textarea>
        <textarea name="prescricao_medica" placeholder="Prescrição Médica" rows="3"></textarea>
        <button type="submit" name="cadastrar_consulta">Agendar Consulta</button>
    </form>
    
    <h3>Consultas Agendadas</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Médico</th>
            <th>Paciente</th>
            <th>Data</th>
            <th>Valor</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT c.*, m.nome as medico_nome, p.nome as paciente_nome 
                FROM consultas c
                JOIN medicos m ON c.id_medico = m.id_medico
                JOIN pacientes p ON c.id_paciente = p.id_paciente
                ORDER BY c.data_consulta DESC";
        $stmt = $pdo->query($sql);
        while ($consulta = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$consulta['id_consulta']}</td>
                <td>{$consulta['medico_nome']}</td>
                <td>{$consulta['paciente_nome']}</td>
                <td>" . date('d/m/Y H:i', strtotime($consulta['data_consulta'])) . "</td>
                <td>R$ " . number_format($consulta['valor'], 2, ',', '.') . "</td>
                <td>{$consulta['status']}</td>
                <td>
                    <a href='?section=consultas&excluir_consulta={$consulta['id_consulta']}' 
                       class='btn btn-delete' 
                       onclick='return confirm(\"Tem certeza que deseja excluir?\")'>
                       Excluir
                    </a>
                </td>
            </tr>";
        }
        ?>
    </table>
</div>