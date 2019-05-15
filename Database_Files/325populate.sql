/*
Alex Childers
CS 325 - Fall 2018
Last modified: 2019/02/01
*/

-- NOTE! Run this script twice to avoid any errors having to do with
-- sequence generation.

prompt ====================================
prompt Deleting any current table contents.
prompt ==================================== 

/* I've noticed that when I run these delete statements on tables that use 
   sequences, it seems like there are one or two rows that end up
   not being deleted at all for some reason. 

   I'm not getting any error messages about foreign key constraint 
   violations, but I've counted by hand and I should have at least 10 rows 
   in most of these tables. The output from running this script may show 
   8 or 9 rows being deleted, instead of 10. 

   This is an interesting bug worth exploring in the future. 

   2019/02/01: Attempted to fix the bug by changing all "delete from"s, 
   seen in delete statements from daycare_enrollment up to and including 
   cat, to "delete." This did not seem to affect the problem at all.
*/ 


delete daycare_enrollment; 
delete doggy_daycare; 
delete boarding_enrollment; 
delete boarding; 
delete class_enrollment; 
delete class_session_date; 
delete pet_permitted_in_class; 
delete class; 
delete worker_providing_service; 
delete service; 
delete volunteer_handling_permissions; 
delete volunteer; 
delete employee_formal_qualifications; 
delete employee; 
delete worker_email_addr; 
delete worker_phone_num; 
delete worker; 
delete dog; 
delete cat; 
delete pet_diet_restriction; 
delete pet_medication_needed; 
delete pet_vaccine_received; 
delete pet; 
delete owner_email_addr; 
delete owner_phone_num; 
delete owner; 

prompt ===================================================
prompt Creating sequence to generate owner_ids for Owners.
prompt ===================================================
 
drop sequence owner_id_seq; 
create sequence owner_id_seq
start with 10; 

prompt ===============================================
prompt Creating sequence to generate pet_ids for Pets.
prompt ===============================================

drop sequence pet_id_seq; 
create sequence pet_id_seq
increment by 3
start with 100000;  

prompt =====================================================
prompt Creating sequence to generate worker_ids for Workers. 
prompt =====================================================

drop sequence worker_id_seq; 
create sequence worker_id_seq
increment by 2
start with 300000;

prompt ==============================================================
prompt Creating sequence to generate the numeric part of section_ids
prompt for Services.
prompt ==============================================================

drop sequence section_id_seq; 
create sequence section_id_seq
start with 10000; 

prompt ============================================================
prompt Creating sequence to generate unique enrollment numbers for 
prompt Class, Boarding, and Daycare enrollments. 
prompt ============================================================

drop sequence enroll_num_seq; 
create sequence enroll_num_seq
start with 5000000;

prompt ==========================
prompt Inserting rows into Owner.
prompt ========================== 

insert into owner
values
(owner_id_seq.nextval, 'Maya', 'Smith'); 

insert into owner
values
(owner_id_seq.nextval, 'Karen', 'Gearhardt');

insert into owner
values
(owner_id_seq.nextval, 'Lea', 'Krakowski');

insert into owner
values
(owner_id_seq.nextval, 'Kaisa', 'Tiryaki');

insert into owner
values
(owner_id_seq.nextval, 'Romulo', 'Santiago');

insert into owner
values
(owner_id_seq.nextval, 'Brecht', 'Zambrano');

insert into owner
values
(owner_id_seq.nextval, 'Maisie', 'Johanneson');

insert into owner
values
(owner_id_seq.nextval, 'Wanda', 'Taggart');

insert into owner
values
(owner_id_seq.nextval, 'Ernie', 'Smith');

insert into owner
values
(owner_id_seq.nextval, 'Rudolf', 'Siskind');

insert into owner
values
(owner_id_seq.nextval, 'Desmond', 'Boone');

prompt ===================================
prompt Inserting rows into Owner_phone_num. 
prompt =================================== 

insert into owner_phone_num
values
(10, '5185550192');

insert into owner_phone_num
values
(11, '4105550133');

insert into owner_phone_num
values
(12, '4045550154');

insert into owner_phone_num
values
(13, '2075550181');

insert into owner_phone_num
values
(13, '5735550193'); 

insert into owner_phone_num
values
(13, '5735550120'); 

insert into owner_phone_num
values
(14, '5125550172');

insert into owner_phone_num
values
(15, '2255550101');

insert into owner_phone_num
values
(15, '5155550114');

insert into owner_phone_num
values
(16, '5125550192');

insert into owner_phone_num
values
(17, '7015550197');

insert into owner_phone_num
values
(18, '2085550124');

insert into owner_phone_num
values
(18, '4025550114');

insert into owner_phone_num
values
(19, '6175550188');

insert into owner_phone_num
values
(19, '9195550188');

insert into owner_phone_num
values
(20, '7755550128');

prompt =====================================
prompt Inserting rows into Owner_email_addr.
prompt =====================================

insert into owner_email_addr
values
(10, 'mayasmith@webmail.aa'); 

insert into owner_email_addr
values
(13, 'kaisa@kaisatiryaki.com'); 

insert into owner_email_addr
values
(13, 'ktiry12@webmail.aa');

