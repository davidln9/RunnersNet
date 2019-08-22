package com.david.runnersnet.users;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;

import java.util.List;
import java.util.Optional;

public interface UserRepository extends CrudRepository<UserEntity, Integer> {

    List<UserEntity> findAll();
    UserEntity findByEmail(String email);

    void deleteByEmail(String email);
}
