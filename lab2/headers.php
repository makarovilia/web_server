<?php include("templates/header.php")?>
<?php 
$headers = get_headers("https://httpbin.org/post");
?>
<main>
    <div class="center">
        <?php foreach ($headers as $header) {
            echo "<p>$header</p>";
        } ?>
    </div>
    <div class="center">
        <a href="index.php" class="link-1 btn btn-outline-dark mt-3">Перейти на предыдущую страницу</a>
    </div>
</main>
<?php include ("templates/footer.php")?>