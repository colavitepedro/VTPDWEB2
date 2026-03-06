<?php
declare(strict_types=1);

$animalSelecionado = "";

if (isset($_GET["animal"])) {
    $animalSelecionado = (string) $_GET["animal"];
}

$estiloRaposa = "";
$estiloGato = "";
$estiloGolfinho = "";
$estiloTartaruga = "";

if ($animalSelecionado === "raposa") {
    $estiloRaposa = "border: 3px solid #ea580c;";
}

if ($animalSelecionado === "gato") {
    $estiloGato = "border: 3px solid #7c3aed;";
}

if ($animalSelecionado === "golfinho") {
    $estiloGolfinho = "border: 3px solid #0891b2;";
}

if ($animalSelecionado === "tartaruga") {
    $estiloTartaruga = "border: 3px solid #16a34a;";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Animais</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      background: #ffffff;
      color: #000000;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 16px;
      line-height: 1.5;
    }

    main {
      max-width: 980px;
      margin: 40px auto;
      padding: 0 16px;
    }

    h1,
    h2 {
      margin: 0 0 12px;
    }

    p {
      margin: 0 0 16px;
    }

    .galeria {
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
      margin-bottom: 24px;
    }

    .animal {
      width: 220px;
      padding: 8px;
      border: 1px solid #999999;
      color: #000000;
      text-decoration: none;
    }

    .animal img {
      display: block;
      width: 100%;
      height: 140px;
      object-fit: cover;
      margin-bottom: 8px;
      border: 1px solid #999999;
    }

    a {
      color: #0000ee;
    }
  </style>
</head>
<body>
  <main>
    <h1>Animais</h1>
    <p>Clique em uma imagem para ver as informações do animal na mesma página.</p>

    <div class="galeria">
      <a class="animal" style="<?= htmlspecialchars($estiloRaposa, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" href="?animal=raposa">
        <img src="raposa.jpg" alt="Raposa-vermelha">
        Raposa-vermelha
      </a>

      <a class="animal" style="<?= htmlspecialchars($estiloGato, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" href="?animal=gato">
        <img src="gato.jpg" alt="Gato doméstico">
        Gato doméstico
      </a>

      <a class="animal" style="<?= htmlspecialchars($estiloGolfinho, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" href="?animal=golfinho">
        <img src="golfinho.jpg" alt="Golfinho-nariz-de-garrafa">
        Golfinho-nariz-de-garrafa
      </a>

      <a class="animal" style="<?= htmlspecialchars($estiloTartaruga, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8") ?>" href="?animal=tartaruga">
        <img src="tartaruga.jpg" alt="Tartaruga-marinha">
        Tartaruga-marinha
      </a>
    </div>

    <?php if ($animalSelecionado === "raposa"): ?>
      <h2>Você clicou em: Raposa-vermelha</h2>
      <p><a href="index.php">Limpar tudo</a></p>
      <p>A raposa-vermelha é conhecida pela inteligência e pela capacidade de se adaptar a ambientes muito diferentes, de florestas frias a regiões próximas de cidades. Sua audição é tão precisa que ela consegue localizar pequenos animais mesmo sob folhas ou neve.</p>
      <p>Esse mamífero costuma ser mais ativo ao amanhecer e ao entardecer. A cauda longa ajuda no equilíbrio durante corridas e saltos, além de servir como proteção extra contra o frio em períodos de descanso.</p>
    <?php endif; ?>

    <?php if ($animalSelecionado === "gato"): ?>
      <h2>Você clicou em: Gato doméstico</h2>
      <p><a href="index.php">Limpar tudo</a></p>
      <p>O gato doméstico convive com seres humanos há milhares de anos e é conhecido pela combinação de curiosidade, agilidade e independência. Mesmo em ambientes internos, costuma explorar cantos altos, observar movimentos e reagir rapidamente a sons discretos.</p>
      <p>Apesar do comportamento reservado em alguns momentos, muitos gatos desenvolvem rotinas sociais bem definidas com seus tutores. Eles se comunicam por miados, postura corporal e movimentos da cauda, além de passarem bastante tempo em higiene e descanso.</p>
    <?php endif; ?>

    <?php if ($animalSelecionado === "golfinho"): ?>
      <h2>Você clicou em: Golfinho-nariz-de-garrafa</h2>
      <p><a href="index.php">Limpar tudo</a></p>
      <p>O golfinho-nariz-de-garrafa é um dos cetáceos mais estudados do mundo. Ele vive em grupos, se comunica por assobios e cliques e usa ecolocalização para identificar obstáculos, cardumes e até variações no relevo do fundo do mar.</p>
      <p>Esses animais demonstram comportamento social complexo e costumam cooperar na busca por alimento. Em várias regiões costeiras, o golfinho é visto como indicador da boa qualidade do ambiente marinho, embora ainda sofra com poluição e pesca irregular.</p>
    <?php endif; ?>

    <?php if ($animalSelecionado === "tartaruga"): ?>
      <h2>Você clicou em: Tartaruga-marinha</h2>
      <p><a href="index.php">Limpar tudo</a></p>
      <p>As tartarugas-marinhas passam grande parte da vida no oceano, mas as fêmeas retornam a praias específicas para colocar ovos. Esse ciclo exige uma orientação impressionante, guiada por pistas naturais como correntes, campos magnéticos e luminosidade.</p>
      <p>Quando jovens, elas enfrentam muitos riscos, desde predadores naturais até lixo plástico no mar. Programas de conservação se concentram em proteger ninhos, reduzir captura acidental e restaurar áreas costeiras importantes para a espécie.</p>
    <?php endif; ?>
  </main>
</body>
</html>