insert into owner_email_addr
values
(11, 'gearhardtka@coldmail.net');

insert into owner_email_addr
values
(14, 'romsant1@csumed.edu');

insert into owner_email_addr
values
(14, 'rsantiago@coldmail.net');

insert into owner_email_addr
values
(15, 'therealmothman@webmail.aa');

insert into owner_email_addr
values
(16, 'maisiemae@coldmail.net');

insert into owner_email_addr
values
(18, 'ernie@erniesmith.net');

insert into owner_email_addr
values
(18, 'oovoojaver@coldmail.net');

insert into owner_email_addr
values
(20, 'dboone@csumed.edu');

prompt ========================
prompt Inserting rows into Pet. 
prompt ======================== 

insert into pet(pet_id, pet_name, sex, is_spayed_neutered, pet_type, owner_id)
values
(pet_id_seq.nextval, 'Kiwi', 'f', 'y', 'cat', 10);

insert into pet
values 
(pet_id_seq.nextval, 'Rosie', 'f', 'y', '15-NOV-2010', 'dog', 11); 

insert into pet
values
(pet_id_seq.nextval, 'Chewy', 'm', 'n', '02-APR-2004', 'dog', 11); 

insert into pet
values
(pet_id_seq.nextval, 'Cobain', 'm', 'y', '30-SEP-2006', 'cat', 12); 

insert into pet(pet_id, pet_name, sex, is_spayed_neutered, pet_type, owner_id)
values
(pet_id_seq.nextval, 'Gertrude', 'f', 'n', 'dog', 13);

insert into pet(pet_id, pet_name, sex, is_spayed_neutered, pet_type, owner_id)
values
(pet_id_seq.nextval, 'Chips', 'm', 'y', 'dog', 13);

insert into pet
values
(pet_id_seq.nextval, 'Katrina', 'f', 'y', '12-MAR-2012', 'dog', 14);

insert into pet
values
(pet_id_seq.nextval, 'Mambo', 'm', 'n', '24-DEC-2015', 'cat', 15);

insert into pet
values
(pet_id_seq.nextval, 'Lamar', 'm', 'y', '18-JUN-2010', 'dog', 16);

insert into pet
values
(pet_id_seq.nextval, 'Huck', 'm', 'y', '04-JAN-2013', 'cat', 17);

insert into pet
values
(pet_id_seq.nextval, 'Baldy', 'f', 'y', '22-OCT-2014', 'cat', 18);

insert into pet
values
(pet_id_seq.nextval, 'Tofu', 'f', 'y', '01-JAN-2015', 'dog', 19);

insert into pet(pet_id, pet_name, sex, is_spayed_neutered, pet_type, owner_id)
values
(pet_id_seq.nextval, 'Royal', 'm', 'y', 'dog', 20);

insert into pet(pet_id, pet_name, sex, is_spayed_neutered, pet_type, owner_id)
values
(pet_id_seq.nextval, 'Rum', 'f', 'y', 'dog', 20);

insert into pet
values
(pet_id_seq.nextval, 'Windsor', 'm', 'y', '25-DEC-2015', 'cat', 10);

insert into pet
values
(pet_id_seq.nextval, 'Bandit', 'm', 'y', '03-DEC-2009', 'cat', 12);

insert into pet
values
(pet_id_seq.nextval, 'Layla', 'f', 'y', '31-JAN-2008', 'cat', 14);

insert into pet
values
(pet_id_seq.nextval, 'Trix', 'f', 'y', '05-FEB-2010', 'cat', 16);

insert into pet
values
(pet_id_seq.nextval, 'Magnus', 'm', 'y', '18-MAR-2013', 'dog', 18);

insert into pet
values
(pet_id_seq.nextval, 'Carl', 'm', 'y', '02-APR-2014', 'cat', 20);

prompt =========================================
prompt Inserting rows into Pet_vaccine_received.
prompt =========================================

insert into pet_vaccine_received
values
(100003, 'distemper', '02-NOV-2012'); 

insert into pet_vaccine_received
values
(100003, 'rabies', '02-NOV-2012'); 

insert into pet_vaccine_received
values
(100006, 'distemper', '04-APR-2011');

insert into pet_vaccine_received
values
(100006, 'rabies', '23-MAR-2011');

insert into pet_vaccine_received
values
(100009, 'distemper', '31-AUG-2005');

insert into pet_vaccine_received
values
(100009, 'rabies', '11-SEP-2005');

insert into pet_vaccine_received
values
(100012, 'distemper', '03-JAN-2007');

insert into pet_vaccine_received
values
(100012, 'rabies', '27-DEC-2006');

insert into pet_vaccine_received
values
(100015, 'distemper', '09-JUN-2016');

insert into pet_vaccine_received
values
(100015, 'rabies', '18-JUL-2016');

insert into pet_vaccine_received
values
(100018, 'distemper', '29-AUG-2010');

insert into pet_vaccine_received
values
(100018, 'rabies', '19-JUL-2010');

insert into pet_vaccine_received
values
(100021, 'distemper', '09-FEB-2014');

insert into pet_vaccine_received
values
(100021, 'rabies', '09-FEB-2014');

