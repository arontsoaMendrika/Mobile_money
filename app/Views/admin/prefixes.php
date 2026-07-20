<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5" style="max-width:600px;">
  <h4 class="mb-4"><i class="fa-solid fa-hashtag me-2"></i>Préfixes de l'opérateur</h4>
  <div class="card">
    <div class="card-body">
      <form method="post" action="<?= site_url('admin/prefixes') ?>">
        <?= csrf_field() ?>
        <label class="form-label">Préfixes valides </label>
        <input type="text" name="valeur" class="form-control mb-3" value="<?= $valeur ?>" placeholder="033,037">
        <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Enregistrer</button>
      </form>
    </div>
  </div>
</div>
<?= $this->endSection() ?>