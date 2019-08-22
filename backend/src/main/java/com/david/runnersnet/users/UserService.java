package com.david.runnersnet.users;


import com.david.runnersnet.auth.EmailExistsException;
import com.david.runnersnet.roles.Role;
import com.david.runnersnet.roles.RoleRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.security.core.GrantedAuthority;
import org.springframework.security.core.authority.SimpleGrantedAuthority;
import org.springframework.security.core.userdetails.UserDetails;
import org.springframework.security.core.userdetails.UserDetailsService;
import org.springframework.security.core.userdetails.UsernameNotFoundException;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;


import java.text.SimpleDateFormat;
import java.util.*;

@Service
public class UserService implements UserDetailsService {
    @Autowired
    private UserRepository userRepository;

    @Autowired
    private PasswordEncoder passwordEncoder;

    @Autowired
    RoleRepository roleRepository;

    /**
     *  Get and encrypt password from a new user and then save it to  userRepository
     * @param newUser the registration info from a nuew user
     * @return userdetails include username, password, and roles
     */
    public org.springframework.security.core.userdetails.User save(UserEntity newUser) {
        newUser.setPassword(passwordEncoder.encode(newUser.getPassword()));
        UserEntity savedUser = userRepository.save(newUser);
        return new org.springframework.security.core.userdetails.User(savedUser.getEmail(), savedUser.getPassword(), getAuthorities());
    }

    private List<SimpleGrantedAuthority> getAuthorities() {
        List<SimpleGrantedAuthority> authList = new ArrayList<>();
        authList.add(new SimpleGrantedAuthority("ROLE_USER"));
        return authList;
    }

    @Override
    @Transactional
    public UserDetails loadUserByUsername(String email) {
        UserEntity user = userRepository.findByEmail(email);
        if (user == null){
            throw new UsernameNotFoundException(email);
        }
        return new org.springframework.security.core.userdetails.User(user.getEmail(), user.getPassword(), getGrantedAuthorities(user.getRoles()));
    }

    private List<GrantedAuthority> getGrantedAuthorities(Collection<Role> roles) {
        List<GrantedAuthority> authorities = new ArrayList<>();

        for (Role role : roles) {
            authorities.add(new SimpleGrantedAuthority(role.getName()));
        }

        return authorities;
    }

    public void registerNewUserAccount(UserEntity accountDto) throws EmailExistsException {

        if (userRepository.findByEmail(accountDto.getEmail()) != null) {
            throw new EmailExistsException
                    ("There is an account with that email address: " + accountDto.getEmail());
        }
        UserEntity user = new UserEntity();

        user.setFirst_name(accountDto.getFirst_name());
        user.setLast_name(accountDto.getLast_name());
        user.setPassword(accountDto.getPassword());
        user.setEmail(accountDto.getEmail());
        user.setGender(accountDto.getGender());
        user.setDateOfBirth(accountDto.getDateOfBirth());

        Role role = roleRepository.findByName("ROLE_USER");
        user.setRoles(Arrays.asList(role));
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");

        // store today's date in mysql datetime format
        user.setDate_created(sdf.format(new Date()));
        save(user);
    }

    public void updateUserAccount(UserEntity userEntity, UserEntity foundUserEntity) {

        boolean passwordNeedsEncryption = true;

        if(userEntity.getFirst_name() == null || userEntity.getFirst_name().equals("")){
            userEntity.setFirst_name(foundUserEntity.getFirst_name());
        }
        if(userEntity.getLast_name() == null || userEntity.getLast_name().equals("")){
            userEntity.setLast_name(foundUserEntity.getLast_name());
        }
        if(userEntity.getEmail() == null || userEntity.getEmail().equals("")){
            userEntity.setEmail(foundUserEntity.getEmail());
        }
        if(userEntity.getPassword() == null || userEntity.getPassword().equals("")){
            userEntity.setPassword(foundUserEntity.getPassword());
            passwordNeedsEncryption = false;
        }
        if(userEntity.getGender() == null || userEntity.getGender().equals("")){
            userEntity.setGender(foundUserEntity.getGender());
        }
        if(userEntity.getDateOfBirth() == null || userEntity.getDateOfBirth().equals("")){
            userEntity.setDateOfBirth(foundUserEntity.getDateOfBirth());
        }

        if (passwordNeedsEncryption) {
            foundUserEntity.setPassword(passwordEncoder.encode(userEntity.getPassword()));
        }

        if(userEntity.getPhoneNumber() == null || userEntity.getPhoneNumber().equals("")){
            userEntity.setPhoneNumber(foundUserEntity.getPhoneNumber());
        }
        if(userEntity.getCountry() == null || userEntity.getCountry().equals("")){
            userEntity.setCountry(foundUserEntity.getCountry());
        }
        if(userEntity.getZipcode() == null || userEntity.getZipcode().equals("")){
            userEntity.setZipcode(foundUserEntity.getZipcode());
        }


        foundUserEntity.setFirst_name(userEntity.getFirst_name());
        foundUserEntity.setLast_name(userEntity.getLast_name());
        foundUserEntity.setEmail(userEntity.getEmail());
        foundUserEntity.setGender(userEntity.getGender());
        foundUserEntity.setDateOfBirth(userEntity.getDateOfBirth());
        foundUserEntity.setPhoneNumber(userEntity.getPhoneNumber());
        foundUserEntity.setCountry(userEntity.getCountry());
        foundUserEntity.setZipcode(userEntity.getZipcode());
        foundUserEntity.setForgotPassword();

        userRepository.save(foundUserEntity);
    }

}
