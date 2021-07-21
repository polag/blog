<?php

include_once __DIR__ . '/includes/globals.php';


if (isset($_GET['stato'])) {
    \DataHandle\Utils\show_alert('updated', $_GET['stato']);

}  
$userId = $_SESSION['userId'];
$id = $_GET['id'];
$post = \DataHandle\Posts::selectPost($id, $userId);
?>
<div class="post-create">
    <h2>Edit post</h2>
    <form action="/biblioteca/includes/manage-post.php?id=<?php echo $id;?>&update=1" method="POST" >
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $post['title'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="summary" class="form-label">Summary</label>
            <input type="text" name="summary" class="form-control" value="<?php echo $post['summary'];?>"  autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Content</label>
            <textarea  type="textarea" name="content" class="form-control"  autocomplete="off" required><?php echo $post['content'];?></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" name="image" value="<?php echo $post['image'];?>" class="form-control" autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="publish" class="form-label">Publish</label>
            <input type="checkbox" name="publish" <?php if ($post['published'] == 1): echo 'checked'; endif;?>>
        </div>
        
        <input type="submit" value="Update post" class="btn btn-dark">



    </form>


</div>
</main>
</body>