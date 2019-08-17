package com.david.runnersnet.logs;

public class CompareUtil {

    private CompareUtil() {}

    public static int getComparison(String date1, String date2) {
        DateParser dateParser1 = new DateParser(date1);
        DateParser dateParser2 = new DateParser(date2);

        dateParser1.start();
        dateParser2.start();

        try {
            dateParser1.join();
            dateParser2.join();
        } catch (InterruptedException ex) {
            ex.printStackTrace();
        }

        if (dateParser1.getYear1() != dateParser2.getYear1()) {
            return dateParser1.getYear1() - dateParser2.getYear1();
        }
        if (dateParser1.getMonth1() != dateParser2.getMonth1()) {
            return dateParser1.getMonth1() - dateParser2.getMonth1();
        }

        if (dateParser1.getDay1() != dateParser2.getDay1()) {
            return dateParser1.getDay1() - dateParser2.getDay1();
        }

        if (dateParser1.getHours() != dateParser2.getHours()) {
            return dateParser1.getHours() - dateParser2.getHours();
        }

        if (dateParser1.getMinutes() != dateParser2.getMinutes()) {
            return dateParser1.getMinutes() - dateParser2.getMinutes();
        }

        return 0;
    }
}
