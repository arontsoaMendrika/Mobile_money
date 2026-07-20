<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<nav class="navbar navbar-dark bg-primary mb-4">
  <div class="container">
    <span class="navbar-brand"><?= esc($numero) ?></span>
    <a href="<?= site_url('logout') ?>" class="btn btn-sm btn-light">Déconnexion</a>
  </div>
</nav>

<div class="container">
  <?php if (session('message')): ?>
    <div class="alert alert-success"><?= esc(session('message')) ?></div>
  <?php endif; ?>
  <?php if (session('error')): ?>
    <div class="alert alert-danger"><?= esc(session('error')) ?></div>
  <?php endif; ?>

  <div class="card mb-4 text-center">
    <div class="card-body">
      <div class="text-muted">Solde disponible</div>
      <h2 class="text-success"><?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</h2>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-md-4"><a href="<?= site_url('depot') ?>" class="btn btn-outline-primary w-100 py-3">Dépôt</a></div>
    <div class="col-md-4"><a href="<?= site_url('retrait') ?>" class="btn btn-outline-warning w-100 py-3">Retrait</a></div>
    <div class="col-md-4"><a href="<?= site_url('transfert') ?>" class="btn btn-outline-danger w-100 py-3">Transfert</a></div>
  </div>

  <div class="card">
    <div class="card-header">Historique</div>
    <table class="table table-sm mb-0">
      <thead><tr><th>Date</th><th>Type</th><th>Montant</th><th>Frais</th><th>Contrepartie</th></tr></thead>
      <tbody>
      <?php foreach ($historique as $t): ?>
        <tr>
          <td><?= esc($t['date_creation']) ?></td>
          <td><span class="badge bg-secondary"><?= esc($t['type_operation']) ?></span></td>
          <td><?= number_format($t['montant'], 0, ',', ' ') ?> Ar</td>
          <td><?= number_format($t['frais'], 0, ',', ' ') ?> Ar</td>
          <td><?= esc($t['expediteur'] === $numero ? $t['destinataire'] : $t['expediteur']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>