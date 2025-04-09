<?php
$servername = "localhost";
$username = "root";
$password = "root"; // XAMPP padrão: senha vazia para o usuário root
$dbname = "games_db";

// Cria a conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Processa o formulário de adição de jogo
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_adicionarar"])) {
    $id = $_POST["id_adicionarar"];
    $titulo = $_POST["titulo_adicionar"];
    $descricao = $_POST["descricao_adicionar"];                                                                             
    $imagem = $_POST["imagem"];
    $avaliacao = $_POST["avaliacao_adicionar"];
    
    // Insere o novo jogo na tabela
    $conn->query("INSERT INTO games (image_link, title, description, assessment) VALUES ('$imagem', '$titulo', '$descricao', '$avaliacao')");
    
    header("Location: index.php");
    exit();
}
                                        
// Processa a edição de jogo
if (isset($_POST["id_editar"])) {
    $id = $_POST["id_editar"];
    $titulo = $_POST["titulo_editar"];
    $descricao = $_POST["descricao_editar"];
    $imagem = $_POST["imagem_editar"];
    $avaliacao = $_POST["avaliacao_editar"];

    // Atualiza o jogo na tabela
    $conn->query("UPDATE games SET image_link='$imagem', title='$titulo', description='$descricao', assessment='$avaliacao' WHERE game_id=$id");
    
            header("Location: index.php");
            exit();
}

// Remove um jogo cadastrado
if (isset($_GET["remove"])) {
    $id = $_GET["remove"];
    $conn->query("DELETE FROM games WHERE game_id=$id");

    header("Location: index.php");
    exit();
}

