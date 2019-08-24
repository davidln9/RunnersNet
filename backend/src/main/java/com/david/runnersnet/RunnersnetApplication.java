package com.david.runnersnet;

import com.david.runnersnet.CmdLine.ArgHolder;
import com.david.runnersnet.CmdLine.CmdLineParser;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;

@SpringBootApplication
public class RunnersnetApplication {

	public static void main(String[] args) {

		CmdLineParser cmdLineParser = new CmdLineParser(args);

		ArgHolder.getInstance().setMailSender(cmdLineParser.getArg("emailusername"));

		SpringApplication.run(RunnersnetApplication.class, args);
	}

}
