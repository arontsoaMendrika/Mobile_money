<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container" style="max-width:400px; margin-top:100px;">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h4 class="mb-4 text-center"><i class="fa-solid fa-wallet text-primary me-2"></i>Mobile Money</h4>
      <form method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>
        <label class="form-label">Numéro de téléphone</label>
        <input type="text" name="numero" class="form-control mb-3" placeholder="03xxxxxxxx" value="0331234567" required>
        <button class="btn btn-primary w-100"><i class="fa-solid fa-arrow-right-to-bracket me-1"></i>Se connecter</button>
      </form>
      <a href="<?= site_url('admin') ?>" class="btn btn-outline-secondary w-100 mt-2"><i class="fa-solid fa-user-shield me-1"></i>Espace Admin</a>
    </div>
  </div>
</div>
<?= $this->endSection() ?>