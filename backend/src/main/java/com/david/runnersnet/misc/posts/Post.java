package com.david.runnersnet.misc.posts;

import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.likes.Like;
import sun.java2d.pipe.SpanShapeRenderer;

import javax.persistence.*;
import java.util.List;

@Entity
@Table(name = "posts")
public class Post implements Composite {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    @Column(name = "userID")
    private int userID;

    private String date;
    private String text;
    private String img_filepath;
    private int type;

    @Transient
    private List<Comment> comments;

    @Transient
    private List<Like> likes;

    public Post() {}

    public Integer getId() {
        return id;
    }

    @Override
    public Integer getPosttype() {
        return this.type;
    }

    @Override
    public void setComments(List<Comment> comments) {

        this.comments = comments;
    }

    @Override
    public void setLikes(List<Like> likes) {
        this.likes = likes;
    }

    @Override
    public List<Comment> getComments() {
        return this.comments;
    }

    @Override
    public List<Like> getLikes() {
        return this.likes;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getUserID() {
        return userID;
    }

    public void setUserID(int userID) {
        this.userID = userID;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
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

    @Override
    public int compareTo(Composite o) {
        return 0;
    }
}

//| type         | int(11)       | YES  |     | NULL    |       |
//| userID       | int(11)       | YES  |     | NULL    |       |
//| id           | int(11)       | YES  |     | NULL    |       |
//| date         | varchar(35)   | YES  |     | NULL    |       |
//| text         | varchar(1500) | YES  |     | NULL    |       |
//| img_filepath | varchar(300)  | YES  |     | NULL    |       |