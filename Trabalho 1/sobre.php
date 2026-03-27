<?php
declare(strict_types=1);

require_once __DIR__ . '/includes/bootstrap.php';

$trackingMessage = register_page_view_with_feedback('sobre');
$pageTitle = 'Sobre | Trabalho 1';
$activePage = 'sobre';

require __DIR__ . '/includes/header.php';
?>
<section class="page-intro page-panel page-panel--green">
  <p class="eyebrow">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Sapiente, eius sequi illo, quis inventore omnis quod placeat eum dolores architecto amet deserunt voluptatibus enim earum non maiores pariatur vero consequatur.</p>
  <h1 class="section-title">Lorem</h1>
  <p class="section-lead">
    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Excepturi in nulla a minima odio aspernatur laudantium quasi earum doloremque veritatis voluptates aut nobis reprehenderit molestias asperiores velit consectetur, autem fugit!
  </p>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>
