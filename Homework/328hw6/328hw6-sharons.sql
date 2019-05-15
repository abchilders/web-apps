/*========
    Example solutions
    CS 328 - Homework 6 - Problem 5

    note:
    *   this function assumes that the tables in create-bks.sql
        have been created, and their tests assume that
        these tables' current contents are those added by pop-bks.sql

    *   this function also uses PL/SQL subroutines is_on_order,
        pending_order_needed, and insert_order_needed; and these
        require that next_ord_needed_id exists, also.

    by: Sharon Tuttle
    last modified: 2019-03-10
========*/

set serveroutput on
spool 328hw6-out.txt
prompt <your name>

prompt ======================
prompt  problem 2
prompt ======================

/*========
    signature: function: sell_book: varchar2 integer -> integer
    purpose: expects an ISBN and a quantity being sold,
             and returns a value representing a results code
             from its attempted handling of a transaction of
             one sale of that quantity of the book with that
             ISBN.
             The results code returned is as follows:
              0  - if the transaction was successful.
             -1  - if the transaction failed because the given ISBN is not
                   in the title table
             -2  - if the transaction failed because of a non-positive
                   sale quantity
             -3  - if the transaction failed because of a sale quantity
                   exceeding the current quantity on hand for that ISBN
             -4  - if the transaction failed for any other reason
========*/

create or replace function sell_book (p_isbn     varchar2,
                                      p_qty_sold integer)
                  return integer is
    too_small_qty_sold exception;
    too_large_qty_sold exception;

    curr_qty_on_hand    integer;
    curr_order_point    integer;
    curr_auto_order_qty integer;

    new_qty_on_hand    integer;
begin
    -- starting with a commit because this is the beginning
    --     of a single, atomic transaction (to be completely
    --     done, or completely NOT done via a rollback)

    commit;

    -- gather information about this title that may be handy
    --    for this transaction (and which will conveniently
    --     throw an exception if the given ISBN is not in the
    --     title table)

    select qty_on_hand, order_point, auto_order_qty
    into   curr_qty_on_hand, curr_order_point, curr_auto_order_qty
    from   title
    where  isbn = p_isbn;

    -- quantity sold must be positive

    if p_qty_sold <= 0 then
        raise too_small_qty_sold;
    end if;

    -- are we trying to sell more than we currently have?

    if p_qty_sold > curr_qty_on_hand then
        raise too_large_qty_sold;
    end if;

    -- if reach here, it is safe to reduce qty_on_hand by the number sold

    new_qty_on_hand := curr_qty_on_hand - p_qty_sold;

    update title
    set qty_on_hand = new_qty_on_hand
    where isbn = p_isbn;

    -- does a new order for this title need to be placed
    --    now? Only if the quantity is now below the order point,
    --                 AND it isn't already on-order,
    --                 AND there isn't already a pending order_needed;

    if ( (new_qty_on_hand <= curr_order_point)
         and (is_on_order(p_isbn) = false)
         and (pending_order_needed(p_isbn) = false) ) then

        insert_order_needed(p_isbn, curr_auto_order_qty);
    end if;

    -- if get here -- all went well with the sale transaction

    commit;
    return 0;

exception
    -- if p_isbn does not exist in the title table

    when no_data_found then
        rollback;
        return -1;

    -- if someone tries to order a non-positive quantity of a book

    when too_small_qty_sold then
        rollback;
        return -2;

    -- if someone tries to buy more than the quantity on hand

    when too_large_qty_sold then
        rollback;
        return -3;

    -- if any other exception is thrown

    when others then
        rollback;
        return -4;
end;
/
show errors

start sell_book_test.sql

spool off

-- end of 328hw6.sql

