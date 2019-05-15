/* Alex Childers
   CS 328 - Homework 2 - Problems 2-4
   Last modified: 2019/02/06
*/

set serveroutput on

spool 328hw2-out.txt

prompt Alex Childers
prompt
prompt =========
prompt problem 2
prompt =========

/* Procedure: silly_shout
	Expects 2 parameters: a desired message and how many times it should be
	"shouted" to the screen. Returns nothing. 
   	
	This procedure prints an all-uppercase version of the desired message
	to the screen that many times, once per line, and with '!!!' at the end
	of each message. 

	If the number of times to shout is less than 0, the procedure will 
	print a message stating that it cannot show the message that many times.
*/

create or replace procedure silly_shout(desired_msg varchar2, 
	times_to_shout integer) as
	
	loop_ctr integer; 
begin
	loop_ctr := 1; 

	if times_to_shout < 0 then
	  	dbms_output.put_line('You can''t shout "' || desired_msg || 
			'" ' || times_to_shout || ' times.'); 
	else
		for loop_ctr in 1 .. times_to_shout
		loop
			dbms_output.put_line(upper(desired_msg) || '!!!'); 
		end loop;
	end if; 
end;
/
show errors

-- Testing procedure silly_shout. 

prompt This should shout JUST DO IT!!! 3 times:
prompt ==========================================

exec silly_shout('just do it', 3)

prompt This should shout nothing at all:
prompt ========================================================================

exec silly_shout('radio silence', 0)

prompt This should print a message stating that the desired message can't be
prompt printed:
prompt =====================================================================

exec silly_shout('Cannot Print Me', -3)

start silly_shout_test.sql

prompt =========
prompt problem 3
prompt =========

/* Function: title_total_cost
	Expects a title's ISBN. Returns the total cost of all of the current
	quantity-on-hand for that title, or returns -1 if there is no title 
	with that ISBN.
*/

create or replace function title_total_cost(given_isbn title.isbn%type) 
	return title.title_cost%type as

	total_cost title.title_cost%type;
begin
	select 	title_cost * qty_on_hand
	into	total_cost
	from	title
	where	isbn = given_isbn; 

	return total_cost; 

exception
	when no_data_found then
		return -1; 
end; 
/
show errors

prompt
prompt This should show that ISBN 0805322272 has a total cost of 461.25:
prompt =================================================================

var full_title_cost number
exec :full_title_cost := title_total_cost('0805322272')
print full_title_cost

prompt This should show that nonexistent ISBN 1234567890 has a 
prompt total cost of -1:
prompt =======================================================

exec :full_title_cost := title_total_cost('1234567890')
print full_title_cost

start title_total_cost_test.sql

spool off
	

