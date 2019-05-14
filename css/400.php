<?php
    header("Content-type: text/css; charset: UTF-8");
    include 'sessioncheck.php';
    // include_once 'profilepicture.php';
    ?>
div {
    opacity: 1;
    
}
.messagebody {
    display: table;
}
.messagehead {
margin: 200px 0px 0px 0%;
width: 475px;
}
.readmessages {
    background-color: white;
    height: auto;
    //padding: 2px;
}
.message {
background-color: white;
width: 300px;

}
.photodiv {
background-color: lightblue;
margin: 87px 0 0 0;
}
.conversationstream {
width: 400px;
margin: 10px 0px 0px 0%;
position: absolute;
display: left;
}
.bodydiv {
font-family: "Arial", Times, serif;
}
.messagestream {
display: none;
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
    margin: 87px 0px 0px 0%;
    position: relative;
    width: 300px;
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
margin: 100px 0px 0px 0%;
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

.friendrequests {
position: relative;
margin: 87px 0px 0px 0%;
}

.notifs {
    position: relative;
margin: 40px 0px 0px 0%;

}
.editpostcontent {
position: absolute;
margin: 100px 0 0 0;
background-color: lightblue;
}
.newfriendnotifs {
margin: 10px, 0px, 0px, 0px;
width: 300px;
background-color: lightblue;
}
.friendnotifs {
width: 300px;
margin: 10px 0px 0px 0px;
position: relative;
}

.editpost {
position: absolute;
top: 0px;
margin: 0 0 0 250px;
font-size: .7em;
}
.notiffloater {
padding: 5px;
border: 1px solid grey;
}
#imagePreview {
width: 180px;
height: 180px;
background-position: center;
background-size: cover;
-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
display: inline-block;
}
.reportuser {
position: fixed;
height: 100px;
width: 100%;
margin: 87px 0px 0px 0%;
text-align: left;
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
}
.notfriends {
position: absolute;
height: 100px;
width: 300px;
margin: 250px 0px 0px 0%;
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
.topribbon {
padding: 8px;
position: relative;
margin: 0px 0px 0px 0px;
font-size: 3.6vw;
text-align: left;
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

input.searchtxt {
height: 25px;
position: relative;
}
.searchbar {
padding: 4px;
margin: 0px 0px 0px 0%;
position: relative;
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
width: 300px;
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
position: relative;
    font-size: .8em;
    font-family: "Arial", Times, serif;
    top: 87px;
}
.content {
margin: 5px 0px 0px 0px;
}
.redirect {
    background-color: cyan;
opacity: 1;
    border-color: cyan;
    box-sizing: content-box;
    font-family: Helvetica, Arial, sans-serif;
    font-size:12px;
}
.profilecol {
position: absolute;
left: 0px;
top: 90px;
    background-color: lightblue;
    width: 100%;
    display: flex;  
    flex-direction: row;
    justify-content: space-between;
}
.profilecol > div {
  width: 100px;
  height: 100px;
}
.resultfeed {
margin: 0px 0px 0px 0%;
position: relative;
top: 200px;
}
.profilefeed {
position: relative;
margin: 0 450px 0 0;
}
.speedposts {
    background-color: rgba(136,235,164,.7);
}
.journalfeed {
position: relative;
margin: 87px 0 0 0;
}
.newsfeed {
position: relative;
margin: 0px 450px 0px 0px; 
width: 100%;
display: left;
text-align: left;
font-family: Arial, Helvetica, sans-serif;
}
.postbuttons {
postion: absolute;
//float: left;
}
.creatingpost {
    position: relative;
    margin: 150px 40% 0px 0px;
}
.menubuttons {
position: relative;
float: left;
}
.createpost {
position: relative;
margin: 201px 0px 0px 0px;
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
    margin: 90px 0px 0px 0px;
}
.editbio {
    background-color: lightblue;
    position: relative;
    z-index: 1;
    height: 250px;
    margin: 3px 500px 0px 0px;
}
.editprofile {
    background-color: lightblue;
    position: relative;
    z-index: 1;
    height: 250 px;
    margin: 3px 500px 0px 0px;
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
    height: 275px;
    background-color: lightblue;
    margin: 47px 500px 0px 0px;
    font-style: "helvetica";
}
.profile_options {
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
.biodiv {
opacity:1;
    z-index:1;
    position: relative;
    height: 252px;
    background-color: lightblue;
    margin: 47px 500px 0px 0px;
}
.normdiv {
opacity:1;
    z-index: 2;
    position: relative;
    height: 370px;
    border: 1px solid #999966;
    background-color: lightblue;
    margin: 47px 500px 0px 0px;
    text-align: center;
    
}
.userstuff {
display: flex;
flex-direction: row;
justify-content: space-between;
}
.toppic {
    height: 32px;
width: 32px;
    padding: 4px;
postion: relative;
margin: 0px 0px 0px 0%;
}
.toppic img {
height: 100%;
width: 100%;
    object-fit: cover;
}
.titlediv {
    top:0px;
    left:0px;
    position: fixed;
    z-index:1;
    height: 80px;
    width: 100%;
    border: 1px solid grey;
    background-color: rgba(0,255,255,1);
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
    font-size: 1.5em;
}

h2 {
    text-align: center;
    margin: 0;
}

label {
    font-style: sans-serif;
    font-size: 1.1em;
}

textarea {
    font-size: .9em;
    width: 300px;
}
header {
    text-align: right;
}
