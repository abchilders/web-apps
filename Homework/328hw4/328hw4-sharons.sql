/*========
   Example solutions
   CS 328 - Homework 4 - Problems 6-7
  
   note: 
   *   these subroutines assume that the tables in create-bks.sql 
       have been created, and their tests assume that
       these tables' current contents are those added by pop-bks.sql

   *   one of the subroutines calls function next_ord_needed_id
       from CS 328 - Homework 3 - Problem 3

   *   one of the testing scripts called assumes that pop-bks.sql exists
       in the current working directory, and calls it

   *   one of the testing scripts called calls function bool_to_string
       from CS 328 - Homework 2 - Problem 1

   by: Sharon Tuttle
   last modified: 2019-02-17
========*/

set serveroutput on
spool 328hw4-out.txt
prompt <your name>

prompt
prompt ======================
prompt problem 6
prompt ======================
prompt

/*========
   signature: procedure: insert_order_needed: varchar2 number -> void
   purpose: expects an ISBN and an order quantity, and returns nothing,
            but has the side-effect of inserting a new row into
            order_needed whose key is one more than the current 
            largest key, with this isbn and quantity, and whose 
            date_created is the current date.
   uses: function next_ord_needed_id
========*/

create or replace procedure insert_order_needed(p_isbn varchar2,
                                                p_order_qty number) as
    next_id   number;
begin
    -- obtain a suitable key for the new row

    next_id := next_ord_needed_id;

    -- insert the desired order_needed row with today's date for
    --     its creation date

    insert into order_needed(ord_needed_id, isbn, order_qty, date_created)
    values
    (next_id, p_isbn, p_order_qty, sysdate);
end;
/
show errors

start insert_order_needed_test.sql

prompt
prompt ======================
prompt problem 7
prompt ======================
prompt

/*========
   signature: function: pending_order_needed: varchar2 -> boolean
   purpose: expects an ISBN, and returns true if that ISBN
      has a pending order_needed row (one whose date_placed is NULL),
      and returns false otherwise
========*/

create or replace function pending_order_needed(p_isbn varchar2) 
    return boolean is
        num_rows integer;
begin

    select count(*)
    into num_rows
    from order_needed
    where isbn = p_isbn
    and date_placed is NULL;

    if num_rows = 0 then
        return false;
    else
        return true;
    end if;

end;
/
show errors

start pending_order_needed_test.sql

spool off

-- end of 328hw4.sql

