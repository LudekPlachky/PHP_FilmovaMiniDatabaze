<?php
require_once 'Db_Connect.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$filmy = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT * FROM filmy WHERE 1=1";
    $params = ['cesky_nazev', 'anglicky_nazev', 'rok', 'reziser', 'herci'];
    foreach ($params as $param) {
        if (!empty($_POST[$param])) {
            $value = $db->escape($_POST[$param]);
            $sql .= " AND $param LIKE '%$value%'";
        }
    }
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $filmy[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyhledávání filmů</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { background-color: #a199f7; }
        .navbar { background-color: #1c1a1c; }
        .card { background-color: #f7f5f7; border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">Filmová databáze</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Přehled</a></li>
                    <li class="nav-item"><a class="nav-link active" href="vyhledavani.php">Vyhledávání</a></li>
                    <li class="nav-item"><a class="nav-link" href="vkladani.php">Vkládání</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Vyhledávání filmů</h1>
        <form method="post" class="mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" id="cesky_nazev" name="cesky_nazev" placeholder="Český název">
                </div>
                <div class="col-md-6">
                    <input type="text" class="form-control" id="anglicky_nazev" name="anglicky_nazev" placeholder="Anglický název">
                </div>
                <div class="col-md-4">
                    <input type="number" class="form-control" id="rok" name="rok" placeholder="Rok">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="reziser" name="reziser" placeholder="Režisér">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" id="herci" name="herci" placeholder="Herci">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Vyhledat</button>
                </div>
            </div>
        </form>

        <?php if (!empty($filmy)): ?>
            <h2>Výsledky vyhledávání</h2>
            <div class="row">
                <?php foreach ($filmy as $film): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($film['cesky_nazev']) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($film['anglicky_nazev']) ?></h6>
                                <p class="card-text">
                                    <strong>Rok uvedení do kin:</strong> <?= htmlspecialchars($film['rok']) ?><br>
                                    <strong>Režisér:</strong> <?= htmlspecialchars($film['reziser']) ?><br>
                                    <strong>Herci:</strong> <?= htmlspecialchars($film['herci']) ?><br>
                                    <strong>Popis:</strong> <?= $short_desc = htmlspecialchars(substr($film['popis'], 0, 70));
                                                                $full_desc = htmlspecialchars($film['popis']);
                                                                echo "<span class='short-desc'>" . $short_desc . "...</span>";
                                                                echo "<span class='full-desc' style='display:none;'>" . $full_desc . "</span>";
                                                                echo "<a href='#' class='more-link'>více...</a>"; ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <script>
                document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.more-link').forEach(function(link) {
                link.addEventListener('click', function(e) {
                e.preventDefault();
                var shortDesc = this.previousElementSibling.previousElementSibling;
                var fullDesc = this.previousElementSibling;
            if (fullDesc.style.display === 'none') {
                fullDesc.style.display = 'inline';
                shortDesc.style.display = 'none';
                this.textContent = 'méně...';
            } else {
                fullDesc.style.display = 'none';
                shortDesc.style.display = 'inline';
                this.textContent = 'více...';
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
