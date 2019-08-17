package com.david.runnersnet.misc.likes;

import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface LikeRepository extends CrudRepository<Like, Integer> {

    List<Like> findAll();
}
