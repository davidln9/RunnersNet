package com.david.runnersnet.user;

import javax.persistence.Entity;
import javax.persistence.Id;
import javax.persistence.Table;
import javax.persistence.Transient;
import java.util.List;

@Entity
@Table(name = "useraccount")
public class UserEntity {

    @Id
    private int cryptID;

    private String password;

    private String username;

    @Transient
    private List<UserEntity> friends;


    public UserEntity() {}

    public UserEntity(String username, String password, int cryptID) {
        this.setUsername(username);
        this.setPassword(password);
        this.setCryptID(cryptID);
    }

    public String getUsername() {
        return this.username;
    }

    public String getPassword() {
        return this.password;
    }

    public void setUsername(String username) {
        this.username = username;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public void setCryptID(int cryptID) {
        this.cryptID = cryptID;
    }
    public int getCryptID() {
        return this.cryptID;
    }

    public void setFriends(List<UserEntity> friends) {
        this.friends = friends;
    }

    public List<UserEntity> getFriends() {
        return this.friends;
    }

}
