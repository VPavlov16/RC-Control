<?php
require "nav.php";

$host = "localhost";
$port = "5432";
$dbname = "postgres";
$user = "postgres";
$password = "admin";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname;user=$user;password=$password";

try {
    $pdo = new PDO($dsn);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

$sql = "SELECT name, description, usedby, pic, vid FROM vehicles";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$plink = "";
?>
<!DOCTYPE html>
<html lang="bg" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicles</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/album/">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link rel="stylesheet" href="../CSS/bootstrap.css" >
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
            width: auto;
            height: auto;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            width: 100%;
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }
        .btn-bd-primary {
            --bd-violet-bg: #712cf9;
            --bd-violet-rgb: 112.520718, 44.062154, 249.437846;
            --bs-btn-font-weight: 600;
            --bs-btn-color: var(--bs-white);
            --bs-btn-bg: var(--bd-violet-bg);
            --bs-btn-border-color: var(--bd-violet-bg);
            --bs-btn-hover-color: var(--bs-white);
            --bs-btn-hover-bg: #6528e0;
            --bs-btn-hover-border-color: #6528e0;
            --bs-btn-focus-shadow-rgb: var(--bd-violet-rgb);
            --bs-btn-active-color: var(--bs-btn-hover-color);
            --bs-btn-active-bg: #5a23c8;
            --bs-btn-active-border-color: #5a23c8;
        }

        .bd-mode-toggle {
            z-index: 1500;
        }

        .bd-mode-toggle .dropdown-menu .active .bi {
            display: block !important;
        }
    </style>
</head>
<body>
<main>
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-6 col-md-8 mx-auto">
                <h1 class="fw-light">Албум с всички RC устройства.</h1>
                <p class="lead text-body-secondary">Тук можете да разгледате различните налични RC устройства и техните индивидуални възможности, характеристики и части на устройството.</p>
            </div>
        </div>
    </section>

    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php foreach ($vehicles as $vehicle): ?>
                    <div class="col">
                        <div class="card shadow-sm h-100 d-flex flex-column">
                            <img src="../images/<?php echo $vehicle['pic']; ?>" alt="<?php echo $vehicle['name']; ?>" class="bd-placeholder-img card-img-top" width="100%" height="225">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title"><?php echo $vehicle['name']; ?></h5>
                                <p class="card-text flex-grow-1"><?php echo $vehicle['description']; ?></p>
                                <?php if ($vehicle['usedby']): ?>
                                    <button class="btn btn-danger mt-2" disabled>Устройството е заето!</button>
                                <?php elseif (isset($_SESSION['user'])): ?>
                                    <a href="control.php?vid=<?php echo $vehicle['vid']; ?>" class="btn btn-success mt-2" onclick="return confirm('Сигурни ли сте, че искате да използвате това устройство?')">Играй!</a>
                                <?php else: ?>
                                    <a href="register.php" class="btn btn-success mt-2" onclick="return confirm('За да играете трябва да имате регистрация!')">Играй!</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>
</body>
</html>