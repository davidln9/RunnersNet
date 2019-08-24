package com.david.runnersnet.Requests;

import com.david.runnersnet.users.UserEntity;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;

import javax.persistence.*;

@Entity
@EntityListeners(AuditingEntityListener.class)
@Table(name="friends")
public class RequestEntity {

    @EmbeddedId
    private RequestId requestId;

    private int status;


    public RequestEntity() {
    }

    public void setRequestId(RequestId requestId) {
        this.requestId = requestId;
    }

    public void setStatus(int status) {
        this.status = status;
    }


}
