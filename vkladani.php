<?php
require_once 'Db_Connect.php';

$db = Database::getInstance();
$conn = $db->getConnection();

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cesky_nazev = $db->escape($_POST['cesky_nazev']);
    $anglicky_nazev = $db->escape($_POST['anglicky_nazev']);
    $rok = $db->escape($_POST['rok']);
    $reziser = $db->escape($_POST['reziser']);
    $herci = $db->escape($_POST['herci']);
    $popis = $db->escape($_POST['popis']);

    $sql = "INSERT INTO filmy (cesky_nazev, anglicky_nazev, rok, reziser, herci, popis) 
            VALUES ('$cesky_nazev', '$anglicky_nazev', '$rok', '$reziser', '$herci', '$popis')";

    if ($conn->query($sql) === TRUE) {
        $message = "Film byl úspěšně přidán.";
    } else {
        $message = "Chyba při přidávání filmu: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vkládání nových filmů</title>
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
                    <li class="nav-item"><a class="nav-link" href="vyhledavani.php">Vyhledávání</a></li>
                    <li class="nav-item"><a class="nav-link active" href="vkladani.php">Vkládání</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h1 class="mb-4">Vkládání nových filmů</h1>
        
        <?php if ($message): ?>
            <div class="alert alert-info" role="alert">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="post">
                    <div class="mb-3">
                        <label for="cesky_nazev" class="form-label">Český název</label>
                        <input type="text" class="form-control" id="cesky_nazev" name="cesky_nazev" required>
                    </div>
                    <div class="mb-3">
                        <label for="anglicky_nazev" class="form-label">Anglický název</label>
                        <input type="text" class="form-control" id="anglicky_nazev" name="anglicky_nazev" required>
                    </div>
                    <div class="mb-3">
                        <label for="rok" class="form-label">Rok uvedení</label>
                        <input type="number" class="form-control" id="rok" name="rok" required>
                    </div>
                    <div class="mb-3">
                        <label for="reziser" class="form-label">Režisér</label>
                        <input type="text" class="form-control" id="reziser" name="reziser" required>
                    </div>
                    <div class="mb-3">
                        <label for="herci" class="form-label">Herci (oddělte čárkou)</label>
                        <textarea class="form-control" id="herci" name="herci" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="popis" class="form-label">Popis</label>
                        <textarea class="form-control" id="popis" name="popis" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Přidat film</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
