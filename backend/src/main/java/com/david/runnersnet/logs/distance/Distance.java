package com.david.runnersnet.logs.distance;

import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.likes.Like;

import javax.persistence.*;
import java.util.List;

@Entity
@Table(name = "distance")
public class Distance {

    @Id
    private int id;

    private int userID;

    @Column(name = "public")
    private int isPublic;

    private String date;
    private String location;
    private String team;
    private int intensity;
    private String journal;
    private String runtime;
    private String pace;
    private float distance;
    private Integer type = 0;

    @Column(nullable = true)
    private Integer shoe;

    @Transient
    List<Comment> comments;

    @Transient
    List<Like> likes;

    public Distance() {}

    public Distance(int userID, int isPublic, String date, String location,
                    String team, int intensity, String journal, String runtime,
                    String pace, float distance, int shoe) {
        this.userID = userID;
        this.isPublic = isPublic;
        this.date = date;
        this.location = location;
        this.team = team;
        this.intensity = intensity;
        this.journal = journal;
        this.runtime = runtime;
        this.pace = pace;
        this.distance = distance;
        this.shoe = shoe;
    }
    public int getType() {
        return type;
    }

    public int getUserID() {
        return userID;
    }

    public void setUserID(int userID) {
        this.userID = userID;
    }

    public int getIsPublic() {
        return isPublic;
    }

    public void setIsPublic(int isPublic) {
        this.isPublic = isPublic;
    }

    public String getDate() {
        return date;
    }

    public void setDate(String date) {
        this.date = date;
    }

    public String getLocation() {
        return location;
    }

    public void setLocation(String location) {
        this.location = location;
    }

    public String getTeam() {
        return team;
    }

    public void setTeam(String team) {
        this.team = team;
    }

    public int getIntensity() {
        return intensity;
    }

    public void setIntensity(int intensity) {
        this.intensity = intensity;
    }

    public String getJournal() {
        return journal;
    }

    public void setJournal(String journal) {
        this.journal = journal;
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

    public float getDistance() {
        return distance;
    }

    public void setDistance(float distance) {
        this.distance = distance;
    }

    public Integer getShoe() {
        return shoe;
    }

    public void setShoe(Integer shoe) {
        this.shoe = shoe;
    }

    public List<Comment> getComments() {
        return this.comments;
    }

    public void setComments(List<Comment> comments) {
        this.comments = comments;
    }

    public void setLikes(List<Like> likes) {
        this.likes = likes;
    }

    public List<Like> getLikes() {
        return this.likes;
    }

    public int getId() {
        return this.id;
    }


}

//        | type      | int(11)       | YES  |     | NULL    |       |
//        | userID    | int(11)       | YES  |     | NULL    |       |
//        | public    | int(11)       | YES  |     | NULL    |       |
//        | date      | varchar(19)   | YES  |     | NULL    |       |
//        | location  | varchar(100)  | YES  |     | NULL    |       |
//        | team      | varchar(100)  | YES  |     | NULL    |       |
//        | intensity | int(11)       | YES  |     | NULL    |       |
//        | journal   | varchar(2500) | YES  |     | NULL    |       |
//        | runtime   | varchar(8)    | YES  |     | NULL    |       |
//        | pace      | varchar(7)    | YES  |     | NULL    |       |
//        | id        | int(11)       | YES  |     | NULL    |       |
//        | distance  | float         | YES  |     | NULL    |       |
//        | shoe      | int(11)       | YES  |     | NULL
