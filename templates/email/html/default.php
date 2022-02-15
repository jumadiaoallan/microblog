<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Hi <?= $full_name?> !,
    <br>

    <p>Please click  <?=$this->Html->link('here',['controller' => 'Users', 'action' => 'verfication', h($token)])?> to activate your account </p>

    Thank you.

  </body>
</html>
