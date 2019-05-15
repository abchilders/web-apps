/*
Alex Childers
CS 325 - Fall 2018
Last modified: 2019/02/01
*/

-- This is the base table for the Owner entity class. 
drop table owner cascade constraints;  

create table owner
(owner_id 	integer, 
 first_name	varchar2(20)	not null,  
 last_name	varchar2(20)	not null, 
 primary key (owner_id)); 


-- This holds the multi-valued attribute phone_number for Owner. 

drop table owner_phone_num cascade constraints; 

create table owner_phone_num
(owner_id	integer, 
 phone_number	char(10), 
 primary key (owner_id, phone_number),
 foreign key (owner_id) references owner); 


-- This holds the multi-valued attribute email for Owner. 

drop table owner_email_addr cascade constraints; 

create table owner_email_addr
(owner_id	integer, 
 email		varchar2(50),
 primary key (owner_id, email),
 foreign key (owner_id) references owner); 


-- This is the base table for the Pet entity class. 
-- pet_type has physical domain varchar(10) just in case we decide to add pets other
-- than dogs and cats later. 

drop table pet cascade constraints; 

create table pet
(pet_id			integer,
 pet_name		varchar2(20)	not null,
 sex			char(1)		check(sex in ('f', 'm')) not null, 
 is_spayed_neutered	char(1)		check(is_spayed_neutered in ('y', 'n')) not null, 
 birthday		date,	
 pet_type		varchar2(10)	check(pet_type in ('dog', 'cat')) not null, 
 owner_id		integer		not null, 
 primary key (pet_id), 
 foreign key (owner_id) references owner); 


-- This holds the multi-valued attribute vaccines for Pet. 

drop table pet_vaccine_received cascade constraints; 

create table pet_vaccine_received
(pet_id		integer, 
 vaccine_name	varchar2(20), 
 date_received	date,
 primary key (pet_id, vaccine_name),
 foreign key (pet_id) references pet); 


-- This holds the multi-valued attribute medications for Pet. 

drop table pet_medication_needed cascade constraints; 

create table pet_medication_needed
(pet_id			integer,
 medication_name	varchar2(20),
 dosage			varchar2(10), 
 primary key (pet_id, medication_name),
 foreign key (pet_id) references pet); 


-- This holds the multi-valued attribute diet_needs for Pet. 

drop table pet_diet_restriction cascade constraints; 

create table pet_diet_restriction
(pet_id		integer,
 diet_need	varchar2(20),
 primary key (pet_id, diet_need), 
 foreign key (pet_id) references pet);


-- This is the base table for the Cat entity class. 

drop table cat cascade constraints; 

create table cat
(pet_id	integer,
 primary key (pet_id), 
 foreign key (pet_id) references pet); 


-- This is the base table for the Dog entity class. 

drop table dog cascade constraints; 

create table dog
(pet_id 	integer,
 pet_size	varchar2(10) 	check(pet_size in ('small', 'medium', 'large')), 
 primary key (pet_id),
 foreign key (pet_id) references pet); 


-- This is the base table for the Worker entity class. 

drop table worker cascade constraints; 

create table worker
(worker_id	integer,
 worker_type	varchar2(20) check(worker_type in('volunteer', 'employee')) not null,  
 first_name	varchar2(20), 
 last_name	varchar2(20), 
 primary key (worker_id)); 


-- This holds the multi-valued attribute phone_number for Worker.

drop table worker_phone_num cascade constraints; 

create table worker_phone_num
(worker_id      integer,
 phone_number   char(10),
 primary key (worker_id, phone_number),
 foreign key (worker_id) references worker);


-- This holds the multi-valued attribute email for Worker.

drop table worker_email_addr cascade constraints; 

create table worker_email_addr
(worker_id      integer,
 email          varchar2(50),
 primary key (worker_id, email),
 foreign key (worker_id) references worker);


-- This is the base table for the Employee entity class.

drop table employee cascade constraints; 

create table employee
(worker_id	integer, 
 job_title	varchar2(30), 
 salary		number, 
 start_date	date, 
 primary key (worker_id), 
 foreign key (worker_id) references worker); 


-- This holds the multi-valued attribute formal_training for Employee. 

drop table employee_formal_qualifications cascade constraints; 

create table employee_formal_qualifications
(worker_id	integer, 
 training	varchar2(100), 
 primary key (worker_id, training), 
 foreign key (worker_id) references employee); 


