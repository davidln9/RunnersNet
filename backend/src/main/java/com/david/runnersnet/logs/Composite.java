package com.david.runnersnet.logs;

import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.likes.Like;

import java.util.List;

public interface Composite extends Comparable<Composite> {
    Integer getId();
    Integer getPosttype();
    void setComments(List<Comment> comments);
    void setLikes(List<Like> likes);
    List<Comment> getComments();
    List<Like> getLikes();

    String getDate();
}
