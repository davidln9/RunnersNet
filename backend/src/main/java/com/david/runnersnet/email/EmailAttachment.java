package com.david.runnersnet.email;

import java.io.File;

public class EmailAttachment {

    private String filename;
    private File file;

    public EmailAttachment() {
        this.setFilename(null);
        this.setFile(null);
    }

    public EmailAttachment(String filename, File file) {
        this.setFilename(filename);
        this.setFile(file);
    }


    public String getFilename() {
        return filename;
    }

    public void setFilename(String filename) {
        this.filename = filename;
    }

    public File getFile() {
        return file;
    }

    public void setFile(File file) {
        this.file = file;
    }

}