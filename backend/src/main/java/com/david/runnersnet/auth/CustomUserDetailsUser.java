package com.david.runnersnet.auth;


import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.userdetails.User;
import java.util.Collection;

public class CustomUserDetailsUser extends User {

    private int userId;

    public CustomUserDetailsUser(String username, String password, Collection<? extends GrantedAuthority> authorities, int userId) {
        super(username, password, authorities);
        setUserId(userId);
    }

    public int getUserId() {
        return userId;
    }

    public void setUserId(int userId) {
        this.userId = userId;
    }
}
