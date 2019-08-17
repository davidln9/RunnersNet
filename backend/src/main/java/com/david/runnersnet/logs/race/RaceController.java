package com.david.runnersnet.logs.race;

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
@RequestMapping("/race")
public class RaceController {

    @Autowired
    RaceRepository raceRepository;

    @Autowired
    UserRepository userRepository;


}
