<?php
ob_start();
phpinfo();
$html = ob_get_clean();

$backLink = '
<a href="../" class="back-link">Voltar</a>
<style>
  .back-link {
    position: fixed;
    left: 16px;
    bottom: 16px;
    z-index: 99999;
  }
</style>';

if (stripos($html, "<body>") !== false) {
    $html = preg_replace("/<body>/i", "<body>" . $backLink, $html, 1);
} else {
    $html = $backLink . $html;
}

echo $html;
