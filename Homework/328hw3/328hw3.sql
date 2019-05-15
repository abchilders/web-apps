/* Alex Childers
   CS 328 - Homework 3
   Last modified: 2019/02/16
*/

set serveroutput on

spool 328hw3-out.txt

prompt =============
prompt Alex Childers
prompt =============
prompt
prompt =========
prompt problem 4
prompt =========

/* Function: next_ord_needed_id

   Purpose: Expects no parameters. Returns a value that is one larger than the
	largest current value of ord_needed_id. (If the table is empty, this 
	function returns a key of 1.)
*/

create or replace function next_ord_needed_id return number as
	curr_ord_needed_id order_needed.ord_needed_id%type;
begin
	-- get the current largest id 
	select 	max(ord_needed_id)
	into 	curr_ord_needed_id
	from 	order_needed; 

	if curr_ord_needed_id is null then
		return 1; 
	else
		return curr_ord_needed_id + 1; 
	end if; 
end;
/
show errors

-- to test the next_ord_needed_id function:
start next_ord_needed_id_test.sql

prompt =========
prompt problem 5
prompt =========

/* Function: is_on_order

   Purpose: Expects an ISBN. Returns true if that ISBN is currently on order,
	 and false otherwise.
*/

create or replace function is_on_order(the_isbn title.isbn%type) return boolean
	as
	order_status title.on_order%type;
begin
	select 	on_order
	into	order_status
	from	title
	where	isbn = the_isbn; 

	if order_status = 'T' then
		return true; 
	else
		return false; 
	end if; 
exception
	when no_data_found then
		return false; 
end; 
/
show errors

-- testing the is_on_order function

prompt
prompt test passes if 0201144719 returns true
prompt ======================================

var 	order_result varchar2(10)
exec 	:order_result := bool_to_string(is_on_order('0201144719'))
print	order_result

start is_on_order_test.sql

spool off
