<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5" style="max-width:600px;">
  <h4 class="mb-4">Préfixes de l'opérateur</h4>
  <?php if (session('message')) { ?>
    <div class="alert alert-success"><?= session('message') ?></div>
  <?php } ?>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= site_url('admin/prefixes') ?>">
        <?= csrf_field() ?>
        <label class="form-label">Préfixes valides </label>
        <input type="text" name="valeur" class="form-control mb-3" value="<?= $valeur ?>" placeholder="033,037">
        <button class="btn btn-primary">Enregistrer</button>
        <a href="<?= site_url('admin/dashboard') ?>" class="btn btn-link">Dashboard</a>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>