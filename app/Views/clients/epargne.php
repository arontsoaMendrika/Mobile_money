<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container" style="max-width:400px; margin-top:100px;">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h4 class="mb-4 text-center"><i class="fa-solid fa-wallet text-primary me-2"></i>Mobile Money</h4>
      <form method="post" action="<?= site_url('epargne') ?>">
        <?= csrf_field() ?>
        <label class="form-label">Pourcentage</label>
        <input type="text" name="epargne_pct" class="form-control mb-3" placeholder="20% ou 50%"  required>
        <button class="btn btn-primary w-100"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i>Valider/button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>