[Setup source]
1. Các config đã thiết lập cho vị trí source D:\xampp\htdocs\masterkid
  (Nếu muốn thay đổi vị trí khác thì  cấu hìnhnhớ lại sync bước 4 và Backup bước 2,3)

2. Mysql account trên local:
    + Username: root
    + Password:
    + DB: masterkid


[Setup Sync - Window]
1. Server & Local MySQL phải được mở remote connection
[http://www.cyberciti.biz/tips/how-do-i-enable-remote-access-to-mysql-database-server.html]

2*. Cấu hình đường dẫn tới PHP trong Enviornment Variables
[https://john-dugan.com/add-php-windows-path-variable]

3. Mở 2 file dbsync.ini trong folder server và folder local trong db_sync, cấu hình thông tin mysql

4. Mở 2 file "invisible.vbs" và 2 file "run.bat" trong folder server và folder local, thay ""D:\xampp\htdocs\masterkid bằng đường dẫn tới nơi đặt folder
Warning: Khi source được setup khác ổ đĩa C thì trong file run.bat phải có dòng "D:" <= ví dụ source ở ổ D.

5*. Tạo Task Scheduler với Action "Start a program"
    - 1 task scheduler cho update server to local dẫn tới "invisible.vbs" trong server
    - 1 task schedule cho update local to server dẫn tới "invisible.vbs" trong local
[http://www.digitalcitizen.life/how-create-task-basic-task-wizard]


[Setup Backup MYSQL - Window]
1. Thay đổi thông tin config:
    - FTP server vào "/masterkid/application/config/mysqlautobackup.php" từ dòng 41->44.
    Hiện tại đang mặc định là:
    + ftp_username: masterkid_dev
    + ftp_password: xI8hRwyoIM
    + ftp_server: 52.76.5.221
    + ftp_path: /public_html/backups/

    - Sửa limit backup total vào "/masterkid/application/config/mysqlautobackup.php" tại dòng 49
    Hiện tại đang mặc định là:
    + define('TOTAL_BACKUP_FILES_TO_RETAIN', 100);

2. Mở "run.bat" trong folder backups, thay "http://localhost/masterkid/backup\" thành link trên localhost hiện tại.

3. Mở file "invisible.vbs" folder backups, thay "D:\xampp\htdocs\masterkid" bằng đường dẫn tới nơi đặt folder

4*. Mở file application/libraries/mysqlautobackup.php sửa dòng 44 "/public_html/backups/[branch_code]/". [branch_code] => mã trung tâm vừa tạo

5*. Tạo Task Scheduler với Action "Start a program"
    - 1 task scheduler cho backup db dẫn tới "invisible.vbs" trong Backups
[http://www.digitalcitizen.life/how-create-task-basic-task-wizard]