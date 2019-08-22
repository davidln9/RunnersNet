package com.david.runnersnet.auth;

import com.auth0.jwt.JWT;
import com.auth0.jwt.interfaces.DecodedJWT;
import org.springframework.security.core.GrantedAuthority;

import java.util.List;

import static com.auth0.jwt.algorithms.Algorithm.HMAC512;
import static com.david.runnersnet.auth.AuthConstants.SECRET;
import static com.david.runnersnet.auth.AuthConstants.TOKEN_PREFIX;

public class TokenDecoder {

    private String user;
    private List<GrantedAuthority> grantedAuthorities;

    private TokenDecoder() {
    }

    public String getUser() {
        return this.user;
    }

    public List<GrantedAuthority> getGrantedAuthorities() {
        return this.grantedAuthorities;
    }

    private void setGrantedAuthorities(List<GrantedAuthority> grantedAuthorities) {
        this.grantedAuthorities = grantedAuthorities;
    }

    private void setUser(String user) {
        this.user = user;
    }

    public static TokenDecoder decode(String token) {

        DecodedJWT decodedJWT = JWT.require(HMAC512(SECRET.getBytes()))
                .build()
                .verify(token.replace(TOKEN_PREFIX, ""));

        String user = decodedJWT.getSubject();
        List<GrantedAuthority> rawAuthorities = AuthParser.parseAuthoritites(decodedJWT.getClaim("authorities").asString());

        TokenDecoder tokenDecoder = new TokenDecoder();

        tokenDecoder.setGrantedAuthorities(rawAuthorities);
        tokenDecoder.setUser(user);

        return tokenDecoder;
    }
}
