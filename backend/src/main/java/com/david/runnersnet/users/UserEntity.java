package com.david.runnersnet.users;

import com.david.runnersnet.roles.Role;
import org.springframework.data.annotation.CreatedDate;
import org.springframework.data.annotation.LastModifiedDate;
import org.springframework.data.jpa.domain.support.AuditingEntityListener;
import org.springframework.transaction.annotation.Transactional;

import javax.persistence.*;
import java.util.Collection;
import java.util.List;
import java.util.UUID;

@Entity
@EntityListeners(AuditingEntityListener.class)
public class UserEntity {

    @Column(name="createdAt", nullable = false, updatable = false)
    @CreatedDate
    private long createdAt;

    @Column(name="updatedAt")
    @LastModifiedDate
    private long modifiedDate;

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private int id;

    @ManyToMany
    @JoinTable(
            name = "users_roles",
            joinColumns = @JoinColumn(
                    name = "user_id", referencedColumnName = "id"
            ),
            inverseJoinColumns = @JoinColumn(
                    name = "role_id", referencedColumnName = "id"
            )
    )
    private Collection<Role> roles;

    @Transient
    private Collection<UserEntity> friends;

    private String first_name;
    private String last_name;
    private String email;
    private String password;
    @Column(name = "date_of_birth", columnDefinition = "DATE")
    private String dateOfBirth;
    @Column(columnDefinition = "DATETIME")
    private String date_created;
    @Column(columnDefinition = "VARCHAR(36)")
    private String passwordResetKey;
    private String phoneNumber;
    private String country;
    @Column(columnDefinition = "VARCHAR(5000)")
    private String biography;

    public UserEntity() {}

    public int getId() {
        return this.id;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getPassword() {
        return this.password;
    }

    public long getCreatedAt() {
        return createdAt;
    }

    public void setCreatedAt(long createdAt) {
        this.createdAt = createdAt;
    }

    public long getModifiedDate() {
        return modifiedDate;
    }

    public void setModifiedDate(long modifiedDate) {
        this.modifiedDate = modifiedDate;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getFirst_name() {
        return first_name;
    }

    public void setFirst_name(String first_name) {
        this.first_name = first_name;
    }

    public String getLast_name() {
        return last_name;
    }

    public void setLast_name(String last_name) {
        this.last_name = last_name;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getDateOfBirth() {
        return this.dateOfBirth;
    }

    public void setDateOfBirth(String dateOfBirth) {
        this.dateOfBirth = dateOfBirth;
    }

    public String getDate_created() {
        return date_created;
    }

    public void setDate_created(String date_created) {
        this.date_created = date_created;
    }

    public void setRoles(List<Role> roles) {
        this.roles = roles;
    }

    @Transactional
    public Collection<Role> getRoles() {
        return this.roles;
    }

    public String getPasswordResetKey() {
        return passwordResetKey;
    }

    public void generatePasswordResetKey() {
        this.passwordResetKey = UUID.randomUUID().toString().replace("-","");
    }

    public void invalidatePasswordKey() {
        this.passwordResetKey = null;
    }

    public String getPhoneNumber() {
        return phoneNumber;
    }

    public void setPhoneNumber(String phoneNumber) {
        this.phoneNumber = phoneNumber;
    }

    public String getCountry() {
        return country;
    }

    public void setCountry(String country) {
        this.country = country;
    }


    public Collection<UserEntity> getFriends() {
        return this.friends;
    }

    public void addFriend(UserEntity friend) {
        this.friends.add(friend);
    }
    public void setFriends(Collection<UserEntity> friends) {
        this.friends = friends;
    }
}
