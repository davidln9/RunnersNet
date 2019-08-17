package com.david.runnersnet.logs;

public class DateParser extends Thread {

    public DateParser(String date1) {
        this.date1 = date1;
    }

    private String date1;

    private int year1 = 0;
    private int month1 = 0;
    private int day1 = 0;
    private int hours = 0;
    private int minutes = 0;

    public int getYear1() {
        return year1;
    }

    public int getMonth1() {
        return month1;
    }

    public int getDay1() {
        return day1;
    }

    public int getHours() {
        return hours;
    }

    public int getMinutes() {
        return minutes;
    }

    private void parseDate() {
        int state = 0;

        StringBuilder current = new StringBuilder();
        for (int i = 0; i < date1.length(); i++) {
            if (state == 0) { // parse beginning (unknown format up to this point)
                if (date1.charAt(i) == '-' || date1.charAt(i) == '/') {
                    if (current.length() == 4) {
                        year1 = Integer.valueOf(current.toString());
                        current = new StringBuilder();
                        state = 1;
                    } else if (current.length() == 2) {
                        month1 = Integer.valueOf(current.toString());
                        state = 4;
                    } else {
                        System.err.println("Invalid date format: " + date1);
                        System.exit(1);
                    }

                } else {
                    current.append(date1.charAt(i));
                }
            } else if (state == 1) { // yyyy/MM/dd
                char char1 = date1.charAt(i);
                i++;
                char char2 = date1.charAt(i);
                i++;

                StringBuilder stringBuilder = new StringBuilder();
                if (char1 != '0') {
                    stringBuilder.append(char1);
                }
                stringBuilder.append(char2);
                month1 = Integer.valueOf(stringBuilder.toString());
                state = 2;

            } else if (state == 2) { // yyyy/mm/DD
                char char1 = date1.charAt(i);
                i++;
                char char2 = date1.charAt(i);
                i++;

                StringBuilder stringBuilder = new StringBuilder();
                if (char1 != '0') {
                    stringBuilder.append(char1);
                }
                stringBuilder.append(char2);
                day1 = Integer.valueOf(stringBuilder.toString());
                state = 3;
            } else if (state == 3) { // parse time

                // hh:mm a/p (12hr)
                // hh:mm (24hr)

                if (date1.charAt(i+1) == ':') {
                    hours = (int)date1.charAt(i);
                    minutes = Integer.valueOf(date1.substring(i+2,i+4));
                } else {
                    hours = Integer.valueOf(date1.substring(i,i+2));
                    minutes = Integer.valueOf(date1.substring(i+3,i+5));
                }

                if (date1.length() == i+5 || hours > 12) { // definitely 24hr time
                    break;
                }
                if (date1.length() > i+6) {
                    if (date1.charAt(i+6) == 'a') {
                        break;
                    } else if (date1.charAt(i+6) == 'p') {
                        hours += 12;
                        break;
                    } else {
                        System.err.println("Unknown format: " + date1.charAt(i + 6));
                    }
                }

                break;


            } else if (state == 4) { // mm/DD/yyyy
                char char1 = date1.charAt(i);
                i++;
                char char2 = date1.charAt(i);
                i++;

                StringBuilder stringBuilder = new StringBuilder();
                if (char1 != '0') {
                    stringBuilder.append(char1);
                }
                stringBuilder.append(char2);
                day1 = Integer.valueOf(stringBuilder.toString());
                state = 5;
            } else if (state == 5) { // mm/dd/YYYY
                char char1 = date1.charAt(i);
                i++;
                char char2 = date1.charAt(i);
                i++;
                char char3 = date1.charAt(i);
                i++;
                char char4 = date1.charAt(i);
                i++;

                StringBuilder stringBuilder = new StringBuilder();
                stringBuilder.append(char1);
                stringBuilder.append(char2);
                stringBuilder.append(char3);
                stringBuilder.append(char4);

                year1 = Integer.valueOf(stringBuilder.toString());
                state = 3;
            }
        }
    }

    @Override
    public void run() {
        this.parseDate();
    }
}
