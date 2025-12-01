<?php
require_once 'config.php';
require_once 'includes/header.php';

// Fetch blog posts from database
try {
    $stmt = $pdo->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
    $blogPosts = $stmt->fetchAll();
} catch (PDOException $e) {
    $blogPosts = [];
    $error = "Error fetching blog posts: " . $e->getMessage();
}
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>BLOGS</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <ul class="timeline-v1">
        <?php if (!empty($blogPosts)): ?>
            <?php foreach ($blogPosts as $index => $post): ?>
                <li<?php echo ($index % 2 == 1) ? ' class="timeline-inverted"' : ''; ?>>
                    <div class="cbp_tmtime">
                        <span><?php echo date('d/m', strtotime($post['created_at'])); ?></span>
                        <span><?php echo date('Y', strtotime($post['created_at'])); ?></span>
                    </div>
                    <div class="cbp_tmicon animated bounceIn">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <div class="cbp_tmlabel">
                        <div class="timeline-v1-content">
                            <?php if (!empty($post['image'])): ?>
                                <img class="img-responsive" src="assets/img/blogs/<?php echo htmlspecialchars($post['image']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>">
                            <?php endif; ?>
                            <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                            <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                            <div class="timeline-v1-meta">
                                <span>By: <?php echo htmlspecialchars($post['author']); ?></span>
                                <span><?php echo date('F j, Y', strtotime($post['created_at'])); ?></span>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>
                <div class="cbp_tmlabel">
                    <div class="timeline-v1-content">
                        <h3>No Blog Posts Available</h3>
                        <p>Check back later for new blog posts and updates.</p>
                    </div>
                </div>
            </li>
        <?php endif; ?>
    </ul>
</div>

<?php require_once 'includes/footer.php'; ?>
