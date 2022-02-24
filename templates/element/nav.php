<nav class="navbar navbar-expand-lg  navbar-light" style="background-color: #666666;">
    <div class="container-fluid">
        <a href="#" class="navbar-brand d-none d-xl-block d-xxl-none d-lg-block">
          <?php echo $this->Html->image('icon.PNG', ['alt' => 'Microblog', 'width' => '40px']); ?>
        </a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <?= $this->Form->create($search, ['type' => 'get', 'url' => ['controller' => 'Users', 'action' => 'search'], 'novalidate' => true]); ?>
            <div class="input-group">
              <?= $this->Form->control('search', ['class' => 'form-control',
                'placeholder' => 'Search',
                'id' => 'search',
                'label' => false,
                'required' => false,
                'maxlength' => false,
               ]) ?>
              <?= $this->Form->button(__(''), ['class' => 'form-control btn btn-secondary bi-search', 'label' => false]) ?>
            </div>
        <?= $this->Form->end()?>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <div class="navbar-nav">
                <?= $this->Html->link(
                    'Home',
                    ['controller' => 'Posts', 'action' => 'index'],
                    ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']
                ); ?>
                <?=$this->Html->link(
                    'Profile',
                    ['controller' => 'Users', 'action' => 'profile', h($this->Identity->get('id'))],
                    ['class' => 'nav-item nav-link text-white']
                ); ?>
                <?= $this->Html->link(
                    'Notification',
                    ['controller' => 'Notifications', 'action' => 'index'],
                    ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']
                ); ?>
                <?php if ($header['notification']) : ?>
                  <span style="color:red;padding:0px;"><?= h($header['notification'])?></span>
                <?php endif; ?>
                <?php if (!empty($this->Identity->get('id'))) : ?>
                      <?= $this->Html->link(
                          'Logout',
                          ['controller' => 'Users', 'action' => 'logout'],
                          ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']
                      ); ?>
                <?php else : ?>
                            <?= $this->Html->link(
                                'Login',
                                ['controller' => 'Users', 'action' => 'login'],
                                ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']
                            ); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script type="text/javascript">
    $(document).ready(function($){
    $('#search').autocomplete({
        source: '/users/search'
          });
      });
    </script>
