package com.david.runnersnet.logs.race;

import com.david.runnersnet.logs.CompareUtil;
import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.likes.Like;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Transient;
import java.util.List;

@Entity
@Table(name = "races")
public class Race implements Composite {

    @Id
    private Integer id;
    private Integer type = 2;
    private Integer userID;
    private String date;
    private Float distance;
    private String location;
    private String racename;
    private Integer relay;
    private String runtime;
    private String pace;
    private String journal;

    private Integer posttype = 2;

    @Transient
    List<Like> likes;

    @Transient
    List<Comment> comments;

    public Race() { }

    public Integer getId() {
        return this.id;
    }

    @Override
    public Integer getPosttype() {
        return 2;
    }

    @Override
    public void setComments(List<Comment> comments) {
        this.comments = comments;
    }

    @Override
    public void setLikes(List<Like> likes) {
        this.likes = likes;
    }

    public List<Comment> getComments() {
        return this.comments;
    }

    public List<Like> getLikes() {
        return this.likes;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getType() {
        return type;
    }

    public void setType(Integer type) {
        this.type = type;
    }

    public Integer getUserID() {
        return userID;
    }

    public void setUserID(Integer userID) {
        this.userID = userID;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public Float getDistance() {
        return distance;
    }

    public void setDistance(Float distance) {
        this.distance = distance;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public String getRacename() {
        return racename;
    }

    public void setRacename(String racename) {
        this.racename = racename;
    }

    public Integer getRelay() {
        return relay;
    }

    public void setRelay(Integer relay) {
        this.relay = relay;
    }

    public String getRuntime() {
        return runtime;
    }

    public void setRuntime(String runtime) {
        this.runtime = runtime;
    }

    public String getPace() {
        return pace;
    }

    public void setPace(String pace) {
        this.pace = pace;
    }

    public String getJournal() {
        return journal;
    }

    public void setJournal(String journal) {
        this.journal = journal;
    }


    @Override
    public int compareTo(Composite o) {
        return CompareUtil.getComparison(this.getDate(), o.getDate());
    }
}

//+----------+---------------+------+-----+---------+-------+
//| Field    | Type          | Null | Key | Default | Extra |
//+----------+---------------+------+-----+---------+-------+
//| type     | int(11)       | YES  |     | NULL    |       |
//| userID   | int(11)       | YES  |     | NULL    |       |
//| id       | int(11)       | YES  |     | NULL    |       |
//| date     | varchar(19)   | YES  |     | NULL    |       |
//| distance | float         | YES  |     | NULL    |       |
//| location | varchar(100)  | YES  |     | NULL    |       |
//| racename | varchar(50)   | YES  |     | NULL    |       |
//| relay    | int(11)       | YES  |     | NULL    |       |
//| runtime  | varchar(8)    | YES  |     | NULL    |       |
//| pace     | varchar(8)    | YES  |     | NULL    |       |
//| journal  | varchar(5000) | YES  |     | NULL    |       |
//+----------+---------------+------+-----+---------+-------+
