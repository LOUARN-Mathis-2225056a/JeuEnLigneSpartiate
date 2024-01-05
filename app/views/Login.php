<?php

namespace app\views;

use app\models\ModelePage;

class Login
{
    public function show():void
    {
        ob_start();
        ?>
        <form method="post">

            <label class="title">LOGIN ADMIN</label>

            <?php if (isset($_GET['error'])) { ?>

                <p class="error"><?php echo $_GET['error']; ?></p>

            <?php } ?>

            <div>
                <label>E-mail</label>

                <input type="text" id="email" name="email" placeholder="E-mail">
            </div>

            <div>
                <label>Mot de passe</label>

                <input type="password" id="mdp" name="mdp" placeholder="Mot de passe">
            </div>


            <button type="submit" name="login" value="Login">Login</button>
            <?= $_SESSION['errorMessage']?>
        </form>
        <?php
        (new ModelePage('Login', ob_get_clean(), 'login'))->show();
    }
}