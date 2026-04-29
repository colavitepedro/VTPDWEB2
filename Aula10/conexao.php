<?php
$conf = parse_ini_file("config.ini");

$string_connection = $conf["driver"] .
    ":dbname=" . $conf["database"] .
    ";host=" . $conf["server"] .
    ";port=" . $conf["port"] .
    ";charset=utf8mb4";

try {
    $conn = new PDO(
        $string_connection,
        $conf["user"],
        $conf["password"]
    );

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    if ($conf["debug"] == "true") {
        echo "<h2>Sucesso!</h2>";
        echo "<p>Conectado ao banco <b>" . $conf["database"] . "</b></p>";
    }
} catch (Exception $e) {
    echo "<p>Erro ao se conectar no banco de dados.</p>";
    echo "<p>" . $e->getMessage() . "</p>";
    exit;
}
?>
