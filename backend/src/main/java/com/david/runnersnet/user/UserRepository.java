package com.david.runnersnet.user;


import org.springframework.data.repository.CrudRepository;

public interface UserRepository extends CrudRepository<UserEntity, Integer> {

    public UserEntity findByUsername(String username);
    public UserEntity findByCryptID(int cryptID);
}
