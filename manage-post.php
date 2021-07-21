<?php
include_once __DIR__ . '/includes/globals.php';

$userId = $_SESSION['userId'];
$id = null;

$posts = \DataHandle\Posts::selectPost($id, $userId);


if (isset($_GET['stato'])) {
    if (isset($_GET['delete'])) {
        \DataHandle\Utils\show_alert('Deleted', $_GET['stato']);
    } elseif (isset($_GET['update'])) {
        \DataHandle\Utils\show_alert('Updated', $_GET['stato']);
    }elseif (isset($_GET['publish'])) {
        if($_GET['publish']==1){
            \DataHandle\Utils\show_alert('Published', $_GET['stato']);
        }else{
            \DataHandle\Utils\show_alert('Unpublished', $_GET['stato']);
        }
        
    }   
}
?>

<div class="post-container">
<div class="row">
    <?php foreach ($posts as $post) : ?>
        <div class="col-lg-6 col-md-6 col-sm-12">
        <div class="card manage-post">
        <?php if ($post['image'] != null) :  ?>
            <img class="post-img-manage" src="<?php echo $post['image'] ?>" alt="post">
            <?php endif;?>
            <div class="card-body">
                <h2 class="post-title"><?php echo $post['title'] ?></h2>
                <p class="post-summary"><?php echo $post['summary'] ?></p>
                <p class="post-date">Created: <?php echo $post['created_at'] ?></p>
                <?php if ($post['updated_at']) : ?>
                    <p class="post-date">Updated: <?php echo $post['updated_at'] ?></p>
                <?php endif;
                if ($post['published_at']) : ?>
                    <p class="post-date">Published: <?php echo $post['published_at'] ?></p>
                <?php endif; ?>
                <a href="./update-post.php?update=1&id=<?php echo $post['id']; ?>" class="btn btn-dark">Update</a>
                <a href="./includes/manage-post.php?delete=1&id=<?php echo $post['id']; ?>" class="btn btn-dark">Delete</a>

                <?php if ($post['published']==1) : ?>
                    <a href="./includes/manage-post.php?publish=0&id=<?php echo $post['id'] ?>" class="btn btn-dark">Unpublish</a>
                <?php else : ?>
                    <a href="./includes/manage-post.php?publish=1&id=<?php echo $post['id'] ?>" class="btn btn-dark">Publish</a>
                <?php endif; ?>
                <a href="./post-view.php?id=<?php echo $post['id'] ?>&comment=0" class="btn btn-dark">View</a>
            </div>
        </div>
        </div>

    <?php endforeach; ?>
    </div>
    <?php if (count($posts) > 1) : ?>
        <a href="./includes/manage-post.php?delete=2" class="btn btn-dark">Delete all posts</a>
    <?php elseif (count($posts) == 0) : ?>
        <p> Non ci sono libri. Vuoi <a href="/biblioteca/insert-book.php">inserire uno?</a></p>


    <?php endif; ?>
</div>
</main>

</body>

</html>