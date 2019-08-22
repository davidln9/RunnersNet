package com.david.runnersnet.logs.race;

import com.david.runnersnet.users.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/race")
public class RaceController {

    @Autowired
    RaceRepository raceRepository;

    @Autowired
    UserRepository userRepository;

}
