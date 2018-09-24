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
                    <td>' .$articles[$i]["link"] . '</td>
                    <td>' .$articles[$i]["image"] . '</td>
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

    if (isset($_GET["update"]) && !empty($_POST["title"]) && !empty($_POST["id"])) {
        $result = $articlesClass->updateArticle($_POST);   
    }

    // Get articles list
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

<body>
    
    <script src="js/comment.js"></script>
    
    <!--HOME-->
    <section id="home" class="summary">
        <div class="row">
            <div class="col-md-6 col-sm-6 nopadding pic1">
                <a href="https://soundcloud.com/te_doare"><img src="assets/images/funki-1024.jpg"></a>
                <div class="absolute color-2">
                    <div class="comments color-2">
                        <h1>Soundscapes and Noises</h1> 
                    </div>                    
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 nopadding pic2">
                <div class="col-md-6 col-sm-6 nopadding pic21">
                    <a href="mix.php"><img src="assets/images/aphex-1024.jpg"></a>
                    <div class="absolute color-2">
                        <div class="comments color-2">
                        <h4>MIXotopia</h4> 
                        </div>                    
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="col-md-6 col-sm-6 nopadding pic22">
                     <a href="trax2.php"><img src="assets/images/acrobat2-1024.jpg"></a>
                    <div class="absolute color-2">
                        <div class="comments color-2">
                         <h4>Nightly TRAX</h4> 
                        </div>                    
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-6 col-sm-6 nopadding pic23">
                     <a href="trax1.php"><img src="assets/images/boards-1024.jpg"></a>
                    <div class="absolute color-2">
                        <div class="comments color-2">
                           <h4>Daily TRAX</h4> 
                        </div>                    
                    <div class="clearfix"></div>
                </div>
                </div>
                <div class="col-md-6 col-sm-6 nopadding pic24">
                     <a href="videos.php"><img src="assets/images/quasimoto-1024.jpg"></a>
                    <div class="absolute color-2">
                        <div class="comments color-2">
                           <h4>VIVIDeos</h4> 
                        </div>                    
                    <div class="clearfix"></div>
                </div>
                </div>
            </div>
        </div>
    </section>
    
    <!--CONTENT-->
    <section id="content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Discover sounds, stories, music</h2>
                    <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur ipsum dolor sit amet consecteturipsum dolor sit amet consectetur ipsum dolor sit amet consectetur</h3>
                </div>
            </div>
        </div>
        <div class="content-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="articles">
                            <?php for($i=0; $i < count($articles); $i++) { ?>
                            <div class="blog-posting entry">
                                <article class="post">
                                    <div class="post-entry">
                                        <div class="post-section">
                                            <span class="bullet first-bullet"></span>
                                            <span class="cat">
                                                <a href="index.php"><?php echo $articles[$i]["title"];?></a>
                                            </span>
                                            <span class="bullet last-bullet"></span>
                                        </div>
                                        <div> 
                                            <?php echo $articles[$i]["content"];?>
                                        </div>
                                        <a class="more-link" href="<?php echo $articles[$i]["link"];?>">continue reading</a>
                                    </div>
                                    <div class="actionBox">
                                        <ul class="commentList">
                                        
                                        </ul>
                                        <form class="form-inline js-comm-form" role="form" onsubmit="return false;">
                                            <div class="form-group">
                                                <input class="form-control js-comm-text" type="text" placeholder="Your comments" />
                                            </div>
                                            <div class="form-group">
                                                <button class="btn btn-default js-add-comment">Add</button>
                                            </div>
                                        </form>
                                    </div>
                                </article>
                            </div>
                            <?php }?>
                        </div>
                    </div> 
                    <div class="col-sm-4">
                        <div id="sidebar" class="sidebar">
                            <div class="sidebar-section">
                                <h2 class="title">
                                    <span>About me</span>
                                </h2>
                                <div class="sidebar-section-content">
                                    <div class="">
                                        <center>
                                            <img alt="about me" src="assets/images/portrait.jpg">
                                        </center>
                                        <p>TeDoare, tempor duis single-origin coffee ea next level ethnic fingerstache fanny pack nostrud photo booth anim velta.</p>           
                                        <div class="clear"></div>           
                                    </div>
                                </div>
                                <div class="clear"></div>

                                <span class="sidebar-section-item-control"></span>
                                <div class="clear"></div>
                            </div>

                            <div class="sidebar-section recommendations">
                                <h2>
                                    <span>Recommended Blogs</span>
                                </h2>
                                <div class="sidebar-section-content recommendation-blogs">
                                    <ul>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://web-6-marian-mates-marianmates.c9users.io/Blog/" target="_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://web-6-marian-mates-marianmates.c9users.io/Blog/" target="_blank"> 
                                                        <b>Marian Mates</b> - Discover what Marian has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/chesovan/web6-marius_ch/curs1/index.html?_c9_id=livepreview1&_c9_host=https://ide.c9.io" target="_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/chesovan/web6-marius_ch/curs1/index.html?_c9_id=livepreview1&_c9_host=https://ide.c9.io" target="_blank"> 
                                                        <b>Marius Chesovan</b> - Discover what Marius has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/andreic15/andrei_cornea/Blog/index.html?_c9_id=livepreview3&_c9_host=https://ide.c9.io" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/andreic15/andrei_cornea/Blog/index.html?_c9_id=livepreview3&_c9_host=https://ide.c9.io" target="_blank"> 
                                                        <b>Andrei Cornea</b> - Discover what Andrei has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/alintv/alin_niculescu/Blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/alintv/alin_niculescu/Blog/index.html" target="_blank"> 
                                                        <b>Alin Niculescu</b> - Discover what Alin has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/adelinarat/adelinarat/BLOG/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/adelinarat/adelinarat/BLOG/index.html" target="_blank"> 
                                                        <b>Adelina Rat</b> - Discover what Adelina has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/achiorean/adrian_chiorean/blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/achiorean/adrian_chiorean/blog/index.html" target="_blank"> 
                                                        <b>Adrian Chiorean</b> - Discover what Adrian has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/grooveman/web6-stefan/Blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/grooveman/web6-stefan/Blog/index.html" target="_blank"> 
                                                        <b>Stefan Moldovan</b> - Discover what Stefan has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/adrianmq/web6_adrianmatei/blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/adrianmq/web6_adrianmatei/blog/index.html" target="_blank"> 
                                                        <b>Adrian Matei</b> - Discover what Adrian has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/r4lu/raluca/Blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/r4lu/raluca/Blog/index.html" target="_blank"> 
                                                        <b>Raluca Pascu</b> - Discover what Raluca has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/cristi21/web6/curs1/index.1.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/cristi21/web6/curs1/index.1.html" target="_blank"> 
                                                        <b>Cristi Pasca</b> - Discover what Cristi has been up to by reading his lates blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/mihaela_stefania/mihaela/blog/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/mihaela_stefania/mihaela/blog/index.html" target="_blank"> 
                                                        <b>Mihaela Marinca</b> - Discover what Mihaela has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/erikaalmasan/erika/curs%201/blog/blog%20Erika.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/erikaalmasan/erika/curs%201/blog/blog%20Erika.html" target="_blank"> 
                                                        <b>Erika Almasan</b> - Discover what Erika has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://web-6vincent-vincent29.c9users.io/Test%20Creation%20site%20perso/index.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://web-6vincent-vincent29.c9users.io/Test%20Creation%20site%20perso/index.html" target="_blank"> 
                                                        <b>Vincent Doare</b> - Discover what Vincent has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/cristinagorcea/cristina/curs/TEMA1.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/cristinagorcea/cristina/curs/TEMA1.html" target="_blank"> 
                                                        <b>Cristina Gorcea</b> - Discover what Cristina has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/katonaszabi/web6szabi/Home%20Automation/My%20Blog.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/katonaszabi/web6szabi/Home%20Automation/My%20Blog.html" target="_blank"> 
                                                        <b>Katona Szabolcs</b> - Discover what Szabi has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                        <li>
                                            <div class="item-thumbnail-only">
                                                <div class="item-thumbnail">
                                                    <a href="https://preview.c9users.io/ioanaa/ioanaa/curs1/tema1.html" target=_blank">
                                                        <img src="assets/images/user.png">
                                                    </a>
                                                </div>
                                                <div class="item-title">
                                                    <a href="https://preview.c9users.io/ioanaa/ioanaa/curs1/tema1.html" target="_blank"> 
                                                        <b>Ioana Alexandra</b> - Discover what Ioana has been up to by reading his latest blog posts
                                                    </a>
                                                </div>
                                            </div>
                                            <div style="clear: both;"></div>
                                        </li>
                                    </ul>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
    </section>
</body>

<?php 
    include ('footer.php'); 
?>