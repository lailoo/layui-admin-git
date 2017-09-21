<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
delimiter $$
drop procedure if exists proc_creattable;
create procedure proc_creattable
(in tablename varchar(50),
in columnnum int)

begin
declare counter int default 1;
declare addcolsqlstr varchar(100);
declare fieldname varchar(100);

	set @sql= concat("create table if not exists  ", tablename," (id int auto_increment primary key) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 ");
	prepare stmt from @sql;
	execute stmt;
	
	set counter=1;

while counter<=columnnum do

	set fieldname= concat("field_", counter) ;
	
	set @sql= concat("alter table ", tablename," add  ", fieldname, " varchar(500)");
	prepare stmt from @sql;
	execute stmt;
	set counter=counter+1;
end while;
end;
$$
delimiter ;



	
call proc_creattable('t_buildinginfo',35);
call proc_creattable('t_field_desc_map',5);

insert into t_buildinginfo(id,field_1) values(12,'sadasd');
insert into t_buildinginfo(id,field_1) values(13,'asdasd');