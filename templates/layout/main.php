<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?= $this->Html->meta('csrfToken', $this->request->getAttribute('csrfToken')) ?>
<?= $this->Html->meta('img', 'img/icon.PNG', ['type' => 'icon']) ?>
<title><?= $header['title']?></title>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css') ?>
<?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css') ?>
<?= $this->Html->css('//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css') ?>
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js'); ?>
<?= $this->Html->script('https://code.jquery.com/jquery-3.6.0.js'); ?>
<?= $this->Html->script('https://code.jquery.com/ui/1.13.1/jquery-ui.js'); ?>
<?= $this->Html->css('style');?>
</head>
<body style="background-color: #7f7f7f;" id="comment_section">
<div class="m-4">
    <?= $this->element('nav') ?>
</div>

<div class="container">
    <?php echo $this->Flash->render();?>
    <?= $this->fetch('content') ?>
</div>



</body>
<?= $this->Html->script('custom.js?v=1.4');?>
<script type="text/javascript">
  var isLogged_in = "<?= h($this->Identity->get('id'))?>";
</script>
</html>