insert into pet_vaccine_received
values
(100024, 'distemper', '18-MAR-2016');

insert into pet_vaccine_received
values
(100024, 'rabies', '03-APR-2016');

insert into pet_vaccine_received
values
(100027, 'distemper', '16-OCT-2011');

insert into pet_vaccine_received
values
(100027, 'rabies', '16-OCT-2011');

insert into pet_vaccine_received
values
(100030, 'distemper', '10-MAY-2014');

insert into pet_vaccine_received
values
(100030, 'rabies', '13-MAY-2014');

insert into pet_vaccine_received
values
(100033, 'distemper', '12-JAN-2015');

insert into pet_vaccine_received
values
(100033, 'rabies', '12-JAN-2015');

insert into pet_vaccine_received
values
(100036, 'distemper', '02-AUG-2015');

insert into pet_vaccine_received
values
(100036, 'rabies', '25-AUG-2015');

insert into pet_vaccine_received
values
(100039, 'distemper', '23-MAR-2015');

insert into pet_vaccine_received
values
(100039, 'rabies', '12-APR-2015');

insert into pet_vaccine_received
values
(100000, 'distemper', '07-AUG-2010');

insert into pet_vaccine_received
values
(100000, 'rabies', '07-AUG-2010');

insert into pet_vaccine_received
values
(100045, 'distemper', '03-MAR-2010');

insert into pet_vaccine_received
values
(100045, 'rabies', '03-MAR-2010');

insert into pet_vaccine_received
values
(100051, 'distemper', '01-AUG-2010');

insert into pet_vaccine_received
values
(100051, 'rabies', '01-AUG-2010');

insert into pet_vaccine_received
values
(100054, 'distemper', '15-OCT-2013');

insert into pet_vaccine_received
values
(100054, 'rabies', '15-OCT-2013');

insert into pet_vaccine_received
values
(100048, 'distemper', '24-MAY-2008');

insert into pet_vaccine_received
values
(100048, 'rabies', '24-MAY-2008');

insert into pet_vaccine_received
values
(100042, 'distemper', '10-MAR-2016');

insert into pet_vaccine_received
values
(100042, 'rabies', '10-MAR-2016');

insert into pet_vaccine_received
values
(100057, 'distemper', '18-AUG-2014');

insert into pet_vaccine_received
values
(100057, 'rabies', '18-AUG-2014');

prompt ==========================================
prompt Inserting rows into Pet_medication_needed. 
prompt ==========================================

insert into pet_medication_needed
values
(100003, 'Amoxicillin', '50 mg'); 

insert into pet_medication_needed
values
(100003, 'Aspirin', '75 mg');

insert into pet_medication_needed
values
(100006, 'Tramadol', '10 mg');

insert into pet_medication_needed
values
(100009, 'Simplicef', '10 mg');

insert into pet_medication_needed
values
(100009, 'Orbax', '5 mg');

insert into pet_medication_needed
values
(100015, 'Hydrocodone', '1 mg');

insert into pet_medication_needed
values
(100015, 'Erythromycin', '50 mg');

insert into pet_medication_needed
values
(100015, 'Fluconazole', '50 mg');

insert into pet_medication_needed
values
(100027, 'Trimethoprim', '75 mg');

insert into pet_medication_needed
values
(100036, 'Melatonin', '1 mg');

prompt =========================================
prompt Inserting rows into Pet_diet_restriction.
prompt =========================================

insert into pet_diet_restriction
values
(100006, 'wet food only'); 

insert into pet_diet_restriction
values
(100006, 'no dairy');

insert into pet_diet_restriction
values
(100009, 'no chicken');

insert into pet_diet_restriction
values
(100012, 'wet food only');

insert into pet_diet_restriction
values
(100012, 'no fish');

insert into pet_diet_restriction
values
(100021, 'no soy');

insert into pet_diet_restriction
values
(100024, 'no wheat');

insert into pet_diet_restriction
values
(100030, 'no chicken');

insert into pet_diet_restriction
values
(100036, 'wet food only');

insert into pet_diet_restriction
values
(100036, 'no chicken'); 

prompt ========================
prompt Inserting rows into Cat. 
prompt ========================

insert into cat
values
(100000);

insert into cat
values
(100009);

insert into cat
values
(100021);

insert into cat
values
(100027);

insert into cat
values
(100030);

insert into cat
values
(100042);

insert into cat
values
(100045);

insert into cat
values
(100048);

insert into cat
values
(100051);

insert into cat
values
(100057);

prompt ========================
prompt Inserting rows into Dog. 
prompt ========================

insert into dog 
values
(100003, 'small'); 

insert into dog
values
(100006, 'medium');

insert into dog
values
(100012, 'large');

insert into dog
values
(100015, 'small');

insert into dog
values
(100018, 'medium');

insert into dog
values
(100024, 'large');

insert into dog
values
(100033, 'small');

insert into dog
values
(100036, 'medium');

insert into dog
values
(100039, 'large');

insert into dog
values
(100054, 'small');

