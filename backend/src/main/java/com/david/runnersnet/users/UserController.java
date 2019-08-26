package com.david.runnersnet.users;

import com.david.runnersnet.auth.EmailExistsException;
import com.david.runnersnet.auth.TokenDecoder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.web.bind.annotation.*;

@CrossOrigin
@RestController
@RequestMapping("/api/user")
public class UserController {

    @Autowired
    UserRepository userRepository;

    @Autowired
    UserService userService;

    @GetMapping("/{email}")
    public ResponseEntity<UserEntity> getUserEntity(
            @RequestHeader("Authorization") String token,
            @PathVariable(value="email") String email) {
        UserEntity foundUserEntity = userRepository.findByEmail(email);

        TokenDecoder tokenDecoder = TokenDecoder.decode(token);

        // admins can get any user's info
        if (tokenDecoder.getGrantedAuthorities().contains(new SimpleGrantedAuthority("ROLE_ADMIN"))) {
            return ResponseEntity.ok().body(foundUserEntity);
        }

        // friends can see each other's info
        if (userRepository.findByEmail(tokenDecoder.getUser()).getFriends().contains(userRepository.findByEmail(email))) {
            return ResponseEntity.ok().body(foundUserEntity);
        }

        return ResponseEntity.badRequest()
                .header("message","You are not friends with this runner")
                .build();
    }

    @PostMapping("/register")
    public ResponseEntity<String> register(@RequestBody UserEntity userFragment) {

        try {
            String key = userService.registerNewUserAccount(userFragment);
            userService.sendUserSignupPassword(userFragment.getEmail(), key);
        } catch (EmailExistsException ex) {
            return ResponseEntity.badRequest().header("Message", "This email already exists!").build();
        }

        return ResponseEntity.ok("User created");
    }

    @PutMapping
    public ResponseEntity<UserEntity> updateUserEntity(
            @RequestHeader("Authorization") String token,
            @RequestBody UserEntity userEntity) {

        TokenDecoder tokenDecoder = TokenDecoder.decode(token);

        UserEntity foundUserEntity = userRepository.findByEmail(tokenDecoder.getUser());

        if (foundUserEntity == null) {
            return ResponseEntity.badRequest().header("message","No user found").build();
        }

        userService.updateUserAccount(userEntity, foundUserEntity);

        return ResponseEntity.ok(foundUserEntity);
    }
}
