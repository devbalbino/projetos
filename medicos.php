
<div id="medicos" class="section">
    <h2>Gerenciar Médicos</h2>
    
    <?php
require_once 'conexao.php';
    // Cadastrar médico
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_medico'])) {
        $nome = $_POST['nome'];
        $crm = $_POST['crm'];
        $especialidade = $_POST['especialidade'];
        
        $sql = "INSERT INTO medicos (nome, crm, especialidade) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$nome, $crm, $especialidade]);
            echo "<p style='color: green;'>Médico cadastrado com sucesso!</p>";
        } catch(PDOException $e) {
            echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
        }
    }
    
    // Excluir médico
    if (isset($_GET['excluir_medico'])) {
        $id = $_GET['excluir_medico'];
        $sql = "DELETE FROM medicos WHERE id_medico = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "<p style='color: green;'>Médico excluído com sucesso!</p>";
    }
    ?>
    
    <h3>Cadastrar Novo Médico</h3>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="text" name="crm" placeholder="CRM" required>
        <input type="text" name="especialidade" placeholder="Especialidade" required>
        <button type="submit" name="cadastrar_medico">Cadastrar Médico</button>
    </form>
    
    <h3>Médicos Cadastrados</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>CRM</th>
            <th>Especialidade</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT * FROM medicos ORDER BY nome";
        $stmt = $pdo->query($sql);
        while ($medico = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$medico['id_medico']}</td>
                <td>{$medico['nome']}</td>
                <td>{$medico['crm']}</td>
                <td>{$medico['especialidade']}</td>
                <td>
                    <a href='?section=medicos&excluir_medico={$medico['id_medico']}' 
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