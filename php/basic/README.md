# PHP FILE UPLOAD

`php.ini` 中与上传相关的配置，参考 [File Uploads](http://www.php.net/manual/zh/ini.core.php#ini.sect.file-uploads)

```ini
;;;;;;;;;;;;;;;;
; File Uploads ;
;;;;;;;;;;;;;;;;

; Whether to allow HTTP file uploads.
; http://php.net/file-uploads
file_uploads = On

; Temporary directory for HTTP uploaded files (will use system default if not
; specified).
; http://php.net/upload-tmp-dir
;upload_tmp_dir =
upload_tmp_dir = /www/web/demo/tmp

; Maximum allowed size for uploaded files.
; http://php.net/upload-max-filesize
upload_max_filesize = 2M

; Maximum number of files that can be uploaded via a single request
max_file_uploads = 20
```

$_FILES 全局变量的内容

```text
Array
(
    [user_file] => Array
        (
            [name] => test.py
            [type] => text/x-python
            [tmp_name] => /www/web/demo/tmp/phpltAIcc
            [error] => 0
            [size] => 29
        )
)
```

tmp_name 临时文件会在PHP脚本结束会自动删除，参考 [POST method uploads](http://www.php.net/manual/en/features.file-upload.post-method.php)

> The file will be deleted from the temporary directory at the end of the request if it has not been moved away or renamed.

PHP支持一次上传多个文件，每个请求上传最大的文件数由配置 `max_file_uploads` 进行控制，请看 `demo2.html`。

```text
Array
(
    [image] => Array
        (
            [name] => test.py
            [type] => text/x-python
            [tmp_name] => /www/web/demo/tmp/phpr2zNS0
            [error] => 0
            [size] => 29
        )

    [picture] => Array
        (
            [name] => miwifi_ssh.bin
            [type] => application/octet-stream
            [tmp_name] => /www/web/demo/tmp/phpKtpTyP
            [error] => 0
            [size] => 4464
        )
)
```

## 参考

- [PHP - File Uploading](https://www.tutorialspoint.com/php/php_file_uploading.htm)
- [Handling file uploads](http://www.php.net/manual/en/features.file-upload.php)