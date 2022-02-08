<nav class="navbar navbar-expand-lg  navbar-light" style="background-color: #666666;">
    <div class="container-fluid">
        <a href="#" class="navbar-brand"><?php echo $this->Html->image('icon.png', array('alt' => 'Microblog', 'width'=>'40px')); ?></a>
        <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <form class="d-flex">
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <button type="button" class="btn btn-secondary"><i class="bi-search"></i></button>
            </div>
        </form>
        <div class="collapse navbar-collapse justify-content-end" id="navbarCollapse">
            <div class="navbar-nav">
                <?= $this->Html->link(
                "Home",
                ['controller' => 'Posts', 'action' => 'index'],
                ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']); ?>
                <a href="http://localhost:8765/users/profile/<?= $this->Identity->get('id')?>" class="nav-item nav-link text-white">Profile</a>
                <a href="#" class="nav-item nav-link text-white">Notification</a>
                <?php if (!empty($this->Identity->get('id'))): ?>
                  <?= $this->Html->link(
                  "Logout",
                  ['controller' => 'Users', 'action' => 'logout'],
                  ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']); ?>
                  <?php else: ?>
                    <?= $this->Html->link(
                    "Login",
                    ['controller' => 'Users', 'action' => 'login'],
                    ['style' => 'color:inherit;text-decoration:none;', 'class' => 'nav-item nav-link text-white']); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
