/* Alex Childers
   CS 328 - Homework 2 - Problems 2-4
   Last modified: 2019/02/06
*/

set serveroutput on

spool 328hw2-out.txt

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


spool off
