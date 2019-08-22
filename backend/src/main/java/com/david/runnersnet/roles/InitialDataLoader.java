package com.david.runnersnet.roles;

import com.david.runnersnet.users.UserEntity;
import com.david.runnersnet.users.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.context.ApplicationListener;
import org.springframework.context.event.ContextRefreshedEvent;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Component;

import org.springframework.transaction.annotation.Transactional;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

@Component
public class InitialDataLoader implements ApplicationListener<ContextRefreshedEvent> {

    boolean alreadySetup = false;

    @Autowired
    private UserRepository userRepository;

    @Autowired
    private RoleRepository roleRepository;

    @Autowired
    private PasswordEncoder passwordEncoder;

    public InitialDataLoader() {
    }

    @Override
    @Transactional
    public void onApplicationEvent(ContextRefreshedEvent event) {

        if (alreadySetup)
            return;

        createRoleIfNotFound("ROLE_ADMIN");
        createRoleIfNotFound("ROLE_USER");

        Role adminRole = roleRepository.findByName("ROLE_ADMIN");

        List<Role> grantedAuthorities = new ArrayList<>();
        grantedAuthorities.add(adminRole);

        UserEntity user = createAdminIfNotFound("test@test.com");
        user.setRoles(grantedAuthorities);
        userRepository.save(user);

        alreadySetup = true;
    }

    @Transactional
    private Role createRoleIfNotFound(String name) {

        Role role = roleRepository.findByName(name);
        if (role == null) {
            role = new Role(name);
            roleRepository.save(role);
        }
        return role;
    }

    /**
     * created 08/05 by David Edwards to prevent multiple
     * admin accounts from being created
     */
    @Transactional
    private UserEntity createAdminIfNotFound(String email) {


        userRepository.deleteByEmail(email);

        UserEntity user = new UserEntity();
        user.setFirst_name("Test");
        user.setLast_name("Test");
        user.setPassword(passwordEncoder.encode("test"));
        user.setEmail(email);

        return user;



    }
}
