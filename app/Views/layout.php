<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $title ?? 'Mobile Money' ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <style>
    :root {
      --brand: #5b3df0;
      --brand-dark: #4429c9;
    }
    body {
      font-family: 'Poppins', sans-serif;
      background: #f4f5fb;
    }
    .navbar-brand {
      font-weight: 600;
    }
    .navbar-brand i { color: var(--brand); }
    .bg-brand { background: var(--brand) !important; }
    .btn-primary {
      background-color: var(--brand);
      border-color: var(--brand);
    }
    .btn-primary:hover, .btn-primary:focus {
      background-color: var(--brand-dark);
      border-color: var(--brand-dark);
    }
    .btn-outline-primary {
      color: var(--brand);
      border-color: var(--brand);
    }
    .btn-outline-primary:hover {
      background-color: var(--brand);
      border-color: var(--brand);
    }
    .text-primary { color: var(--brand) !important; }
    .card {
      border: none;
      border-radius: 14px;
      box-shadow: 0 2px 10px rgba(0,0,0,.06);
    }
    .btn { border-radius: 8px; font-weight: 500; }
    .nav-link.active, .nav-link:hover { color: var(--brand) !important; }
    .action-btn {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: .4rem;
      padding: 1.25rem .5rem;
    }
    .action-btn i { font-size: 1.4rem; }
    .alert i { margin-right: .5rem; }
  </style>
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-brand px-3 shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= session()->get('numero') ? site_url('dashboard') : site_url('/') ?>">
      <i class="fa-solid fa-wallet me-2"></i>Mobile Money
    </a>

    <?php if (session()->get('numero')) { ?>
      <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
        <a href="<?= site_url('dashboard') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a>
        <a href="<?= site_url('depot') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-arrow-down me-1"></i>Dépôt</a>
        <a href="<?= site_url('retrait') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-arrow-up me-1"></i>Retrait</a>
        <a href="<?= site_url('transfert') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-right-left me-1"></i>Transfert</a>
        <a href="<?= site_url('epargner') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-right-left me-1"></i>Epargner</a>
        <span class="text-white-50 small ms-1"><?= session()->get('numero') ?></span>
        <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-light"><i class="fa-solid fa-right-from-bracket me-1"></i>Déconnexion</a>
      </div>
    <?php } elseif (strpos(current_url(), '/admin') !== false) { ?>
      <div class="d-flex align-items-center gap-2 flex-wrap justify-content-end">
        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-gauge me-1"></i>Dashboard</a>
        <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-hashtag me-1"></i>Préfixes</a>
        <a href="<?= site_url('admin/baremes') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-list-ol me-1"></i>Barèmes</a>
        <a href="<?= site_url('admin/operateurs') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-building me-1"></i>Opérateurs</a>
        <a href="<?= site_url('admin/reversements') ?>" class="btn btn-sm btn-outline-light"><i class="fa-solid fa-money-bill-transfer me-1"></i>Reversements</a>
        <a href="<?= site_url('/') ?>" class="btn btn-sm btn-light"><i class="fa-solid fa-right-from-bracket me-1"></i>Quitter</a>
      </div>
    <?php } ?>
  </div>
</nav>

<div class="container py-4">
  <?php if (session()->getFlashdata('error') || session('error')) { ?>
    <div class="alert alert-danger"><i class="fa-solid fa-circle-exclamation"></i><?= session()->getFlashdata('error') ?? session('error') ?></div>
  <?php } ?>
  <?php if (session()->getFlashdata('success') || session()->getFlashdata('message') || session('message')) { ?>
    <div class="alert alert-success"><i class="fa-solid fa-circle-check"></i><?= session()->getFlashdata('success') ?? session()->getFlashdata('message') ?? session('message') ?></div>
  <?php } ?>
  <?= $this->renderSection('content') ?>
</div>
</body>
</html>
