<?php
include_once __DIR__ . '/includes/globals.php';
include_once __DIR__ . '/includes/Comment.php';
$id=$_GET['id'];
$comment = $_GET['comment'];
$post = \DataHandle\Posts::selectPost($id);
$comments=array();
$comments = \DataHandle\Comment::selectComments($id);
$quantity = \DataHandle\Comment::countComments($id)['quantity'];

?>

<div class="post-container">

    <div>
        
    <h2 class="post-title"><?php echo $post['title']?></h2>
    
    <img class="post-img" src="<?php echo $post['image']?>" alt="post">
    <p class="post-content"><?php echo $post['content']?></p>
    <h4 class="post-author">Author: <?php echo $post['username']?></h4>
    <p class="post-date">Created on: <?php echo $post['created_at']?></p>

    

    </div>
    <div class="comment-container">
    <?php if($comment): ?>
        <h2>Leave a comment:</h2>
            <form action="./includes/create-comment.php?id=<?php echo $id;?>" method="POST">
                <input type="text" name="comment" id="comment">
                <input type="submit" class="btn btn-dark" value="Comment">
            </form>
        <?php endif; ?>
            <?php if(count($comments)>0): ?>
                <h3 class="comment-quantity">This post has <?php echo $quantity?> comments.</h3>
                <?php foreach($comments as $comment): ?>
                    
                <h3 class="comment-author"><?php echo $comment['username']?></h3>
                <img class="user-img" src="<?php echo $comment['image']?>" alt="user">
                <p class="comment-content"><?php echo $comment['content']?></p>
                <?php  endforeach; ?>
                <?php  endif ?>
        
    
    </div>
    

</div> 
</main>

</body>

</html> 