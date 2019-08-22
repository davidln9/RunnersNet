package com.david.runnersnet.auth;

import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;

import java.util.ArrayList;
import java.util.List;

public class AuthParser {

    public static List<GrantedAuthority> parseAuthoritites(String raw) {

        int state = 0;
        String currAuth = "";
        List<GrantedAuthority> authorities = new ArrayList<>();
        for (int i = 1; i < raw.length() - 1; i++) {
            if (raw.charAt(i) == ',') {
                authorities.add(new SimpleGrantedAuthority(currAuth));
                currAuth = "";
            } else {
                currAuth += raw.charAt(i);
            }
        }

        authorities.add(new SimpleGrantedAuthority(currAuth));
        return authorities;
    }
}
