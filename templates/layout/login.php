<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css') ?>
    <title><?= $title ?></title>
  </head>
  <body  style="background-color: #7f7f7f;">
    <div class="container">
      <div class="row justify-content-md-center" style="margin-top:5%;">
        <div class="col-6 p-3">
          <?= $this->Flash->render(); ?>
        </div>
      </div>

      <?php echo $this->fetch('content') ?>
    </div>
  </body>
</html>