package com.david.runnersnet.home;

import com.david.runnersnet.auth.TokenDecoder;
import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.users.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestHeader;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
@RequestMapping("/api/homefeed")
public class HomeController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    HomeBuilder homeBuilder;

    @GetMapping
    public ResponseEntity<List<Composite>> getHomePageContent(@RequestHeader("Authorization") String token) {

        return ResponseEntity.ok(homeBuilder.getHomeFeed(userRepository.findByEmail(TokenDecoder.decode(token).getUser())));
    }
}
