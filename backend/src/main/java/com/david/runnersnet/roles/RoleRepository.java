package com.david.runnersnet.roles;

import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface RoleRepository extends CrudRepository<Role, Integer> {

    List<Role> findAll();
    Role findByName(String name);
}
