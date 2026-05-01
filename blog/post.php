<?php
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($_GET['slug'] ?? ''));

if (empty($slug)) {
  header('Location: /blog/');
  exit;
}

// Find the post file matching this slug
$postsDir = __DIR__ . '/posts/';
$postFile = null;

foreach (glob($postsDir . '*.php') as $file) {
  $meta = [];
  include $file;
  if (($meta['slug'] ?? '') === $slug) {
    $postFile = $file;
    break;
  }
}

if (!$postFile || ($meta['status'] ?? '') !== 'published') {
  header('HTTP/1.0 404 Not Found');
  $pageTitle       = 'Not found — Roadbard';
  $pageDescription = 'This post could not be found.';
  $pageSlug        = '';
  include __DIR__ . '/includes/head.php';
  echo '<body><main class="blog-main"><p class="not-found">Post not found. <a href="/blog/">Return to the index.</a></p></main></body></html>';
  exit;
}

$pageTitle       = htmlspecialchars($meta['title']) . ' — Roadbard';
$pageDescription = $meta['description'] ?? '';
$pageSlug        = $slug;

// Capture post body: re-include and capture output after the metadata block
ob_start();
include $postFile;
$rawOutput = ob_get_clean();

// Strip the PHP-executed metadata (already in $meta); keep only HTML output
$postBody = trim($rawOutput);
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

    <article class="post">

      <a href="/blog/" class="back-link" aria-label="Back to post index">← All posts</a>

      <header class="post-header">
        <div class="awen" aria-hidden="true">
          <span></span><span></span><span></span>
        </div>
        <h1 class="post-title"><?php echo htmlspecialchars($meta['title']); ?></h1>
        <div class="rule-wrap" aria-hidden="true">
          <span class="rule-line"></span>
          <span class="rule-diamond"></span>
          <span class="rule-line"></span>
        </div>
        <p class="post-date"><?php echo date('j F Y', strtotime($meta['date'])); ?></p>
      </header>

      <div class="post-body">
        <?php echo $postBody; ?>
      </div>

      <footer class="post-footer">
        <div class="rule-wrap" aria-hidden="true">
          <span class="rule-line"></span>
          <span class="rule-diamond"></span>
          <span class="rule-line"></span>
        </div>
        <p class="post-signoff">— Radagast, a wandering druid on two wheels.</p>
        <a href="/blog/" class="back-link">← All posts</a>
      </footer>

    </article>

  </main>

<?php include __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
