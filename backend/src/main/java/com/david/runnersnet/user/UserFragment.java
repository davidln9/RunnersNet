package com.david.runnersnet.user;

// not an entity
// this is what is submitted from the front end and then the backend adds the cryptID to the bean object
public class UserFragment {

    private String password;

    private String username;


    public UserFragment() {}

    public UserFragment(String email, String password) {
        this.setUsername(email);
        this.setPassword(password);
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
}
