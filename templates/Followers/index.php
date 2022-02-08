<div class="row justify-content-md-center p-3" style="background-color:#999999;color:white;">
  <div class="col-md-12 card">

      <?php foreach ($following as $follow): ?>
        <?php foreach ($user as $followed_user): ?>
           <?php if ($follow->following_user == $followed_user->id): ?>
             <div class="row p-3" style="background-color:#999999;color:white;">
               <div class="col-md-6 mt-2">
                 <table>
                   <tr>
                     <td> <?= $this->Html->image("upload/".$followed_user->profile_path, ["alt" => "Microblog", 'width'=>'60px', 'url' => ['controller' => 'Users', 'action' => 'profile', $followed_user->id]])?> </td>
                     <td>
                       <?= $this->Html->link(
                       $followed_user->full_name,
                       ['controller' => 'Users', 'action' => 'profile', $followed_user->id],
                       ['style' => 'color:inherit;text-decoration:none;']); ?>
                     </td>
                   </tr>
                 </table>
                 <hr>
               </div>
             </div>
           <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
  </div>
</div>
<nav aria-label="pagination" class="float-end mt-3">
  <ul class="pagination">
    <?= $this->Paginator->prev("<<")?>
    <?= !$this->Paginator->numbers() ? '<li class="page-item"><a href="#" class="page-link">1</a></li>' : $this->Paginator->numbers() ?>
    <?= $this->Paginator->next(">>")?>
  </ul>
</nav>
