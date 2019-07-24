package com.david.runnersnet.misc.likes;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface LikeRepository extends CrudRepository<Like, Integer> {

    @Query(value = "SELECT * FROM likes WHERE posttype = :posttype AND postID = :postID", nativeQuery = true)
    List<Like> findAll(@Param("posttype") int posttype, @Param("postID") int postID);

    @Query(value = "SELECT * FROM likes WHERE posttype = :posttype", nativeQuery = true)
    List<Like> findAll(@Param("posttype") int posttype);

    List<Like> findAll();
}
