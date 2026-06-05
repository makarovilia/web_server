<?php
function url(string $path): string {
    return PROJECT_FOLDER . '/' . ltrim($path, '/');
}
?>