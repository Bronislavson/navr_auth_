<?php
    use App\Services\Page;
    use App\Controllers\Auth; 
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
    <h1>500: Произошла ошибка сервере</h1>
</div>

</body>
</html>