<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <?= $this->Html->meta('img', 'img/icon.PNG', ['type' => 'icon']) ?>
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.js'); ?>
    <?= $this->Html->script('https://code.jquery.com/ui/1.13.1/jquery-ui.js'); ?>
    <title><?= $title ?></title>
  </head>
  <body  style="background-color: #7f7f7f;">
    <div class="container">
      <div class="row justify-content-md-center" style="margin-top:5%;">
        <div class="col-6 p-3">
          <?= $this->Flash->render(); ?>
          <?php if (!empty($this->Flash->render('not-verified'))) : ?>
            <div class="alert alert-info">
              Already expired email verification?, Click
              <?= $this->Html->link(
                  'here',
                  ['controller' => 'Users', 'action' => 'resend'],
                  ['style' => 'color:inherit;text-decoration:none;']
              ); ?>
              to resend.
            </div>
          <?php endif; ?>
        </div>
      </div>

      <?php echo $this->fetch('content') ?>
    </div>
  </body>
</html>
