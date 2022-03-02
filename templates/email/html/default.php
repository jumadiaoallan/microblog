<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    Hi <?= $full_name?> !,
    <br>

    <p>Please click  <a href="http://mb.cakephp1.ynsdev.pw/users/verification/<?= h($token)?>">here</a> to activate your account </p>
    <p>Note that email verification link will expired in 1 hour.</p>
    <br>
    Thank you.

  </body>
</html>
