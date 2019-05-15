/*=====
  testing script for function sell_book

  (note: because it runs committing transactions as
  part of tests, running pop-bks.sql at beginning
  and at end of testing script)

  by: Sharon Tuttle
  last modified: 2019-03-10
=====*/

set feedback off
start pop-bks.sql
set feedback 6

set serveroutput on
set linesize 100

prompt
prompt ***************************************
prompt test sell_book
prompt ***************************************
prompt

prompt ===================
prompt TEST 1
prompt ===================
prompt

prompt =============================================================
prompt there is an order_needed row for 025602796X:
prompt =============================================================

select *
from   order_needed
where  isbn = '025602796X';

prompt =============================================================
prompt Trying to sell 5 copies of 025602796X should SUCCEED
prompt with a code of 0:
prompt =============================================================

var results_code number;
exec :results_code := sell_book('025602796X', 5)
print results_code

prompt =============================================================
prompt Are there now 5 copies of 025602796X?
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, auto_order_qty, on_order
from   title
where  isbn = '025602796X';

prompt =============================================================
prompt there better be the same row (and just one) in order_needed:
prompt =============================================================

select *
from   order_needed
where  isbn = '025602796X';

prompt ===================
prompt TEST 2
prompt ===================
prompt

prompt =============================================================
prompt Trying to sell 10 copies of 0130355488 should FAIL
prompt with a code of -1 (this ISBN is not in the database):
prompt =============================================================

exec :results_code := sell_book('0130355488', 10)
print results_code

prompt ===================
prompt TEST 3
prompt ===================
prompt

prompt =============================================================
prompt there should NOT be an order_needed row for '0805367829':
prompt =============================================================

select *
from   order_needed
where  isbn = '0805367829';

prompt =============================================================
prompt Trying to sell 11 copies of 0805367829 should SUCCEED
prompt with a code of 0:
prompt =============================================================

exec :results_code := sell_book('0805367829', 11)
print results_code

prompt =============================================================
prompt are there now 39 copies of 0805367829, with on_order still F?
prompt    (it needs an order, has not been ordered yet)
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, auto_order_qty, on_order
from   title
where  isbn = '0805367829';

prompt =============================================================
prompt there SHOULD now be an order_needed row for 0805367829
prompt    (with an order quantity of 10):
prompt =============================================================

select *
from   order_needed
where  isbn = '0805367829';

prompt ===================
prompt TEST 4
prompt ===================
prompt

prompt =============================================================
prompt there should NOT be an order_needed row for '087150331X':
prompt =============================================================

select *
from   order_needed
where  isbn = '087150331X';

prompt =============================================================
prompt Trying to sell 1 copy of 087150331X should SUCCEED
prompt with a code of 0:
prompt =============================================================

exec :results_code := sell_book('087150331X', 1)
print results_code

prompt =============================================================
prompt are there now 2 copies of 087150331X, with order_needed still F?
prompt    (it needs an order, has not been ordered yet)
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, auto_order_qty, on_order
from   title
where  isbn = '087150331X';

prompt =============================================================
prompt there SHOULD now be an order_needed row for 087150331X
prompt    (with an order quantity of 5):
prompt =============================================================

select *
from   order_needed
where  isbn = '087150331X';

prompt ===================
prompt TEST 5
prompt ===================
prompt

prompt =============================================================
prompt Trying to sell 1 copy of 087150331X should SUCCEED
prompt with a code of 0:
prompt =============================================================

exec :results_code := sell_book('087150331X', 1)
print results_code

prompt =============================================================
prompt is there now 1 copy of 087150331X, with order_needed still F?
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, on_order
from   title
where  isbn = '087150331X';

prompt =============================================================
prompt BUT there SHOULD still be ONLY ONE order_needed row for 087150331X:
prompt =============================================================

select *
from   order_needed
where  isbn = '087150331X';

prompt ===================
prompt TEST 6
prompt ===================
prompt

prompt =============================================================
prompt Trying to sell -5 copies of 0574214100 should FAIL
prompt with a code of -2 (should not sell a non-positive
prompt number of books!):
prompt =============================================================

exec :results_code := sell_book('0574214100', -5)
print results_code

prompt ===================
prompt TEST 7
prompt ===================
prompt

prompt =============================================================
prompt there should NOT be an order_needed row for '0070790523':
prompt =============================================================

select *
from   order_needed
where  isbn = '0070790523';

prompt =============================================================
prompt Trying to sell 4 copies of 0070790523 should SUCCEED
prompt with a code of 0:
prompt =============================================================

exec :results_code := sell_book('0070790523', 4)
print results_code

prompt =============================================================
prompt are there now 71 copies of 0070790523, with order_needed still F?
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, on_order
from   title
where  isbn = '0070790523';

prompt =============================================================
prompt there should NOT be an order_needed for this title:
prompt =============================================================

select *
from   order_needed
where  isbn = '0070790523';

prompt ===================
prompt TEST 8
prompt ===================
prompt

prompt =============================================================
prompt Trying to sell 21 copies of 0805367802 should FAIL
prompt with a code of -3 (should not sell MORE than the current
prompt quantity on hand of a book):
prompt =============================================================

exec :results_code := sell_book('0805367802', 21)
print results_code

prompt =============================================================
prompt had better still have 20 of this title (sale not permitted
prompt    for more than on-hand...!)
prompt =============================================================

select isbn, title_name, qty_on_hand, order_point, on_order
from   title
where  isbn = '0805367802';

prompt =============================================================
prompt there should NOT be an order_needed for this title:
prompt =============================================================

select *
from   order_needed
where  isbn = '0805367802';

-- required post-test_sell_book-calls' queries

prompt =============================================
prompt title table after tests but before rollback:
prompt =============================================

select   isbn, qty_on_hand, order_point, on_order
from     title
order by isbn;

prompt ====================================================
prompt order_needed table after tests but before call
prompt pop-bks.sql again:
prompt ====================================================

select   *
from     order_needed
order by ord_needed_id;

set feedback off
start pop-bks.sql
set feedback 6
set linesize 80

-- end of sell_book_test.sql
