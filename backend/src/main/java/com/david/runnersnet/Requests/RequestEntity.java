package com.david.runnersnet.Requests;

import com.david.runnersnet.users.UserEntity;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Entity
@EntityListeners(AuditingEntityListener.class)
public class RequestEntity {

    @Id
    private Long id;
    private Integer status;

    @ManyToOne
    @JoinColumn(name = "sender")
    private UserEntity sender;

    @ManyToOne
    @JoinColumn(name = "receiver")
    private UserEntity receiver;

    @Column(name="createdAt", nullable = false, updatable = false)
    @CreatedDate
    private long createdAt;

    @Column(name="updatedAt")
    @LastModifiedDate
    private long modifiedDate;


    public RequestEntity() {
    }
}