-- This is the base table for the Volunteer entity class. 

drop table volunteer cascade constraints; 

create table volunteer
(worker_id	integer, 
 primary key (worker_id), 
 foreign key (worker_id) references worker); 


-- This holds the multi-valued attribute pet_training for Volunteer.

drop table volunteer_handling_permissions cascade constraints; 

create table volunteer_handling_permissions
(worker_id	integer, 
 pet_may_handle	varchar2(10)    check(pet_may_handle in ('dog', 'cat')),
 primary key (worker_id, pet_may_handle),
 foreign key (worker_id) references volunteer);


-- This is the base table for the Service entity class. 

drop table service cascade constraints; 

create table service
(section_id	char(6),
 service_type	varchar2(20)	 check(service_type in('boarding',
				 'daycare', 'class')) not null, 
 primary key (section_id)); 


-- This is the intersection table for the M:N relationship between 
-- Worker and Service. 

drop table worker_providing_service cascade constraints; 

create table worker_providing_service
(worker_id		integer,
 service_sect_id	char(6),
 primary key (worker_id, service_sect_id),
 foreign key (worker_id) references worker,
 foreign key (service_sect_id) references service(section_id));


-- This is the base table for the Class entity class. 

drop table class cascade constraints; 

create table class
(section_id	char(6),
 class_name	varchar2(100),
 full_cost	number, 
 primary key (section_id), 
 foreign key (section_id) references service); 


-- This holds the multi-valued attribute pets_allowed for Class. 

drop table pet_permitted_in_class cascade constraints; 

create table pet_permitted_in_class
(section_id 	char(6), 
 pet		varchar2(10)    check(pet in ('dog', 'cat')),
 primary key (section_id, pet),
 foreign key (section_id) references class); 


-- This holds the multi-valued attribute dates_of_occurrence for Class. 

drop table class_session_date cascade constraints; 

create table class_session_date
(section_id		char(6), 
 date_of_occurrence	date, 
 primary key (section_id, date_of_occurrence), 
 foreign key (section_id) references class); 


/* NOTE that the date_enrolled attribute for class_enrollment,
   boarding_enrollment, and daycare_enrollment contain the date that the
   owner paid for the service. If the owner has not paid yet, the
   date_enrolled is null.
*/

-- This is the base table for the Class_Enrollment association entity class.

drop table class_enrollment cascade constraints; 

create table class_enrollment
(enroll_num 	integer,
 owner_id	integer, 
 section_id	char(6), 
 date_enrolled	date, 
 pet_id		integer, 
 primary key (enroll_num),
 foreign key (owner_id) references owner,
 foreign key (section_id) references class,
 foreign key (pet_id) references pet); 


-- This is the base table for the Boarding entity class. 

drop table boarding cascade constraints;

create table boarding
(section_id		char(6), 
 boarding_category	varchar2(20),
 half_day_cost		number, 
 full_day_cost		number, 
 primary key (section_id), 
 foreign key (section_id) references service); 


-- This is the base table for the Boarding_enrollment association entity class. 

drop table boarding_enrollment cascade constraints; 

create table boarding_enrollment
(enroll_num	integer,
 pet_id		integer, 
 section_id	char(6), 
 date_enrolled	date, 	
 start_date	date	not null,
 end_date	date	not null, 
 primary key (enroll_num), 
 foreign key (pet_id) references pet,
 foreign key (section_id) references boarding); 


-- This is the base table for the Doggy_Daycare entity class. 

drop table doggy_daycare cascade constraints; 

create table doggy_daycare
(section_id		char(6),
 daycare_category 	varchar2(20),
 half_day_cost		number,
 full_day_cost		number, 
 primary key (section_id), 
 foreign key (section_id) references service); 


-- This is the base table for the Daycare_Enrollment association entity class. 
/* NOTE: I couldn't figure out how to convey a start time and end time via 
   the date or time datatype, so I'm using integers to convey military
   time instead. 

   Also, daycare_day represents the day that the dog will be in daycare.
   This differs from date_enrolled, which is the day that the owner paid for 
   the enrollment. 
*/

drop table daycare_enrollment cascade constraints; 

create table daycare_enrollment
(enroll_num		integer, 
 pet_id			integer, 
 section_id		char(6), 
 date_of_daycare	date,
 date_enrolled		date,  
 start_time		integer,
 end_time		integer,
 primary key (enroll_num), 
 foreign key (section_id) references doggy_daycare); 
