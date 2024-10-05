<?php
    use App\Services\Page; 
?>

<!DOCTYPE html>
<html lang="en">
<?php
    Page::part(part_name:'head');
?>
<body>

<?php
    Page::part(part_name:'navbar');
?>

<div class="container">
    <h1>404: PAGE NoT FOUND</h1>
</div>

</body>
</html>