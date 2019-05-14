<?php
    header("Content-type: text/css; charset: UTF-8");
    include 'sessioncheck.php';
    //include_once 'profilepicture.php';
    ?>
div {
    opacity: 1;
    
}
.messagebody {
    display: table;
}
.messagehead {
margin: 200px 0px 0px 30%;
width: 475px;
}
.readmessages {
    background-color: white;
    height: auto;
    //padding: 2px;
}
.message {
background-color: white;
width: 400px;

}
.photodiv {
background-color: lightblue;
margin: 47px 0 0 0;
}
.conversationstream {
width: 400px;
margin: 10px 0px 0px 30%;
position: absolute;
display: left;
}
.bodydiv {
font-family: "Arial", Times, serif;
}
.messagestream {
width: 400px;
margin: 200px 0px 0px 26%;
position: absolute;
display: left;
}
.unreadmessages {
background-color: lightblue;
padding: 2px;
width: 100%;
height: 100%;
}
.displaypic {
height: 30px;
width: 30px;
}
.displaypic img {
width: 100%;
height: 100%;
object-fit: cover;
}
.messagename {
position: relative;
left: 35px;
top: -25px;
//height: 90px;
display: table;
}
.messagefriends {
background-color: white;
width: 240px;
height: 30px;
}
.friendresults {
    margin: 0px 0px 0px 60%;
    position: absolute;
    top: 200px;
}
a {
    font-family: "Arial", Times, serif;
color: black;
}

.likeable {
position: relative;
background-color: #eaede6;
}
.posttext {
display: block;
position: relative;
padding: 5px;
}
.albumdiv {
display: block;
position: absolute;
margin: 100px 0px 0px 40%;
}
.addphoto {
margin: 10px 0px 0px 0px;
padding: 5px;
}
.albumname {
margin: 10px 0px 10px 0px;
}
.notifications {
position: absolute;
height: 100px;
width: auto;
margin: 10px 0px 0px 0px;
padding: 5px;
}
.notifbody {

display: table;
}
.notifs {
    position: absolute;
    display: right;
margin: 100px 0px 0px 50%;

}
.friendrequests {

margin: 100px 0px 0px 25%;
display: left;
position: absolute;
}
.editpostcontent {
position: absolute;
margin: 100px 0 0 0;
background-color: lightblue;
width: 100%;
}
.newfriendnotifs {
width: 300px;
margin: 10px 0px 0px 0px;
background-color: lightblue;
}
.friendnotifs {
width: 300px;
margin: 10px 0px 0px 0px;
}
.editpost {
position: absolute;
top: 0px;
margin: 0px 0px 0px 93%;
font-size: .7em;
}
.notiffloater {
padding: 5px;
border: 1px solid grey;
}
#imagePreview {
width: 180px;
height: 180px;
background-position: center center;
background-size: cover;
-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
display: inline-block;
}
.reportuser {
position: fixed;
height: 100px;
width: 400px;
margin: 250px 0px 0px 35%;
text-align: left;
}
.notfriends {
position: absolute;
height: 100px;
width: 300px;
margin: 250px 0px 0px 40%;
text-align: left;
}
.posthead p {
position: relative;
display: table-cell;
    vertical-align: center;
width: 300px;
height: 75px;
}
.videodiv {
height: auto;
width: 460px;
position: relative;
display: block;
}
.prevcommenthead {
display: block;
margin: 0;
height: 31px;
}
.prevcommentrow {
display: table-row;
}
.prevcomments {
//display: table-cell;
    
height: auto;
    max-height: 240px;
overflow: auto;
    background-color: #eaede6;
left: 10px;
}
.prevcommentsdiv {
position: relative;
padding: 5px;
margin: 0;
}
div.topribbon {
padding: 8px;
position: absolute;
margin: 0px 0px 0px 60%;
}
.comment {
position: relative;
padding: 5px;
//display: table-cell;
    background-color: #eaede6;
margin: 0;
}
.insertcomment {
    
left: 10px;
padding: 2px;
}
.commentpic {
height: 31px;
width: 31px;
padding: 3px;
}
.commentpic img {
width: 100%;
height: 100%;
object-fit: cover;
}
.commenterpic {
    //width: 460px;
height: 31px;
width: 31px;
padding: 3px;
display: inline-block;
}
.commenterpic img {
width: 100%;
height: 100%;
    object-fit: cover;
}
.commentername {
position: relative;
left: 3px;
top: -5px;
//height: 10px;
display: inline-block;
}
.commenttext {
position: relative;
//padding: 5px;
}
.postpic {
position: absolute;
height: 50px;
width: 50px;
padding: 5px;
}
.postpic img {
width: 100%;
height: 100%;
    object-fit: cover;
}
.regpostpic {
//width: 460px;
//display: inline-block;
overflow: auto;
margin: 0px 0px 0px 0px;
position: relative;
    //float: center;
    //float: left;
}
.prevcommentfloater {
height: auto;
margin: 5px;
}
.messagetext {
    
}
.messagenamer {
    position: relative;
    left: 40px;
    top: -50px;
    margin: 0;
    
}
.postname {
  position: relative;
  left: 60px;
  //top: -5px;
  //height: 90px;
  display: table;
}
.regpostpic img {
width: 100%;
height: 100%;
    object-fit: contain;
}
.namereport {
position: relative;
left: 100px;
top: -50px;
height: 10px;
display: table;
}
.nameresults {
position: relative;
left: 100px;
top: -30px;
//height: 90px;
display: table;
}
.nameresults p {
display: table-cell;
vertical-align: center;
//top: -50px;
}
.nameresults a {
    text-decoration: none;
}
.nameresults a:hover {
    text-decoration: underline;
}
.searchresults {
    background-color: white;
width: 300px;
height: 100px;
}
.profileposts {
    background-color: rgba(173,216,230,.7);
}
.speedposts {
    background-color: rgba(136,235,164,.7);
}

