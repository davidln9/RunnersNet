package com.david.runnersnet.auth;

import com.auth0.jwt.JWT;
import com.david.runnersnet.user.UserLoggedIn;
import com.david.runnersnet.user.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.web.authentication.www.BasicAuthenticationFilter;

import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import java.io.IOException;
import java.util.ArrayList;

import static com.auth0.jwt.algorithms.Algorithm.HMAC512;
import static com.david.runnersnet.auth.AuthConstants.*;

/**
 *  Verify if a user is allowed (authorized) to make a request
 */
public class JwtAuthorizationFilter extends BasicAuthenticationFilter {

    @Autowired
    UserRepository userRepository;

    public JwtAuthorizationFilter(AuthenticationManager authenticationManager) {
        super(authenticationManager);
    }

    /**
     * Filter the request with Authorization header only
     * @param req HTTP Request
     * @param res HTTP Response
     * @param chain
     * @throws IOException
     * @throws ServletException
     */
    @Override
    protected void doFilterInternal(HttpServletRequest req, HttpServletResponse res, FilterChain chain) throws IOException, ServletException {
        String header = req.getHeader(HEADER_STRING);
        if (header == null || !header.startsWith(TOKEN_PREFIX)) {
            chain.doFilter(req, res);
            return;
        }
        UsernamePasswordAuthenticationToken authentication = getAuthentication(req);
        SecurityContextHolder.getContext().setAuthentication(authentication);
        chain.doFilter(req, res);
    }

    /**
     *  Vefify the token in a request
     * @param request HTTP request
     * @return a token simply presents username and password
     */
    private UsernamePasswordAuthenticationToken getAuthentication(HttpServletRequest request) {
        String token = request.getHeader(HEADER_STRING);
        if (token == null)
            return null;
        String user = JWT.require(HMAC512(SECRET.getBytes()))
                .build()
                .verify(token.replace(TOKEN_PREFIX, ""))
                .getSubject();

        if (user != null) {
            UserLoggedIn.getInstance().setUsername(user);
            return new UsernamePasswordAuthenticationToken(user, null, new ArrayList<>());
        }
        return null;

    }
}