prompt ===========================
prompt Inserting rows into Worker. 
prompt ===========================

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Dua', 'Mcknight'); 

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Konrad', 'Goddard');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Daphne', 'Villanueva');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Marian', 'Sosa');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Fannie', 'Paine');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Tala', 'Grey');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Jovan', 'Gale');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Josef', 'Finley');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Aubree', 'Cole');

insert into worker
values
(worker_id_seq.nextval, 'employee', 'Scott', 'Millar');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Kara', 'Kelley');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Blaine', 'Henderson');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Saara', 'Thorne');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Zayden', 'Powell');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Alexis', 'Li');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Loren', 'Daniel');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Stanislaw', 'Wicks');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Prisha', 'Mills');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Hall', 'Needham');

insert into worker
values
(worker_id_seq.nextval, 'volunteer', 'Claire', 'Strong');

prompt =====================================
prompt Inserting rows into Worker_phone_num. 
prompt =====================================

insert into worker_phone_num
values
(300000, '3175550148'); 

insert into worker_phone_num
values
(300002, '3175550158');

insert into worker_phone_num
values
(300002, '3175550152');

insert into worker_phone_num
values
(300004, '3175550162');

insert into worker_phone_num
values
(300006, '3175550113');

insert into worker_phone_num
values
(300006, '3175550145');

insert into worker_phone_num
values
(300006, '3175550148');

insert into worker_phone_num
values
(300008, '6015550190');

insert into worker_phone_num
values
(300010, '6015550186');

insert into worker_phone_num
values
(300012, '6015550169');

insert into worker_phone_num
values
(300014, '6015550161');

insert into worker_phone_num
values
(300016, '6015550168');

insert into worker_phone_num
values
(300018, '6015550115');

insert into worker_phone_num
values
(300018, '9045550128');

insert into worker_phone_num
values
(300020, '9045550118');

insert into worker_phone_num
values
(300022, '9045550174');

insert into worker_phone_num
values
(300024, '9045550132');

insert into worker_phone_num
values
(300024, '9045550114');

insert into worker_phone_num
values
(300026, '9045550188');

insert into worker_phone_num
values
(300028, '5735550115');

insert into worker_phone_num
values
(300030, '5735550107');

insert into worker_phone_num
values
(300032, '5735550169');

insert into worker_phone_num
values
(300034, '5735550182');

insert into worker_phone_num
values
(300036, '5735550156');

insert into worker_phone_num
values
(300038, '5735550111');

prompt ======================================
prompt Inserting rows into Worker_email_addr. 
prompt ======================================

insert into worker_email_addr
values
(300000, 'dmcknight@lcpetboarding.net'); 

insert into worker_email_addr
values
(300002, 'kgoddard@lcpetboarding.net');

insert into worker_email_addr
values
(300004, 'dvillanueva@lcpetboarding.net');

insert into worker_email_addr
values
(300006, 'msosa@lcpetboarding.net');

insert into worker_email_addr
values
(300008, 'fpaine@lcpetboarding.net');

insert into worker_email_addr
values
(300010, 'tgrey@lcpetboarding.net');

insert into worker_email_addr
values
(300012, 'jgale@lcpetboarding.net');

insert into worker_email_addr
values
(300014, 'jfinley@lcpetboarding.net');

insert into worker_email_addr
values
(300016, 'acole@lcpetboarding.net');

insert into worker_email_addr
values
(300018, 'smillar@lcpetboarding.net');

insert into worker_email_addr
values
(300020, 'kara.kelley@webmail.aa');

insert into worker_email_addr
values
(300020, 'kkelley@coldmail.net');

insert into worker_email_addr
values
(300022, 'blaineh@webmail.aa');

insert into worker_email_addr
values
(300024, 'saara.thorne3@webmail.aa');

insert into worker_email_addr
values
(300024, 'sthorne@csumed.edu');

insert into worker_email_addr
values
(300026, 'zaydenpowell@webmail.aa');

insert into worker_email_addr
values
(300028, 'alexisli@coldmail.net');

insert into worker_email_addr
values
(300030, 'me@lorendaniel.com');

insert into worker_email_addr
values
(300032, 'stan_wicks@webmail.aa');

insert into worker_email_addr
values
(300034, 'prish44@webmail.aa');

insert into worker_email_addr
values
(300034, 'prisha.mills@csumed.edu');

insert into worker_email_addr
values
(300036, 'look@allthosechickens.qw');

insert into worker_email_addr
values
(300036, 'hneedham@webmail.aa'); 

insert into worker_email_addr
values
(300038, 'clairestrong@webmail.aa'); 

prompt =============================
prompt Inserting rows into Employee. 
prompt =============================

insert into employee
values
(300000, 'Veterinarian', 3461.50, '23-JAN-2008'); 

insert into employee
values
(300002, 'Groomer', 1538.50, '12-FEB-2008'); 

insert into employee
values
(300004, 'Groomer', 1541, '20-MAR-2010'); 

insert into employee
values
(300006, 'Teacher', 1540, '06-APR-2011');

insert into employee
values
(300008, 'Teacher', 1545, '01-MAY-2012');

insert into employee
values
(300010, 'Veterinarian', 3455, '27-JUN-2013');

insert into employee
values
(300012, 'Animal Care Associate', 1155, '23-JAN-2008'); 

