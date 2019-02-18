function CustomPrintForm(){
     this.render = function(type, report, fieldNames, fieldValues){
         var winW = window.innerWidth;
         var winH = window.innerHeight;
         var dialogoverlay = document.getElementById('dialogoverlay-long');
         var dialogbox = document.getElementById('dialogbox-long');
         dialogoverlay.style.display = "block";
         dialogoverlay.style.height = winH+"px";
         dialogbox.style.left = (winW/2) - (1500 * .5)+"px";
         dialogbox.style.top = "50px";
         dialogbox.style.display = "block";

         var url = 'rid-printReports';
         alert(type);
         alert(url);
         alert(report);
         jQuery.ajax({
             url: url,
             data: {
                 'fieldNames': fieldNames,
                 'fieldValues': fieldValues,
                 'type': type,
                 'report': report,
             },
             type: "POST",
             success:function(data){
                 console.log(data);
                 var winHeight = window.innerHeight;
                 if(report == 'excel') {
                   $('#dialogboxbody-long').html('File quedanListingExcel.xlsx downloaded in C:/trinity/excel/ Folder!!!');
                 } else {
                   $('#dialogboxbody-long').html('<iframe style="width:100%; height:'+(winHeight-200)+'px" src="http://192.168.2.153/trinity/assets/pdf/' + report + '"></iframe>');
                 }
             },
             error:function (){}
         }); //jQuery.ajax({


         document.getElementById('dialogboxhead-long').innerHTML = 'View PDF... <button onclick="printForm.no()">Close</button>';
         //document.getElementById('dialogboxbody').innerHTML = dialog;
         document.getElementById('dialogboxfoot-long').innerHTML = '<button onclick="printForm.no()">Close</button>';
     }
     this.no = function(){
         document.getElementById('dialogbox-long').style.display = "none";
         document.getElementById('dialogoverlay-long').style.display = "none";
     }
 }
 var printForm = new CustomPrintForm();
