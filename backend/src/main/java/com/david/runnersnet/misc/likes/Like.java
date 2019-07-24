package com.david.runnersnet.misc.likes;

import javax.persistence.*;
//+----------+-------------+------+-----+---------+-------+
//| Field    | Type        | Null | Key | Default | Extra |
//+----------+-------------+------+-----+---------+-------+
//| posttype | int(11)     | YES  |     | NULL    |       |
//| postID   | int(11)     | YES  |     | NULL    |       |
//| posterID | int(11)     | YES  |     | NULL    |       |
//| likerID  | int(11)     | YES  |     | NULL    |       |
//| date     | varchar(35) | YES  |     | NULL    |       |
//+----------+-------------+------+-----+---------+-------+

@Entity
@Table(name = "likes")
public class Like {

    @Transient
    String objString;

    @Id
    private int id;

    private int posttype;
    private int postID;
    @Column(name = "posterID")
    private int posterID;
    @Column(name = "likerID")
    private int likerID;
    private String date;

    public Like() {}

    public void setId(int id) {
        this.id = id;
    }

    public int getId() {
        return this.id;
    }

    public void setPosttype(int posttype) {
        this.posttype = posttype;
    }

    public int getPosttype() {
        return this.posttype;
    }

    public void setPostID(int postID) {
        this.postID = postID;
    }

    public int getPostID() {
        return this.postID;
    }

    public int getPosterID() {
        return posterID;
    }

    public void setPosterID(int posterID) {
        this.posterID = posterID;
    }

    public int getLikerID() {
        return likerID;
    }

    public void setLikerID(int likerID) {
        this.likerID = likerID;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public void setObjString(String objString) {
        this.objString = objString;
    }

    public String getObjString() {
        return this.toString();
    }
}
