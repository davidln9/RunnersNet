package com.david.runnersnet.user;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;
import java.util.Random;

@RestController
@RequestMapping("/api/user")
public class UserController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    UserService userService;

    @PostMapping("/register")
    public ResponseEntity<UserFragment> register(@RequestBody UserFragment userFragment) {
        UserEntity searchedUser = userRepository.findByUsername(userFragment.getUsername());

        if (searchedUser != null) {
            return ResponseEntity.badRequest().header("Message", "UserEntity already exists!").build();
        }

        int cryptID;
        do {
            cryptID = Math.abs(new Random(System.currentTimeMillis()).nextInt() % 1000000000);

            searchedUser = userRepository.findByCryptID(cryptID);

        } while (searchedUser != null);


        UserEntity realUser = new UserEntity(userFragment.getUsername(), userFragment.getPassword(), cryptID);
        userService.save(realUser);

        return ResponseEntity.ok(null);
    }

}
