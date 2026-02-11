<div id="pacientes" class="section">
    <h2>Gerenciar Pacientes</h2>
    
    <?php
    require_once 'conexao.php';
    // Cadastrar paciente
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_paciente'])) {
        $nome = $_POST['nome'];
        $data_nascimento = $_POST['data_nascimento'];
        $telefone = $_POST['telefone'];
        $genero = $_POST['genero'];
        $endereco = $_POST['endereco'];
        $numero_identificacao = $_POST['numero_identificacao'];
        
        $sql = "INSERT INTO pacientes (nome, data_nascimento, telefone, genero, endereco, numero_identificacao) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$nome, $data_nascimento, $telefone, $genero, $endereco, $numero_identificacao]);
            echo "<p style='color: green;'>Paciente cadastrado com sucesso!</p>";
        } catch(PDOException $e) {
            echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
        }
    }
    
    // Excluir paciente
    if (isset($_GET['excluir_paciente'])) {
        $id = $_GET['excluir_paciente'];
        $sql = "DELETE FROM pacientes WHERE id_paciente = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        echo "<p style='color: green;'>Paciente excluído com sucesso!</p>";
    }
    ?>
    
    <h3>Cadastrar Novo Paciente</h3>
    <form method="POST">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="date" name="data_nascimento" placeholder="Data de Nascimento" required>
        <input type="text" name="telefone" placeholder="Telefone" required>
        <select name="genero" required>
            <option value="">Selecione o gênero</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select>
        <input type="text" name="endereco" placeholder="Endereço" required>
        <input type="text" name="numero_identificacao" placeholder="Número de Identificação" required>
        <button type="submit" name="cadastrar_paciente">Cadastrar Paciente</button>
    </form>
    
    <h3>Pacientes Cadastrados</h3>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Data Nasc.</th>
            <th>Telefone</th>
            <th>Gênero</th>
            <th>Nº Identificação</th>
            <th>Ações</th>
        </tr>
        <?php
        $sql = "SELECT * FROM pacientes ORDER BY nome";
        $stmt = $pdo->query($sql);
        while ($paciente = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td>{$paciente['id_paciente']}</td>
                <td>{$paciente['nome']}</td>
                <td>" . date('d/m/Y', strtotime($paciente['data_nascimento'])) . "</td>
                <td>{$paciente['telefone']}</td>
                <td>{$paciente['genero']}</td>
                <td>{$paciente['numero_identificacao']}</td>
                <td>
                    <a href='?section=pacientes&excluir_paciente={$paciente['id_paciente']}' 
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