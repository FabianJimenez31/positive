-- Add Config Files --
SET SESSION sql_mode="NO_AUTO_CREATE_USER";
ALTER TABLE phppos_items ADD is_osticket int(11) not null , add osticket_fields text  not null  ;
ALTER TABLE phppos_sales_items ADD is_osticket int(11) not null , add osticket_fields text  not null , add osticket_sent text  not null  , add osticket_number varchar(64) not null;
