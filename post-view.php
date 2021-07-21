<?php
include_once __DIR__ . '/includes/globals.php';
include_once __DIR__ . '/includes/Comment.php';
$id = $_GET['id'];
$comment = $_GET['comment'];
$post = \DataHandle\Posts::selectPost($id);
$comments = array();
$comments = \DataHandle\Comment::selectComments($id);
$quantity = \DataHandle\Comment::countComments($id)['quantity'];
?>

<div class="post-container">

    <div class="post-box">

        <h2 class="post-title"><?php echo $post['title'] ?></h2>
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <p class="post-content"><?php echo $post['content'] ?></p>
            </div>
            <?php if ($post['image'] != null) :  ?>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <img class="post-img" src="<?php echo $post['image'] ?>" alt="post">
                </div>
            <?php endif; ?>

        </div>
        <p class="post-date">Created on: <?php echo date('d M Y', strtotime($post['created_at'])) ?></p>



        <div class="card author">
            <div class="row g-0">
                <div class="col-lg-4 col-md-8 col-sm-12">
                    <img class="user-img" src="<?php echo $post['avatar'] ?>" alt="avatar">
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card-body">
                        <h4 class="post-author">Author: <?php echo $post['username'] ?></h4>
                        <p class="card-text"><?php echo $post['bio']; ?></p>

                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="comment-container">
        <?php if ($comment) : ?>
            <h3>Leave a comment:</h3>
            <form action="./includes/create-comment.php?id=<?php echo $id; ?>" method="POST">
                <div class="input-group mb-3">
                    <input type="text" name="comment" class="form-control" placeholder="Comment" aria-label="comment" id="comment" aria-describedby="comment" required>
                    <input type="submit" class="btn btn-outline-secondary" id="comment" value="Comment">
                </div>

            </form>
        <?php endif; ?>
        <?php if (count($comments) > 0) : ?>
            <p class="comment-quantity">This post has <?php echo $quantity ?> comment<?php if (count($comments) > 1) : echo 's';
                                                                                        endif; ?>.</p>
            <?php foreach ($comments as $comment) : ?>

                <div class="row comments">
                    <div class="col-1">
                        <a href="/biblioteca/profile.php?userId=<?php echo $comment['user_id']; ?>" class="comment-author"><?php echo $comment['username']; ?></a>
                        <img class="comment-img" src="<?php echo $comment['image'] ?>" alt="user">
                    </div>
                    <div class="col-4">
                        <p class="comment-content"><?php echo $comment['content'] ?>
                        <?php if ($_SESSION['userId'] == $comment['user_id']) : ?>
                            <a href="/biblioteca/includes/delete-comment.php?id=<?php echo $comment['id']; ?>&postId=<?php echo $id; ?>"><i class="far fa-trash-alt"></i></a>
                        <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
</div>
</main>

</body>

</html>