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

            <h2>LOGIN</h2>

            <?php if (isset($_GET['error'])) { ?>

                <p class="error"><?php echo $_GET['error']; ?></p>

            <?php } ?>
            <label>User Name</label>

            <input type="text" id="email" name="email" placeholder="Email"><br>

            <label>Password</label>

            <input type="password" id="mdp" name="mdp" placeholder="Mot De Passe"><br>

            <button type="submit" name="login" value="Login">Login</button>
            <?= $_SESSION['errorMessage']?>
        </form>
        <?php
        (new ModelePage('Login', ob_get_clean(), 'login'))->show();
    }
}
