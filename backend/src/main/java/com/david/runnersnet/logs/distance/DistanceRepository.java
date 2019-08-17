package com.david.runnersnet.logs.distance;

import com.david.runnersnet.logs.Composite;
import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface DistanceRepository extends CrudRepository<Distance, Integer> {

    public List<Composite> findByUserID(int userID);
    public Composite findById(int id);
}