insert into employee
values
(300014, 'Animal Care Associate', 1154, '30-AUG-2008'); 

insert into employee
values
(300016, 'Animal Care Associate', 1153, '11-SEP-2016');

insert into employee
values
(300018, 'Animal Care Associate', 1150.50, '20-OCT-2017'); 

prompt ===================================================
prompt Inserting rows into Employee_formal_qualifications. 
prompt ===================================================

insert into employee_formal_qualifications
values
(300000, 'Bachelor of Science in Zoology'); 

insert into employee_formal_qualifications
values
(300000, 'Doctor of Veterinary Medicine');

insert into employee_formal_qualifications
values
(300000, 'Diplomate of the Western University College of Veterinary Medicine'); 

insert into employee_formal_qualifications
values
(300000, 'Certificate of Specialization in Canine Health');

insert into employee_formal_qualifications
values
(300010, 'Doctor of Veterinary Medicine');

insert into employee_formal_qualifications
values
(300010, 'Diplomate of the University of Smithton Veterinary School');

insert into employee_formal_qualifications
values
(300010, 'Bachelor of Science in Biology');

insert into employee_formal_qualifications
values
(300010, 'Certificate of Accreditation in Feline Organ Systems');

insert into employee_formal_qualifications
values
(300002, 'Completion of Apprenticeship in Grooming');

insert into employee_formal_qualifications
values
(300002, 'General Education Diploma');

insert into employee_formal_qualifications
values
(300004, 'High School Diploma');

insert into employee_formal_qualifications
values
(300004, 'National Certified Master Groomer');

insert into employee_formal_qualifications
values
(300004, 'Completion of Apprenticeship in Grooming');

insert into employee_formal_qualifications
values
(300006, 'High School Diploma');

insert into employee_formal_qualifications
values
(300008, 'Certified Professional Dog Trainer');

insert into employee_formal_qualifications
values
(300012, 'General Education Diploma');

insert into employee_formal_qualifications
values
(300016, 'Associate of Science in Chemistry');

prompt ==============================
prompt Inserting rows into Volunteer. 
prompt ==============================

insert into volunteer
values
(300020); 

insert into volunteer
values
(300022);

insert into volunteer
values
(300024);

insert into volunteer
values
(300026);

insert into volunteer
values
(300028);

insert into volunteer
values
(300030);

insert into volunteer
values
(300032);

insert into volunteer
values
(300034);

insert into volunteer
values
(300036);

insert into volunteer
values
(300038);

prompt ===================================================
prompt Inserting rows into Volunteer_handling_permissions. 
prompt ===================================================

insert into volunteer_handling_permissions
values
(300020, 'dog');

insert into volunteer_handling_permissions
values
(300020, 'cat');

insert into volunteer_handling_permissions
values
(300022, 'dog');

insert into volunteer_handling_permissions
values
(300024, 'cat');

insert into volunteer_handling_permissions
values
(300026, 'dog');

insert into volunteer_handling_permissions
values
(300026, 'cat');

insert into volunteer_handling_permissions
values
(300028, 'dog');

insert into volunteer_handling_permissions
values
(300028, 'cat');

insert into volunteer_handling_permissions
values
(300030, 'dog');

insert into volunteer_handling_permissions
values
(300032, 'cat');

insert into volunteer_handling_permissions
values
(300034, 'dog');

insert into volunteer_handling_permissions
values
(300034, 'cat');

insert into volunteer_handling_permissions
values
(300036, 'dog');

insert into volunteer_handling_permissions
values
(300036, 'cat');

insert into volunteer_handling_permissions
values
(300038, 'dog');

prompt ============================
prompt Inserting rows into Service. 
prompt ============================

insert into service
values
('B' || section_id_seq.nextval, 'boarding'); 

insert into service
values
('B' || section_id_seq.nextval, 'boarding');

insert into service
values
('B' || section_id_seq.nextval, 'boarding');

insert into service
values
('B' || section_id_seq.nextval, 'boarding');

insert into service
values
('D' || section_id_seq.nextval, 'daycare');

insert into service
values
('D' || section_id_seq.nextval, 'daycare');

insert into service
values
('D' || section_id_seq.nextval, 'daycare');

insert into service
values
('D' || section_id_seq.nextval, 'daycare');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

insert into service
values
('C' || section_id_seq.nextval, 'class');

prompt =============================================
prompt Inserting rows into Worker_providing_service. 
prompt =============================================

insert into worker_providing_service
values
(300000, 'B10000'); 

insert into worker_providing_service
values
(300000, 'B10001');

insert into worker_providing_service
values
(300000, 'B10002');

insert into worker_providing_service
values
(300000, 'B10003');

insert into worker_providing_service
values
(300010, 'D10004');

insert into worker_providing_service
values
(300010, 'D10005');

insert into worker_providing_service
values
(300010, 'D10006');

insert into worker_providing_service
values
(300010, 'D10007');

insert into worker_providing_service
values
(300002, 'B10000');

insert into worker_providing_service
values
(300002, 'B10001');

insert into worker_providing_service
values
(300002, 'B10002');

insert into worker_providing_service
values
(300002, 'B10003');

