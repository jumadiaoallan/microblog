<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
<title>Microblog</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</head>
<body style="background-color: #7f7f7f;" id="comment_section">
<div class="m-4">
    <?= $this->element('nav') ?>
</div>

<div class="container">
  <?php

      echo $this->Flash->render();

   ?>
    <?= $this->fetch('content') ?>
</div>



</body>
<?= $this->Html->script('custom');?>
</html>
