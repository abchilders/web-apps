/* CS 328 - HW 1 - Problem 3
   Alex Childers
   Last modified: 2019/02/01
*/

spool bks-try-out.txt

prompt
prompt by Alex Childers
prompt
prompt =================
prompt Problem 3 part a
prompt =================

/* Projects the names of publishers and which state they're in, displayed in
   alphabetical order of publisher name. The state should be displayed in a 
   column of width 9. 
*/

column pub_state format a9

select 		pub_name, pub_state
from 		publisher
order by	pub_name; 

prompt =================
prompt Problem 3 part b
prompt =================

/* Projects the prices and names of titles published by Benjamin/Cummings,
   displayed in reverse order of title price. The title prices are displayed in 
   the format $999.99. 
*/ 

column title_price format $999.99

select 		title_price, title_name
from 		title
where		pub_id = (select pub_id
		  	  from 	 publisher
		  	  where  pub_name = 'Benjamin/Cummings')
order by 	title_price desc; 

prompt =================
prompt Problem 3 part c
prompt =================

/* Projects each publisher's name, the number of titles available from that 
   publisher, "# TITLES," and the average title price "AVG PRICE" from that 
   publisher. Results are displayed in order of average title price from each 
   publisher. Average title prices are displayed in the format $999.99. 
*/

column "AVG PRICE" format $999.99

select		pub_name, count(*) "# TITLES", avg(title_price) "AVG PRICE"
from		publisher p join title t on p.pub_id = t.pub_id
group by	pub_name
order by 	avg(title_price);

prompt =================
prompt Problem 3 part d
prompt =================

/* Projects the names of titles involved in order 11012 and the quantity of
   each title being ordered. 
*/

select	title_name, order_qty
from	order_line_item olt join title t on olt.isbn = t.isbn
where	order_num = 11012; 
 
prompt =================
prompt Problem 3 part e
prompt =================

/* Projects the name of the publisher(s) involved in the order line item(s)
   with the greatest order quantity. 
*/

select 	pub_name
from	publisher p 
	join order_summary os on p.pub_id = os.pub_id
	join order_line_item olt on os.order_num = olt.order_num
where	order_qty = (select max(order_qty)
		     from   order_line_item); 	 

spool off

-- Reset column formatting after the rest of the script is done running.
clear columns
