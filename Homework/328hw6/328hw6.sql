/* 	Alex Childers
	CS 328 - Homework 6 - Problem 5
	Last modified: 2019/03/17
*/

set serveroutput on

spool 328hw6-out.txt

prompt =============
prompt Alex Childers
prompt problem 5
prompt =============

/* 	Function: sell_book

	Represents the sales transaction of selling one or more copies of a 
	particular single book. 
		
	Expects an ISBN representing the book being sold and an integer
	representing the quantity being sold. Returns an integer representing a 
	results code that conveys whether the sales transaction was successfully
	completed.
*/

create or replace function sell_book(isbn_to_sell title.isbn%type, 
									 sell_qty     integer)
	return integer as
	
	test_isbn			title.isbn%type; 
	invalid_quantity 	exception;
	not_enough_books 	exception; 
	qty_had 			title.qty_on_hand%type; 
	selling_order_pt 	title.order_point%type; 
	sell_auto_order_qty	title.auto_order_qty%type; 
begin
	commit; 
	
	-- will raise a NO_DATA_FOUND exception if the isbn doesn't exist in the
	-- title table 
	select 	isbn
	into 	test_isbn
	from 	title
	where 	isbn = isbn_to_sell; 
	
	-- quantity must be greater than 0 
	if sell_qty <= 0 then
		raise invalid_quantity; 
	end if; 
	
	-- we need to make sure we're not selling more books than we have on hand
	select 	qty_on_hand
	into 	qty_had
	from 	title
	where	isbn = isbn_to_sell; 
	
	if sell_qty > qty_had then
		raise not_enough_books; 
	end if; 
	
	-- if we've gotten this far, sell the book!
	update 	title
	set		qty_on_hand = qty_on_hand - sell_qty
	where	isbn = isbn_to_sell; 
	
	-- update qty_had accordingly
	qty_had := qty_had - sell_qty; 
	
	-- do we need to add a row to order_needed?
	select 	order_point
	into 	selling_order_pt
	from 	title
	where	isbn = isbn_to_sell; 
	
	if 	(qty_had <= selling_order_pt) and 
		(is_on_order(isbn_to_sell) = false) and
		(pending_order_needed(isbn_to_sell) = false) then
		
		-- if we do need to add a row, make an entry using insert_order_needed
		select 	auto_order_qty 
		into 	sell_auto_order_qty
		from	title
		where	isbn = isbn_to_sell; 
		
		insert_order_needed(isbn_to_sell, sell_auto_order_qty); 
	end if; 
		
	-- finally, commit and return 0 to represent a successful sale transaction
	commit; 
	return 0; 
	
exception
	when NO_DATA_FOUND then
		rollback;
		return -1; 
	when invalid_quantity then
		rollback; 
		return -2; 
	when not_enough_books then
		rollback; 
		return -3; 
end; 
/ 
show errors

start sell_book_test.sql

spool off 