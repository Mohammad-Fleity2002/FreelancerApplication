package com.example.freelancer;

public class Feedbacks {
    private String id,feedback_description,feedback_rate;
    private Users customer;
    private Services service;
    public Feedbacks(String i,String f_desc,String f_rate,Users cs,Services sv){
        this.customer=cs;
        this.feedback_description=f_desc;
        this.feedback_rate=f_rate;
        this.service=sv;
        this.id=i;
    }

    //getter
    public String getFeedback_description() {
        return feedback_description;
    }
    public String getFeedback_rate() {
        return feedback_rate;
    }
    public Users getCustomer() {
        return customer;
    }
    public Services getService() {
        return service;
    }
    public String getId() {
        return id;
    }

    //setter
    public void setService(Services service) {
        this.service = service;
    }
    public void setCustomer(Users customer) {
        this.customer = customer;
    }
    public void setFeedback_rate(String feedback_rate) {
        this.feedback_rate = feedback_rate;
    }
    public void setFeedback_description(String feedback_description) {
        this.feedback_description = feedback_description;
    }
    public void setId(String id) {
        this.id = id;
    }
}

