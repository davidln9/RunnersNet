package com.david.runnersnet.user;

import javax.persistence.*;
import java.io.Serializable;

@Entity
@Table(name = "friends")
public class Friend implements Serializable {

    int person1;
    int person2;
    int status;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    int id;

    public Friend() {}

    public int getPerson1() {
        return person1;
    }

    public void setPerson1(int person1) {
        this.person1 = person1;
    }

    public int getPerson2() {
        return person2;
    }

    public void setPerson2(int person2) {
        this.person2 = person2;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }
}
