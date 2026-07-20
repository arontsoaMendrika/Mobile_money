<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5" style="max-width:600px;">
  <a href="<?= site_url('dashboard') ?>" class="btn btn-sm btn-link mb-3">&larr; Retour</a>

  <?php if (session('error')) { ?>
    <div class="alert alert-danger"><?= session('error') ?></div>
  <?php } ?>

  <div class="card mb-4">
    <div class="card-body">
      <h5>Retrait</h5>
      <p class="text-muted mb-3">Solde : <?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</p>
      <form method="post" action="<?= site_url('retrait') ?>">
        <?= csrf_field() ?>
        <input type="number" name="montant" class="form-control mb-3" placeholder="Montant en Ar" min="1" required>
        <button class="btn btn-warning w-100">Confirmer le retrait</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">Barème des frais</div>
    <table class="table table-sm mb-0">
      <thead><tr><th>Tranche</th><th class="text-end">Frais</th></tr></thead>
      <tbody>
      <?php foreach ($baremes as $b) { ?>
        <tr>
          <td><?= number_format($b['montant_min'],0,',',' ') ?> &ndash;
              <?= $b['montant_max'] ? number_format($b['montant_max'],0,',',' ') : 'et plus' ?> Ar</td>
          <td class="text-end"><?= number_format($b['frais'],0,',',' ') ?> Ar</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>