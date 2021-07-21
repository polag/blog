<?php
include_once __DIR__ . '/includes/header.php';
include_once __DIR__ . '/includes/FormHandle.php';
include_once __DIR__ . '/includes/Books.php';

$libri = \DataHandle\Books::selectBook();

if (count($libri) > 0) :
?>
?>
<div class="post-container">
        <h1>LIBRI</h1>
        <div class="row">
            <?php foreach ($libri as $libro) : ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                 
                            <div class="card libro-card">
                            <?php if ($libro['copertina'] != null) :  ?>
                                <img class="preview-img" src="<?php echo $libro['copertina'] ?>" alt="libro">
                                <?php endif;?>
                                <div class="card-body">
                                    <!-- <h2 class="libro-title"><?php echo $libro['t'] ?></h2>
                                    <h3 class="libro-author">By <?php echo $libro['username'] ?></h3>
                                    <p class="libro-summary"><?php echo $libro['summary'] ?></p> -->
                                </div>
                            </div>
                            </a>
                </div>

            <?php endforeach; ?>
        </div>
    </div>
<?php else : ?>

    <p> Non ci sono libri. Vuoi <a href="/biblioteca/insert-book.php">inserire uno?</a></p>


<?php endif; ?>
</main>

</body>

</html>