input.searchtxt {
height: 25px;
position: relative;
}
div.searchbar {
padding: 4px;
margin: 0px 0px 0px 42%;
position: absolute;
}
.regposthead {
display: block;
height: 60px;
width: auto;
//border: 1px dashed grey;
top: 2px;
}
.videodiv {
height: auto;
width: auto;
display: block;
}
.likepostfloater {
height: auto;
margin: 5px;
border: 1px solid grey;
}
.regpostfloater {
height: auto;
margin: 5px;
border: 1px solid grey;
}
.regposts {
display: block;
    background-color: white;
width: 460px;
height: auto;
position: relative;
margin: 15px 0px 0px 0px;
}
.raceposts {

    background-color: #FFC4C4;
}
.milesdiv {
padding: 5px;
    text-align: left;
position: fixed;
    font-size: .8em;
    font-family: "Arial", Times, serif;
    top: 40px
}
.journalfeed {
position: absolute;
top: 40px;
left: 30%;
}
.content {
margin: 5px 0px 0px 0px;
}
.redirect {
    background-color: cyan;
opacity: .7;
    border-color: cyan;
    box-sizing: content-box;
    font-family: Helvetica, Arial, sans-serif;
    font-size:12px;
}
div.profilecol {
position: fixed;
left: 20%;
top: 47px;
    background-color: whitesmoke;
    width: 100%;
    display: flex;  
    flex-direction: column;
    justify-content: space-between;
}
.profilecol > div {
width: 150px;
height: 150px;
}
div.resultfeed {
margin: 0px 0px 0px 40%;
position: relative;
top: 200px;
}
.profilefeed {
position: relative;
    margin: 0px 450px 0px 36.5%;
}
.newsfeed {
position: relative;
margin: 0px 450px 0px 35%; 
display: left;
text-align: left;
font-family: Arial, Helvetica, sans-serif;
}
div.postbuttons {
postion: absolute;
//float: left;
}
.creatingpost {
    position: relative;
    margin: 150px 40% 0px 35%;
}
.menubuttons {
position: relative;
float: left;
}
div.createpost {
position: relative;
margin: 201px 450px 0px 36.5%;
}
p {
    font-family: Helvetica, Arial, sans-serif;
    font-size: .9em;
    color: black;
}
a.headname {
    position: absolute;
    float: left;
    top: 1px;
    left: 5px;
}
.distancediv {
    background-color: lightblue;
    position: relative;
    z-index:1;
    height: auto;
    margin: 50px 0 0 0;
}
div.editbio {
    background-color: lightblue;
    position: relative;
    z-index: 1;
    height: 250px;
    margin: 3px 500px 0px 500px;
}
div.editlimits {
    background-color: lightblue;
    position: relative;
    z-index: 1;
    height: 400px;
    margin: 3px 500px 0px 500px;
}
.profpic {
    max-height: 100%;
    max-width: 100%;
    overflow:hidden;
}
.picresults {
    background-color: green;
position: relative;
height: 75px;
width: 75px;
top: 12px;
left: 12px;
}
.picresults img {
width: 100%;
height: 100%;
    object-fit: cover;
}
.profilepic img {
width: 100%;
height: 100%;
    object-fit: cover;
}
.biography {
height: 100px;
overflow: scroll;
    background-color: white;
border: 1px solid grey;
    font-family: "Arial", Times, serif;
    font-size: .75em;
}
.editpic {
    z-index:1;
    position: relative;
    height: auto;
    background-color: lightblue;
    margin: 47px 500px 0px 500px;
    font-style: "helvetica";
}
div.profile_options {
    z-index:2;
    height: 50px;
    font-style: sans-serif;
    font-size:.7em;
}
.namediv {
    z-index:1;
    position: relative;
    height: auto;
    background-color: rgba(173,216,230,.7);
    margin: 47px 0 0 0;
    padding: 5px;
}
div.biodiv {
opacity:.7;
    z-index:1;
    position: relative;
    height: 252px;
    background-color: lightblue;
    margin: 47px 500px 0px 500px;
}
div.normdiv {
opacity:.7;
    z-index: 2;
    position: relative;
    height: 370px;
    border: 1px solid #999966;
    background-color: lightblue;
    margin: 47px 500px 0px 500px;
    text-align: center;
    
}
div.toppic {
    height: 32px;
width: 32px;
    padding: 4px;
postion: absolute;
margin: 0px 0px 0px 25%;
}
.toppic img {
height: 100%;
width: 100%;
    object-fit: cover;
}
div.titlediv {
    top:0px;
    left:0px;
    position: fixed;
    z-index:1;
    height: 40px;
    width: 100%;
    border: 1px solid grey;
    background-color: rgba(0,255,255,.7);
    padding: 0px;
}
body {
    background-color: whitesmoke;
}
p3 {
    color: red;
    text-align: center;
    font-size: 1.1em;
    margin:0;
}

h1 {
    text-align: center;
    color: black;
    margin:0;
}

h2 {
    text-align: center;
    margin: 0;
}
.PreviewPicture {
width: 180px;
height: 180px;
background-position: center center;
background-size: cover;
background-image: url('/uploads/default.jpg');
-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
display: inline-block;
opacity: 100%;
label {
    font-style: sans-serif;
    font-size: 1.1em;
}

textarea {
    font-size: .9em;
    width: 100%;
}
header {
    text-align: right;
}
h1 {
    text-align: center;
    font-size: 1.5em;
}
