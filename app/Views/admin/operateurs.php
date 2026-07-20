<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
  <h4 class="mb-4">Opérateurs et préfixes</h4>

  <?php if (session('message')): ?><div class="alert alert-success"><?= esc(session('message')) ?></div><?php endif; ?>
  <?php if (session('error')): ?><div class="alert alert-danger"><?= esc(session('error')) ?></div><?php endif; ?>

  <div class="card mb-4">
    <div class="card-body">
      <div class="row">
        <div class="col-md-6 border-end">
          <h6 class="mb-3">Nouvel opérateur concurrent</h6>
          <form method="post" action="<?= site_url('admin/operateurs/add') ?>" class="row g-2 align-items-end">
            <?= csrf_field() ?>
            <div class="col-6"><label class="form-label small">Nom</label>
              <input type="text" name="nom" class="form-control" required></div>
            <div class="col-3"><label class="form-label small">Commission %</label>
              <input type="number" step="0.1" name="commission_pct" class="form-control" value="0" required></div>
            <div class="col-3"><button class="btn btn-primary w-100">Ajouter</button></div>
          </form>
        </div>
        <div class="col-md-6">
          <h6 class="mb-3">Nouveau préfixe</h6>
          <form method="post" action="<?= site_url('admin/prefixe/add') ?>" class="row g-2 align-items-end">
            <?= csrf_field() ?>
            <div class="col-4"><label class="form-label small">Préfixe</label>
              <input type="text" name="valeur" class="form-control" placeholder="032" required></div>
            <div class="col-5"><label class="form-label small">Opérateur</label>
              <select name="id_operateur" class="form-select">
                <?php foreach ($operateurs as $o): ?>
                  <option value="<?= $o['id'] ?>"><?= esc($o['nom']) ?></option>
                <?php endforeach; ?>
              </select></div>
            <div class="col-3"><button class="btn btn-primary w-100">Ajouter</button></div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <?php foreach ($operateurs as $o): ?>
      <div class="col-md-6 mb-3">
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <span><strong><?= esc($o['nom']) ?></strong>
              <?php if ($o['est_interne']): ?>
                <span class="badge bg-success ms-2">Notre réseau</span>
              <?php else: ?>
                <span class="badge bg-secondary ms-2">Concurrent</span>
              <?php endif; ?>
            </span>
          </div>
          <div class="card-body">
            <div class="mb-3">
              <?php foreach ($o['prefixes'] as $p): ?>
                <span class="badge bg-light text-dark border me-1 mb-1 p-2">
                  <?= esc($p['valeur']) ?>
                  <a href="<?= site_url('admin/prefixe/delete/'.$p['id']) ?>" class="text-danger text-decoration-none ms-1">×</a>
                </span>
              <?php endforeach; ?>
              <?php if (empty($o['prefixes'])): ?>
                <span class="text-muted small">Aucun préfixe</span>
              <?php endif; ?>
            </div>

            <?php if (!$o['est_interne']): ?>
              <form method="post" action="<?= site_url('admin/operateurs/update/'.$o['id']) ?>" class="row g-2 align-items-end">
                <?= csrf_field() ?>
                <div class="col-7"><label class="form-label small mb-0">Commission transfert sortant (%)</label>
                  <input type="number" step="0.1" name="commission_pct" class="form-control form-control-sm"
                         value="<?= $o['commission_pct'] ?>"></div>
                <div class="col-5"><button class="btn btn-sm btn-outline-primary w-100">Mettre à jour</button></div>
              </form>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
<?= $this->endSection() ?>