insert into worker_providing_service
values
(300004, 'D10004');

insert into worker_providing_service
values
(300004, 'D10005');

insert into worker_providing_service
values
(300004, 'D10006');

insert into worker_providing_service
values
(300004, 'D10007');

insert into worker_providing_service
values
(300006, 'C10008');

insert into worker_providing_service
values
(300006, 'C10009');

insert into worker_providing_service
values
(300006, 'C10010');

insert into worker_providing_service
values
(300006, 'C10011');

insert into worker_providing_service
values
(300006, 'C10012');

insert into worker_providing_service
values
(300008, 'C10013');

insert into worker_providing_service
values
(300008, 'C10014');

insert into worker_providing_service
values
(300008, 'C10015');

insert into worker_providing_service
values
(300008, 'C10016');

insert into worker_providing_service
values
(300008, 'C10017');

insert into worker_providing_service
values
(300012, 'B10000');

insert into worker_providing_service
values
(300012, 'B10001');

insert into worker_providing_service
values
(300014, 'B10002');

insert into worker_providing_service
values
(300014, 'B10003');

insert into worker_providing_service
values
(300016, 'D10004');

insert into worker_providing_service
values
(300016, 'D10005');

insert into worker_providing_service
values
(300018, 'D10006');

insert into worker_providing_service
values
(300018, 'D10007');

/* Here, I am assigning each volunteer one Boarding session to focus on.
   That being said, according to the business rules, workers (including
   volunteers) are perfectly welcome to help with other services as well.
   These are just the ones that they are being asked to focus on for now.
   
   Perhaps volunteers who have been with Loving Care Pet Boarding for a
   long time and have lots of experience would be permitted to help out 
   with multiple sections or with daycare, or even classes in the future.
   When these experienced volunteers help with multiple services on a 
   regular basis, those might be added to the database to more accurately 
   reflect volunteer activities. 
*/

insert into worker_providing_service
values
(300020, 'B10000'); 

insert into worker_providing_service
values
(300022, 'B10001');

insert into worker_providing_service
values
(300024, 'B10002');

insert into worker_providing_service
values
(300026, 'B10003');

insert into worker_providing_service
values
(300028, 'B10000');

insert into worker_providing_service
values
(300030, 'B10001');

insert into worker_providing_service
values
(300032, 'B10002');

insert into worker_providing_service
values
(300034, 'B10003');

insert into worker_providing_service
values
(300036, 'B10000');

insert into worker_providing_service
values
(300038, 'B10001');

prompt ==========================
prompt Inserting rows into Class. 
prompt ==========================

insert into class 
values
('C10008', 'Dog Obedience Training 1', 120); 

insert into class
values
('C10009', 'Dog Obedience Training 2', 120);

insert into class
values
('C10010', 'Dog Obedience Training 3', 120);

insert into class
values
('C10011', 'Dog Obedience Training 4', 120);

insert into class
values
('C10012', 'Dog Socialization', 100);

insert into class
values
('C10013', 'Cat Leash Training', 100);

insert into class
values
('C10014', 'Taming Cat Behavioral Problems', 120);

insert into class
values
('C10015', 'Building Trust With Your Pet', 120);

insert into class
values
('C10016', 'Puppy Training', 120); 

insert into class
values
('C10017', 'Therapy Dog Training', 120); 

prompt ===========================================
prompt Inserting rows into Pet_permitted_in_class. 
prompt ===========================================

insert into pet_permitted_in_class
values
('C10008', 'dog'); 

insert into pet_permitted_in_class
values
('C10009', 'dog');

insert into pet_permitted_in_class
values
('C10010', 'dog');

insert into pet_permitted_in_class
values
('C10011', 'dog');

insert into pet_permitted_in_class
values
('C10012', 'dog');

insert into pet_permitted_in_class
values
('C10013', 'cat');

insert into pet_permitted_in_class
values
('C10015', 'dog');

insert into pet_permitted_in_class
values
('C10015', 'cat');

insert into pet_permitted_in_class
values
('C10016', 'dog');

insert into pet_permitted_in_class
values
('C10017', 'dog');

prompt =======================================
prompt Inserting rows into Class_session_date. 
prompt =======================================

insert into class_session_date
values
('C10008', '07-JAN-2019'); 

insert into class_session_date
values
('C10008', '14-JAN-2019');

insert into class_session_date
values
('C10008', '21-JAN-2019');

insert into class_session_date
values
('C10008', '28-JAN-2019');

insert into class_session_date
values
('C10008', '04-FEB-2019');

insert into class_session_date
values
('C10008', '11-FEB-2019');

insert into class_session_date
values
('C10009', '08-JAN-2019');

insert into class_session_date
values
('C10009', '15-JAN-2019');

insert into class_session_date
values
('C10009', '22-JAN-2019');

insert into class_session_date
values
('C10009', '29-JAN-2019');

insert into class_session_date
values
('C10009', '05-FEB-2019');

insert into class_session_date
values
('C10009', '12-FEB-2019');

insert into class_session_date
values
('C10010', '09-JAN-2019');

insert into class_session_date
values
('C10010', '16-JAN-2019');

