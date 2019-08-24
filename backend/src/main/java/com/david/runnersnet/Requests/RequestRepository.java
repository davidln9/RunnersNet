package com.david.runnersnet.Requests;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface RequestRepository extends CrudRepository<RequestEntity, Integer> {

    @Query(value = "SELECT * FROM friends WHERE person1 = ?1 OR person2 = ?2 AND status = 2", nativeQuery = true)
    List<RequestEntity> findAll(int person);

}
