package com.david.runnersnet.logs.race;

import com.david.runnersnet.logs.Composite;
import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface RaceRepository extends CrudRepository<Race, Integer> {

    List<Composite> findByUserID(int userID);
}
