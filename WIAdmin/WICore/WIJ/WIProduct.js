/***********
** WIProduct NAMESPACE
**************/
$(document).ready(function(event)
{


        $("#NewProduct").click(function()
    {

            var css  = $("#codecss").html(),

             //create data that will be sent over server

              styling = {
                UserData:{
                    css           : css,
                    href          : href

                },
                FieldId:{
                    css           : "codecss",
                    href          : "href"

                }
             };
             // send data to server
             WIProduct.sendData(styling);
        
    });



});

var WIProduct = {}