// Filtro de jogos com base na avaliação (Exibir apenas os jogos com a avaliação selecionada)   
$filter = isset($_GET["filter"]) ? $_GET["filter"] : null;
if (isset($_GET["filter"])) {
    $filter = intval($_GET["filter"]);
    $result = $conn->query("SELECT * FROM games WHERE assessment = $filter");
} else {
    $result = $conn->query("SELECT * FROM games ORDER BY assessment DESC"); 
}

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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#adicionarModal">
                                <i class="fas fa-plus me-2"></i>Adicionar jogo
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

                <!-- Grupo de filtros -->
        <div class="container mb-4">
            <div class="btn-group row row-cols-auto gap-2" role="group" aria-label="Filtrar por avaliação">
                <a href="index.php" class="btn btn-outline-success col-sm">Todos</a>
                <a href="index.php?filter=5" class="btn btn-outline-success col-sm">5 Estrelas</a>
                <a href="index.php?filter=4" class="btn btn-outline-success col-sm">4 Estrelas</a>
                <a href="index.php?filter=3" class="btn btn-outline-success col-sm">3 Estrelas</a>
                <a href="index.php?filter=2" class="btn btn-outline-success col-sm">2 Estrelas</a>
                <a href="index.php?filter=1" class="btn btn-outline-success col-sm">1 Estrela</a>
                <a href="index.php?filter=0" class="btn btn-outline-success col-sm">0 Estrelas</a>
            </div>
        </div>

        
        <div class="container">
            <div class="grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?php echo $row["image_link"]; ?>" class="card-img-top" alt="<?php echo $row["title"]; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                            <div class="rating">
                                <?php for ($i = 0; $i < $row["assessment"]; $i++): ?>
                                    <span>⭐️</span>
                                <?php endfor; ?>
                            </div>
                            <div class="mt-auto">
                                <button data-bs-toggle="modal" data-bs-target="#editarModal" 
                                        data-id="<?= $row["game_id"]; ?>" 
                                        data-imagem="<?= $row["image_link"]; ?>" 
                                        data-titulo="<?= $row["title"]; ?>" 
                                        data-descricao="<?= $row["description"]; ?>" 
                                        data-avaliacao="<?= $row["assessment"]; ?>" 
                                        class="btn btn-outline-primary w-100 mt-2">
                                    <i class="fas fa-edit me-2"></i>Editar
                                </button>
                                <button data-bs-toggle="modal" data-bs-target="#infoModal" 
                                        data-id="<?= $row["game_id"]; ?>" 
                                        data-descricao="<?= $row["description"]; ?>" 
                                        data-titulo="<?= $row["title"]; ?>" 
                                        data-avaliacao="<?= $row["assessment"]; ?>" 
                                        data-imagem="<?= $row["image_link"]; ?>" 
                                        class="btn btn-outline-success w-100 mt-2">
                                    <i class="fas fa-info-circle me-2"></i>Informações
                                </button>
                                <a href="index.php?remove=<?= $row["game_id"]; ?>" class="btn btn-outline-danger w-100 mt-2">
                                    <i class="fas fa-trash me-2"></i>Remover
                                </a>
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
                                <option value="0">Zero ⭐️</option>
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

    <!-- Modal Editar (para alterar dados do jogo) -->
    <div class="modal fade" id="editarModal" tabindex="-1" aria-labelledby="editarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-edit me-2"></i>Editar jogo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <!-- Campo oculto para o ID do jogo -->
                        <input type="hidden" name="id_editar" id="id_editar">
                        <div class="mb-3">
                            <label for="imagem_editar" class="form-label">Link da imagem</label>
                            <input type="text" class="form-control" required name="imagem_editar" id="imagem_editar">
                        </div>
                        <div class="mb-3">
                            <label for="titulo_editar" class="form-label">Título do jogo</label>
                            <input type="text" class="form-control" required name="titulo_editar" id="titulo_editar">
                        </div>
                        <div class="mb-3">
                            <label for="descricao_editar" class="form-label">Descrição do jogo</label>
                            <textarea class="form-control" required name="descricao_editar" id="descricao_editar" rows="4"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="avaliacao_editar" class="form-label">Avaliação</label>
                            <select class="form-select" name="avaliacao_editar" id="avaliacao_editar">
                                <option selected disabled>Selecione sua avaliação</option>
                                <option value="0">Zero ⭐️</option>
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
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Salvar alterações
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Informações (mantém o modal de informação se necessário) -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content info-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="titulo-modal-info"></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="image-section">
                        <img src="" id="edit-imagem-info" alt="Game Image">
                    </div>
                    <div class="content-section">
                        <h3 id="titulo-modal-body-info"></h3>
                        <p id="edit-descricao-info"></p>
                        <div class="rating-section">
                            <h4 id="avaliacao-info"></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap e JS para preenchimento dos modais -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Modal Editar: preenche os campos do formulário com os dados do jogo
        document.addEventListener('DOMContentLoaded', function() {
            const editarModal = document.getElementById('editarModal');
            if (editarModal) {
                editarModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const id = button.getAttribute('data-id');
                    const imagem = button.getAttribute('data-imagem');
                    const titulo = button.getAttribute('data-titulo');
                    const descricao = button.getAttribute('data-descricao');
                    const avaliacao = button.getAttribute('data-avaliacao');

                    document.getElementById('id_editar').value = id;
                    document.getElementById('imagem_editar').value = imagem;
                    document.getElementById('titulo_editar').value = titulo;
                    document.getElementById('descricao_editar').value = descricao;
                    document.getElementById('avaliacao_editar').value = avaliacao;
                });
            }

            // Modal Informações: preenche os dados para exibição
            const infoModal = document.getElementById('infoModal');
            if (infoModal) {
                infoModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const descricao = button.getAttribute('data-descricao');
                    const titulo = button.getAttribute('data-titulo');
                    const avaliacao = button.getAttribute('data-avaliacao');
                    const imagem = button.getAttribute('data-imagem');
                    
                    document.getElementById('edit-descricao-info').innerText = descricao;
                    document.getElementById('titulo-modal-info').innerText = titulo;
                    document.getElementById('titulo-modal-body-info').innerText = titulo;
                    document.getElementById('edit-imagem-info').src = imagem;

                    let stars = '';
                    for (let i = 0; i < avaliacao; i++) {
                        stars += '⭐️';
                    }
                    document.getElementById('avaliacao-info').innerText = stars;
                });
            }
        });
    </script>
</body>
</html>
<?php
$conn->close();
?>
