package com.david.runnersnet.home;

import com.david.runnersnet.logs.Composite;
import com.david.runnersnet.logs.LogBuilder;
import com.david.runnersnet.logs.Speed.SpeedRepository;
import com.david.runnersnet.logs.distance.DistanceRepository;
import com.david.runnersnet.logs.race.RaceRepository;
import com.david.runnersnet.misc.posts.PostRepository;
import com.david.runnersnet.user.Friend;
import com.david.runnersnet.user.FriendRepository;
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
    FriendRepository friendRepository;

    @Autowired
    PostRepository postRepository;

    public HomeBuilder() {
    }

    public List<Composite> getHomeFeed(int cryptID) {
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

        for (Object friend : friendRepository.findFriends(cryptID)) {
            Friend f = (Friend)friend;
            if (f.getPerson1() != cryptID) {
                for (Composite composite : distanceRepository.findByUserID(f.getPerson1())) {
                    composites.add(composite);
                }
                for (Composite composite : raceRepository.findByUserID(f.getPerson1())) {
                    composites.add(composite);
                }
                for (Composite composite : speedRepository.findByUserID(f.getPerson1())) {
                    composites.add(composite);
                }
                for (Composite post : postRepository.findByUserID(f.getPerson1())) {
                    composites.add(post);
                }
            } else {
                for (Composite composite : distanceRepository.findByUserID(f.getPerson2())) {
                    composites.add(composite);
                }
                for (Composite composite : raceRepository.findByUserID(f.getPerson2())) {
                    composites.add(composite);
                }
                for (Composite composite : speedRepository.findByUserID(f.getPerson2())) {
                    composites.add(composite);
                }
                for (Composite post : postRepository.findByUserID(f.getPerson2())) {
                    composites.add(post);
                }
            }
        }


        logBuilder.setCompositeList(composites);
        logBuilder.addLikesAndCommentsMany();

        composites = logBuilder.getCompositeList();

        Collections.sort(composites);
        return composites;
    }
}
