<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5" style="max-width:600px;">
  <a href="<?= site_url('dashboard') ?>" class="btn btn-sm btn-link mb-3"><i class="fa-solid fa-arrow-left me-1"></i>Retour</a>

  <div class="card mb-4">
    <div class="card-body">
      <h5><i class="fa-solid fa-arrow-up text-warning me-2"></i>Retrait</h5>
      <p class="text-muted mb-3">Solde : <?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</p>
      <form method="post" action="<?= site_url('retrait') ?>">
        <?= csrf_field() ?>
        <input type="number" name="montant" class="form-control mb-3" placeholder="Montant en Ar" min="1" required>
        <button class="btn btn-warning w-100"><i class="fa-solid fa-check me-1"></i>Confirmer le retrait</button>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header"><i class="fa-solid fa-list-ol me-1"></i>Barème des frais</div>
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