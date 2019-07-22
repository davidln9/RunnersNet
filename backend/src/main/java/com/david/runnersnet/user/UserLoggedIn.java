package com.david.runnersnet.user;

public class UserLoggedIn {
    private static UserLoggedIn ourInstance = new UserLoggedIn();

    public static UserLoggedIn getInstance() {
        return ourInstance;
    }

    private UserLoggedIn() {
    }

    private String username;

    public void setUsername(String username) {
        this.username = username;
    }

    public String getUsername() {
        return this.username;
    }
}
