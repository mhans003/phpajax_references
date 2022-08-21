<?php
    session_start();

    //$_SESSION['favorites'] = [];

    if(!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    function is_favorite($id) {
        return in_array($id, $_SESSION['favorites']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Async Button</title>
    <style>
        #blog-posts {
            width: 700px;
        }
        .blog-post {
            border: 1px solid black;
            margin: 10px 10px 20px 10px;
            padding: 6px 10px;
        }
        button.favorite-button, button.unfavorite-button {
            background: #0000FF;
            color: white;
            text-align: center;
            width: 70px;
        }
        button.favorite-button:hover, button.unfavorite-button:hover {
            background: #000099;
        }
        button.favorite-button {
            display: inline;
        }
        .favorite button.favorite-button {
            display: none;
        }
        button.unfavorite-button {
            display: none;
        }
        .favorite button.unfavorite-button {
            display: inline;
        }
        .favorite-heart {
            color: red;
            font-size: 2em;
            float: right;
            display: none;
        }
        .favorite .favorite-heart {
            display: block;
        }
    </style>
</head>
<body>
    <?php echo join(', ', $_SESSION['favorites']); ?>
    <div id="blog-posts">
        <div id="blog-post-101" class="blog-post <?php if(is_favorite(101)) { echo 'favorite'; } ?>">
            <span class="favorite-heart">&hearts;</span>
            <h3>Blog Post 101</h3>
            <p>Lorem ipsum text blog post 101...</p>
            <button class="favorite-button">Favorite</button>
            <button class="unfavorite-button">Unfavorite</button>
        </div>
        <div id="blog-post-102" class="blog-post <?php if(is_favorite(102)) { echo 'favorite'; } ?>">
            <span class="favorite-heart">&hearts;</span>
            <h3>Blog Post 102</h3>
            <p>Lorem ipsum text blog post 102...</p>
            <button class="favorite-button">Favorite</button>
            <button class="unfavorite-button">Unfavorite</button>
        </div>
        <div id="blog-post-103" class="blog-post <?php if(is_favorite(103)) { echo 'favorite'; } ?>">
            <span class="favorite-heart">&hearts;</span>
            <h3>Blog Post 103</h3>
            <p>Lorem ipsum text blog post 103...</p>
            <button class="favorite-button">Favorite</button>
            <button class="unfavorite-button">Unfavorite</button>
        </div>
    </div>

    <script>
        function favorite() {
            var parent = this.parentElement;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'favorite.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;
                    console.log('Result: ' + result);
                    if(result == 'true') {
                        parent.classList.add("favorite");
                    }
                }
            };
            xhr.send("id=" + parent.id);
        }

        var buttons = document.getElementsByClassName("favorite-button");
        for(let i = 0; i < buttons.length; i++) {
            buttons.item(i).addEventListener("click", favorite);
        }

        function unfavorite() {
            var parent = this.parentElement;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'unfavorite.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.onreadystatechange = function() {
                if(xhr.readyState == 4 && xhr.status == 200) {
                    var result = xhr.responseText;
                    console.log('Result: ' + result);
                    if(result == 'true') {
                        parent.classList.remove("favorite");
                    }
                }
            };
            xhr.send("id=" + parent.id);
        }

        var buttons = document.getElementsByClassName("unfavorite-button");
        for(let i = 0; i < buttons.length; i++) {
            buttons.item(i).addEventListener("click", unfavorite);
        }
    </script>
</body>
</html>