insert into class_session_date
values
('C10010', '23-JAN-2019');

insert into class_session_date
values
('C10010', '30-JAN-2019');

insert into class_session_date
values
('C10010', '06-FEB-2019');

insert into class_session_date
values
('C10010', '13-FEB-2019');

insert into class_session_date
values
('C10011', '10-JAN-2019');

insert into class_session_date
values
('C10011', '17-JAN-2019');

insert into class_session_date
values
('C10011', '24-JAN-2019');

insert into class_session_date
values
('C10011', '31-JAN-2019');

insert into class_session_date
values
('C10011', '07-FEB-2019');

insert into class_session_date
values
('C10011', '14-FEB-2019');

insert into class_session_date
values
('C10012', '11-JAN-2019');

insert into class_session_date
values
('C10012', '18-JAN-2019');

insert into class_session_date
values
('C10012', '25-JAN-2019');

insert into class_session_date
values
('C10012', '01-FEB-2019');

insert into class_session_date
values
('C10012', '08-FEB-2019');

insert into class_session_date
values
('C10012', '15-FEB-2019');

insert into class_session_date
values
('C10013', '07-JAN-2019');

insert into class_session_date
values
('C10013', '14-JAN-2019');

insert into class_session_date
values
('C10013', '21-JAN-2019');

insert into class_session_date
values
('C10013', '28-JAN-2019');

insert into class_session_date
values
('C10013', '04-FEB-2019');

insert into class_session_date
values
('C10013', '11-FEB-2019');

insert into class_session_date
values
('C10014', '08-JAN-2019');

insert into class_session_date
values
('C10014', '15-JAN-2019');

insert into class_session_date
values
('C10014', '22-JAN-2019');

insert into class_session_date
values
('C10014', '29-JAN-2019');

insert into class_session_date
values
('C10014', '05-FEB-2019');

insert into class_session_date
values
('C10014', '12-FEB-2019');

insert into class_session_date
values
('C10015', '09-JAN-2019');

insert into class_session_date
values
('C10015', '16-JAN-2019');

insert into class_session_date
values
('C10015', '23-JAN-2019');

insert into class_session_date
values
('C10015', '30-JAN-2019');

insert into class_session_date
values
('C10015', '06-FEB-2019');

insert into class_session_date
values
('C10015', '13-FEB-2019');

insert into class_session_date
values
('C10016', '10-JAN-2019');

insert into class_session_date
values
('C10016', '17-JAN-2019');

insert into class_session_date
values
('C10016', '24-JAN-2019');

insert into class_session_date
values
('C10016', '31-JAN-2019');

insert into class_session_date
values
('C10016', '07-FEB-2019');

insert into class_session_date
values
('C10016', '14-FEB-2019');

insert into class_session_date
values
('C10017', '11-JAN-2019');

insert into class_session_date
values
('C10017', '18-JAN-2019');

insert into class_session_date
values
('C10017', '25-JAN-2019');

insert into class_session_date
values
('C10017', '01-FEB-2019');

insert into class_session_date
values
('C10017', '08-FEB-2019');

insert into class_session_date
values
('C10017', '15-FEB-2019');

prompt =====================================
prompt Inserting rows into Class_enrollment. 
prompt =====================================

insert into class_enrollment
values
(enroll_num_seq.nextval, 11, 'C10008', '23-NOV-2018', 100003); 

insert into class_enrollment
values
(enroll_num_seq.nextval, 12, 'C10015', '01-NOV-2018', 100009);

insert into class_enrollment
values
(enroll_num_seq.nextval, 13, 'C10008', '12-NOV-2018', 100015);

insert into class_enrollment
values
(enroll_num_seq.nextval, 14, 'C10015', '18-NOV-2018', 100018);

insert into class_enrollment
values
(enroll_num_seq.nextval, 15, 'C10013', '04-NOV-2018', 100021);

insert into class_enrollment
values
(enroll_num_seq.nextval, 16, 'C10017', '09-NOV-2018', 100024);

insert into class_enrollment
values
(enroll_num_seq.nextval, 17, 'C10013', '15-NOV-2018', 100027);

insert into class_enrollment (enroll_num, owner_id, section_id, date_enrolled)
values
(enroll_num_seq.nextval, 18, 'C10014', '19-NOV-2018');

insert into class_enrollment
values
(enroll_num_seq.nextval, 19, 'C10009', '23-NOV-2018', 100033);

insert into class_enrollment (enroll_num, owner_id, section_id)
values
(enroll_num_seq.nextval, 20, 'C10014'); 

insert into class_enrollment
values
(enroll_num_seq.nextval, 16, 'C10011', sysdate, 100024); 

insert into class_enrollment
values
(enroll_num_seq.nextval, 20, 'C10008', sysdate, 100036); 

insert into class_enrollment 
values
(enroll_num_seq.nextval, 20, 'C10009', sysdate, 100039); 

insert into class_enrollment 
values
(enroll_num_seq.nextval, 18, 'C10010', sysdate, 100054); 

prompt =============================
prompt Inserting rows into Boarding. 
prompt =============================

-- The "Fixed" boarding sections are for pets who have been spayed
-- or neutered. 

