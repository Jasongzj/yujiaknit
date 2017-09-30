/**
 * Created by Jason on 2017/7/17.
 */
/**
 * 产品图上传
 */
$(function () {
    $('#file_upload').uploadify({
        'swf'             : SCOPE.uploadify_swf,
        'uploader'        : SCOPE.image_upload,
        'buttonText'      : '点击上传图片',
        'fileTypeDesc'    : 'Image files',
        'fileObjName'     : 'file',
        'fileTypeExts'    : '*.gif; *.jpg; *.png',
        'onUploadSuccess' : function (file, data, response) {
            console.log(data);
            if(response){
                var obj = JSON.parse(data);
                $('#upload_org_code_img').attr('src', obj.data);
                $('#file_upload_image').attr('value', obj.data);
                $('#upload_org_code_img').show();
            };
        }
    });
});
