ฐานข้อมูลที่เอามาจาก RMS
1. people
2. people_dep
3. people_pro
4. std_group
5. studing
===copy ข้อมูลจาก db rms2012
============ข้อมูลครู=============================
TRUNCATE TABLE overtime.people;
INSERT INTO overtime.people SELECT * FROM rms2012.people;

===========ข้อมูลชื่อแผนก========================
TRUNCATE TABLE overtime.people_dep;
INSERT INTO overtime.people_dep SELECT * FROM rms2012.people_dep;

========ข้อมูล สังกัดแผนก==================
TRUNCATE TABLE overtime.people_pro;
INSERT INTO overtime.people_pro SELECT * FROM rms2012.people_pro;
-------------------
create view  overtime.people_pro 
as SELECT * FROM rms2012.people_pro;



======studing========
TRUNCATE TABLE overtime.studing;
INSERT INTO overtime.studing SELECT * FROM rms2012.studing;

=============================================
6. std_group สร้างจาก std2018_student
create table std_group as
SELECT DISTINCT `groupCode` as group_id,`groupName` as group_name FROM `std2018_student` 
----------------
create view overtime.std_group as
SELECT DISTINCT `groupCode` as group_id,`groupName` as group_name FROM rms2012.`std2018_student`


============================================================
7. เอาตำแหน่งหน้าที่จาก rms2020
create view  overtime.people_stagov 
as SELECT * FROM rms2012.people_stagov ;
============================================================
204  แผนกวิชาช่างไฟฟ้ากำลัง
218  แผนกวิชาช่างเทคนิคควบคุม และซ่อมบำรุงระบบขนส่งทางร...
220   3    แผนกวิชาเทคโนโลยีสารสนเทศ
1200100057540  218    7=ครูสอน,   5=หัวหน้สแผนก
ย้ายเมธาไปช่างไฟฟ้า=========
UPDATE `people_pro` SET `people_stagov_id` = '7', `people_dep_id` = '204' WHERE `people_id` = '1200100057540' 


=============================================================
SELECT DISTINCT d.`subject`,s.subject_name FROM `draw_money` d
LEFT JOIN studing s on d.`subject`=s.subject_id
WHERE `t_id`='3240400238082' AND `sem`='1/2563' order by `subject`


1810600049524
นายสันติ  
ลูกลิ้ม

3530700019448
นายวิชญวัฒน์
เกตุอู๊ต

3200200195061
นายมงคล
หุ่นดี

1103300080701
นายมงคล  


SELECT DISTINCT p1.`people_id`,
concat(p1.`people_name`,' ',p1.`people_surname`) as name ,
p3.people_stagov_name
FROM `people` p1 
INNER JOIN people_pro p2 ON p1.`people_id`=p2.`people_id` 
INNER JOIN people_stagov p3 ON p2.people_stagov_id=p3.people_stagov_id
WHERE p2.people_dep_id='200' 
and `people_exit`=0 
order by p2.people_stagov_id