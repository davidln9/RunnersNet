package com.david.runnersnet.misc.posts;

import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface PostRepository extends CrudRepository<Post, Integer> {

    Post findById(int id);
    List<Post> findByUserID(int userID);
}
