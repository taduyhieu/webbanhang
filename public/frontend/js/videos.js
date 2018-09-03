
        var myVideoV1 = document.getElementById("video-v1"); 
        var myVideoV2 = document.getElementById("video-v2");
        var myVideoV3 = document.getElementById("video-v3");
        var myVideoV4 = document.getElementById("video-v4");
        var myVideoV5 = document.getElementById("video-v5"); 
        var myVideoV6 = document.getElementById("video-v6");
        var myVideoV7 = document.getElementById("video-v7");
        var myVideoV8 = document.getElementById("video-v8");
        var myVideoV9 = document.getElementById("video-v9");
        /*=-----------*/
        function playPauseV1() { 
            if (myVideoV1.paused) 
                myVideoV1.play(); 
            else 
                myVideoV1.pause(); 
        } 
        function playPauseV2() { 
            if (myVideoV2.paused) 
                myVideoV2.play(); 
            else 
                myVideoV2.pause(); 
        } 
        function playPauseV3() { 
            if (myVideoV3.paused) 
                myVideoV3.play(); 
            else 
                myVideoV3.pause(); 
        } 
        function playPauseV4() { 
            if (myVideoV4.paused) 
                myVideoV4.play(); 
            else 
                myVideoV4.pause();

        } 
        function playPauseV5() { 
            if (myVideoV5.paused) 
                myVideoV5.play(); 
            else 
                myVideoV5.pause();
             
        } 
        function playPauseV6() { 
            if (myVideoV6.paused) 
                myVideoV6.play(); 
            else 
                myVideoV6.pause();
             
        } 
        function playPauseV7() { 
            if (myVideoV7.paused) 
                myVideoV7.play(); 
            else 
                myVideoV7.pause();
             
        }
        function playPauseV8() { 
            if (myVideoV8.paused) 
                myVideoV8.play(); 
            else 
                myVideoV8.pause();
             
        } 
        function playPauseV9() { 
            if (myVideoV9.paused) 
                myVideoV9.play(); 
            else 
                myVideoV9.pause();
             
        }
        /*-----------active--------------*/
        $(document).ready(function(){
            // $('.dropdown-menu.dropright').click(function(){
            //     $('.dropdown-menu.dropright ').removeClass("active");
            //     // $(this).removeClass("show");
            //     $('.dropdown-menu.dropright.active').css("display","none");
            //     $('.dropdown-menu.dropright').toggleClass('shows');
            //     $(this).addClass("active");
            // });
            $('li.dropdown-item a').click(function(){
                $('li.dropdown-item a').removeClass("active");
                $(this).addClass("active");
            });
           $('navbar-nav  a').click(function(){
                $('.navbar-nav a').removeClass("active");
                $(this).addClass("active");
            });
        });
        /*-----------------active ------------*/
        // $(document).ready(function () {
        //     var url = window.location;
        //     let element =$('.btn-group-vertical ul.dropdown-menu.dropright>li>a[href="' + url + '"]')
        //     element.parents('ul.dropdown-menu.dropright').children().css({"display": "list-item"});
        //     element.css({"color": "#f02a35"});
        // });