package com.david.runnersnet.logs.distance;

import com.david.runnersnet.misc.comments.Comment;
import com.david.runnersnet.misc.comments.CommentRepository;
import com.david.runnersnet.misc.likes.Like;
import com.david.runnersnet.misc.likes.LikeRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.RestController;

import javax.validation.constraints.Null;
import java.util.ArrayList;
import java.util.List;

import static com.david.runnersnet.constants.PostTypes.DISTANCE;

@RestController
public class DistanceBuilder {

    @Autowired
    CommentRepository commentRepository;

    @Autowired
    LikeRepository likeRepository;

    private List<Distance> distanceList;
    private Distance distance;

    public DistanceBuilder() {}

    public void setDistanceList(List<Distance> distanceList) {
        this.distanceList = distanceList;
    }

    public void setDistance(Distance distance) {
        this.distance = distance;
    }

    public Distance getDistance() {
        return this.distance;
    }

    public void addLikesAndComments() throws NullPointerException {

        if (this.distance == null) {
            throw new NullPointerException("No Distance Object");
        }

        List<Like> likes = likeRepository.findAll(DISTANCE, distance.getId());
        List<Comment> comments = commentRepository.findAll(DISTANCE, distance.getId());

        distance.setLikes(likes);
        distance.setComments(comments);

    }

    public void addLikesAndCommentsMany() throws NullPointerException {

        if (this.distanceList == null) {
            throw new NullPointerException("No List");
        }
        List<Like> allLikes = likeRepository.findAll(DISTANCE);
        List<Comment> allComments = commentRepository.findAll(DISTANCE);


        for (Distance distance : distanceList) {

            List<Like> likes = new ArrayList<>();
            List<Comment> comments = new ArrayList<>();

            for (Like like : allLikes) {
                if (like.getPostID() == distance.getId()) {
                    likes.add(like);
                }
            }

            for (int i = 0; i < allComments.size(); i++) {
                Comment comment = allComments.get(i);
                if (comment.getPostID() == distance.getId()) {
                    comments.add(comment);
                }
            }

            distance.setComments(comments);
            distance.setLikes(likes);

        }
    }

    public List<Distance> getDistanceList() {
        return this.distanceList;
    }
}
