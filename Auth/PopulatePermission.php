<?php  require_once '../App/partials/Header.inc';  require_once '../App/partials/Menu/MarketingMenu.inc';  ?>
 
<?php 
    var_dump($_SESSION);
    var_dump($_SESSION['ACCESS_LIST']);
    if(isset($_POST) && !empty($_POST)) {
        $Controller->QueryData(  'INSERT INTO permission(title, slug,description,page ) VALUES (?,?,?,?)',[
                $_POST['title'] , 
                $_POST['slug'] , 
                $_POST['description'] , 
                $_POST['page'] 
            ]);
    }
?>

<form action="" method="post">
    <input type="text" name="title"  placeholder = "title" id=""> <br>
    <input type="text" name="slug"  placeholder = "slug" id=""> <br>
    <input type="text" name="description" class = "w-50" placeholder = "description" id=""> <br>
    <input type="text" name="page"  placeholder = "page" id=""> <br>
    <button type="submit">Save</button>
</form>

<?php  require_once '../App/partials/Footer.inc'; ?>