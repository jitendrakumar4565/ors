
DELETE FROM draft_recomm_list;
DELETE FROM draft_requisition;
DELETE FROM final_recomm_list;
DELETE FROM inbox_requisition;
DELETE FROM trash_requisition;

ALTER TABLE draft_recomm_list AUTO_INCREMENT = 1;
ALTER TABLE draft_requisition AUTO_INCREMENT = 1;
ALTER TABLE final_recomm_list AUTO_INCREMENT = 1;
ALTER TABLE inbox_requisition AUTO_INCREMENT = 1;
ALTER TABLE trash_requisition AUTO_INCREMENT = 1;

