<?php
include 'sessioncheck.php';
?>
<!DOCTYPE html>
<html>
<link rel="stylesheet" media="screen and (min-width: 550px)" href="css/styles.php">
    <link rel="stylesheet" media="screen and (max-width: 550px)" href="css/400.php" />
<header>
    <title>Add Photo Album</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <div class="titlediv">
        <?php
        include 'menu.php';
        ?>
    </div>
</header>
<body>
    <?php
if(!preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) {
    echo "<script src='sparkles.js'></script><span class='js-cursor-container'></span>";
}
    echo "<div class='albumdiv' id='albumdiv'>";
    echo "<div class='regpostfloater'>";
    echo "<div class='albumname'>";
    echo "What do you want to call this album?<br>";
    echo "<input type='inputtext' name='txtalbumname' id='txtalbumname' placeholder='name of album' autocomplete='no'>";
    echo "</div>"; //closes albumname
    echo "</div>"; //closes floater
    echo "</div>"; //closes albumdiv
    ?>
    
    <script>
        var div = document.createElement('div');
        var aname = document.getElementById("txtalbumname");
        var input = document.createElement('input');
        input.setAttribute("type", "file");
        //input.innerHTML = "Add Photo";
        input.setAttribute("name", "fileToUpload");
        input.setAttribute("id", "fileToUpload");
        
        var nextpic = document.createElement('input');
        nextpic.setAttribute("type", "button");
        nextpic.setAttribute("id", "btnNextPic");
        nextpic.setAttribute("value", "Add Photo");
        
        var index = 0;
        
        var frm = document.createElement("form");
        frm.setAttribute("method", "post");
        frm.setAttribute("action", "albumupload.php");
        
        var ins = document.createElement("input");
        ins.setAttribute("type", "file");
        ins.setAttribute("id", "fileToUpload");
        ins.setAttribute("name", "fileToUpload");
        
        var nxt = document.createElement("input");
        nxt.setAttribute("type", "button");
        nxt.setAttribute("id", "btnNextPic");
        nxt.setAttribute("value", "+");
        
        var done = document.createElement("input");
        done.setAttribute("type", "submit");
        //done.setAttribute("")
        
        nextpic.addEventListener("click", addPhoto);
        aname.addEventListener("keydown", function(e) {
            if (e.keyCode === 13 && index === 0) {
                createNewPhotoDiv();
                //index++;
            }
        });
        function createNewPhotoDiv() {
            
            //div.innerHTML = "my <b>new</b> skill - <large>DOM manipulation!</large>";
            // set style
            //div.style.color = 'red';
            // better to use CSS though - just set class
            div.setAttribute('class', 'addphoto'); // and make sure myclass has some styles in css
            div.setAttribute('id', 'photodiv');
            div.appendChild(input);
            div.appendChild(nextpic);
            document.getElementById('albumdiv').appendChild(div);
            
        }
        var ind = 0;
        
        function addPhoto() {
            var thediv = document.createElement("div");
            
            thediv.setAttribute("id", "thediv");
            thediv.setAttribute("class", "addphoto");
            thediv.appendChild(input);
            thediv.appendChild(nextpic);
            
            
            document.getElementById('albumdiv').appendChild(thediv);
        }
    </script>
        
</body>
</html>

