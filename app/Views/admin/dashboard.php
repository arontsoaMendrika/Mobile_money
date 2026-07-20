<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<nav class="navbar navbar-dark bg-dark mb-4">
  <div class="container">
    <span class="navbar-brand">Espace Opérateur</span>
    <div>
      <a href="<?= site_url('admin/prefixes') ?>" class="btn btn-sm btn-outline-light">Préfixes</a>
      <a href="<?= site_url('admin/baremes') ?>" class="btn btn-sm btn-outline-light">Barèmes</a>
    </div>
  </div>
</nav>

<div class="container">
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card text-center"><div class="card-body">
        <div class="text-muted">Gain total (frais)</div>
        <h3 class="text-success"><?= number_format($gainTotal,0,',',' ') ?> Ar</h3>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card text-center"><div class="card-body">
        <div class="text-muted">Masse monétaire clients</div>
        <h3><?= number_format($masseTotale,0,',',' ') ?> Ar</h3>
      </div></div>
    </div>
    <div class="col-md-4">
      <div class="card text-center"><div class="card-body">
        <div class="text-muted">Nombre de comptes</div>
        <h3><?= count($comptes) ?></h3>
      </div></div>
    </div>
  </div>

  <div class="card mb-4">
    <div class="card-header">Gains par type d'opération</div>
    <table class="table mb-0">
      <thead><tr><th>Type</th><th>Nb opérations</th><th>Volume</th><th>Frais perçus</th></tr></thead>
      <tbody>
      <?php foreach ($gainParType as $g) { ?>
        <tr>
          <td class="text-capitalize"><?= $g['type_operation'] ?></td>
          <td><?= $g['nb'] ?></td>
          <td><?= number_format($g['total_montant'],0,',',' ') ?> Ar</td>
          <td class="text-success"><?= number_format($g['total_frais'],0,',',' ') ?> Ar</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>

  <div class="card">
    <div class="card-header">Situation des comptes clients</div>
    <table class="table table-striped mb-0">
      <thead><tr><th>#</th><th>Numéro</th><th class="text-end">Solde</th></tr></thead>
      <tbody>
      <?php foreach ($comptes as $c) { ?>
        <tr>
          <td><?= $c['id'] ?></td>
          <td><?= $c['numero_telephone'] ?></td>
          <td class="text-end"><?= number_format($c['solde'],0,',',' ') ?> Ar</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>