<!DOCTYPE html>
<html lang="en">
<head>
    <script src="/RDX/js/theme.js"></script>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="/RDX/images/logo.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>RDX | ADMIN</title>
    <link rel="stylesheet" type="text/css" href="/RDX/css/admin.css">
    <!-- <link rel="stylesheet" type="text/css" href="/RDX/css/style.css"> -->
    <link rel="stylesheet" href="/RDX/css/admin-animations.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>

<?php if (isset($_SESSION['success']) || isset($_SESSION['error'])): ?>
<?php $isSuccess = isset($_SESSION['success']); ?>
<div class="toast <?= $isSuccess ? 'success' : 'error' ?>" id="toast">
    <i class="fas fa-<?= $isSuccess ? 'check-circle' : 'times-circle' ?>"></i>
    <?= $isSuccess ? $_SESSION['success'] : $_SESSION['error'] ?>
</div>
<?php unset($_SESSION['success']); unset($_SESSION['error']); ?>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const t = document.getElementById('toast');
        setTimeout(() => t.classList.add('show'), 100);
        setTimeout(() => t.classList.remove('show'), 3200);
    });
</script>
<?php endif; ?>