<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-5">
  <h4 class="mb-4">Barèmes de frais</h4>
  <?php if (session('message')) { ?>
    <div class="alert alert-success"><?= session('message') ?></div>
  <?php } ?>

  <div class="card mb-4">
    <div class="card-body">
      <form method="post" action="<?= site_url('admin/baremes/add') ?>" class="row g-2 align-items-end">
        <?= csrf_field() ?>
        <div class="col-md-3">
          <label class="form-label">Type</label>
          <select name="type_operation" class="form-select">
            <option value="retrait">Retrait</option>
            <option value="transfert">Transfert</option>
          </select>
        </div>
        <div class="col-md-2"><label class="form-label">Min</label><input type="number" name="montant_min" class="form-control" required></div>
        <div class="col-md-2"><label class="form-label">Max</label><input type="number" name="montant_max" class="form-control" placeholder="vide = illimité"></div>
        <div class="col-md-2"><label class="form-label">Frais</label><input type="number" name="frais" class="form-control" required></div>
        <div class="col-md-3"><button class="btn btn-primary w-100">Ajouter</button></div>
      </form>
    </div>
  </div>

  <div class="row">
    <?php foreach (['retrait' => $retrait, 'transfert' => $transfert] as $type => $liste) { ?>
    <div class="col-md-6">
      <div class="card mb-3">
        <div class="card-header text-capitalize"><?= $type ?></div>
        <table class="table table-sm mb-0">
          <thead><tr><th>Min</th><th>Max</th><th>Frais</th><th></th></tr></thead>
          <tbody>
          <?php foreach ($liste as $b) { ?>
            <tr>
              <td><?= number_format($b['montant_min'],0,',',' ') ?></td>
              <td><?= $b['montant_max'] ? number_format($b['montant_max'],0,',',' ') : '&infin;' ?></td>
              <td><?= number_format($b['frais'],0,',',' ') ?> Ar</td>
              <td><a href="<?= site_url('admin/baremes/delete/'.$b['id']) ?>" class="btn btn-sm btn-outline-danger">×</a></td>
            </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="form-check mb-3">
  <input class="form-check-input" type="checkbox" name="frais_inclus" value="1" id="fi">
  <label class="form-check-label" for="fi">
    Inclure les frais dans le montant (le destinataire reçoit moins)
  </label>
</div>
</div>
<?= $this->endSection() ?>