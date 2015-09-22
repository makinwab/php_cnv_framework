<?php
    class Pagination
    {

        public function useLoadMore($total_pages, $fetch_page)
        {
            $res = "

             $(document).ready(function() {

                    var track_click = 0; //track user click on load more button, righ now it is 0 click

                    var total_pages = ".total_pages.";
                    $('#results').load('".$fetch_page."', {'page':track_click}, function() {track_click++;}); //initial data to load

                    $('.load_more').click(function (e) { //user clicks on button

                        $(this).hide(); //hide load more button on click
                        $('.animation_image').show(); //show loading image

                        if(track_click <= total_pages) //make sure user clicks are still less than total pages
                        {
                            //post page number and load returned data into result element
                            $.post('".$fetch_page."',{'page': track_click}, function(data) {

                                $('.load_more').show(); //bring back load more button

                                $('#results').append(data); //append data received from server

                                //scroll page to button element
                                $('html, body').animate({scrollTop: $('#load_more_button').offset().top}, 500);

                                //hide loading image
                                $('.animation_image').hide(); //hide loading image once data is received

                                track_click++; //user click increment on load button

                            }).fail(function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError); //alert any HTTP error
                                    $('.load_more').show(); //bring back load more button
                                    $('.animation_image').hide(); //hide loading image once data is received
                                });


                            if(track_click >= total_pages-1)
                            {
                                //reached end of the page yet? disable load button
                                $('.load_more').attr('disabled', 'disabled');
                            }
                        }

                    });
                });

            ";

            return $res;
        }

        public function useLinks($fetch_page)
        {
            $res = "
            $(document).ready(function() {
            $('#results').load('".$fetch_page."', {'page':0}, function(){ $('#1-page').addClass('active'); });  //initial page number to load

            $('.paginate_click').click(function (e) {

            $('#results').prepend('<div class=\'loading-indication\'><img src=\'".URL."public/images/ajax-loader.gif\' /> Loading...</div>');

            var clicked_id = $(this).attr('id').split('-'); //ID of clicked element, split() to get page number.
            var page_num = parseInt(clicked_id[0]); //clicked_id[0] holds the page number we need

            $('.paginate_click').removeClass('active'); //remove any active class

            //post page number and load returned data into result element
            //notice (page_num-1), subtract 1 to get actual starting point
            $('#results').load('".$fetch_page."', {'page':(page_num-1)}, function(){

            });

            $(this).addClass('active'); //add active class to currently clicked element (style purpose)

            return false; //prevent going to href link
            });
            });";

            return $res;
        }

        public function useScrolless($total_groups,$fetch_page)
        {
            $res = "
             $(document).ready(function() {
            var track_load = 0; //total loaded record group(s)
            var loading  = false; //to prevents multipal ajax loads
            var total_groups =".$total_groups."; //total record group(s)

            $('#results').load('".$fetch_page."', {'group_no':track_load}, function() {track_load++;}); //load first group

            $(window).scroll(function() { //detect page scroll

            if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
            {

            if(track_load <= total_groups && loading==false) //there's more data to load
            {
            loading = true; //prevent further ajax loading
            $('.animation_image').show(); //show loading image

            //load data from the server using a HTTP POST request
            $.post('".$fetch_page."',{'group_no': track_load}, function(data){

            $('#results').append(data); //append received data into the element

            //hide loading image
            $('.animation_image').hide(); //hide loading image once data is received

            track_load++; //loaded group increment
            loading = false;

            }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?

            alert(thrownError); //alert with HTTP error
            $('.animation_image').hide(); //hide loading image
            loading = false;

            });

            }
            }
            });
            });";

            return $res;

        }
    }
?>
