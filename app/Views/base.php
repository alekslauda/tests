<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en-US">

<head profile="http://www.w3.org/2005/10/profile">
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="http://example.com/myicon.png">
  <link href="<?= ASSETS_ROOT ?>/css/bootstrap.min.css" rel="stylesheet">
  <link href="<?= ASSETS_ROOT ?>/css/app.css" rel="stylesheet">
  <script src="<?= ASSETS_ROOT ?>/js/vue/vue.js"></script>
  <script src="<?= ASSETS_ROOT ?>/js/app.js" type="module"></script>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="<?= HOME ?>">Tests</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="<?= SOLUTION_1 ?>">Solution 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?= SOLUTION_2 ?>">Solution 2</a>
        </li>
      </ul>
    </div>
  </nav>
  <main>
    <div class="container">
      <?php echo $this->renderTemplate($this->view->template); ?>
      <hr>
      <footer>

      </footer>
    </div>
  </main>
</body>

</html>
