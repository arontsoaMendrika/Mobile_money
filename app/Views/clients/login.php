<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container" style="max-width:400px; margin-top:100px;">
  <div class="card shadow-sm">
    <div class="card-body p-4">
      <h4 class="mb-4 text-center">Mobile Money</h4>
      <?php if (session('error')) { ?>
        <div class="alert alert-danger"><?= session('error') ?></div>
      <?php } ?>
      <form method="post" action="<?= site_url('login') ?>">
        <?= csrf_field() ?>
        <label class="form-label">Numéro de téléphone</label>
        <input type="text" name="numero" class="form-control mb-3" placeholder="0331234567" required>
        <button class="btn btn-primary w-100">Se connecter</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>