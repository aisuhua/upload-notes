resumeable

nginx

```text
wget http://nginx.org/download/nginx-1.10.3.tar.gz
wget "https://github.com/fdintino/nginx-upload-module/archive/master.zip"
./configure --add-module=/root/nginx-upload-module-master
make
make install

vim /etc/profile
export PATH=/usr/local/nginx/sbin:$PATH

apt-get install gcc make
apt-get install libpcre3 libpcre3-dev openssl libssl-dev

root@ubuntu-nginx:~/nginx-1.10.3# ./configure --add-module=/root/nginx-upload-module

./configure: error: the HTTP rewrite module requires the PCRE library.
You can either disable the module by using --without-http_rewrite_module
option, or install the PCRE library into the system, or build the PCRE library
statically from the source with nginx by using --with-pcre=<path> option.

root@ubuntu-nginx:~/nginx-1.10.3# apt-get install libpcre3 libpcre3-dev

./configure: error: SSL modules require the OpenSSL library.
You can either do not enable the modules, or install the OpenSSL library
into the system, or build the OpenSSL library statically from the source
with nginx by using --with-openssl=<path> option.

root@ubuntu-nginx:~/nginx-1.10.3# sudo apt-get install openssl libssl-dev

# 启动
/usr/local/nginx/sbin/nginx -c /usr/local/nginx/conf/nginx.conf
```

- [Ubuntu 16.04 LTS 下Nginx的编译安装与启动](https://my.oschina.net/u/923772/blog/704637)

demo.conf

```conf
server {
    listen 80;
    server_name www.demo.com;

    root /www/web/demo;
    index index.html index.htm index.php;

    # Upload form should be submitted to this location
    location /upload {
        # Pass altered request body to this location
        upload_pass /upload2.php;

        # Store files to this directory
        # The directory is hashed, subdirectories 0 1 2 3 4 5 6 7 8 9 should exist
        upload_store /www/web/demo/tmp 1;

        # Allow uploaded files to be read only by user
        upload_store_access user:r;

        # Set specified fields in request body
        upload_set_form_field $upload_field_name.name "$upload_file_name";
        upload_set_form_field $upload_field_name.content_type "$upload_content_type";
        upload_set_form_field $upload_field_name.path "$upload_tmp_path";

        # Inform backend about hash and size of a file
        # upload_aggregate_form_field "$upload_field_name.md5" "$upload_file_md5";
        upload_aggregate_form_field "$upload_field_name.sha1" "$upload_file_sha1_uc";
        upload_aggregate_form_field "$upload_field_name.size" "$upload_file_size";

        upload_pass_form_field "^submit$|^description$";

        upload_cleanup 400 404 499 500-505;
    }


    location ~ \.php$ {
        try_files $uri =404;

        include fastcgi.conf;
        fastcgi_pass 127.0.0.1:9000;
    }
}
```

接口返回内容

```text
Array
(
)
Array
(
)
Array
(
    [image_name] => upload.conf
    [image_content_type] => application/octet-stream
    [image_path] => /www/web/demo/tmp/0/0000000010
    [image_sha1] => 2DE634A1CE44BFBD3B47C30AA0FBE76FC1811E09
    [image_size] => 6463
)
```

上传多个文件时见 demo3.html，接口返回内容如下：

```text
/www/web/demo/upload.php:3:
array (size=12)
  'image_name' => string 'IMG_2849.jpg' (length=12)
  'image_content_type' => string 'image/jpeg' (length=10)
  'image_path' => string '/www/web/demo/tmp/3/0000000003' (length=30)
  'image_md5' => string 'D12222F694D51EA7C4B6127AEF029E91' (length=32)
  'image_sha1' => string '821601037678D590FA2BDF6AEED0B7DF8865A2B5' (length=40)
  'image_size' => string '152834' (length=6)
  'picture_name' => string 'miwifi_ssh.bin' (length=14)
  'picture_content_type' => string 'application/octet-stream' (length=24)
  'picture_path' => string '/www/web/demo/tmp/4/0000000004' (length=30)
  'picture_md5' => string '075D316B45118594EC3E7123BAAFFA50' (length=32)
  'picture_sha1' => string '18FF92FE6740AEBA0D41027F5E69396B0D7BEA19' (length=40)
  'picture_size' => string '4464' (length=4)
```

- [nginx-upload-module](https://github.com/fdintino/nginx-upload-module)

## 其他

- [Resumable file upload in PHP: Handle large file uploads in an elegant way](https://hackernoon.com/resumable-file-upload-in-php-handle-large-file-uploads-in-an-elegant-way-e6c6dfdeaedb)
- [tus-php](https://github.com/ankitpokhrel/tus-php/) 实现了断点续传的PHP库
- [plupload/examples/upload.php](https://github.com/moxiecode/plupload/blob/master/examples/upload.php) 分片上传的PHP实现示例
- [How to upload large files above 500MB in PHP [duplicate]](https://stackoverflow.com/questions/16102809/how-to-upload-large-files-above-500mb-in-php) 通过调整PHP配置，实现上传大文件
