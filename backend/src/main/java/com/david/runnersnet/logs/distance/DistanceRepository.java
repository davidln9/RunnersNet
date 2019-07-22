package com.david.runnersnet.logs.distance;

import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface DistanceRepository extends CrudRepository<Distance, Integer> {

    public List<Distance> findByUserID(int userID);
    public Distance findById(int id);
}
