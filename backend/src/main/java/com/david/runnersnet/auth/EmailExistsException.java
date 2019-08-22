package com.david.runnersnet.auth;

public class EmailExistsException extends Exception {

    public EmailExistsException(String message) {
        super(message);
    }
}
