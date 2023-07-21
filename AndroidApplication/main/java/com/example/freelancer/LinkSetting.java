package com.example.freelancer;

public class LinkSetting {
    private static String url_sign_in="http://192.168.16.104/php/I3302/mySQL/Freelancer/login.php";
    private static String url_sign_up="http://192.168.16.104/php/I3302/mySQL/Freelancer/sign_up.php";
    private static String url_loading="http://192.168.16.104/php/I3302/mySQL/Freelancer/loading.php";
    private static String url_search="http://192.168.16.104/php/I3302/MySQL/freelancer/search.php";
    private static String url_add_service="http://192.168.16.104/php/I3302/MySQL/freelancer/add_service.php";
    private static String url_my_services="http://192.168.16.104/Php/I3302/MySQL/freelancer/my_services.php";
    private static String url_activity_services="http://192.168.16.104/Php/I3302/MySQL/freelancer/activity_feedbacks.php";
    private static String url_add_feedback="http://192.168.16.104/Php/I3302/MySQL/freelancer/add_feedback.php";
/*
     private static String url_sign_in="http://192.168.1.9/php/I3302/mySQL/Freelancer/login.php";
    private static String url_sign_up="http://192.168.1.9/php/I3302/mySQL/Freelancer/sign_up.php";
    private static String url_loading="http://192.168.1.9/php/I3302/mySQL/Freelancer/loading.php";
    private static String url_search="http://192.168.1.9/php/I3302/MySQL/freelancer/search.php";
    private static String url_add_service="http://192.168.1.9/php/I3302/MySQL/freelancer/add_service.php";
    private static String url_my_services="http://192.168.1.9/Php/I3302/MySQL/freelancer/my_services.php";
    private static String url_activity_services="http://192.168.1.9/Php/I3302/MySQL/freelancer/activity_feedbacks.php";
    private static String url_add_feedback="http://192.168.1.9/Php/I3302/MySQL/freelancer/add_feedback.php";
*/
    private LinkSetting(){};

    public static String getUrl_sign_in() {
        return url_sign_in;
    }

    public static String getUrl_sign_up() {
        return url_sign_up;
    }

    public static String getUrl_loading() {
        return url_loading;
    }

    public static String getUrl_search() {
        return url_search;
    }

    public static String getUrl_add_service() {
        return url_add_service;
    }

    public static String getUrl_my_services() {
        return url_my_services;
    }

    public static String getUrl_activity_services() {
        return url_activity_services;
    }

    public static String getUrl_add_feedback() {
        return url_add_feedback;
    }
}
