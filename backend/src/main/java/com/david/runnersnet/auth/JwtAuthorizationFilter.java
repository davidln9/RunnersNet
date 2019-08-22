package com.david.runnersnet.auth;

import com.david.runnersnet.users.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationContext;
import org.springframework.security.authentication.AuthenticationManager;
import org.springframework.security.authentication.UsernamePasswordAuthenticationToken;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.context.SecurityContextHolder;
import org.springframework.security.web.authentication.www.BasicAuthenticationFilter;
import org.springframework.transaction.annotation.Transactional;
import org.springframework.web.bind.annotation.CrossOrigin;

import javax.servlet.FilterChain;
import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.List;

import static com.auth0.jwt.algorithms.Algorithm.HMAC512;
import static com.david.runnersnet.auth.AuthConstants.*;

/**
 *  Verify if a user is allowed (authorized) to make a request
 */
@Transactional
@CrossOrigin
public class JwtAuthorizationFilter extends BasicAuthenticationFilter {


    public JwtAuthorizationFilter(AuthenticationManager authenticationManager, ApplicationContext ctx) {
        super(authenticationManager);
        userRepository = ctx.getBean(UserRepository.class);
    }

    @Autowired
    UserRepository userRepository;
    /**
     * Filter the request with Authorization header only
     * @param req HTTP Request
     * @param res HTTP Response
     * @param chain
     * @throws IOException
     * @throws ServletException
     */
    @Override
    @Transactional
    protected void doFilterInternal(HttpServletRequest req, HttpServletResponse res, FilterChain chain) throws IOException, ServletException {

        String header = req.getHeader(HEADER_STRING);
        res.setHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
        res.setHeader("Access-Control-Max-Age", "3600");
        res.setHeader("Access-Control-Allow-Headers", "Authorization, Origin, " +
                "X-Requested-With, Content-Type, Accept");
        res.addHeader("Access-Control-Expose-Headers", HEADER_STRING);

        if (req.getMethod().equals("OPTIONS")) {
            res.setStatus(HttpServletResponse.SC_OK);
            return;
        }

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

        TokenDecoder tokenDecoder = TokenDecoder.decode(token);
        String user = tokenDecoder.getUser();
        List<GrantedAuthority> grantedAuthorities = tokenDecoder.getGrantedAuthorities();

        if (user != null) {

            return new UsernamePasswordAuthenticationToken(
                    user,
                    null,
                    grantedAuthorities
            );
        }
        return null;

    }
}
