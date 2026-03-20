<?php
declare(strict_types=1);

$pageTitle = "FAQs";
$activePage = "faqs";

require __DIR__ . "/includes/header.php";
?>
      <section class="hero-panel">
        <h1>Perguntas frequentes</h1>
      </section>

      <section class="content-grid">
        <article class="text-card">
          <h2>Dúvidas comuns</h2>
          <div class="faq-item">
            <h3>Por que usar include ou require?</h3>
            <p>Para reaproveitar partes fixas da interface, como cabeçalho e rodapé, mantendo o código mais coeso e fácil de atualizar.</p>
          </div>

          <div class="faq-item">
            <h3>Qual é a diferença prática aqui?</h3>
            <p>Neste exercício, `require` garante que o layout principal sempre exista. Se um arquivo essencial faltar, a execução é interrompida.</p>
          </div>

          <div class="faq-item">
            <h3>Onde entram os arquivos de contato?</h3>
            <p>Cada envio do formulário gera um novo arquivo `.txt` dentro da pasta `contatos`, sem sobrescrever os anteriores.</p>
          </div>
        </article>

        <figure class="image-card">
          <img src="assets/faqs.svg" alt="Ilustração da página de perguntas frequentes">
        </figure>
      </section>
<?php require __DIR__ . "/includes/footer.php"; ?>
