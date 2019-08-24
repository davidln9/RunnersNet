package com.david.runnersnet.CmdLine;

public class CmdLineParser {

    private String[] args;
    public CmdLineParser(String[] args) {

        this.args = args;
    }

    public String getArg(String name) {

        for (String arg: args) {
            if (arg.split("=")[0].substring(2).equals(name)) {
                return arg.split("=")[1];
            }
        }

        return null;
    }
}
