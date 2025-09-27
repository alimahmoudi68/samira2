var ticket_uploader ;
jQuery(document).ready(function($){


        $('#btn_ticket_uploader').click(function(e) {
            e.preventDefault();

            
            if(ticket_uploader !== undefined){
                ticket_uploader.open();
                return;
            }
            ticket_uploader  =  wp.media({
                title : 'انتخاب فایل تیکت' ,
                button : {
                    text : 'انتخاب فایل'
                },
                multiple : false,
              

            });

            ticket_uploader.on('select' , function(){
                let selected = ticket_uploader.state().get('selection').first().toJSON();
                $('#ticket_attachment').val(selected.url);

            });

            ticket_uploader.open();



        });

    });

