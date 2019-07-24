package com.david.runnersnet.misc.comments;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;

import java.util.List;

public interface CommentRepository extends CrudRepository<Comment, Integer> {

    @Query(value = "SELECT * FROM comments WHERE posttype = :posttype AND postID = :postID", nativeQuery = true)
    List<Comment> findAll(@Param("posttype") int posttype, @Param("postID") int postID);

    @Query(value = "SELECT * FROM comments WHERE posttype = :posttype", nativeQuery = true)
    List<Comment> findAll(@Param("posttype") int posttype);

    List<Comment> findAll();
}
