package com.david.runnersnet.logs.distance;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

@RestController
@RequestMapping("/distance")
public class DistanceController {

    @Autowired
    DistanceRepository distanceRepository;

    @Autowired
    DistanceBuilder distanceBuilder;

    @GetMapping("/{id}")
    public ResponseEntity getDistance(@PathVariable(value = "id", required = true) int id) {

        Distance distance = distanceRepository.findById(id);

        distanceBuilder.setDistance(distance);
        try {
            distanceBuilder.addLikesAndComments();
        } catch (NullPointerException ex) {
            ex.printStackTrace();
            return ResponseEntity.status(HttpStatus.BAD_REQUEST)
                    .body("No distance with id: " + id + " found");
        }

        return ResponseEntity.ok(distanceBuilder.getDistance());
    }
}