insert into boarding
values
('B10000', 'Regular (Fixed)', 15, 30);

insert into boarding
values
('B10001', 'Deluxe (Fixed)', 20, 40);

-- The "Not Fixed" boarding sections are for pets who have
-- NOT been spayed or neutered. These cost more.

insert into boarding
values
('B10002', 'Regular (Not Fixed)', 20, 38);

insert into boarding
values
('B10003', 'Deluxe (Not Fixed)', 25, 48);

prompt ========================================
prompt Inserting rows into Boarding_enrollment. 
prompt ========================================

insert into boarding_enrollment 
values
(enroll_num_seq.nextval, 100003, 'B10000', '19-NOV-2018', '23-DEC-2018', '31-DEC-2018');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100006, 'B10002', '19-NOV-2018', '14-DEC-2018', '18-DEC-2018'); 

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100012, 'B10003', '28-NOV-2018', '27-DEC-2018', '02-JAN-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100015, 'B10001', '11-NOV-2018', '09-DEC-2018', '13-DEC-2018');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100021, 'B10003', '02-NOV-2018', '28-DEC-2018', '30-DEC-2018');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100033, 'B10000', '30-NOV-2018', '02-JAN-2019', '09-JAN-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100039, 'B10001', '29-NOV-2018', '10-DEC-2018', '13-DEC-2018');

insert into boarding_enrollment (enroll_num, pet_id, section_id, start_date, end_date)
values
(enroll_num_seq.nextval, 100042, 'B10000', '08-DEC-2018', '11-DEC-2018'); 

insert into boarding_enrollment (enroll_num, pet_id, section_id, start_date, end_date)
values
(enroll_num_seq.nextval, 100051, 'B10001', '19-DEC-2018', '22-DEC-2018'); 

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100003, 'B10000', '19-NOV-2018', '28-JAN-2019', '01-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100006, 'B10002', '19-NOV-2018', '29-JAN-2019', '02-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100012, 'B10003', '28-NOV-2018', '27-JAN-2019', '03-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100015, 'B10001', '11-NOV-2018', '28-JAN-2019', '02-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100021, 'B10003', '02-NOV-2018', '29-JAN-2019', '03-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100033, 'B10000', '30-NOV-2018', '27-JAN-2019', '02-FEB-2019');

insert into boarding_enrollment
values
(enroll_num_seq.nextval, 100039, 'B10001', '29-NOV-2018', '28-JAN-2019', '03-FEB-2019');


prompt ==================================
prompt Inserting rows into Doggy_daycare. 
prompt ==================================

-- The "Fixed" daycare sections are for dogs who have been spayed
-- or neutered.

insert into doggy_daycare
values
('D10004', 'Regular (Fixed)', 10, 20);

insert into doggy_daycare
values
('D10005', 'Deluxe (Fixed)', 15, 30);

-- The "Not Fixed" daycare sections are for pets who have
-- NOT been spayed or neutered. These cost more.

insert into doggy_daycare
values
('D10006', 'Regular (Not Fixed)', 15, 28);

insert into doggy_daycare
values
('D10007', 'Deluxe (Not Fixed)', 20, 38);

prompt =======================================
prompt Inserting rows into Daycare_enrollment. 
prompt =======================================

insert into daycare_enrollment
values 
(enroll_num_seq.nextval, 100054, 'D10004', '10-DEC-2018', '27-NOV-2018', 0830, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100054, 'D10004', '11-DEC-2018', '27-NOV-2018', 0830, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100054, 'D10004', '12-DEC-2018', '27-NOV-2018', 0830, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100054, 'D10004', '13-DEC-2018', '27-NOV-2018', 0830, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100039, 'D10005', '07-DEC-2018', '01-DEC-2018', 0900, 1330);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100039, 'D10005', '13-DEC-2018', '01-DEC-2018', 0900, 1330);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100039, 'D10005', '14-DEC-2018', '01-DEC-2018', 1000, 1500); 

insert into daycare_enrollment(enroll_num, pet_id, section_id, date_of_daycare, start_time, end_time)
values
(enroll_num_seq.nextval, 100012, 'D10007', '13-DEC-2018', 1000, 1400);

insert into daycare_enrollment(enroll_num, pet_id, section_id, date_of_daycare, start_time, end_time)
values
(enroll_num_seq.nextval, 100012, 'D10007', '14-DEC-2018', 1000, 1600);

insert into daycare_enrollment(enroll_num, pet_id, section_id, date_of_daycare, start_time, end_time)
values
(enroll_num_seq.nextval, 100012, 'D10007', '16-DEC-2018', 0900, 1700);
  
insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100003, 'D10004', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100006, 'D10006', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100015, 'D10005', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100018, 'D10004', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100024, 'D10005', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100033, 'D10004', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100036, 'D10005', '13-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100003, 'D10004', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100006, 'D10006', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100015, 'D10005', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100018, 'D10004', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100024, 'D10005', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100033, 'D10004', '15-DEC-2018', sysdate, 0900, 1700);

insert into daycare_enrollment
values
(enroll_num_seq.nextval, 100036, 'D10005', '15-DEC-2018', sysdate, 0900, 1700);

