<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title><?= $title ?? 'Mobile Money' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark px-3">
  <span class="navbar-brand">Mobile Money</span>
  <?php if (session()->get('numero')): ?>
    <span class="text-white">
      <?= session()->get('numero') ?>
      <a href="/logout" class="btn btn-sm btn-outline-light ms-2">Déconnexion</a>
    </span>
  <?php endif; ?>
</nav>
<div class="container py-4">
  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif; ?>
  <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
  <?php endif; ?>
  <?= $this->renderSection('content') ?>
</div>
</body>
</html>