/* CS 328 - HW 1 - Problem 4
   Alex Childers
   Last modified: 2019/02/01
*/

set serveroutput on

-- Create a clean version of the movies tables. 

start movies-create.sql
start movies-pop.sql

spool movies-trigger-out.txt

prompt
prompt by Alex Childers
prompt

/* Trigger: approve_rental

   Purpose: Fires before an insert into the rental table. Prevents the 
   	insertion of a row into the rental table if the renting client's 
	credit rating is below 1.5.
*/

create or replace trigger approve_rental 
	before insert
	on rental
	for each row
declare
	credit_rating client.client_credit_rtg%type;
begin
	select 	client_credit_rtg
	into 	credit_rating
	from	client
	where 	client_num = :new.client_num; 

	if credit_rating < 1.5 then
		raise_application_error(-20000, 'client ' || :new.client_num ||
			'''s credit rating is below 1.5');  
	else
		dbms_output.put_line('rental successful; client ' || 
			:new.client_num || '''s credit rating is at least' ||
			' 1.5'); 
	end if; 
end; 
/ 
show errors

commit;
 
prompt ========================================================================
prompt The following rental insert should fail-- the client's credit rating
prompt is less than 1.5. 
prompt ========================================================================

insert into rental(rental_num, client_num, vid_id, date_out, date_due)
values
('0000025', '2222', '130031', '29-JAN-2018', '01-FEB-2018'); 

prompt ========================================================================
prompt The following rental insert should succeed-- the client's credit rating 
prompt is greater than or equal to 1.5. 
prompt ========================================================================

insert into rental(rental_num, client_num, vid_id, date_out, date_due)
values
('0000026', '4444', '120011', '21-JAN-2018', '23-JAN-2018');

prompt ========================================================================
prompt Note that in the following list of rental contents, rental 0000025 
prompt should not appear, but rental 0000026 should appear. 
prompt ========================================================================

select 	*
from 	rental; 

rollback; 

spool off
