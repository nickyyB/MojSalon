$(document).ready(function(){

    $(".button-left").hide();
    const date = new Date();
    let showDate = new Date(date);
    if(date.getDay() == 0) showDate.setDate(showDate.getDate() - 7);
    else showDate.setDate(showDate.getDate() - date.getDay() + 1);
    const months = [
        "Januar",
        "Februar",
        "Mart",
        "April",
        "Maj",
        "Jun",
        "Avgust",
        "Septembar",
        "Oktobar",
        "Novembar",
        "Decembar",
    ];
    let week = [];
    let selectedDate = "";
    let selectedTime = "";

    showWeek(showDate);
    

    $(".button-right").click(function(){
        $(".button-left").show();
        showDate.setDate(showDate.getDate() + 7);
        $(".day-numbers").removeClass("clicked");
        $("#selected-date-time").empty();
        $(".time-picker").empty();
        $(".confirm-button").addClass("disabled");

        showWeek(showDate);
    })

    $(".button-left").click(function(){
        showDate.setDate(showDate.getDate() - 7);
        if(showDate <= date) $(".button-left").hide();
        $(".day-numbers").removeClass("clicked");
        $("#selected-date-time").empty();
        $(".time-picker").empty();
        $(".confirm-button").addClass("disabled");

        showWeek(showDate);
    })

    $(document).on('click', '.day-numbers:not(.past-day)', function(){
        $(".day-numbers").not(this).removeClass("clicked");
        $(this).removeClass("hover");
        $(this).addClass("clicked");
        $(".time-picker").empty();
        $("#selected-date-time").empty();
        $(".confirm-button").addClass("disabled");

        showTimes(week[($(this).attr("id")).split("-")[1]]);
    });

    $(document).on('mouseenter', '.day-numbers:not(.past-day)', function(){
        $(this).addClass("hover");
    });

    $(document).on('mouseleave', '.day-numbers:not(.past-day)', function(){
        $(this).removeClass("hover");
    });

    $(document).on('click', '.time',function(){
        $(".time").not(this).removeClass("clicked");
        $(this).removeClass("hover");
        $(this).addClass("clicked");
        $(".confirm-button").removeClass("disabled");
        $("#selected-date-time").empty();
        selectedDate = ((week[($(".clicked.day-numbers").attr("id")).split("-")[1]]).split(" ")[0]);
        selectedTime = " " + $(this).text();
        $("#selected-date-time").append(selectedDate.split("-").reverse().join(".") + selectedTime);
    });

    $(document).on('mouseenter', '.time', function(){
        $(this).addClass("hover");
    });

    $(document).on('mouseleave', '.time', function(){
        $(this).removeClass("hover");
    });

    $(".confirm-button").click(function(){
        if (!$(this).hasClass("disabled")){
            insertAppointment(selectedDate, selectedTime);
        }
    })

    function showWeek(d){
        let month = months[d.getMonth()] + " " + d.getFullYear();
        let day = new Date(d);
        $(".day-numbers").removeClass("past-day");
        
        for (let i = 1; i <=7; i++){
            $("#day-"+i).text(day.getDate());
            if(day <= date ){
                $("#day-"+i).addClass("past-day");
            }
            week[i] = day.getFullYear()+"-"+(day.getMonth()+1)+"-"+day.getDate()+" 00:00:00";
            day.setDate(day.getDate() + 1);
        }
        if(d.getMonth() != day.getMonth()){
           month += " / " + months[day.getMonth()] + " " + day.getFullYear();
        }
        $(".month-year h6").text(month);
    }

    function showTimes(day){
        let serviceId = window.location.href.split("/").pop();
        // day.setDate(day.getDate() + 1);
        // console.log(day.getFullYear()+"-"+(day.getMonth()+1)+"-"+day.getDate()+" "+day.getHours()+":"+day.getMinutes()+":"+day.getSeconds());
        $.ajax({
            type: "GET",
            url: "/User/timetable",
            dataType:'json',
            data: {
                serviceId: serviceId,
                day: day
            },
            success: function(data){
                let timetable = $(".time-picker");
                Object.keys(data).forEach(function(k){
                    if(data[k] == 1){
                        timetable.append(
                            $("<div></div>").addClass("time").append(k)
                        )
                    }
                });
                
            }

        })
    }

    function insertAppointment(selectedDate, selectedTime){
        // console.log("Poslat zahtev");
        // console.log(selectedDate + selectedTime);
        let serviceId = window.location.href.split("/").pop();
        $.ajax({
            type: "POST",
            url: "/User/insertAppointment",
            dataType: "json",
            data: {
                datetime: selectedDate + " " + selectedTime,
                serviceId: serviceId
            },
            success: function(data){
                if(data){
                    location.href = "/User/appointments";
                }
            }
        })
    }

});
