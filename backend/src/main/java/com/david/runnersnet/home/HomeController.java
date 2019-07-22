package com.david.runnersnet.home;

import com.david.runnersnet.logs.distance.Distance;
import com.david.runnersnet.logs.distance.DistanceRepository;
import com.david.runnersnet.user.UserEntity;
import com.david.runnersnet.user.UserLoggedIn;
import com.david.runnersnet.user.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
@RequestMapping("/home")
public class HomeController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    DistanceRepository distanceRepository;

    @GetMapping
    public ResponseEntity<List<Distance>> getHomePageContent() {
        UserEntity user = userRepository.findByUsername(UserLoggedIn.getInstance().getUsername());

        List<Distance> runs = distanceRepository.findByUserID(user.getCryptID());
        return ResponseEntity.ok(runs);
    }
}
