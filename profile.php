<?php
include_once __DIR__ . '/includes/globals.php';
include_once __DIR__.'/includes/User.php';

$user = \DataHandle\User::selectUser($_SESSION['userId']);



if(isset($_GET['edit'])):?>
    <div class="edit-profile">
    <h2>Aggiornare utente</h2>
    <form action="/biblioteca/includes/edit-profile.php?id=<?php echo $user['id'];?>" method="POST" >
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $user['username'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="firstname" class="form-label">Nome</label>
            <input type="text" name="firstname" class="form-control" value="<?php echo $user['nome'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Cognome</label>
            <input type="text" name="lastname" class="form-control" value="<?php echo $user['cognome'];?>"  autocomplete="off" required>        
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefono</label>
            <input type="text" name="phone" value="<?php echo  $user['telefono'];?>" class="form-control" autocomplete="off" >
        </div>
        <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
            <input type="text" name="email" value="<?php echo  $user['email'];?>" class="form-control" autocomplete="off" >
        </div>
       
        
        <input type="submit" value="Aggiorna" class="btn btn-dark">
        <a href="/biblioteca/profile.php" class="btn btn-dark">Torna</a>



    </form>

    <?php elseif(isset($_GET['password'])):?>
        <form action="/biblioteca/includes/manage-profile.php?password=1" method="POST" >
            <div class="mb-3">
                <label for="newPassword" class="form-label">Nuova Password</label>
                <input type="password" name="newPassword" class="form-control" autocomplete="off" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Vecchia Password</label>
                <input type="password" name="password" class="form-control"  autocomplete="off" required>
            </div>
            <input type="submit" value="Aggiorna password" class="btn btn-dark">
            <a href="/biblioteca/profile.php" class="btn btn-dark">Torna</a>
        </form>


<?php else: ?>
<div class="user-profile">
    <h1 class="username"><?php echo $user['username'];?></h1>  
    <p><?php echo $user['nome'].' '. $user['cognome'];?></p>  
    <p>Email: <?php echo $user['email'];?></p>
    <p>Phone: <?php echo $user['telefono'];?></p>
   
    <?php if(!isset($_GET['userId'])): ?>
    <a href="/biblioteca/profile.php?edit=1"><i class="far fa-edit"></i></a>
    <?php endif;?>
</div
<?php if(!isset($_GET['userId'])): ?>
<div class="user-buttons">
    <a href="/biblioteca/profile.php?password=1" class="btn btn-dark">Change Password</a>
    <a href="/biblioteca/includes/manage-profile.php?delete=1" class="btn btn-dark">Delete account</a>

</div>
<?php endif;?>
<?php endif; ?>

</body>
</html>