package com.david.runnersnet.email;

import com.david.runnersnet.CmdLine.ArgHolder;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.stereotype.Service;
import org.springframework.util.Assert;

import javax.mail.internet.MimeMessage;
import java.util.List;

/**
 * Services to send email
 */
@Service
public class EmailService {
    @Autowired
    private JavaMailSender javaMailSender;

    /**
     * Send email that only contains plain text
     * @param sendToList Array of email addresses to send to
     * @param subject Subject of the email
     * @param text Plain text to be sent
     */
    public void sendPlainText(String[] sendToList, String subject, String text) {

        SimpleMailMessage msg = new SimpleMailMessage();

        msg.setTo(sendToList);
        msg.setFrom(ArgHolder.getInstance().getMailSender());
        msg.setSubject(subject);
        msg.setText(text);

        javaMailSender.send(msg);
    }

    /**
     * Send email that contains MIME content but no attachment
     * @param sendToList Array of email addresses to send to
     * @param subject Subject of the email
     * @param content MIME content to be sent
     */
    public void sendMime(String[] sendToList, String subject, String content) {

        MimeMessage msg = javaMailSender.createMimeMessage();

        try {
            MimeMessageHelper helper = new MimeMessageHelper(msg, true);

            helper.setTo(sendToList);
            helper.setSubject(subject);
            helper.setText(content, true);
        } catch (Exception ex) {
            ex.printStackTrace();
        }

        javaMailSender.send(msg);
    }

    /**
     * Send email that contains MIME content and attachments
     * @param sendToList Array of email addresses to send to
     * @param subject Subject of the email
     * @param content HTML content to be sent
     * @param attachments ArrayList of attachments
     */
    public void sendMime(String[] sendToList, String subject, String content, List<EmailAttachment> attachments) {

        MimeMessage msg = javaMailSender.createMimeMessage();

        try {
            MimeMessageHelper mimeHelper = new MimeMessageHelper(msg, true);

            mimeHelper.setTo(sendToList);
            mimeHelper.setSubject(subject);
            mimeHelper.setText(content, true);

            for (EmailAttachment attachment : attachments) {
                Assert.notNull(attachment.getFilename(), "Attached filename must not be null");
                Assert.notNull(attachment.getFile(), "Attached file must not be null");
                mimeHelper.addAttachment(attachment.getFilename(), attachment.getFile());
            }
        } catch (Exception ex) {
            ex.printStackTrace();
        }

        javaMailSender.send(msg);
    }
}
