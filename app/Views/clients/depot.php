<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5" style="max-width:600px;">
  <a href="<?= site_url('dashboard') ?>" class="btn btn-sm btn-link mb-3"><i class="fa-solid fa-arrow-left me-1"></i>Retour</a>

  <div class="card mb-4">
    <div class="card-body">
      <h5><i class="fa-solid fa-arrow-down text-primary me-2"></i>Faire un Dépôt</h5>
      <p class="text-muted mb-3">Solde actuel : <?= number_format($compte['solde'], 0, ',', ' ') ?> Ar</p>

      <form method="post" action="<?= site_url('depot') ?>">
        <?= csrf_field() ?>

        <div class="mb-3">
          <label class="form-label">Montant à déposer (Ar)</label>
          <input type="number" name="montant" class="form-control" placeholder="Montant en Ar" min="1" required>
        </div>

        <button class="btn btn-success w-100"><i class="fa-solid fa-check me-1"></i>Confirmer le dépôt</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>