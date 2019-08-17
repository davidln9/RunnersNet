package com.david.runnersnet.logs.Speed;

import com.david.runnersnet.logs.Composite;
import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface SpeedRepository extends CrudRepository<Speed, Integer> {

    List<Composite> findByUserID(int userID);
}
