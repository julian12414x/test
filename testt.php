<?php

$baseDir = __DIR__;


function listFiles($dir) {
    $files = array();
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != '.' && $file != '..') {
                    $path = $dir . '/' . $file;
                    $files[$file] = is_dir($path) ? 'dir' : 'file';
                }
            }
            closedir($dh);
        }
    }
    return $files;
}

// Navegar a directorios específicos si se proporciona un nombre de directorio
$dir = isset($_GET['dir']) ? $_GET['dir'] : '';
$fullPath = realpath($baseDir . '/' . $dir);

if ($fullPath && strpos($fullPath, $baseDir) === 0 && is_dir($fullPath)) {
    $files = listFiles($fullPath);
} else {
    echo "Directorio no válido.";
    exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Navegador de Archivos</title>
</head>
<body>
    <h1>Navegador de Archivos</h1>
    
    <ul>
        <?php if ($dir !== '' && $dir !== '.'): ?>
            <li><a href="?dir=<?= urlencode(dirname($dir)) ?>">..</a></li>
        <?php endif; ?>
        <?php foreach ($files as $file => $type): ?>
            <li>
                <?php if ($type === 'dir'): ?>
                    <a href="?dir=<?= urlencode($dir . '/' . $file) ?>"><?= htmlspecialchars($file) ?></a>
                <?php else: ?>
                    <?= htmlspecialchars($file) ?>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <?php if ($type === 'file' && isset($_GET['file'])): ?>
        <h2>Contenido del archivo: <?= htmlspecialchars($_GET['file']) ?></h2>
        <pre><?php echo htmlspecialchars(file_get_contents($fullPath . '/' . $_GET['file'])); ?></pre>
    <?php endif; ?>
</body>
</html>
