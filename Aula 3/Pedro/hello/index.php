<?php
date_default_timezone_set("America/Sao_Paulo");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hello World</title>
</head>
<body style="background-color: #dddddd;">
  <h1>My first PHP page</h1>
  <h1>Hello world!</h1>

  <p>Olá, meu nome é Pedro.</p>
  <p>
    Hoje é dia <strong><?= date("d/m/Y") ?></strong>
    e agora são <strong><?= date("H:i") ?></strong>
  </p>

  <hr>

  <p><a href="../">Voltar</a></p>
</body>
</html>
