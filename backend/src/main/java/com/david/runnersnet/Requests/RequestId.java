package com.david.runnersnet.Requests;

import javax.persistence.Column;
import javax.persistence.Embeddable;
import javax.persistence.ManyToOne;
import java.io.Serializable;

@Embeddable
public class RequestId implements Serializable {

    @Column(name="person1")
    private int sender_id;

    @Column(name="person2")
    private int receiver_id;


    public RequestId() {}

    public RequestId(int sender_id, int receiver_id) {
        this.sender_id = sender_id;
        this.receiver_id = receiver_id;
    }

    public int getSender_id() {
        return this.sender_id;
    }

    public int getReceiver_id() {
        return this.receiver_id;
    }
}
