package com.david.runnersnet.misc.comments;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import java.io.Serializable;

@Entity
@Table(name = "comments")
public class Comment implements Serializable {

    private Integer type = 5;
    private Integer posttype;
    private Integer postID;
    @Id
    private Integer commentID;
    private String date;
    private Integer userID;
    private String text;
    private String img_filepath;

    public Comment() {}

    public Comment(Integer type, Integer posttype, Integer postID, Integer commentID, String date, Integer userID, String text, String img_filepath) {
        this.type = type;
        this.posttype = posttype;
        this.postID = postID;
        this.commentID = commentID;
        this.date = date;
        this.userID = userID;
        this.text = text;
        this.img_filepath = img_filepath;
    }

    public Integer getType() {
        return type;
    }

    public void setType(Integer type) {
        this.type = type;
    }

    public Integer getPosttype() {
        return posttype;
    }

    public void setPosttype(Integer posttype) {
        this.posttype = posttype;
    }

    public Integer getPostID() {
        return postID;
    }

    public void setPostID(Integer postID) {
        this.postID = postID;
    }

    public Integer getCommentID() {
        return commentID;
    }

    public void setCommentID(Integer commentID) {
        this.commentID = commentID;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public Integer getUserID() {
        return userID;
    }

    public void setUserID(Integer userID) {
        this.userID = userID;
    }

    public String getText() {
        return text;
    }

    public void setText(String text) {
        this.text = text;
    }

    public String getImg_filepath() {
        return img_filepath;
    }

    public void setImg_filepath(String img_filepath) {
        this.img_filepath = img_filepath;
    }


}

//+--------------+--------------+------+-----+---------+-------+
//| Field        | Type         | Null | Key | Default | Extra |
//+--------------+--------------+------+-----+---------+-------+
//| type         | int(11)      | YES  |     | NULL    |       |
//| posttype     | int(11)      | YES  |     | NULL    |       |
//| postID       | int(11)      | YES  |     | NULL    |       |
//| commentID    | int(11)      | YES  |     | NULL    |       |
//| date         | varchar(35)  | YES  |     | NULL    |       |
//| userID       | int(11)      | YES  |     | NULL    |       |
//| text         | varchar(500) | YES  |     | NULL    |       |
//| img_filepath | varchar(300) | YES  |     | NULL    |       |
//+--------------+--------------+------+-----+---------+-------+