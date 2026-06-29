<?php require_once 'config/db.php';
require_once 'includes/auth.php';
require_login();
require_once 'includes/header.php';
$tables = ['patients' => 'المرضى', 'doctors' => 'الأطباء', 'departments' => 'الأقسام', 'appointments' => 'المواعيد', 'users' => 'المستخدمون']; ?>
<h2 class="mb-4">لوحة التحكم</h2>
<div class="row g-3"><?php foreach ($tables as $t => $label): $c = $pdo->query("SELECT COUNT(*) c FROM $t")->fetch()['c']; ?><div class="col-md-4">
            <div class="card stat">
                <div class="card-body">
                    <h5><?= e($label) ?></h5>
                    <h2><?= e($c) ?></h2>
                </div>
            </div>
        </div><?php endforeach; ?></div>
<?php require_once 'includes/footer.php'; ?>