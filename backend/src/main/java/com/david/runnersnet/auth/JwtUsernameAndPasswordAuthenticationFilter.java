package com.david.runnersnet.auth;

import com.auth0.jwt.JWT;
import com.david.runnersnet.users.UserEntity;
import com.david.runnersnet.users.UserRepository;
import com.david.runnersnet.users.UserService;
import com.fasterxml.jackson.databind.ObjectMapper;
import org.springframework.context.ApplicationContext;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.Authentication;
import org.springframework.security.core.AuthenticationException;
import org.springframework.security.core.userdetails.User;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.web.authentication.UsernamePasswordAuthenticationFilter;
import org.springframework.web.bind.annotation.CrossOrigin;

import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.Date;

import static com.auth0.jwt.algorithms.Algorithm.HMAC512;
import static com.david.runnersnet.auth.AuthConstants.*;

@CrossOrigin
public class JwtUsernameAndPasswordAuthenticationFilter extends UsernamePasswordAuthenticationFilter {

    private AuthenticationManager authManager;


    @Autowired
    UserService userService;

    @Autowired
    UserRepository userRepository;

    public JwtUsernameAndPasswordAuthenticationFilter(AuthenticationManager authManager, ApplicationContext ctx) {
        this.authManager = authManager;
        this.userService = ctx.getBean(UserService.class);
        this.userRepository = ctx.getBean(UserRepository.class);
    }


    @Override
    public Authentication attemptAuthentication(HttpServletRequest request, HttpServletResponse response) throws AuthenticationException {
        try {


            // 1. Get credentials from request
            UserEntity creds = new ObjectMapper().readValue(request.getInputStream(), UserEntity.class);

            // 2. Get details from the userService
            UserDetails userDetails = userService.loadUserByUsername(creds.getEmail());

            // 3. Authentication manager authenticate the user, and use UserDetialsServiceImpl::loadUserByUsername() method to load the user.
            return authManager.authenticate(new UsernamePasswordAuthenticationToken(
                    creds.getEmail(), creds.getPassword(), userDetails.getAuthorities()));
        } catch (IOException ex) {
            throw new RuntimeException(ex);
        }
    }

    // Upon successful authentication, generate a token.
    // The 'auth' passed to successfulAuthentication() is the current authenticated user.
    @Override
    protected void successfulAuthentication(HttpServletRequest request, HttpServletResponse response, FilterChain chain, Authentication auth) {
        String email = ((User)auth.getPrincipal()).getUsername();
        String firstName = userRepository.findByEmail(email).getFirst_name();
        String token = JWT.create()
                .withSubject(email)
                .withClaim("authorities",String.valueOf(((User)auth.getPrincipal()).getAuthorities()))
                .withExpiresAt(new Date(System.currentTimeMillis()+EXPIRATION_TIME))
                .sign(HMAC512(SECRET.getBytes()));
        response.addHeader(HEADER_STRING, TOKEN_PREFIX + token);
        // send the user's first name back as well
        response.addHeader("firstname", firstName);
    }


    @Override
    protected void unsuccessfulAuthentication(HttpServletRequest req, HttpServletResponse res, AuthenticationException failed) throws IOException, ServletException {
        super.unsuccessfulAuthentication(req, res, failed);
    }
}
