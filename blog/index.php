<?php
$pageTitle       = 'The Long Path — Roadbard';
$pageDescription = 'Behind-the-scenes writing from the Roadbard project.';
$pageSlug        = '';

// Read and sort published posts
$postsDir = __DIR__ . '/posts/';
$posts = [];

foreach (glob($postsDir . '*.php') as $file) {
  $meta = [];
  include $file;
  if (!empty($meta) && ($meta['status'] ?? '') === 'published') {
    $meta['_file'] = $file;
    $posts[] = $meta;
  }
}

usort($posts, fn($a, $b) => strcmp($b['date'], $a['date']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include __DIR__ . '/includes/head.php'; ?>
</head>

<body>

  <div class="grain" aria-hidden="true"></div>

<?php include __DIR__ . '/includes/header.php'; ?>

  <main class="blog-main">

    <div class="blog-index-header">
      <div class="awen" aria-hidden="true">
        <span></span><span></span><span></span>
      </div>
      <h1 class="index-title">The Long Path</h1>
      <div class="rule-wrap" aria-hidden="true">
        <span class="rule-line"></span>
        <span class="rule-diamond"></span>
        <span class="rule-line"></span>
      </div>
      <p class="index-subtitle">Behind-the-scenes writing from the project</p>
    </div>

    <?php if (empty($posts)): ?>
      <p class="no-posts">Nothing published yet. Check back soon.</p>
    <?php else: ?>
      <ol class="post-list" reversed>
        <?php foreach ($posts as $post): ?>
          <li class="post-item">
            <a href="/blog/post.php?slug=<?php echo htmlspecialchars($post['slug']); ?>" class="post-item-link">
              <span class="post-item-date"><?php echo htmlspecialchars(date('j F Y', strtotime($post['date']))); ?></span>
              <h2 class="post-item-title"><?php echo htmlspecialchars($post['title']); ?></h2>
              <?php if (!empty($post['description'])): ?>
                <p class="post-item-desc"><?php echo htmlspecialchars($post['description']); ?></p>
              <?php endif; ?>
            </a>
          </li>
        <?php endforeach; ?>
      </ol>
    <?php endif; ?>

  </main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
