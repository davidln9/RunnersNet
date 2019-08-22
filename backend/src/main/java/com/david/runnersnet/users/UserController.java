package com.david.runnersnet.users;

import com.auth0.jwt.JWT;
import com.auth0.jwt.interfaces.DecodedJWT;
import com.david.runnersnet.auth.EmailExistsException;
import com.david.runnersnet.auth.TokenDecoder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.web.bind.annotation.*;

import java.util.List;

import static com.auth0.jwt.algorithms.Algorithm.HMAC512;
import static com.david.runnersnet.auth.AuthConstants.SECRET;
import static com.david.runnersnet.auth.AuthConstants.TOKEN_PREFIX;

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
            userService.registerNewUserAccount(userFragment);
        } catch (EmailExistsException ex) {
            return ResponseEntity.badRequest().header("Message", "This email already exists!").build();
        }

        return ResponseEntity.ok("User created");
    }

    @GetMapping("/register")
    public String getMap() {
        System.out.println("here");
        return "yes";
    }

    @PutMapping("/{email}")
    public ResponseEntity<UserEntity> updateUserEntity(
            @RequestHeader("Authorization") String token,
            @PathVariable (value= "email") String email,
            @RequestBody UserEntity userEntity)  {

        /*
            Must verify email before performing these changes to the user
         */

        TokenDecoder tokenDecoder = TokenDecoder.decode(token);

        if (!tokenDecoder.getUser().equals(email)) {
            return ResponseEntity.status(HttpStatus.FORBIDDEN)
                    .header("Message","Unauthorized to change that account")
                    .build();
        }

        UserEntity foundUserEntity = userRepository.findByEmail(tokenDecoder.getUser());
        userService.updateUserAccount(userEntity, foundUserEntity);

        return ResponseEntity.ok(foundUserEntity);
    }
}
