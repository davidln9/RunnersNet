package com.david.runnersnet.auth;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.boot.web.servlet.FilterRegistrationBean;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.Profile;
import org.springframework.core.Ordered;
import org.springframework.http.HttpMethod;
import org.springframework.security.config.annotation.web.builders.HttpSecurity;
import org.springframework.security.config.annotation.web.builders.WebSecurity;
import org.springframework.security.config.annotation.web.configuration.EnableWebSecurity;
import org.springframework.security.config.annotation.web.configuration.WebSecurityConfigurerAdapter;
import org.springframework.security.config.http.SessionCreationPolicy;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.cors.CorsConfiguration;
import org.springframework.web.cors.CorsConfigurationSource;
import org.springframework.web.cors.UrlBasedCorsConfigurationSource;
import org.springframework.web.filter.CorsFilter;

import javax.servlet.http.HttpServletResponse;
import javax.sql.DataSource;
import java.util.Arrays;

import static com.david.runnersnet.auth.AuthConstants.SIGN_UP_URL;


@CrossOrigin
@EnableWebSecurity
@Configuration
public class WebSecurityConfig extends WebSecurityConfigurerAdapter {


    @Autowired
    DataSource dataSource;

    @Bean
    public PasswordEncoder passwordEncoder() {
        return new BCryptPasswordEncoder();
    }

    // when unauthenticated:
    // allow GET requests /api/*, and allow POST requests to /api/user/register
    // allow nothing to /admin/*

    // when authenticated as USER
    // allow POST, PUT, DELETE requests to /api/*

    // when authenticated as ADMIN
    // allow all CRUD operations to every endpoint

    @Override
    protected void configure(HttpSecurity http) throws Exception {

        http
                .cors()
                .and()
                .csrf().disable()
                .authorizeRequests()
                .antMatchers(HttpMethod.POST, SIGN_UP_URL).permitAll()
                .antMatchers(HttpMethod.GET,"/api/**").permitAll() // anyone can read from api
                .antMatchers(HttpMethod.POST,"/api/shoppingcarts/**").permitAll()
                .antMatchers(HttpMethod.POST,"/api/shoppingcartitems/**").permitAll()
                .and()
                .addFilter(new JwtUsernameAndPasswordAuthenticationFilter(authenticationManager(), getApplicationContext()))
                .addFilter(new JwtAuthorizationFilter(authenticationManager(), getApplicationContext()))
                .authorizeRequests()
                .antMatchers(HttpMethod.POST,"/api/**").hasAnyRole("USER", "ADMIN") // user can post, put, delete
                .antMatchers(HttpMethod.PUT, "/api/**").hasAnyRole("USER", "ADMIN")
                .antMatchers(HttpMethod.GET,"/admin/**").hasRole("ADMIN") // only admin can read, write, update, delete from /admin/
                .antMatchers(HttpMethod.POST, "/admin/**").hasRole("ADMIN")
                .antMatchers(HttpMethod.PUT, "/admin/**").hasRole("ADMIN")
                .antMatchers(HttpMethod.DELETE, "/admin/**").hasRole("ADMIN")
                .anyRequest().authenticated()
                .and()
                .sessionManagement().sessionCreationPolicy(SessionCreationPolicy.STATELESS);
    }

//    @Override
//    public void configure(final WebSecurity web) {
//        web.ignoring().antMatchers(HttpMethod.OPTIONS);
//    }

    @Bean
    public FilterRegistrationBean processCorsFilter() {
        final UrlBasedCorsConfigurationSource source = new UrlBasedCorsConfigurationSource();
        final CorsConfiguration config = new CorsConfiguration();
        config.setAllowCredentials(true);
        config.addAllowedOrigin("http://localhost:3000");
        config.setAllowedHeaders(Arrays.asList("*"));
        config.addAllowedMethod("*");
        config.setExposedHeaders(Arrays.asList("Authorization", "Access-Control-Allow-Origin",
                "Access-Control-Allow-Methods", "Access-Control-Max-Age", "Access-Control-Allow-Headers",
                "Access-Control-Expose-Headers", "Location", "firstname"));
        source.registerCorsConfiguration("/**", config);


        final FilterRegistrationBean bean = new FilterRegistrationBean(new CorsFilter(source));
        bean.setOrder(Ordered.HIGHEST_PRECEDENCE);
        return bean;
    }



//    @Bean
//    CorsConfigurationSource corsConfigurationSource() {
//        final UrlBasedCorsConfigurationSource source = new UrlBasedCorsConfigurationSource();
//        CorsConfiguration corsConfig = new CorsConfiguration();
//
//        corsConfig.setAllowCredentials(true);
//        /*
//         * corsConfig.applyPermitDefaultValues();
//         * Allow all origins.
//         * Allow "simple" methods GET, HEAD and POST.
//         * Allow all headers.
//         * */
//        corsConfig.applyPermitDefaultValues();
////        corsConfig.addAllowedMethod("PUT");
////        corsConfig.addAllowedMethod("DELETE");
////        corsConfig.addAllowedMethod("GET");
////        corsConfig.addAllowedMethod("POST");
//        corsConfig.addAllowedHeader("*");
//        corsConfig.addAllowedMethod("*");
//        corsConfig.addAllowedOrigin("*");
//
//        corsConfig.setExposedHeaders(Arrays.asList("Authorization"));
//        source.registerCorsConfiguration("/**", corsConfig);
//        return source;
//    }
}