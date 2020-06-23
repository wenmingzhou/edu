// ͼƬ�ϴ�demo
jQuery(function() {
    var $ = jQuery,
        $list = $('#fileList'),
        // �Ż�retina, ��retina�����ֵ��2
        ratio = window.devicePixelRatio || 1,

        // ����ͼ��С
        thumbnailWidth = 100 * ratio,
        thumbnailHeight = 100 * ratio,

        // Web Uploaderʵ��
        uploader;

    // ��ʼ��Web Uploader
    uploader = WebUploader.create({
        //���һЩ�Լ���Ҫ�Ĳ���
        formData:{
            _token:$('input[name=_token]').val(),
        },
        // �Զ��ϴ���
        auto: true,

        // swf�ļ�·��
        swf:   '/statics/webuploader/js/Uploader.swf',

        // �ļ����շ���ˡ�
        //server: '/admin/uploader/webuploader',  //���ش洢
        server: '/admin/uploader/qiniu',          //�ƴ洢

        // ѡ���ļ��İ�ť����ѡ��
        // �ڲ����ݵ�ǰ�����Ǵ�����������inputԪ�أ�Ҳ������flash.
        pick: '#filePicker',

        // ֻ����ѡ���ļ�����ѡ��
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });

    // �����ļ���ӽ�����ʱ��
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
            '<img>' +
            '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
            $img = $li.find('img');
        //���֮ǰ������
        $('.thumbnail').remove();
        $list.append( $li );

        // ��������ͼ
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>����Ԥ��</span>');
                return;
            }

            $img.attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
    });

    // �ļ��ϴ������д���������ʵʱ��ʾ��
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // �����ظ�����
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // �ļ��ϴ��ɹ�����item��ӳɹ�class, ����ʽ����ϴ��ɹ���
    uploader.on( 'uploadSuccess', function( file,response ) {
        $( '#'+file.id ).addClass('upload-state-done');
        //������ֵ��ֵд����������
        $('input[name=avatar]').val(response.path);
    });

    // �ļ��ϴ�ʧ�ܣ���ʵ�ϴ�����
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // �����ظ�����
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('�ϴ�ʧ��');
    });

    // ����ϴ����ˣ��ɹ�����ʧ�ܣ���ɾ����������
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });
});