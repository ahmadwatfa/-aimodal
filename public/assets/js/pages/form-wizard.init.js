/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Form wizard Js File
*/
    $(document).ready (function (){
        var __webpack_exports__ = {};
    if($("#basic-example").length != 0) {
        $("#basic-example").steps({
            headerTag: "h3",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            autoFocus: true,
        });
    }
        if($("#vertical-example").length != 0) {
            $("#vertical-example").steps({
                headerTag: "h3",
                bodyTag: "section",
                transitionEffect: "slideLeft",
                stepsOrientation: "vertical",
                /*labels: {
                    current: "current step:",
                }*/
            });
        }
    });
