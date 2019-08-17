package com.david.runnersnet.logs.Speed;

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
@Table(name = "speed")
public class Speed implements Composite {

    @Id
    private Integer id;

    private Integer userID;
    private String location;
    private String date;
    private String description;
    private Float distance;
    private String team;
    private String journal;
    private Integer privacy;
    private Float warmup;
    private Float cooldown;
    private Float workout;

    public void setId(Integer id) {
        this.id = id;
    }

    public Integer getUserID() {
        return userID;
    }

    public void setUserID(Integer userID) {
        this.userID = userID;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public Float getDistance() {
        return distance;
    }

    public void setDistance(Float distance) {
        this.distance = distance;
    }

    public String getTeam() {
        return team;
    }

    public void setTeam(String team) {
        this.team = team;
    }

    public String getJournal() {
        return journal;
    }

    public void setJournal(String journal) {
        this.journal = journal;
    }

    public Integer getPrivacy() {
        return privacy;
    }

    public void setPrivacy(Integer privacy) {
        this.privacy = privacy;
    }

    public Float getWarmup() {
        return warmup;
    }

    public void setWarmup(Float warmup) {
        this.warmup = warmup;
    }

    public Float getCooldown() {
        return cooldown;
    }

    public void setCooldown(Float cooldown) {
        this.cooldown = cooldown;
    }

    public Float getWorkout() {
        return workout;
    }

    public void setWorkout(Float workout) {
        this.workout = workout;
    }



    @Transient
    private List<Like> likes;

    @Transient
    private List<Comment> comments;

    public Speed() {}

    @Override
    public Integer getId() {
        return this.id;
    }

    @Override
    public Integer getPosttype() {
        return 1;
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

    @Override
    public int compareTo(Composite o) {
        return CompareUtil.getComparison(this.getDate(), o.getDate());
    }
}

//+-------------+---------------+------+-----+---------+-------+
//| Field       | Type          | Null | Key | Default | Extra |
//+-------------+---------------+------+-----+---------+-------+
//| type        | int(11)       | YES  |     | NULL    |       |
//| id          | int(11)       | YES  |     | NULL    |       |
//| userID      | int(11)       | YES  |     | NULL    |       |
//| location    | varchar(300)  | YES  |     | NULL    |       |
//| date        | varchar(33)   | YES  |     | NULL    |       |
//| description | varchar(500)  | YES  |     | NULL    |       |
//| distance    | float         | YES  |     | NULL    |       |
//| team        | varchar(300)  | YES  |     | NULL    |       |
//| journal     | varchar(5000) | YES  |     | NULL    |       |
//| privacy     | int(11)       | YES  |     | NULL    |       |
//| warmup      | float         | YES  |     | NULL    |       |
//| cooldown    | float         | YES  |     | NULL    |       |
//| workout     | float         | YES  |     | NULL    |       |
//+-------------+---------------+------+-----+---------+-------+