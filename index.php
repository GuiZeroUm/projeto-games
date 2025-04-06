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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NETFLIX VERDE GAMES EDITION</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="fas fa-gamepad me-2"></i>
                    NETFLIX VERDE GAMES EDITION
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                                <i class="fas fa-plus me-2"></i>Adicionar jogo original
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container">
            <div class="grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?php echo $row["image_link"]; ?>" class="card-img-top" alt="<?php echo $row["title"]; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                            <div class="mt-auto">
                                <button data-bs-toggle="modal" data-bs-target="#editModal" 
                                        data-id="<?= $row["game_id"]; ?>" 
                                        data-descricao="<?=$row["description"]; ?>" 
                                        data-titulo="<?=$row["title"]; ?>" 
                                        data-avaliacao="<?=$row["assessment"]; ?>" 
                                        data-imagem="<?=$row["image_link"]; ?>" 
                                        class="btn btn-outline-success w-100">
                                    <i class="fas fa-info-circle me-2"></i>Informações
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Modal Adicionar -->
    <div class="modal fade" id="adicionarModal" tabindex="-1" aria-labelledby="adicionarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-plus-circle me-2"></i>Adicionar novo jogo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id_adicionarar" id="adicionar-id">
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Link da imagem</label>
                            <input type="text" class="form-control" required name="imagem" id="imagem" placeholder="Cole o link da imagem do jogo">
                        </div>
                        <div class="mb-3">
                            <label for="titulo_adicionar" class="form-label">Título do jogo</label>
                            <input type="text" class="form-control" required name="titulo_adicionar" id="titulo_adicionar" placeholder="Digite o título do jogo">
                        </div>
                        <div class="mb-3">
                            <label for="descricao_adicionar" class="form-label">Descrição do jogo</label>
                            <textarea class="form-control" required name="descricao_adicionar" id="descricao_adicionar" rows="4" placeholder="Descreva o jogo"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="avaliacao_adicionar" class="form-label">Avaliação</label>
                            <select class="form-select" name="avaliacao_adicionar" id="avaliacao_adicionar">
                                <option selected disabled>Selecione sua avaliação</option>
                                <option value="1">Uma ⭐️</option>
                                <option value="2">Duas ⭐️</option>
                                <option value="3">Três ⭐️</option>
                                <option value="4">Quatro ⭐️</option>
                                <option value="5">Cinco ⭐️</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Adicionar jogo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content info-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="image-section">
                        <img src="" id="edit-imagem" alt="Game Image">
                    </div>
                    <div class="content-section">
                        <h3 id="titulo-modal-body"></h3>
                        <p id="edit-descricao"></p>
                        <div class="rating-section">
                            <h4 id="avaliacao"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editModal = document.getElementById('editModal');
            if (editModal) {
                editModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const descricao = button.getAttribute('data-descricao');
                    const titulo = button.getAttribute('data-titulo');
                    const avaliacao = button.getAttribute('data-avaliacao');
                    const imagem = button.getAttribute('data-imagem');
                    
                    document.getElementById('edit-descricao').innerText = descricao;
                    document.getElementById('titulo-modal').innerText = titulo;
                    document.getElementById('titulo-modal-body').innerText = titulo;
                    document.getElementById('edit-imagem').src = imagem;

                    let stars = '';
                    for (let i = 0; i < avaliacao; i++) {
                        stars += '⭐️';
                    }
                    document.getElementById('avaliacao').innerText = stars;
                });
            }
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>