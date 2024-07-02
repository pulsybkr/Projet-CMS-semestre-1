<h2 class="title-page">Mon compte</h2>

<form method="post" action="">
    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
    <button class="button button--danger button--sm" type="submit" name="delete_user">Se deconncter</button>
</form>