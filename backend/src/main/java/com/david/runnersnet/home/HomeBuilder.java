package com.david.runnersnet.home;

import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.logs.LogBuilder;
import com.david.runnersnet.logs.Speed.SpeedRepository;
import com.david.runnersnet.logs.distance.DistanceRepository;
import com.david.runnersnet.logs.race.RaceRepository;
import com.david.runnersnet.misc.posts.PostRepository;
import com.david.runnersnet.users.UserEntity;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RestController;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

@RestController
public class HomeBuilder {

    @Autowired
    LogBuilder logBuilder;

    @Autowired
    DistanceRepository distanceRepository;

    @Autowired
    RaceRepository raceRepository;

    @Autowired
    SpeedRepository speedRepository;


    @Autowired
    PostRepository postRepository;

    public HomeBuilder() {
    }

    public List<Composite> getHomeFeed(UserEntity userEntity) {

        int cryptID = userEntity.getId();
        List<Composite> composites = new ArrayList<>();

        for (Composite composite : distanceRepository.findByUserID(cryptID)) {
            composites.add(composite);
        }

        for (Composite composite : raceRepository.findByUserID(cryptID)) {
            composites.add(composite);
        }

        for (Composite composite : speedRepository.findByUserID(cryptID)) {
            composites.add(composite);
        }

        for (Composite post : postRepository.findByUserID(cryptID)) {
            composites.add(post);
        }

        for (UserEntity friend : userEntity.getFriends()) {

            for (Composite composite : distanceRepository.findByUserID(friend.getId())) {
                composites.add(composite);
            }
            for (Composite composite : raceRepository.findByUserID(friend.getId())) {
                composites.add(composite);
            }
            for (Composite composite : speedRepository.findByUserID(friend.getId())) {
                composites.add(composite);
            }
            for (Composite post : postRepository.findByUserID(friend.getId())) {
                composites.add(post);
            }
        }


        logBuilder.setCompositeList(composites);
        logBuilder.addLikesAndCommentsMany();

        Collections.sort(composites);
        return composites;
    }
}
