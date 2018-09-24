<?php

    include_once 'db.php';

    
    class Articles extends DB {
    
        
        function getArticles() {
            $sql = 'select * from articles where published = 1';
            $sth = $this->dbh->prepare($sql);
            $sth->execute();
            
            return $sth->fetchAll(PDO::FETCH_ASSOC);    
        }
        
        function getArticle($id) {
            $params = [':id' => $id]; 
            $sql = 'select * from articles where id = :id and published = 1';
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            
            return $sth->fetch(PDO::FETCH_ASSOC);      
        }
        
        function deleteArticle($id) {
            $params = [':id' => $id]; 
            $sql = 'UPDATE articles SET published = 0 WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            return $sth->rowCount(); 
        }
        
        function addArticle($article) {
            $params = [':title' => $article["title"], ':content' => $article["content"]]; 
            $sql = 'INSERT INTO articles(title, content, published, image) VALUES(:title, :content, 1, :title)';
            $sth = $this->dbh->prepare($sql);
            $result = $sth->execute($params);
            return $sth->rowCount();
        }
        
        function updateArticle($article) {
            $params = [':id' => $article['id'], ':title' => $article["title"], ':content' => $article["content"]];
            $sql = 'UPDATE articles SET title = :title, content = :content WHERE id = :id';
            $sth = $this->dbh->prepare($sql);
            $sth->execute($params);
            return $sth->rowCount(); 
        }
        
        function getArticlesJSON() {
            $articles = $this->getArticles();
            echo json_encode($articles);
        }
        
        function getArticlesHTML() {
            $articles = $this->getArticles();
            $result = '<table border="1">';
            
            for($i=0; $i < count($articles); $i++) {
                $result .= '<tr>
                    <td>'. $articles[$i]["title"]. '</td>
                    <td>' .$articles[$i]["content"] . '</td>
                    <td><a href="admin.php?delete&id=' . $articles[$i]["id"].'">Delete</a></td>
                    <td><a href="admin.php?edit&id='. $articles[$i]["id"] . '">Edit</a></td>
                </tr>';
            }
            
            $result .= '</table>';
            echo $result;
        }
        
     }  
     
    $articlesClass = new Articles();
    $article = '';
    $edit = false;
    
    if (isset($_GET['articlesToHTML'])) {
        return $articlesClass->getArticlesHTML();
        die;
    }
    
    if (isset($_GET['articlesToJSON'])) {
        return $articlesClass->getArticlesJSON();
        die;
    }
    
    if (isset($_GET["delete"]) && !empty($_GET["id"])) {
        $result = $articlesClass->deleteArticle($_GET["id"]);  
        if ($result === 1) {
            echo "Article Deleted";
        }
    }
    
    if (isset($_GET["edit"]) && !empty($_GET["id"])) {
        $edit = true;
        $article = $articlesClass->getArticle($_GET["id"]);         
    }
    
    if (!empty($_POST["title"]) && empty($_POST["id"]) ) {
        // $_FILES
        $result = $articlesClass->addArticle($_POST);   
    }
    
    if (isset($_GET["update"]) && !empty($_POST["title"]) && !empty($_POST["id"])) {
        $result = $articlesClass->updateArticle($_POST);   
    }

    $articles = $articlesClass->getArticles();
    if ($articles === false) {
        echo "Empty List";
    }
    else {

    }
?>
<?php 
    include ('header.php'); 
?>

<!--MAIN-->
<div class="admin-main">

    <table class="table">
        <tr>
            <td>Title</td>
            <td>Content</td>
            <td></td>
            <td></td>
        </tr>
    <?php for($i=0; $i < count($articles); $i++) { ?>
        <tr>
            <td><?php echo $articles[$i]["title"];?></td>
            <td><?php echo $articles[$i]["content"];?></td>
            <td><a href="admin.php?delete&id=<?php echo $articles[$i]["id"];?>">Delete</a></td>
            <td><a href="admin.php?edit&id=<?php echo $articles[$i]["id"];?>">Edit</a></td>
        </tr>
    <?php }?>
    </table>     
    
    
    <form enctype="multipart/form-data" method="POST" action="admin.php?<?php echo $edit ? 'update' : '' ?>">
        <h3>Add article</h3>
        <input class="form-control" type="hidden" name="id" value="<?php echo isset($article["id"]) ? $article["id"] : ""; ?>"/> 
        <input class="form-control" type="text" name="title" placeholder="Title" value="<?php echo isset($article["title"]) ? $article["title"] : ""; ?>"/>
        <textarea class="form-control" type="text" name="content" placeholder="Content" value="<?php echo isset($article["content"]) ? $article["content"] : ""; ?>"/></textarea>
        <input name="file" type="file" />
        <input class="btn btn-primary" type="submit" value="Submit"/>
    </form>
    
    <script src="js/upload.js"></script>
    
</div>

