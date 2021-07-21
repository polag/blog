<?php

include_once __DIR__ . '/includes/globals.php';


if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert('Inserted', $_GET['stato']);

}  


?>
<div class="">
    <h2>Inserire un libro</h2>
    <form action="/biblioteca/includes/insert-book.php" method="POST" >
        <div class="mb-3">
            <label for="titolo" class="form-label">Titolo</label>
            <input type="text" name="titolo" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="ISBN" class="form-label">ISBN</label>
            <input type="text" name="ISBN" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="copertina" class="form-label">Copertina</label>
            <input  type="text" name="copertina" placeholder="https://" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="data_pubblicazione" class="form-label">Data di pubblicazione</label>
            <input type="date" name="data_pubblicazione"  class="form-control" autocomplete="off">
        </div>
        <div class="mb-3">
            <label for="genere" class="form-label">Genere</label>
            <input type="text" name="genere" class="form-control" >
        </div>
        <div class="mb-3">
            <label for="autore" class="form-label">Autore/i (separati con ,)</label>
            <input type="text" name="autore"  class="form-control" autocomplete="off">
        </div>
        
        <input type="submit" value="Inserire libro" class="btn btn-dark">
        
    </form>


</div>
</main>
</body>