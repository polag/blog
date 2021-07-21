<?php
require __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/util.php';

?>
<div class="row access">

    <div class="col-6 ">
        <h1>Log In</h1>
        <?php

        if (isset($_GET['statologin'])) {
            \DataHandle\Utils\show_alert('login', $_GET['statologin']);
        }
        ?>
        <form action="./includes/login.php" method="POST" class="container">
            <div class="col">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" required>
            </div>
            <div class="col">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <input type="submit" value="Login" class="btn btn-dark">

        </form>

    </div>
    <div class="col-6">
        <h1>Sign Up</h1>
        <?php
        if (isset($_GET['statoreg'])) {
            \DataHandle\Utils\show_alert('registration', $_GET['statoreg']);
        }
        ?>
        <form action="./includes/registration.php" method="POST" class="container">
            <div class="row">
                <div class="col">
                    <label for="firstname" class="form-label">Nome</label>
                    <input type="text" name="firstname" id="firstname" class="form-control" required>
                </div>
                <div class="col">
                    <label for="lastname" class="form-label">Cognome</label>
                    <input type="text" name="lastname" id="lastname" class="form-control" required>

                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Telefono</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                </div>
            </div>
            <div class="col">
                <label for="email" class="form-label">E-mail</label>
                <input type="text" name="email" id="email" class="form-control" required>

            </div>
            <div class="row">
            <div class="col">
                <label for="codice" class="form-label">Codice Fiscale</label>
                <input type="text" name="codice" id="codice" class="form-control" required>

            </div>
            </div>   
            <div class="row">
                <div class="col">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col">
                    <label for="password-check" class="form-label">Repeat Password</label>
                    <input type="password" name="password-check" id="password-check" class="form-control" required>
                </div>
            </div>

            <input type="submit" value="Sign Up" class="btn btn-dark">

        </form>

    </div>


</div>

</main>
</body>

</html>