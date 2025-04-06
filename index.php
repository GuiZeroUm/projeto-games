<?php

$servername = "localhost";
$username = "root";
$password = "root"; // No MAMP, a senha padrão é "root"
$dbname = "games_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: ");
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_adicionarar"])) {
    $id = $_POST["id_adicionarar"];
    $titulo = $_POST["titulo_adicionar"];
    $descricao = $_POST["descricao_adicionar"];
    $imagem = $_POST["imagem"];
    $avaliacao = $_POST["avaliacao_adicionar"];
    $conn -> query("INSERT INTO games (image_link, title, description, assessment) VALUES ('$imagem', '$titulo', '$descricao', '$avaliacao')");

    header("Location: index.php");
    exit();
}

// Buscar tarefas
$result = $conn->query("SELECT * FROM games");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas (PHP)</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="style.css"> -->
</head>
<body>
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">NETFLIX VERDE GAMES EDITION</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#adicionarModal">Adicionar jogo original</button>
            </div>
        </nav>
        
        <?php while ($row = $result->fetch_assoc()): ?>
            <div>
                <div class="card grid list-gri" style="width: 18rem;">
                    <img src="<?php echo $row["image_link"]; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                        <button data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $row["game_id"]; ?>" data-descricao="<?=$row["description"]; ?>" data-titulo="<?=$row["title"]; ?>" data-avaliacao="<?=$row["assessment"]; ?>" data-imagem="<?=$row["image_link"]; ?>" class="btn btn-primary">Informações</button>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <div class="modal fade" id="adicionarModal" tabindex="-1" aria-labelledby="adicionarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h1 class="modal-title fs-5" id="titulo-modal">Adicionar novo jogo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_adicionarar" id="adicionar-id">
                        <div class="mb-3">
                            <input type="text" class="form-control" required name="imagem" id="imagem" placeholder="Cole o link da imagem do jogo">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" required name="titulo_adicionar" id="titulo_adicionar" placeholder="Digite o título do jogo">
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" required placeholder="Leave a comment here" name="descricao_adicionar" id="descricao_adicionar" style="height: 100px"></textarea>
                            <label for="descricao_adicionar">Descrição do jogo</label>
                        </div>
                        <div class="mb-3">
                            <div class="col-md">
                                <div class="form-floating">
                                <select class="form-select" name="avaliacao_adicionar" id="avaliacao_adicionar">
                                    <option selected>Avaliação</option>
                                    <option value="1">Uma ⭐️</option>
                                    <option value="2">Duas ⭐️</option>
                                    <option value="3">Três ⭐️</option>
                                    <option value="4">Quatro ⭐️</option>
                                    <option value="5">Cinco ⭐️</option>
                                </select>
                                <label for="avaliacao_adicionar">Selecione sua avaliação do jogo</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar jogo</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="titulo-modal"></h1>
                    <h3 id="titulo-modal-body"></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_editar" id="edit-id">
                        <div class="mb-3">
                            
                            <p id="edit-descricao"></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <h1 id="avaliacao"></h1>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para preencher o modal com os dados da tarefa
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const descricao = button.getAttribute('data-descricao');
                    const titulo = button.getAttribute('data-titulo');
                    const avaliacao = button.getAttribute('data-avaliacao')
                    
                    document.getElementById('edit-id').value = id;
                    document.getElementById('edit-descricao').innerText = descricao;
                    document.getElementById('titulo-modal').innerText = titulo;
                    document.getElementById('titulo-modal-body').innerText = titulo;

                    if (avaliacao == 5) {
                        document.getElementById('avaliacao').innerText = '⭐️⭐️⭐️⭐️⭐️';
                    }
                    if (avaliacao == 4) {
                        document.getElementById('avaliacao').innerText = '⭐️⭐️⭐️⭐️';
                    } 
                    if (avaliacao == 3) {
                        document.getElementById('avaliacao').innerText = '⭐️⭐️⭐️';
                    } 
                    if (avaliacao == 2) {
                        document.getElementById('avaliacao').innerText = '⭐️⭐️';
                    } 
                    if (avaliacao == 1) {
                        document.getElementById('avaliacao').innerText = '⭐️';
                    } 
                });
            }
        });
    </script>

</body>
</html>

<?php $conn->close(); ?>