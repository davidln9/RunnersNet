package com.david.runnersnet.user;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;

import java.util.List;

public interface FriendRepository extends CrudRepository<Friend, Integer> {

    @Query(value = "SELECT * FROM friends WHERE person1 = ?1 OR person2 = ?1 AND status = 2", nativeQuery = true)
    List<Friend> findFriends(int my_crypt_id);

    @Query(value = "SELECT * FROM friends WHERE person1 = ?1 OR person2 = ?1", nativeQuery = true)
    List<Friend> getFriendsAndRequests(int my_crypt_id);
}
