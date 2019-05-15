/*	Alex Childers
	CS 328 - Homework 4
	Last modified: 2019/02/23
*/

set serveroutput on

spool 328hw4-out.txt

prompt =============
prompt Alex Childers
prompt =============
prompt
prompt =========
prompt problem 6
prompt =========

/* 	Procedure: insert_order_needed

	Purpose: Expects a desired ISBN and order quantity for the desired order.
		Inserts a new row into order_needed using a key returned by function
		next_ord_needed_id, the parameter ISBN, the parameter order quantity,
		and the current date.
*/

create or replace procedure insert_order_needed(
	needed_isbn order_needed.isbn%type, 
	needed_order_qty order_needed.order_qty%type) as
	new_id order_needed.ord_needed_id%type;
begin
	-- get a new key for the next row in order_needed
	new_id := next_ord_needed_id; 
	
	-- insert a new row into order_needed with the given info
	insert into order_needed(ord_needed_id, isbn, order_qty, date_created)
	values
	(new_id, needed_isbn, needed_order_qty, sysdate); 
end; 
/
show errors

-- test the insert_order_needed procedure
start insert_order_needed_test.sql

prompt =========
prompt problem 7
prompt =========

/* Function: pending_order_needed

   Purpose: Expects an ISBN. Returns a boolean value indicating whether or not
	that ISBN has such a "pending" order_needed row.  (that is, if there is a 
	row with that ISBN whose date_placed attribute is null).
*/

create or replace function pending_order_needed(
	the_isbn order_needed.isbn%type) return boolean as
	isbn_date_placed order_needed.date_placed%type;
begin
	-- iterate through all rows with the requested isbn
	for next_order_needed in (select *
							  from	 order_needed
							  where  isbn = the_isbn)
	loop
		if next_order_needed.date_placed is null then
			return true; 
		end if; 
	end loop; 
	
	/* if we get here, there were no rows with the request isbn in which the
		date_placed was null */
	return false; 
end;
/ 
show errors

-- test pending_order_needed function
start pending_order_needed_test.sql

spool off
