package com.david.runnersnet.Requests;

import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface RequestRepository extends CrudRepository<RequestEntity, Integer> {

    List<RequestEntity> findBySender(int sender);
    List<RequestEntity> findByReceiver(int receiver);
}
