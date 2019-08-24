package com.david.runnersnet.CmdLine;

public class ArgHolder {
    private static ArgHolder ourInstance = new ArgHolder();

    public static ArgHolder getInstance() {
        return ourInstance;
    }

    private String mailSender;
    private ArgHolder() {
    }

    public void setMailSender(String mailSender) {
        this.mailSender = mailSender;
    }

    public String getMailSender() {
        return this.mailSender;
    }
}
