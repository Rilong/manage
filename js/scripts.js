   var hours = null;
   var minutes = null;
   var elementTime = null;
   var elementId = null;
   var hoursWithInt = null;
   var minutesWithInt = null;
   var hoursToInt = null;
   var minutesToInt = null;
   var availableMinutes = $("#availableMinutes");
   var tasksQuantity = 0;
   var tasks = null;
   $("#listTasks").load("tasksLoad.php");
   //=================set time======================
   $(".times").click(function (event) {
      elementTime = $(event.target);
      elementId = $(event.target).attr("id");
   });

   $(".hours ul").click(function (event) {
      $(".hours ul li").each(function () {
         $(this).css({
            "border":"none",
            "width": "50px",
            "height": "43px"
         });
      });
      $(event.target).css({
         "border":"1px solid red",
         "width": "48px",
         "height": "41px"
      });
      hours = $(event.target).text();
   });

   $(".minutes ul").click(function (event) {
      $(".minutes ul li").each(function () {
         $(this).css({
            "border":"none",
            "width": "50px",
            "height": "43px"
         });
      });
      $(event.target).css({
         "border":"1px solid red",
         "width": "48px",
         "height": "41px"
      });

      minutes = $(event.target).text();
   });

   $(".remodal-confirm").bind("click", function () {
      var result, hoursNo, minutesNo, _minutes, _hours;
      var reg = /^0/;
      var time = hours + ":" + minutes;
      if (minutes != null && hours != null) elementTime.text(time);
      if (hours.match(reg) && hours != null) hours = hours.substr(1, 1);
      if (minutes.match(reg) && minutes != null) minutes = minutes.substr(1, 1);

      if (elementId == "with") {
           hoursWithInt = Number(hours);
           minutesWithInt = Number(minutes);

      }else {
         result = $("#with").text();
         result = result.split(":");
         hoursNo = result[0];
         minutesNo = result[1];
         if (hoursNo.match(reg))
            hoursNo = hoursNo.substr(1, 1);
         if (minutesNo.match(reg))
            minutesNo = minutesNo.substr(1,1);
         hoursWithInt = Number(hoursNo);
         minutesWithInt = Number(minutesNo);
      }

      if (elementId == "to") {
         hoursToInt = Number(hours);
         minutesToInt = Number(minutes);
      }else {
         result = $("#to").text();
         result = result.split(":");
         hoursNo = result[0];
         minutesNo = result[1];
         if (hoursNo.match(reg))
            hoursNo = hoursNo.substr(1, 1);
         if (minutesNo.match(reg))
            minutesNo = minutesNo.substr(1,1);
         hoursToInt = Number(hoursNo);
         minutesToInt = Number(minutesNo);
      }

      _minutes = minutesToInt + minutesWithInt;
      _hours = (hoursToInt - hoursWithInt) * 60;

      if ($("div").is(".text")) {
         $(".text").each(function () {
            tasks = Number($(this).html().slice(0, -2).trim());
            tasksQuantity += tasks;
         });
      }

      result = (_minutes + _hours) - tasksQuantity;
      availableMinutes.text(result);
      $.ajax({
         url: "../ajax/time.php",
         type: "POST",
         dataType: "html",
         data: {TimeMinutes: result, Time: time, elementId:elementId}
      });

      //=================clean========================
         $(".hours ul li").each(function () {
            $(this).css({
               "border":"none",
               "width": "50px",
               "height": "43px"
            });
         });
      $(".minutes ul li").each(function () {
            $(this).css({
               "border":"none",
               "width": "50px",
               "height": "43px"
            });
         });
      hours = null;
      minutes = null;
      tasksQuantity = 0;
   });


   // ==========================addTask============================



   $("#addTaskSend").click(function () {
      var taskName = $("#TaskName").val();
      var durationTask = $("#duration").val();
      var time = $("#availableMinutes");
      result = Number(time.html()) - Number(durationTask);
      if (taskName.length != 0 && durationTask.match(/[0-9]/)) {
         $("#listTasks").html("");
         $.ajax({
            url: "../ajax/addTask.php",
            type: "POST",
            dataType: "html",
            data: {name: taskName, duration: durationTask, time: result},
            beforeSend: function () {
               $("#listTasks").prepend("<div class=\"noTasks\">Завантаження...</div>")
            },
            success: function () {
               $("#listTasks").load("tasksLoad.php");
                time.html(result);
            }
         });
         $("#TaskName").val("");
         $("#duration").val("");
      }
   });

   //=============================controls================================

   $("#listTasks").click(function (event) {
      var element = $(event.target);
      var id, taskName, taskDuration, taskNameNew, taskDurationNew;
      var action;

      // delete
      if (element.is(".delete") || element.is(".icon-cancel-circled")) {
         id = Number($(element.parent(".delete")).data("taskDelete"));
         action = "delete";
      }
      // edit
      else if (element.is(".edit") || element.is(".icon-pencil")){
         id = Number($(element.parent(".edit")).data("taskEdit"));
         action = "edit";
      }else return false;

      if (action == "delete") {
         var time = Number($("#availableMinutes").html());
         taskDuration = Number($(element.parents(".task")).children(".duration").children(".text").html().slice(0, -2).trim());
         result = time + taskDuration;
         $.ajax({
            url: "../ajax/deleteTask.php",
            type: "POST",
            dataType: "html",
            data: {id: id, time: result},
            success: function () {
               $(element.parents(".task")).slideUp(800);
               setTimeout(function () {
                  $(element.parents(".task")).remove();
                  $("#availableMinutes").html(result);
                  if($(".task").length == 0)
                     $("#listTasks").prepend("<div class=\"noTasks\">У вас немає завдань!</div>");
               }, 801);
            }
         });
      }else if (action == "edit") {
         taskName = $(element.parents(".task")).children(".taskName").text();
         taskDuration = Number($(element.parents(".task")).children(".duration").children(".text").html().slice(0, -2).trim());
         $(".TaskNameEdit").val(taskName);
         $(".durationEdit").val(taskDuration);

         $(".confirm-edit").bind("click", function () {
            taskNameNew = $(".TaskNameEdit").val();
            taskDurationNew = Number($(".durationEdit").val());
            var result = taskDuration - taskDurationNew;
            var minutes = Number($("#availableMinutes").html());

            $(element.parents(".task")).children(".taskName").html(taskNameNew);
            $(element.parents(".task")).children(".duration").children(".text").html(taskDurationNew + " хв");
            $("#availableMinutes").html(minutes + result);
               $.ajax({
                  url: "../ajax/updateTask.php",
                  type: "POST",
                  dataType: "html",
                  data: {time: minutes + result, name: taskNameNew, duration: taskDurationNew, id: id}
               });
            $(this).unbind("click"); // event click stop
         });
      }
   });

