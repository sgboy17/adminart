d:
cd D:\xampp\htdocs\masterkid\db_sync\local
php db-sync.phar localhost 52.76.5.221 masterkid.mk_action --target.table masterkid_root.mk_action -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_change_schedule --target.table masterkid_root.mk_change_schedule -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_class --target.table masterkid_root.mk_class -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_class_hour --target.table masterkid_root.mk_class_hour -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_invoice --target.table masterkid_root.mk_invoice -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_invoice_detail --target.table masterkid_root.mk_invoice_detail -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_room --target.table masterkid_root.mk_room -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_student --target.table masterkid_root.mk_student -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_student_class --target.table masterkid_root.mk_student_class -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_student_money --target.table masterkid_root.mk_student_money -e
php db-sync.phar localhost 52.76.5.221 masterkid.mk_student_schedule --target.table masterkid_root.mk_student_schedule -e