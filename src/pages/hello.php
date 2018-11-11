<?php $name = $request->get('name', 'Pretty'); ?>

Hello <?= htmlspecialchars($name, ENT_QUOTES); ?>
