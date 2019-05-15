/*
 * Alex Childers and Grant Pawell
 * Last Modified: Jan 25, 2018
 */

start set-up-ex-tbls.sql

set serveroutput on

spool 328lab1-2-results.txt

prompt Alex Childers and Grant Pawell

create or replace trigger ck_empl_rep
	before insert or update
	on customer
	for each row
declare
	rep_job_title varchar2(10);
begin
	select job_title
	into rep_job_title
	from empl
	where empl_num = :new.empl_rep;
	
	if rep_job_title != 'Sales' then
		raise_application_error(-20000, 'Invalid empl_rep');
	else
		dbms_output.put_line('Insert/update accepted');
	end if;
end;
/
show errors

insert into customer
values
(000001, 'Doe', 'Jane', '7499', 'Rossow Street', 'Arcata', 'CA', '95521', 1234.56);

insert into customer
values
(000002, 'Doe', 'John', '7934', 'Harpst Street', 'Arcata', 'CA', '95521', 5678.90);

update customer
set empl_rep = '7499'
where cust_id = '123456';

update customer
set empl_rep = '7934'
where cust_id = '123456';

select *
from customer;

spool off