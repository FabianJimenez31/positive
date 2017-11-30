-- deliveries --
SET SESSION sql_mode="NO_AUTO_CREATE_USER";
	
INSERT INTO `phppos_modules` (`name_lang_key`, `desc_lang_key`, `sort`, `icon`, `module_id`) VALUES
('module_ostickets', 'common_view_report', 77, 'ion-android-cloud-done', 'ostickets');

INSERT INTO `phppos_permissions` (`module_id`, `person_id`) (SELECT 'ostickets', person_id FROM phppos_permissions WHERE module_id = 'sales');

INSERT INTO `phppos_modules_actions` (`action_id`, `module_id`, `action_name_key`, `sort`) VALUES ('check_update', 'ostickets', 'common_view_report', 299);

INSERT INTO phppos_permissions_actions (module_id, person_id, action_id)
SELECT DISTINCT phppos_permissions.module_id, phppos_permissions.person_id, action_id
from phppos_permissions
inner join phppos_modules_actions on phppos_permissions.module_id = phppos_modules_actions.module_id
WHERE phppos_permissions.module_id = 'ostickets' and
action_id = 'check_update'
order by module_id, person_id;

