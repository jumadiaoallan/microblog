<?= $this->Html->css('pagination');?>

<nav aria-label="pagination" class="float-end mt-3">
  <ul class="pagination">
    <?= $this->Paginator->prev('<<')?>
    <?= !$this->Paginator->numbers() ? '<li class="page-item"><a href="#" class="page-link">1</a></li>' : $this->Paginator->numbers() ?>
    <?= $this->Paginator->next('>>')?>
  </ul>
</nav>
