<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
  <h4 class="mb-4"><i class="fa-solid fa-money-bill-transfer me-2"></i>Montants à reverser aux autres opérateurs</h4>

  <div class="row g-3 mb-4">
    <div class="col-md-6"><div class="card text-center"><div class="card-body">
      <div class="text-muted">Total à reverser</div>
      <h3 class="text-danger"><?= number_format($totalDu, 0, ',', ' ') ?> Ar</h3>
    </div></div></div>
    <div class="col-md-6"><div class="card text-center"><div class="card-body">
      <div class="text-muted">Commissions encaissées</div>
      <h3 class="text-success"><?= number_format($totalComm, 0, ',', ' ') ?> Ar</h3>
    </div></div></div>
  </div>

  <div class="card mb-4">
    <div class="card-header"><i class="fa-solid fa-building me-1"></i>Par opérateur</div>
    <table class="table mb-0">
      <thead><tr>
        <th>Opérateur</th><th>Taux</th><th class="text-center">Transferts</th>
        <th class="text-end">À reverser</th><th class="text-end">Frais</th><th class="text-end">Commissions</th>
      </tr></thead>
      <tbody>
      <?php foreach ($lignes as $l) { ?>
        <tr>
          <td><strong><?= $l['nom'] ?></strong></td>
          <td><?= $l['commission_pct'] ?> %</td>
          <td class="text-center"><?= $l['nb_transferts'] ?></td>
          <td class="text-end text-danger"><?= number_format($l['a_reverser'], 0, ',', ' ') ?> Ar</td>
          <td class="text-end"><?= number_format($l['frais_percus'], 0, ',', ' ') ?> Ar</td>
          <td class="text-end text-success"><?= number_format($l['commissions_percues'], 0, ',', ' ') ?> Ar</td>
        </tr>
      <?php } ?>
      </tbody>
      <tfoot class="table-light fw-bold">
        <tr>
          <td colspan="3">Total</td>
          <td class="text-end"><?= number_format($totalDu, 0, ',', ' ') ?> Ar</td>
          <td></td>
          <td class="text-end"><?= number_format($totalComm, 0, ',', ' ') ?> Ar</td>
        </tr>
      </tfoot>
    </table>
  </div>

  <div class="card">
    <div class="card-header"><i class="fa-solid fa-clock-rotate-left me-1"></i>Détail des transferts sortants (50 derniers)</div>
    <table class="table table-sm mb-0">
      <thead><tr><th>Date</th><th>Expéditeur</th><th>Destinataire</th><th>Opérateur</th>
        <th class="text-end">Montant</th><th class="text-end">Commission</th></tr></thead>
      <tbody>
      <?php foreach ($detail as $d) { ?>
        <tr>
          <td class="small"><?= $d['date_creation'] ?></td>
          <td><?= $d['expediteur'] ?></td>
          <td><?= $d['destinataire'] ?></td>
          <td><span class="badge bg-secondary"><?= $d['operateur'] ?></span></td>
          <td class="text-end"><?= number_format($d['montant'], 0, ',', ' ') ?> Ar</td>
          <td class="text-end"><?= number_format($d['commission'], 0, ',', ' ') ?> Ar</td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>