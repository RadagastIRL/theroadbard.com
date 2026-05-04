  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="<?php echo htmlspecialchars($pageDescription ?? 'Behind-the-scenes writing from the Roadbard project.'); ?>">
  <meta name="author" content="Radagast">

  <!-- Open Graph -->
  <meta property="og:type" content="<?php echo htmlspecialchars($pageType ?? 'article'); ?>">
  <meta property="og:url" content="<?php echo htmlspecialchars($pageUrl ?? 'https://theroadbard.com/blog/'); ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($pageTitle ?? 'Roadbard — The Long Path'); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($pageDescription ?? 'Behind-the-scenes writing from the Roadbard project.'); ?>">

  <title><?php echo htmlspecialchars($pageTitle ?? 'Roadbard — The Long Path'); ?></title>

  <!-- Apply stored theme before first paint to prevent flash -->
  <script>(function(){try{var t=localStorage.getItem('roadbard-theme');if(t==='dark'||t==='light')document.documentElement.setAttribute('data-theme',t);}catch(e){}}());</script>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=IM+Fell+English:ital@0;1&display=swap" rel="stylesheet">

  <!-- Design tokens (dark + light) then page styles -->
  <link rel="stylesheet" href="/shared/tokens.css">
  <link rel="stylesheet" href="/blog/style.css">

  <!-- Theme management -->
  <script src="/shared/theme.js" defer></script>
