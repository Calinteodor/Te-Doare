$(function(){
    $('.submit-upload').on('click', function(){
        // Form serialize doesn't work for input type=file
        //var formData = $('#form-upload').serialize();
        
        var formData = new FormData($('#form-upload')[0]);
        
        console.log("FORM DATA = ", formData);
        console.log("FORM DATA FILE = ", formData.get('file'));
        
        var $bar = $('.bar');
        $bar.show();
        
        $.ajax({
            xhr:function(){
               var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener("progress",function(e){
                    console.log("PROGRESS ", e);
                    if (e.lengthComputable){
                        var percentComplete = (e.loaded / e.total * 100);
                        $('.progress').css('width', percentComplete + '%');
                        $bar.find('span').html(percentComplete + '%');
                    }
                });
                return xhr;
            },
            url: 'upload.php',
            type: 'POST',
            data: formData,
            processData:false,//always set this to false for upload
            contentType:false,//alwsays set this to false for upload
            success: function() {
                $bar.hide();   
            }
        });
    });
    
    $('[type=file]').on('change', function(){
        var file = $('[name=file]')[0].files[0],
            fileType = file.name.split('.').pop(), 
            acceptFileTypes = /^(jpg|png|gif)$/i,
            $submit = $('.submit-upload'),
            $error = $('.error-upload');
    
         // validate file size 5mb
        if (acceptFileTypes.test(fileType) === false) {
            $error.html('Invalid file type');
            $submit.attr('disabled', true);
        } 
        else {
            $error.html('');
            $submit.attr('disabled', false);
        }
    });
});