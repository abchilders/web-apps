/* Alex Childers
   CS 328 - Homework 2 - Problem 5
   Last modified: 2019/02/08
*/

spool 328hw2-5-out.txt

prompt =============
prompt Alex Childers
prompt =============

/* Function: vol_exists
	Expects a worker's ID. Returns true if a volunteer with that worker
	ID exists, and false otherwise.

NOTE: This is a helper function for the procedure delete_volunteer.
	It is based on the author_exists function by Sharon Tuttle:

nrs-projects.humboldt.edu/~st10/s19cs328/328lab02/author_exists_ex_sql.html

*/

create or replace function vol_exists(the_id worker.worker_id%type) 
	return boolean as

	vol_found worker.worker_id%type;
begin
	select 	worker_id
	into   	vol_found
	from 	volunteer
	where	worker_id = the_id;

	-- an exception will be thrown if the id is not found. otherwise:
	return true; 

exception
	when no_data_found then
		return false; 
end;
/ 
show errors

/* Procedure: delete_volunteer
	Expects a volunteer's ID. Returns nothing.

	Deletes all information about the given volunteer from all related 
	tables in the database (e.g. worker_phone_num, worker_providing_service,
	volunteer).
*/

create or replace procedure delete_volunteer
	(vol_to_delete worker.worker_id%type) as

	rows_with_vol integer;
begin
	-- Validate worker id.
	select 	count(*)
	into 	rows_with_vol
	from	volunteer
	where	worker_id = vol_to_delete;

	if rows_with_vol = 0 then
		 raise_application_error(-20100, 'Volunteer ' || vol_to_delete
                        || ' does not exist.');
	end if; 

	/* If we get here, vol_to_delete is valid. So delete from children up
	   to highest parent table, worker. 
	*/
	
	delete from worker_providing_service
	where worker_id = vol_to_delete; 

	delete from volunteer_handling_permissions
	where worker_id = vol_to_delete; 

	delete from volunteer
	where worker_id = vol_to_delete;

	delete from worker_email_addr
	where worker_id = vol_to_delete; 

	delete from worker_phone_num
	where worker_id = vol_to_delete; 

	delete from worker
	where worker_id = vol_to_delete; 
end;
/ 
show errors

prompt
prompt ************************ 
prompt TESTING delete_volunteer
prompt ************************
prompt

set serveroutput on

-- commit database state before deleting anything
commit; 

prompt We're going to delete volunteer 300038, Claire Strong, from the 
prompt database. We can see that she exists in all the applicable tables:
prompt ==================================================================
prompt

prompt 	worker_providing_service:

select 	*
from 	worker_providing_service
where	worker_id = 300038;

prompt 	volunteer_handling_permissions:

select 	*
from 	volunteer_handling_permissions
where	worker_id = 300038; 

prompt 	volunteer:

select 	*
from 	volunteer
where	worker_id = 300038; 

prompt 	worker_email_addr:

select 	*
from 	worker_email_addr
where	worker_id = 300038;

prompt 	worker_phone_num:

select *
from 	worker_phone_num
where	worker_id = 300038; 

prompt	worker:

select 	*
from 	worker
where	worker_id = 300038; 

prompt *** TEST 1 ***
prompt Test passes if our select statements targeting worker 300038 return that
prompt no data was found:
prompt ========================================================================
prompt

exec delete_volunteer(300038)

prompt  worker_providing_service:

select  *
from    worker_providing_service
where   worker_id = 300038;

prompt  volunteer_handling_permissions:

select  *
from    volunteer_handling_permissions
where   worker_id = 300038;

prompt  volunteer:

select  *
from    volunteer
where   worker_id = 300038;

prompt  worker_email_addr:

select  *
from    worker_email_addr
where   worker_id = 300038;

prompt  worker_phone_num:

select *
from    worker_phone_num
where   worker_id = 300038;

prompt  worker:

select  *
from    worker
where   worker_id = 300038;

prompt *** TEST 2 ***
prompt Test passes if you see an error message from trying to delete an invalid
prompt volunteer ID, 123: 
prompt ========================================================================
prompt

exec delete_volunteer(123)

prompt And now the contents of the table, conspicuously missing worker 300038:
prompt =======================================================================
prompt

select *
from worker_providing_service;

select *
from volunteer_handling_permissions;

select *
from volunteer;

select *
from worker_email_addr;

select *
from worker_phone_num;

select *
from worker;

-- rollback changes after testing
rollback; 

spool off
