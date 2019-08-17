package com.david.runnersnet.logs;

import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.comments.CommentRepository;
import com.david.runnersnet.misc.likes.Like;
import com.david.runnersnet.misc.likes.LikeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RestController;

import java.util.ArrayList;
import java.util.List;

@RestController
public class LogBuilder {

    @Autowired
    CommentRepository commentRepository;

    @Autowired
    LikeRepository likeRepository;

    private List<Composite> compositeList;

    public LogBuilder() {}

    public void setCompositeList(List<Composite> compositeList) {
        this.compositeList = compositeList;
    }

    public void addLikesAndCommentsMany() throws NullPointerException {

        if (this.compositeList == null) {
            throw new NullPointerException("No List");
        }
        List<Like> allLikes = likeRepository.findAll();
        List<Comment> allComments = commentRepository.findAll();


        for (Composite composite : compositeList) {

            List<Like> likes = new ArrayList<>();
            List<Comment> comments = new ArrayList<>();

            for (Like like : allLikes) {
                if (like.getPostID() == composite.getId()) {
                    if (like.getPosttype() == composite.getPosttype()) {
                        likes.add(like);
                    }
                }
            }

            for (Comment comment : allComments) {
                if (comment.getPostID() == composite.getId()) {
                    if (comment.getPosttype() == composite.getPosttype()) {
                        comments.add(comment);
                    }
                }
            }

            composite.setComments(comments);
            composite.setLikes(likes);

        }
    }

    public List<Composite> getCompositeList() {
        return this.compositeList;
    }
}
