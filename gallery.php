<?php
require_once 'config.php';
require_once 'includes/header.php';

// Fetch gallery images from database
try {
    $stmt = $pdo->query("SELECT * FROM gallery_images ORDER BY created_at DESC");
    $galleryImages = $stmt->fetchAll();
} catch (PDOException $e) {
    $galleryImages = [];
    $error = "Error fetching gallery images: " . $e->getMessage();
}
?>

<!-- Image title -->
<div style="text-align: center; margin-top: 50px; margin-bottom: 40px;">
    <h2>GALLERY</h2>
</div>
<!-- End title  -->

<!--=== Content Part ===-->
<div class="container content">
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    
    <div class="row">
        <?php if (!empty($galleryImages)): ?>
            <?php foreach ($galleryImages as $image): ?>                <div class="col-md-4 col-sm-6 gallery-item">
                    <div class="gallery-image">
                        <img src="<?php echo htmlspecialchars($image['image_path']); ?>" 
                             alt="<?php echo htmlspecialchars($image['title']); ?>" 
                             class="img-responsive gallery-img"
                             data-toggle="modal" 
                             data-target="#imageModal"
                             data-image="<?php echo htmlspecialchars($image['image_path']); ?>"
                             data-title="<?php echo htmlspecialchars($image['title']); ?>"
                             data-description="<?php echo htmlspecialchars($image['description']); ?>">
                        <div class="gallery-overlay">
                            <div class="gallery-info">
                                <h4><?php echo htmlspecialchars($image['title']); ?></h4>
                                <p><?php echo htmlspecialchars($image['description']); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-md-12">
                <div class="alert alert-info text-center">
                    <h4>No Images Available</h4>
                    <p>Gallery images will be displayed here once they are added.</p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="imageModalLabel">Gallery Image</h4>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="" class="img-responsive" style="margin: 0 auto;">
                <div id="modalImageInfo" class="image-info">
                    <h4 id="modalImageTitle"></h4>
                    <p id="modalImageDescription"></p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.gallery-item {
    margin-bottom: 30px;
}

.gallery-image {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.gallery-image:hover {
    transform: scale(1.05);
}

.gallery-img {
    width: 100%;
    height: 250px;
    object-fit: cover;
    cursor: pointer;
}

.gallery-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-image:hover .gallery-overlay {
    opacity: 1;
}

.gallery-info {
    text-align: center;
    color: white;
    padding: 20px;
}

.gallery-info h4 {
    margin-bottom: 10px;
    color: white;
}

.image-info {
    margin-top: 20px;
    text-align: left;
}

#modalImage {
    max-width: 100%;
    max-height: 500px;
}
</style>

<script>
$(document).ready(function() {
    $('.gallery-img').on('click', function() {
        var imageSrc = $(this).data('image');
        var imageTitle = $(this).data('title');
        var imageDescription = $(this).data('description');
        
        $('#modalImage').attr('src', imageSrc).attr('alt', imageTitle);
        $('#modalImageTitle').text(imageTitle);
        $('#modalImageDescription').text(imageDescription);
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
