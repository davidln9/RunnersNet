package com.david.runnersnet.home;

import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.logs.LogBuilder;
import com.david.runnersnet.logs.Speed.SpeedRepository;
import com.david.runnersnet.logs.distance.DistanceRepository;
import com.david.runnersnet.logs.race.RaceRepository;
import com.david.runnersnet.user.*;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.List;

@RestController
@RequestMapping("/home")
public class HomeController {

    // all these autowired things!!!!
    @Autowired
    UserRepository userRepository;

    @Autowired
    HomeBuilder homeBuilder;

    @GetMapping
    public ResponseEntity<List<Composite>> getHomePageContent() {
        int cryptID = userRepository.findByUsername(UserLoggedIn.getInstance().getUsername()).getCryptID();

        return ResponseEntity.ok(homeBuilder.getHomeFeed(cryptID));
    }
}
